<?php 
try{
    $db=new PDO("mysql:host=localhost;dbname=crm;charset=utf8","root","mysql");
   

}catch(PDOEXception $hata){
    echo $hata->getMessage();
}

$url = "http://localhost/crm";
