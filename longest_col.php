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
    public $maxlen;
    public $types=array();
    public $maxlen_text;

    function __construct($name)
    {
        $this->name=$name;
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
            $type=gettype($row[$i]);
            if(!isset($col->types[$type]))
            {
                $col->types[$type]=0;
            }
            $col->types[$type]++;
            $len=strlen($row[$i]);
            if($len > $col->maxlen)
            {
                $col->maxlen=$len;
                $col->maxlen_text=$row[$i];
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
        $tlist=$type . '=' . $count . $sep;
        $sep=',';
    }
    printf("%s = %d (%s) (%s)\n", $col->name, $col->maxlen, $col->maxlen_text, $tlist);
}