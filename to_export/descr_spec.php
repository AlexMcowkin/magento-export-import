<?php
echo 'start';

$csv_file = '"product_id";"spec_descr"'."\r\n";

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

$sql = "SELECT mcpf1.entity_id, mcpet.value
FROM mgnt_catalog_product_flat_1 AS mcpf1
LEFT JOIN mgnt_catalog_product_entity_text AS mcpet
ON mcpf1.entity_id=mcpet.entity_id WHERE mcpf1.price > 0 AND mcpet.attribute_id = 131 ORDER BY mcpf1.entity_id";
$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$csv_file .= '"'.$row["entity_id"].'";"'.$row["value"].'"'."\r\n";
}


$file_name = 'descr_spec.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($csv_file));
fclose($file);

echo 'finished';

// SELECT r1.entity_id, r1.value AS descr, r2.value AS efat
// FROM
//   (SELECT entity_id, value FROM mgnt_catalog_product_entity_text WHERE attribute_id = 67) r1,
//   (SELECT entity_id, value FROM mgnt_catalog_product_entity_text WHERE attribute_id = 131) r2
// WHERE r1.entity_id = r2.entity_id

