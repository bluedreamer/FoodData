#!/usr/bin/php
<?php
$host = isset($argv[1])?$argv[1]:"";
$db = isset($argv[2])?$argv[2]:"";
$user = isset($argv[3])?$argv[3]:"";
$password = isset($argv[4])?$argv[4]:"";

$truncate=false;

$mysql=new mysqli($host, $user, $password, $db);
if($mysql->connect_error)
{
    die("Couldn't connect to database: " . $mysql->connect_error);
}

$filelist = array(
    "acquisition_sample.csv",
    "agricultural_acquisition.csv",
//    "branded_food.csv",
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

foreach($filelist as $file)
{
    $table_name=basename($file, ".csv");
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
    while($csv_row=fgetcsv($fp, 10000, ","))
    {
        $bind_param_data=[];
        $bind_param_data[]=&$param_type_list;
        $stmt=$mysql->prepare($insert_query);
        for($i=0; $i < count($csv_row); ++$i)
        {
            $bind_param_data[]=&$csv_row[$i];
        }
        call_user_func_array(array($stmt, "bind_param"), $bind_param_data);
        $stmt->execute();
    }
    $mysql->commit();
    printf("Completed %s\n", $table_name);

    fclose($fp);
}

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