<?php
function mediaLess($text)
{
	$text = preg_replace('|<iframe[^>]+>.*?</iframe>|', ' ', $text);
    return preg_replace('|<img[^>]+>|', ' ', $text);
}

function haveRightsOn(App\Article $article)
{
	return App\User::roleName() === 'admin' || (Auth::user()->department_id === $article->department_id && Auth::user()->city_id === $article->city_id);
}

function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

function numOfHumans($num)
{
	$voted = "Проголосовало";
	$humans = 'человек';
	if($num > 20 && (($num-2)%10==0 or ($num-3)%10==0 or ($num-4)%10==0) || (in_array($num, [2,3,4])))
	{
		$humans = "человека";
	}
	if(($num > 20 and ($num-1)%10==0) || $num==1)
	{
		$voted = "Проголосовал";
	}
	return "$voted $num $humans";
}

function parse_csv($file)
{
	$csv = array_map('str_getcsv', file($file));
    array_walk($csv, function(&$a) use ($csv) {
      $a = array_combine($csv[0], $a);
    });
    array_shift($csv); # remove column header    
    return $csv;
}

function extractZipTo($zip_path, $directory)
{
	$zip = new \ZipArchive;
	$res = $zip->open(storage_path('app').'/'.$zip_path);
	if ($res === TRUE) {
	  $zip->extractTo(storage_path('app').'/'.$directory);
	  $zip->close();
	}
}

function flip_csv_array($csv)
{
	foreach ($csv as $key => $value)
	{
        foreach($value as $k => $v)
        {
        	$result[trim($k, '﻿"')][] = $v;
        }
    }
    return $result;
}

function kill_ufef($csv)
{
	return json_decode(str_replace('\ufeff', '', json_encode($csv)), true);
}