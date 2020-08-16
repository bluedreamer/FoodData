#!/bin/bash
set +x

host="$1";
db="$2";
user="$3";
password="$4";

table_list=$(mysql --skip-column-names -h $host -u $user -p$password -e "SET SESSION group_concat_max_len=4096; SELECT GROUP_CONCAT(TABLE_NAME SEPARATOR ' ') FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=\"$db\"")

for table in $table_list
do
  mysqldump --no-data -h $host -u $user -p$password $db $table > schema/$table.sql
done
