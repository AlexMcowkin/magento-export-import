<?php
echo 'start';

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

$file = fopen('descr_spec.csv', 'r');

$r = 0;
$_pn = '';
while ($row = fgetcsv($file, 10000, ";"))
{
   $r++;
   if(($r == 1)) {continue;}

   // $sql_upd = "INSERT INTO product (id, prod_id, name, url, msrp, price, sku, weight, brand, qty, stock) 
   //             VALUES ('', :prod_id, :name, :url, :msrp, :price, :sku, :weight, :brand, :qty, :stock)";
   // $stmt = $db->prepare($sql_upd);
   // $stmt->bindParam(':prod_id', $row['0']);       
   // $stmt->bindParam(':name', $row['5']);
   // $stmt->bindParam(':url', $row['8']);       
   // $stmt->bindParam(':msrp', $row['4']);
   // $stmt->bindParam(':price', $row['6']);       
   // $stmt->bindParam(':sku', $row['7']);
   // $stmt->bindParam(':weight', $row['9']);       
   // $stmt->bindParam(':brand', $row['11']);
   // $stmt->bindParam(':qty', $row['12']);       
   // $stmt->bindParam(':stock', $row['13']);
   // $stmt->execute(); 



   $sql_upd = "UPDATE product SET specifications = :specifications WHERE prod_id = :prod_id";
   $stmt = $db->prepare($sql_upd);
   $stmt->bindParam(':prod_id', $row['0']);       
   $stmt->bindParam(':specifications', $row['1']);
   $stmt->execute(); 


   // $_pathNumber = $row['1'];
   // $pathNumber = explode('/', $_pathNumber);
   // foreach($pathNumber as $pn)
   // {
      // if(($pn == 1) OR ($pn == 2)) {continue;}
      // else {$_pn .= $pn.'/';}
   // }
   // $sql_upd = "UPDATE category SET path_number = :path_number WHERE cat_id = :cat_id";
   // $stmt = $db->prepare($sql_upd);
   // $stmt->bindParam(':path_number', rtrim($_pn,'/'));       
   // $stmt->bindParam(':cat_id', $row['0']);
   // $stmt->execute(); 
   // $_pn = '';
}

fclose($file);
