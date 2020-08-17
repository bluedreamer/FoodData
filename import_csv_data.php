#!/usr/bin/php
<?php
include_once "filelist.php";
include_once "Stats.php";

$host = isset($argv[1])?$argv[1]:"";
$db = isset($argv[2])?$argv[2]:"";
$user = isset($argv[3])?$argv[3]:"";
$password = isset($argv[4])?$argv[4]:"";
$record_chunk=10000;
$truncate=true;

function map_datatype_to_bind_param($data_type)
{
    switch($data_type)
    {
        case "int":
        case "smallint":
        case "tinyint":
        case "bigint":
            return "i";

        case "char":
        case "date":
        case "mediumtext":
        case "set":
        case "text":
        case "time":
        case "timestamp":
        case "longtext":
        case "varchar":
        case "datetime":
        case "enum":
            return "s";

        case "mediumblob":
        case "longblob":
        case "tinyblob":
        case "varbinary":
        case "binary":
        case "blob":
            return "b";

        case "decimal":
        case "float":
        case "double":
            return "d";

        default:
            die("Dont know: $data_type");
    }
}

$mysql=new mysqli($host, $user, $password, $db);
if($mysql->connect_error)
{
    die("Couldn't connect to database: " . $mysql->connect_error);
}
$mysql->autocommit(false);

$stats=[];
foreach($filelist as $file)
{
    $table_name=$file;
    $file.=".csv";
    $stats[$table_name]=new Stats();
    printf("Processing %s\n", $table_name);
    if($truncate)
    {
        printf("Truncated %s\n", $table_name);
        $query = sprintf("TRUNCATE %s", $table_name);
        $mysql->query($query);
    }

    $query=<<<SQL
SELECT COLUMN_NAME, DATA_TYPE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA="$db"
 AND TABLE_NAME="$table_name"
SQL;
    $result=$mysql->query($query);

    $field_list=[];
    while($row=$result->fetch_assoc())
    {
        $field_list[$row["COLUMN_NAME"]]=map_datatype_to_bind_param($row["DATA_TYPE"]);
    }

    $fp=fopen($file, "r");
    if($fp===false)
    {
        die("Couldn't open file: $file");
    }

    $field_names=fgetcsv($fp, 10000, ",");
    $column_count_in_csv_file=count($field_names);
    $sep='';
    $insert_query="INSERT INTO $table_name SET ";

    $param_type_list="";
    foreach($field_list as $fieldname_from_table => $value)
    {
        if(!in_array($fieldname_from_table, $field_names))
        {
            die("Field from table not a file field: $fieldname_from_table");
        }
        $param_type_list.=$value;
    }

    foreach($field_names as $fieldname_from_file)
    {
        if(!array_key_exists($fieldname_from_file, $field_list))
        {
            die("Field from file not a table field: $fieldname_from_file");
        }

        $insert_query.=$sep . "`$fieldname_from_file`=?";
        $sep=",";
    }

    $mysql->begin_transaction();
    $import_count=0;
    $csv_row=[];
    $stmt=$mysql->prepare($insert_query);

    while($csv_row=fgetcsv($fp, 10000, ","))
    {
        for($i=0; $i < count($csv_row); ++$i)
        {
            $value = &$csv_row[$i];

            if(is_numeric($value))
            {
                $value = $value + 0;
            }

            if(empty($value))
            {
                $value = null;
            }
        }
        $bind_param_data=[];
        $bind_param_data[]=&$param_type_list;
        for($i=0; $i < $column_count_in_csv_file; ++$i)
        {
            $csv_row[]="";
            $bind_param_data[]=&$csv_row[$i];
        }
        call_user_func_array(array($stmt, "bind_param"), $bind_param_data);
        if(!$stmt->execute())
        {
            printf("ERR: %s\n", $stmt->sqlstate);
        }
        if($stmt->affected_rows!=1)
        {
            printf("ERR2: %s [%s]\n", $stmt->error, print_r($csv_row, true));
        }

        if($import_count > $record_chunk)
        {
            $import_count=0;
            $mysql->commit();
            $mysql->begin_transaction();
            printf("%d ", $stats[$table_name]->records);
        }
        ++$import_count;
        $stats[$table_name]->inc();
    }
    $stats[$table_name]->end();
    $mysql->commit();
    printf("\n");
    fclose($fp);
}

printf("==========================================================\n");
printf("Chunk size: %d\n", $record_chunk);
$total_time=0;
$total_records=0;
foreach($filelist as $file)
{
    $table_name = basename($file, ".csv");
    printf("%35s loaded %7d in %11.06fs at %8.2f recs/s\n",
        $table_name,
        $stats[$table_name]->records,
        $stats[$table_name]->gettime(),
        $stats[$table_name]->recspersec(),
    );
    $total_records+=$stats[$table_name]->records;
    $total_time+=$stats[$table_name]->gettime();
}
printf("----------------------------------------------------------\n");
printf("%7d records in %11.06fs at %8.2f recs/s\n", $total_records, $total_time, $total_records/$total_time);
printf("==========================================================\n");
