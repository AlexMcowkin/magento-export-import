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

$file = fopen('cat_url.csv', 'r');

$r = 0;
$_pn = '';
while ($row = fgetcsv($file, 10000, ";"))
{
   $r++;
   if(($r == 1)) {continue;}
   // $row[1] = str_replace('/', '-or-', $row[1]);
   // $sql_ins="INSERT INTO category (id, cat_id, name) VALUES ('', '$row[0]', '$row[1]')";
   // $query = $db->query($sql_ins);


   $sql_upd = "UPDATE category SET url = :url WHERE cat_id = :cat_id";
   $stmt = $db->prepare($sql_upd);
   $stmt->bindParam(':url', $row['1']);       
   $stmt->bindParam(':cat_id', $row['0']);
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
