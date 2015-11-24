<?php 
echo 'start';

$csv_file = '"store";"websites";"attribute_set";"type";"categories";"sku";"has_options";"name"'."\r\n";

try
{
	$dbhost = 'localhost';
	$dbname = 'test_db'; 
	$dbuser = 'root';
	$dbpass = 'root';
	
	$db = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass); 
	$db->exec('SET NAMES utf8');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
	die('Connection failed');
}

$file_name = 'to_magento_cat.csv';

$sql = "SELECT * FROM product GROUP BY prod_id ASC";
$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$cat = '';
	$sql2 = "SELECT prod_cat FROM prod_cat WHERE prod_id = {$row['prod_id']}";
	$query2 = $db->query($sql2);
	while($row2 = $query2->fetch(PDO::FETCH_ASSOC))
	{
		$csv_file .= '"admin";"base";"Default";"simple";"'.$row2['prod_cat'].'";"'.$row['sku'].'";"0";"'.$row['name'].'"'."\r\n";
	}
}

$file = fopen($file_name,"w");
fwrite($file,trim($csv_file));
fclose($file);

echo 'finished';