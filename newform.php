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
$dim=$_GET['dim'];
$campo=strtolower($campo);
$campo=str_replace(" ","_",$campo);

$sql="ALTER TABLE cliente_form_$id ADD $campo varchar ($dim);";
$result=mysql_query($sql) or die (mysql_error());

$ok=1;

}
//rem
if (isset ($_GET['c'])) {
$c=$_GET['c'];
$sql="ALTER TABLE cliente_form_$id DROP $c";
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
 
 <h2 class="title">aggiunta form utente id : <?php echo $id;?></h2>
<p class="meta"><img src="images/gestione.gif" title="Gestione Utente">&nbsp;&nbsp;<a href="edituser.php?lastid=<?php echo $id;?>">Gestione Utente</a></p>
				<div class="entry">
					<p>
					<table id="hor-zebra">
					<thead>
					<tr><th scope="col">NOME</th>
					<th scope="col">Dimensione (default 100) <br>se e' un campo di Note (lungo) impostare >100</th>
					<th scope="col"></th>
					</tr></thead>
					<tbody>
					<tr>
					<form method="GET" action="newform.php">
					<td><input type="text" name="campo" size="30"/></td>
					<td><input type="text" name="dim" size="3" value="100"/></td>
					<td><input type="submit" value="Aggiungi"/></td>
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<input type="hidden" name="k" value="1" />
					</form>
					</tr>
					</tbody>
					</table>
			<p>NOTE: CAMPO IN <strong>MINUSCOLO</strong>, LO SPAZIO SOSTITUITO CON _ (<strong>underscore</strong>) e NESSUN CARATTERE STRANO</p>
			<p>
			
			Esempi: per un campo del form "Nome" -> <strong>n</strong>ome<br>
			Anno di Nascita -> anno<strong>_</strong>nascita<br>
			Provincia -> <strong>p</strong>rovincia<br>
			</p>
			<br><br>
		</p>
		
				<p>
		  <h2 class="title">form attivi</h2>
		<?php
			//filtro per pagina, ordine, verso
					$sql="SELECT * from cliente_form_$id";
					$result=mysql_query($sql) or die (mysql_error());
				//	echo $sql;
					
				//elenco
							echo '<table id="hor-zebra">
					<thead><tr><th scope="col">FORM</th>
					<th scope="col">Azioni  (si perdono tutti i dati del campo se presenti)</th>
					</tr></thead>
					<tbody>';
			
					$i=4;
					$num_fields=mysql_num_fields($result); 
					//echo $num_fields;
					while ($i<$num_fields)

					{
					$th=mysql_field_name($result, $i);
					echo "<tr><td>".strtoupper($th)."</td><td><img src='images/remove.gif'>&nbsp;<a href='newform.php?id=".$id."&c=".$th."'>Rimuovi</a></td></tr>";
					$i++;
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