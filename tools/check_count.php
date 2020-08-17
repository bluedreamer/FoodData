#!/usr/bin/php
<?php
$host = isset($argv[1])?$argv[1]:"";
$db = isset($argv[2])?$argv[2]:"";
$user = isset($argv[3])?$argv[3]:"";
$password = isset($argv[4])?$argv[4]:"";

$mysql=new mysqli($host, $user, $password, $db);
if($mysql->connect_error)
{
    die("Couldn't connect to database: " . $mysql->connect_error);
}
$mysql->autocommit(false);

$tablelist = $mysql=new mysqli($host, $user, $password, $db);
if($mysql->connect_error)
{
    die("Couldn't connect to database: " . $mysql->connect_error);
}
$mysql->autocommit(false);

$tablelist = array(
    "acquisition_sample",
    "agricultural_acquisition",
    "branded_food",
    "fndds_derivation",
    "fndds_ingredient_nutrient_value",
    "food",
    "food_attribute",
    "food_attribute_type",
    "food_calorie_conversion_factor",
    "food_category",
    "food_component",
    "food_nutrient",
    "food_nutrient_conversion_factor",
    "food_nutrient_derivation",
    "food_nutrient_source",
    "food_portion",
    "food_protein_conversion_factor",
    "food_update_log_entry",
    "foundation_food",
    "input_food",
    "lab_method",
    "lab_method_code",
    "lab_method_nutrient",
    "market_acquisition",
    "measure_unit",
    "nutrient",
    "nutrient_incoming_name",
    "retention_factor",
    "sample_food",
    "sr_legacy_food",
    "sub_sample_food",
    "sub_sample_result",
    "survey_fndds_food",
    "wweia_food_category",
);

foreach($tablelist as $table)
{
    $result=$mysql->query("SELECT COUNT(*) FROM $table");
    $row=$result->fetch_row();
    printf("%35s has %7d records\n", $table, $row[0]);
    $result->close();
}