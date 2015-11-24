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

// $file = fopen('cat_prod_id.csv', 'r');

// $r = 0;
// $_pn = '';
// while ($row = fgetcsv($file, 10000, ";"))
// {
//    $r++;

//    if(($r == 1)) {continue;}

//    if($row[1] == 2) {continue;}
   
//    $sql_ins="INSERT INTO prod_cat (id, cat_id, prod_id, prod_cat) VALUES ('', '$row[0]', '$row[1]', '')";
//    $query = $db->query($sql_ins);

//    // $_pathNumber = $row['1'];
//    // $pathNumber = explode('/', $_pathNumber);
//    // foreach($pathNumber as $pn)
//    // {
//       // if(($pn == 1) OR ($pn == 2)) {continue;}
//       // else {$_pn .= $pn.'/';}
//    // }
//    // $sql_upd = "UPDATE category SET path_number = :path_number WHERE cat_id = :cat_id";
//    // $stmt = $db->prepare($sql_upd);
//    // $stmt->bindParam(':path_number', rtrim($_pn,'/'));       
//    // $stmt->bindParam(':cat_id', $row['0']);
//    // $stmt->execute(); 
//    // $_pn = '';
// }

// fclose($file);

$sql = "SELECT path_text, cat_id FROM category ";
$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
   if(empty($row['path_text'])) {continue;}

   $sql_upd = "UPDATE prod_cat SET prod_cat = :prod_cat WHERE cat_id = :cat_id";
   $stmt = $db->prepare($sql_upd);
   $stmt->bindParam(':prod_cat', $row['path_text']);       
   $stmt->bindParam(':cat_id', $row['cat_id']);
   $stmt->execute(); 
}



