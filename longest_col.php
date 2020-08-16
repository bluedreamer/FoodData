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
        $this->name=$name;
        $this->minlen=10000;
        $this->minlen_text="";
        $this->maxlen=0;
        $this->maxlen_text="";
        $this->types=array();
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
            else if(empty($value))
            {
                $value=null;
            }

            $type=gettype($value);
            if(!isset($col->types[$type]))
            {
                $col->types[$type]=0;
            }
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
        $tlist=$type . '=' . $count . $sep;
        $sep=',';
    }
    printf("%s max=%d (%s) min=%d (%s) (%s)\n", $col->name, $col->maxlen, $col->maxlen_text, $col->minlen, $col->minlen_text, $tlist);
}