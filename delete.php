<?php
$dsn = 'mysql:host=localhost;dbname=test;charset=utf8;port:3306';
$db_user = 'root';
$db_pass = '';
try{
  $db = new PDO($dsn, $db_user, $db_pass);
  $id = isset($_GET['id'])?$_GET['id']:false;
  if($id){
    $query = $db->prepare('DELETE FROM filme WHERE filme_id = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    header('Location:read.php');
  }
}catch(PDOException $e){
  echo $e->getMessage();
  die();
}
