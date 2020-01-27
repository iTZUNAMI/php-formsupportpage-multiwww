<?php

include("config.php");
dbconn();


//obbligatorio da passare
if (!isset ($_GET['id'])) {echo "errore...!"; $id=-1;}
else{$id=$_GET['id'];}



//inserisco nuovi campi form
if (isset ($_POST['k'])) { 

//se k==1 normale

$email=$_POST['email'];



$sql="INSERT INTO email VALUES('$id','$email')";
$result=mysql_query($sql) or die (mysql_error());

echo "ok";

}








?>

NUOVO FORM:
<form method="POST" action="addmail.php?id=<?php echo $id;?>">

Email: <input type="text" name="email" />
<br>
<input type="submit" value="Aggiungi"/>
<input type="hidden" name="k" value="1" />
</form>