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
$sql = "SELECT id, path_number FROM category";
$query = $db->query($sql);
while($row = $query->fetch(PDO::FETCH_ASSOC))
{
   if(empty($row['path_number'])) {continue;}

   $str = '';

   $pthArr = explode('/', $row['path_number']); //    7/8/15
   foreach ($pthArr as $value)
   {
      $sql2 = "SELECT name FROM category WHERE cat_id = $value";
      $query2 = $db->query($sql2);
      while($row2 = $query2->fetch(PDO::FETCH_ASSOC))
      {
         $str .= $row2['name'].'/';
      }
   }

   $sql_upd = "UPDATE category SET path_text = :path_text WHERE id = :id";
   $stmt = $db->prepare($sql_upd);
   $stmt->bindParam(':path_text', rtrim($str,'/'));
   $stmt->bindParam(':id', $row['id']);
   $stmt->execute();

}
