# FoodData

Food Data is a small project to import the nutriotional databases provided by the USDA.

It contains the schema's for MariaDB/Mysql and a PHP script to import the CSV files

## Access the raw data from the US government

The data is available for free from the US Department of Agriculture's website

* Website: https://fdc.nal.usda.gov/download-datasets.html
* The Full Data April 2020 CSV dataset was used 
* DB Column descriptions etc added from provided PDF 

## Usage

* Create the database
 ```bash
cat schema/db.sql | mysql
 ``` 
* Create all the tables
```bash
cat schema/table_*.sql | mysql usda
```
* Download and extract the data from the USDA
* Import the data into the database
```bash
cd FoodData_Central_csv_2020-04-29
../import_csv_data.php dbhost dbname dbuser dbpassword
```
 

## Version History

Version | Description | Date
--- | --- | ---
1.0.0 | Initial version. Using the "April 2020 version 2 (CSV)" dataset | 2020-08-16