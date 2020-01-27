<?php

include 'dbc.php';
page_protect();

include("config.php");
dbconn();

//obbligatorio da passare
if (!isset ($_GET['id'])) {echo "errore...!"; $id=-1;}
else{$id=$_GET['id'];}

//inserisco nuovi campi form
if (isset ($_GET['k'])) {




//se k==1 normale

$campo=$_GET['campo'];

$sql="INSERT INTO email(id,email) VALUES ('$id','$campo')";
$result=mysql_query($sql) or die (mysql_error());

$ok=1;

}
//rem
if (isset ($_GET['c'])) {
$c=$_GET['c'];
$sql="DELETE FROM email WHERE email='$c'";
$result=mysql_query($sql) or die (mysql_error());

$ok=2;
}





echo $header;

	if (isset($_SESSION['user_id'])) {
	


	
	$var="";
	
	if (checkAdmin()) {$var.='
	
	<li><a href="admin.php">Gestione Clienti</a></li>
	<li><a href="admin.php?q=&doSearch=Search">Elenco Clienti</a></li>
	<li><a href="register.php">Nuovo Cliente</a></li>
	';
	
	$admin=1;
	}
	
	$var.='
   <li><a href="mysettings.php">Impostazioni</a></li>
   <li><a href="logout.php">ESCI</a></li>';
	
	menu($var);
	}

	echo $header_2;
	echo $cont;

if ($ok==1)
{
echo '<h3>Inserimento OK</h2>';
}
if ($ok==2)
{
echo '<h3>Rimozione OK</h2>';
}
?>
 
 <h2 class="title">aggiunta email utente id : <?php echo $id;?></h2>
<p class="meta"><img src="images/gestione.gif" title="Gestione Utente">&nbsp;&nbsp;<a href="edituser.php?lastid=<?php echo $id;?>">Gestione Utente</a></p>
				<div class="entry">
					<p>
					<table id="hor-zebra">
					<thead>
					<tr><th scope="col">EMAIL</th>
					<th scope="col"></th>
					</tr></thead>
					<tbody>
					<tr>
					<form method="GET" action="newmail.php">
					<td><input type="text" name="campo" size="30"/></td>
					<td><input type="submit" value="Aggiungi"/></td>
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<input type="hidden" name="k" value="1" />
					</form>
					</tr>
					</tbody>
					</table>
			<br><br>
		</p>
		
				<p>
		  <h2 class="title">email attive per inoltro</h2>
		<?php
			//filtro per pagina, ordine, verso
					$sql="SELECT * from email WHERE id='$id'";
					$result=mysql_query($sql) or die (mysql_error());
				//	echo $sql;
					
				//elenco
							echo '<table id="hor-zebra">
					<thead><tr><th scope="col">EMAIL</th>
					</tr></thead>
					<tbody>';

					while ($row=mysql_fetch_array($result))

					{
				
					echo "<tr><td>".$row['email']."  &nbsp;&nbsp;<img src='images/remove.gif'>&nbsp;<a href='newmail.php?c=".$row['email']."&id=".$id."'>Rimuovi</a></td></tr>";
				
					} 
			
			?>
			
			</table>
			<br><br><br><br>
      </p>
		
		
		</div>
		<?php
echo $cont_end;

$lk='
<li><a href="myaccount.php">I Miei Contatti</a></li>
<li><a href="#">FAQ</a></li>';
side($lk);

echo $footer;

?>