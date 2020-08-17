#!/usr/bin/php
<?php
include_once "filelist.php";

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

$mysql=new mysqli($host, $user, $password, $db);
if($mysql->connect_error)
{
    die("Couldn't connect to database: " . $mysql->connect_error);
}
$mysql->autocommit(false);

foreach($filelist as $table)
{
    $result=$mysql->query("SELECT COUNT(*) FROM $table");
    $row=$result->fetch_row();
    printf("%35s has %7d records\n", $table, $row[0]);
    $result->close();
}