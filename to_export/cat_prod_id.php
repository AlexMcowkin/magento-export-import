<?php
echo 'start';

$csv_file = '"category_id";"product_id"'."\r\n";

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

$sql = "SELECT mcpf1.entity_id, mccpi.category_id, mccpi.product_id
FROM mgnt_catalog_product_flat_1 AS mcpf1
LEFT JOIN mgnt_catalog_category_product_index AS mccpi
ON mcpf1.entity_id=mccpi.product_id WHERE mcpf1.price > 0 ORDER BY mcpf1.entity_id";
$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$csv_file .= '"'.$row["entity_id"].'";"'.$row["category_id"].'"'."\r\n";
}

$file_name = 'cat_prod_id.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($csv_file));
fclose($file);

echo 'finished';