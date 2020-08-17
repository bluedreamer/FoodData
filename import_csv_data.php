#!/usr/bin/php
<?php
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

$filelist = array(
    "acquisition_sample.csv",
    "agricultural_acquisition.csv",
    "branded_food.csv",
    "fndds_derivation.csv",
    "fndds_ingredient_nutrient_value.csv",
    "food.csv",
    "food_attribute.csv",
    "food_attribute_type.csv",
    "food_calorie_conversion_factor.csv",
    "food_category.csv",
    "food_component.csv",
    "food_nutrient.csv",
    "food_nutrient_conversion_factor.csv",
    "food_nutrient_derivation.csv",
    "food_nutrient_source.csv",
    "food_portion.csv",
    "food_protein_conversion_factor.csv",
    "food_update_log_entry.csv",
    "foundation_food.csv",
    "input_food.csv",
    "lab_method.csv",
    "lab_method_code.csv",
    "lab_method_nutrient.csv",
    "market_acquisition.csv",
    "measure_unit.csv",
    "nutrient.csv",
    "nutrient_incoming_name.csv",
    "retention_factor.csv",
    "sample_food.csv",
    "sr_legacy_food.csv",
    "sub_sample_food.csv",
    "sub_sample_result.csv",
    "survey_fndds_food.csv",
    "wweia_food_category.csv",
);

class Stats
{
    public $start_time;
    public $end_time;
    public $records;

    function __construct()
    {
        $this->start_time=gettimeofday();
        $this->end_time=null;
        $this->records=0;
    }

    function end()
    {
        $this->end_time=gettimeofday();
    }

    function inc()
    {
        ++$this->records;
    }

    function gettime()
    {
        $usec_diff=$this->end_time["usec"] - $this->start_time["usec"];
        $sec_diff=$this->end_time["sec"] - $this->start_time["sec"];
        if($usec_diff < 0)
        {
            $usec_diff+=1000000;
            --$sec_diff;
        }
        $result=$usec_diff / 1000000;
        $result+=$sec_diff;

        return $result;
    }

    function recspersec()
    {
        return $this->records / $this->gettime();
    }
}

$stats=[];
foreach($filelist as $file)
{
    $table_name=basename($file, ".csv");
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
        $bind_param_data=[];
        $bind_param_data[]=&$param_type_list;
        for($i=0; $i < $column_count_in_csv_file; ++$i)
        {
            $csv_row[]="";
            $bind_param_data[]=&$csv_row[$i];
        }
        call_user_func_array(array($stmt, "bind_param"), $bind_param_data);
        $stmt->execute();
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
    printf("%40s loaded %7d in %11.06fs at %8.2f recs/s\n",
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
