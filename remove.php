<?php 
include 'dbc.php';
page_protect();

include 'config.php';

echo $header;

	if (isset($_SESSION['user_id'])) {
	
	$id=$_SESSION['user_id'];
	$admin=0;
	$user=$_GET['u'];
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
	$id_richiesta=$_GET['id_richiesta'];
?>
	  <h2 class="title">Conferma rimozione richiesta</h2>
				<div class="entry">
				
					<p>
					<?php
				if ($_GET['rem']==1)
				{				
					if ($admin==1){
					
				//rimozione fasulla
					$sql="UPDATE cliente_form_$user SET cancella='1' WHERE id_richiesta='$id_richiesta' ";
					$result=mysql_query($sql) or die (mysql_error());
					
					echo "Cancellazione 'FASULLA' effettuata con successo<br/>";
					echo "<a href='edituser.php?lastid=$user'>Torna alle richieste</a>";
					
					
					}
					else
					{
					
				//rimozione fasulla
					$sql="UPDATE cliente_form_$id SET cancella='1' WHERE id_richiesta='$id_richiesta' ";
					$result=mysql_query($sql) or die (mysql_error());
					
					echo "Cancellazione effettuata con successo.<br/>";
					echo "<a href='myaccount.php'>Torna alle richieste</a>";
					
					}
					
				}
				else
				{
				?>
				
				<p>
		
				
				&nbsp;&nbsp;&nbsp;
				<center>
				<p>
				<font size="+3">Rimuovere il Contatto <?php echo $id_richiesta;?> ?</font>
				</p>
				<?php
				if ($admin==1){
			   echo '<a href="remove.php?u='.$user.'&id_richiesta='.$id_richiesta.'&rem=1"><font size="+3">SI</font></a>';
				}
				else{
				  echo '<a href="remove.php?id_richiesta='.$id_richiesta.'&rem=1"><font size="+3">SI</font></a>';
				}
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript: history.go(-1)"><font size="+3">NO</font></a>
				</center>
				</p>
				<?php
				}
					?>
					</p>
					
					<br><br><br><br>
					
			</div>

<?php
echo $cont_end;


$lk='
<li><a href="myaccount.php">I Miei Contatti</a></li>
<li><a href="#">FAQ</a></li>';
side($lk);
echo $footer;

?>