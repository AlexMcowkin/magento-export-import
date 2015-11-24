<?php
echo 'start';

$csv_file = '"category_id";"url"'."\r\n";

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

$sql = "SELECT entity_id, path FROM mgnt_catalog_category_entity AS mcce ORDER BY entity_id";
$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$csv_file .= '"'.$row["entity_id"].'";"'.$row["path"].'"'."\r\n";
}

$file_name = 'cat_path.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($csv_file));
fclose($file);

echo 'finished';