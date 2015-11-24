<?php
echo 'start';

$csv_file = '"entity_id";"big_image"'."\r\n";

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


$sql = "SELECT mcpf1.entity_id, mcpve.value
FROM mgnt_catalog_product_flat_1 AS mcpf1
LEFT JOIN mgnt_catalog_product_entity_varchar AS mcpve
ON mcpf1.entity_id=mcpve.entity_id WHERE mcpf1.price > 0 AND mcpve.attribute_id = 79 ORDER BY mcpf1.entity_id";
$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$csv_file .= '"'.$row["entity_id"].'";"'.$row["value"].'"'."\r\n";
}


$file_name = 'img_big.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($csv_file));
fclose($file);

echo 'finished';