<?php 
include 'dbc.php';
page_protect();

include 'config.php';

echo $header;

	if (isset($_SESSION['user_id'])) {
	
	$id=$_SESSION['user_id'];
	$admin=0;
	$u=$_GET['u'];
	
	$var="";
	
	if (checkAdmin()) {
	
	$var.='
	<li><a href="admin.php">Gestione Clienti</a></li>
	<li><a href="admin.php?q=&doSearch=Search">Elenco Clienti</a></li>
	<li><a href="register.php">Nuovo Cliente</a></li>';
	$admin=1;
	}
	
	$var.='
   <li><a href="mysettings.php">Impostazioni</a></li>
   <li><a href="logout.php">ESCI</a></li>';
	
	
	menu($var);
	}

	echo $header_2;
	echo $cont;
?>
	  <h2 class="title">generazione codice html</h2>
	  <p class="meta"><img src="images/gestione.gif" title="Gestione Utente">&nbsp;&nbsp;<a href="javascript: history.go(-1)">Gestione Utente</a></p>
				<p>
				bisonga includere questi campi nella pagina
				</p>
				<div class="entry">
<br><br>
					<p>

					<?php
					
					if ($admin==1){
					
					$sql="SELECT * from cliente_form_$u";
					$result=mysql_query($sql) or die (mysql_error());

					$i=0;
					$num_fields=mysql_num_fields($result); 
					//echo $num_fields;
					while ($i<$num_fields)

					{
			
					$th=mysql_field_name($result, $i);
						if ($th=='id_richiesta')
						{
						$a.= "input type=\"hidden\" name=\"".$th."\" value='".$u."' <br>";
						}
							else if ($th=='letto' || $th=='cancella' || $th=='data')
							{
							//$a.= "input type=\"text\" name=\"".$th."\" value='".$u."' <br>";
							}
					
					
										else
										{
										$a.= "input type=\"text o select o textarea\" name=\"".$th."\" <br>";
										}
					$i++;
					} 
					}
					$a.= "input type=\"hidden\" name=\"uty\" value=\"URL REDIRECT THANK YOU PAGE\" <br>";
					echo $a;
					?>
		
<br><br><br>
Note: metodo GET, action su form.php del server attivo per il servizio
					</p>
					
					<br><br><br>
					
			</div>

<?php
echo $cont_end;

$lk='
<li><a href="myaccount.php">I Miei Contatti</a></li>
<li><a href="#">FAQ</a></li>';
side($lk);

echo $footer;

?>