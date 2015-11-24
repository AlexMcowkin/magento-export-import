<?php
echo 'start';

$csv_file = '"category_id";"name"'."\r\n";

try
{
	$dbhost = 'localhost';
	$dbname = 'dzustore_mgnt1'; 
	$dbuser = 'dzustore_mgnt1';
	$dbpass = 'U54mPuXoqMr9MoLu';
	
	$db = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass); 
	$db->exec('SET NAMES utf8');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
	die('Connection failed');
}

$sql = "SELECT entity_id, value FROM mgnt_catalog_category_entity_varchar AS mccev WHERE attribute_id = 35 AND store_id = 0";
$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$csv_file .= '"'.$row["entity_id"].'";"'.$row["value"].'"'."\r\n";
}

$file_name = 'cat_name.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($csv_file));
fclose($file);

echo 'finished';