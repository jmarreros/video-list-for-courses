<?php

$file_name  = preg_replace("([^\w\s\d\-_~,;\[\]\(\)])", "", $file_name);
$file_name  = str_replace(' ', '-', strtolower($file_name)).'.json';

// // Export json data
header("Content-type: application/json");
header("Content-Disposition: attachment; filename=".$file_name);

print $course;