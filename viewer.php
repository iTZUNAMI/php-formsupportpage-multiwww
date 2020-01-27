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
	  <h2 class="title">Visualizzazione richiesta</h2>
				<p>
				<img src='images/gestione.gif'>&nbsp;<a href="javascript: history.go(-1)">Torna indietro</a>
				&nbsp;&nbsp;<img src="images/print_icon.gif" >&nbsp;&nbsp;<a href="javascript:window.print()">Stampa</a>
				&nbsp;&nbsp;&nbsp;
				<?php
				if ($admin==1)
				 {
				echo '<img src="images/remove.gif">&nbsp;<a href="remove.php?u='.$u.'&id_richiesta='.$_GET['id_richiesta'].'">Rimuovi richiesta</a>';
				 }
				else
				{
				  echo '<img src="images/remove.gif">&nbsp;<a href="remove.php?id_richiesta='.$_GET['id_richiesta'].'">Rimuovi richiesta</a>';
				}
				?>

				</p>
				<div class="entry">

					<p>
					<?php
					
					if ($admin==1){
					
					$id_richiesta=$_GET['id_richiesta'];
					
					
					//filtro per pagina, ordine, verso
					$sql="SELECT * from cliente_form_$u WHERE id_richiesta='$id_richiesta'";
					$result=mysql_query($sql) or die (mysql_error());
				//	echo $sql;
					
				//elenco
							echo '<table id="hor-zebra">
					<thead><tr><th scope="col">FORM</th>
					<th scope="col">TESTO</th>
					</tr></thead>
					<tbody>';
			
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
							
							echo "<tr><td>".strtoupper($th)."</td><td>".$camp."</td></tr>";
							}

					$i++;
					} 
		
					echo "</tbody></table>";
					
					}
					else
					{
				
					$id_richiesta=$_GET['id_richiesta'];
					
					//filtro per pagina, ordine, verso
					$sql="SELECT * from cliente_form_$id WHERE id_richiesta='$id_richiesta'";
					$result=mysql_query($sql) or die (mysql_error());
				//	echo $sql;
					
				//elenco
							echo '<table id="hor-zebra">
					<thead><tr><th scope="col">FORM</th>
					<th scope="col">TESTO</th>
					</tr></thead>
					<tbody>';
			
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
							
							echo "<tr><td>".strtoupper($th)."</td><td>".$camp."</td></tr>";
							}

					$i++;
					} 
					
 
							 /*
									echo "<tr ".$odd."><td>".$row['id_richiesta']."</td><td>".$row['data']."";
									
									if ($row['letto']==0){echo "<td><em><strong>Non letto</strong></em></td>";}
									else {echo "<td>Letto</td>";}
									
									echo "<td><a href=''>Visualizza</a></td>";
									
									echo "<td><a href=''>Rimuovi</a></td>";
									
									echo "</tr>";
								*/	
									
		
							
							
								
							
							
					echo "</tbody></table>";
					
					//letto=1 se user
					$sql="UPDATE cliente_form_$id SET letto='1' WHERE id_richiesta='$id_richiesta' ";
					$result=mysql_query($sql) or die (mysql_error());
					
					
					}
					?>
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