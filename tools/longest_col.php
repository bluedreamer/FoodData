#!/usr/bin/php
<?php

$line_no=1;

$fp=fopen($argv[1], "r");
if($fp===false)
{
    die("Couldn't open file");
}
class coldata
{
    public $name;
    public $minlen;
    public $maxlen;
    public $types;
    public $maxlen_text;
    public $minlen_text;

    function __construct($name)
    {
        $this->name = $name;
        $this->minlen = 10000;
        $this->minlen_text = "";
        $this->maxlen = 0;
        $this->maxlen_text = "";
        $this->types["boolean"] = 0;
        $this->types["integer"] = 0;
        $this->types["double"] = 0;
        $this->types["string"] = 0;
        $this->types["array"] = 0;
        $this->types["object"] = 0;
        $this->types["resource"] = 0;
        $this->types["resource (closed)"] = 0;
        $this->types["NULL"] = 0;
        $this->types["unknown type"] = 0;
    }
}
$columns=[];
while($row=fgetcsv($fp, 10000, ","))
{
    if($line_no==1)
    {
        foreach($row as $name)
        {
            $col=new coldata($name);
            $columns[]=$col;
        }
    }
    else
    {
        $field_count=count($row);
        for($i=0; $i < $field_count; ++$i)
        {
            $col=$columns[$i];
            $value=$row[$i];

            if(is_numeric($value))
            {
                $value=$value+0;
            }

            if(empty($value))
            {
                $value=null;
            }

            $type=gettype($value);
            $col->types[$type]++;

            $len=strlen($value);
            if($len > $col->maxlen)
            {
                $col->maxlen=$len;
                $col->maxlen_text=$value;
            }
            if($len < $col->minlen)
            {
                $col->minlen=$len;
                $col->minlen_text=$value;
            }
        }
    }
    ++$line_no;
}

foreach($columns as $col)
{
    $tlist="";
    $sep='';
    foreach($col->types as $type => $count)
    {
        if($count!=0)
        {
            $tlist.=$sep . $type . '=' . $count;
            $sep=',';
        }
    }
    printf("%s max=%d (%s) min=%d (%s) (%s)\n", $col->name, $col->maxlen, $col->maxlen_text, $col->minlen, $col->minlen_text, $tlist);
}
