<?php

include("config.php");
dbconn();


if (isset ($_GET['k'])) {

//inserisco in tab_cliente cliente nuovo
$nome=$_POST['nome'];
$url=$_POST['url'];


/*
CREATE TABLE cliente(
id INT NOT NULL AUTO_INCREMENT, 
nome VARCHAR(30), 
url VARCHAR(100)
);
*/

$sql="INSERT INTO cliente(nome,url) VALUES ('$nome','$url')";
$result=mysql_query($sql) or die (mysql_error());


//creo tabella_cliente_form_id (last insert)
$lastid=mysql_insert_id();

//nessuna colonna init
/*
CREATE TABLE cliente(
id INT NOT NULL AUTO_INCREMENT, 
data DATETIME (NOW)
);
*/
$sql2="CREATE TABLE cliente_form_$lastid(id_richiesta INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(id_richiesta),data DATETIME)";

$result=mysql_query($sql2) or die (mysql_error());

echo "inserimento ok - $lastid";

}
 
 
?>

NUOVO CLIENTE:

<br>

<form method="POST" action="newclient.php?k=1">
Nome: <input type="text" name="nome" />
Url: <input type="text" name="url" />
e altri dati..
<input type="submit" value="Aggiungi"/>

</form>



















