<?php 
echo 'start';

$csv_file = '"store";"websites";"attribute_set";"type";"categories";"sku";"has_options";"name";"url_key";"country_of_manufacture";"msrp_enabled";"msrp_display_actual_price_type";"meta_title";"meta_description";"image";"small_image";"thumbnail";"custom_design";"page_layout";"options_container";"gift_message_available";"image_label";"small_image_label";"thumbnail_label";"url_path";"status";"visibility";"brand";"tax_class_id";"is_recurring";"weight";"price";"special_price";"msrp";"description";"short_description";"specification";"meta_keyword";"custom_layout_update";"news_from_date";"news_to_date";"special_from_date";"special_to_date";"custom_design_from";"custom_design_to";"qty";"min_qty";"use_config_min_qty";"is_qty_decimal";"backorders";"use_config_backorders";"min_sale_qty";"use_config_min_sale_qty";"max_sale_qty";"use_config_max_sale_qty";"is_in_stock";"low_stock_date";"notify_stock_qty";"use_config_notify_stock_qty";"manage_stock";"use_config_manage_stock";"stock_status_changed_auto";"use_config_qty_increments";"qty_increments";"use_config_enable_qty_inc";"enable_qty_increments";"is_decimal_divided";"stock_status_changed_automatically";"use_config_enable_qty_increments";"product_name";"store_id";"product_type_id";"product_status_changed";"product_changed_websites"'."\r\n";

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

// $sql = "SELECT * FROM product GROUP BY prod_id ASC LIMIT 0 , 500";
// $file_name = 'to_mahento_1.csv';

// $sql = "SELECT * FROM product GROUP BY prod_id ASC LIMIT 500,500";
// $file_name = 'to_mahento_2.csv';

// $sql = "SELECT * FROM product GROUP BY prod_id ASC LIMIT 1000,500";
// $file_name = 'to_mahento_3.csv';

// $sql = "SELECT * FROM product GROUP BY prod_id ASC LIMIT 1500,500";
// $file_name = 'to_mahento_4.csv';

// $sql = "SELECT * FROM product GROUP BY prod_id ASC LIMIT 2000,500";
// $file_name = 'to_mahento_5.csv';

$sql = "SELECT * FROM product GROUP BY prod_id ASC LIMIT 2500,500";
$file_name = 'to_mahento_6.csv';

// ----------------------------------------------------
// $sql = "SELECT * FROM product GROUP BY prod_id ASC";
// $file_name = 'to_mahento_prod.csv';
// ----------------------------------------------------


$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$cat = '';
	$url_key = str_replace('.html', '', $row['sku']);

	$csv_file .= '"admin";"base";"Default";"simple";"'.$cat.'";"'.$row['sku'].'";"0";"'.$row['name'].'";"'.$url_key.'";"";"Use config";"Use config";"";"";"'.$row['img_big'].'";"'.$row['img_small'].'";"'.$row['img_thumb'].'";"";"No layout updates";"Product Info Column";"No";"";"";"";"'.$row[url].'";"Enabled";"Catalog, Search";"'.$row['brand'].'";"None";"No";"'.$row['weight'].'";"'.$row['msrp'].'";"";"";"'.$row['descr_full'].'";"'.$row['descr_short'].'";"'.$row['specifications'].'";"";"";"";"";"";"";"";"";"'.$row['qty'].'";"0";"1";"0";"0";"1";"1";"1";"0";"1";"'.$row['stock'].'";"";"";"1";"0";"1";"0";"1";"0";"1";"0";"0";"0";"1";"'.$row['name'].'";"0";"simple";"";""'."\r\n";
}

$file = fopen($file_name,"w");
fwrite($file,trim($csv_file));
fclose($file);

echo 'finished';