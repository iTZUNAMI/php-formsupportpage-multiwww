<?php
include("config.php");
dbconn();

//obbligatorio da passare
if (!isset ($_GET['id'])) {echo "id?"; exit;}
else {$id=$_GET['id'];}

//id = id_richiesta

$sql="INSERT INTO cliente_form_$id(data, letto, cancella) VALUES(NOW(), 0, 0)";
$r1=mysql_query($sql) or die (mysql_error());

$lastid=mysql_insert_id();
//c=campo v=valore
 foreach ($_GET as $c => $v) {
     // print $c $v  
		if ($c!="id" &&  $c!="uty"){
			$sql_up="UPDATE cliente_form_$id SET $c='$v' WHERE id_richiesta='$lastid'";
			$r2=mysql_query($sql_up) or die (mysql_error());

		}
   }

 
//testo
$sql="SELECT * from cliente_form_$id WHERE id_richiesta='$lastid'";
$result=mysql_query($sql) or die (mysql_error());
//elenco
$testo='Nuova Richiesta di Informazioni: ';
			
					$i=0;
					$num_fields=mysql_num_fields($result); 
					$row = mysql_fetch_row($result);
					//echo $num_fields;
					while ($i<$num_fields)

					{
					

							$th=mysql_field_name($result, $i);
							if ($th!='letto' && $th!='cancella'){
							
							if ($th=='id_richiesta'){$th='ID CONTATTO';}
							
							$camp=$row[$i];
							//campo data
							if ($i==1){$camp=date("G:i  d/m/Y",strtotime($row[$i]));}
							
							$testo.= "\n\n".strtoupper($th)." :".$camp."";
							}

					$i++;
					} 
$testo.= "\n\nVisualizza promemoria nel sito..";

//mail per ogni id
$sql="SELECT * from email WHERE id='$id'";
$result=mysql_query($sql) or die (mysql_error());
while ($row=mysql_fetch_array($result))

					{
	
$a="".$row['email']."";
$oggetto="Richiesta Informazioni";

mail($a, $oggetto, $testo);
					} 
echo "db: ok, email: da inviare a: $a <br> redirect thank you page a : ".$_GET['uty']."";

?>
