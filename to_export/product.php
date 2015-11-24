<?php
echo 'start';

$csv_file = '"entity_id";"type";"store";"attribute_set";"msrp";"name";"price";"sku";"url_path";"weight";"brand";"brand_value";"qty";"is_in_stock"'."\r\n";

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

$sql = "SELECT mcpf1.entity_id, mcpf1.msrp, mcpf1.name, mcpf1.price, mcpf1.sku, mcpf1.url_path, mcpf1.weight, mcpf1.brand, mcpf1.brand_value, mcsi.qty, mcsi.is_in_stock 
FROM mgnt_catalog_product_flat_1 AS mcpf1
LEFT JOIN mgnt_cataloginventory_stock_item AS mcsi
ON mcpf1.entity_id=mcsi.product_id WHERE mcpf1.price > 0 ORDER BY mcpf1.entity_id";
$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$csv_file .= '"'.$row["entity_id"].'";"simple";"default";"default";"'.$row["msrp"].'";"'.$row["name"].'";"'.$row["price"].'";"'.$row["sku"].'";"'.$row["url_path"].'";"'.$row["weight"].'";"'.$row["brand"].'";"'.$row["brand_value"].'";"'.$row["qty"].'";"'.$row["is_in_stock"].'"'."\r\n";
}

$file_name = 'product.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($csv_file));
fclose($file);

echo 'finished';