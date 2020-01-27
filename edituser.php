<?php 
include 'dbc.php';
page_protect();

include 'config.php';

echo $header;

	if (isset($_SESSION['user_id'])) {
	
	$id=$_SESSION['user_id'];
	$lastid=$_GET['lastid'];
	
	$var="";
	
	if (checkAdmin()) {$var.='
	
	<li><a href="admin.php">Gestione Clienti</a></li>
	<li><a href="admin.php?q=&doSearch=Search">Elenco Clienti</a></li>
	<li><a href="register.php">Nuovo Cliente</a></li>
	';}
	
	$var.='
   <li><a href="mysettings.php">Impostazioni</a></li>
   <li><a href="logout.php">ESCI</a></li>';
	
	
	
	menu($var);
	}

	echo $header_2;
	echo $cont;
?>
	  <h2 class="title"><img src="images/gestione.gif" title="Gestione Utente">&nbsp;&nbsp;gestione utente</h2>
			
				<div class="entry">
					<p>
							<table id="hor-zebra">
					<thead>
					<tr><th scope="col">ID</th>
					<th scope="col">Nome</th>
					<th scope="col">Username</th>
					<th scope="col">Email</th>
					<th scope="col">Gestione utente</th>
					</tr></thead>
					<tbody>
			<?php
					$sql="SELECT * from users WHERE id='$lastid'";
					$result=mysql_query($sql) or die (mysql_error());
					 while ($rrows = mysql_fetch_array($result)) {
					 echo "<tr>";
					  echo "<td>".$rrows['id']."</td>";
					  echo "<td>".$rrows['full_name']."</td>";
					  echo "<td>".$rrows['user_name']."</td>";
					  echo "<td>".$rrows['user_email']."</td>";
				    echo "<td>
						<a href='myadmin.php?u=".$rrows['id']."'><img src='images/richi.gif' title='Visualizza Richieste'></a>&nbsp;&nbsp;
					<a href='newform.php?id=".$rrows['id']."'><img src='images/form.gif' title='Gestione Form'></a>&nbsp;&nbsp;
					<a href='newmail.php?id=".$rrows['id']."'><img src='images/add.gif' title='Gestione Email'></a>&nbsp;&nbsp;
					<a href='genera.php?u=".$rrows['id']."'><img src='images/html.gif' title='Codice HTML'></a>
					
					</td>";
					$a="<a href='myadmin.php?u=".$rrows['id']."'><img src='images/richi.gif' title='Visualizza Richieste'></a>&nbsp;&nbsp;";
					$b="<a href='newform.php?id=".$rrows['id']."'><img src='images/form.gif' title='Gestione Form'></a>&nbsp;&nbsp;";
					$c="<a href='newmail.php?id=".$rrows['id']."'><img src='images/add.gif' title='Gestione Email'></a>&nbsp;&nbsp;";
					}
					
			
			
			?>
			
			</tbody>
			</table>
		</p>
				<p>
		  <h2 class="title"><?php echo $c;?>email attive</h2>
<?php
			//filtro per pagina, ordine, verso
					$sql="SELECT * from email WHERE id='$lastid'";
					$result=mysql_query($sql) or die (mysql_error());
				//	echo $sql;
					
				//elenco
							echo '<table id="hor-zebra">
					<thead><tr><th scope="col">EMAIL</th>
					</tr></thead>
					<tbody>';

					while ($row=mysql_fetch_array($result))

					{
				
					echo "<tr><td>".$row['email']."  &nbsp;&nbsp;<img src='images/remove.gif'>&nbsp;<a href='newmail.php?c=".$row['email']."&id=".$lastid."'>Rimuovi</a></td></tr>";
				
					} 
			
			?>
			
			</table>
      </p>
		<p>
		  <h2 class="title"><?php echo $b;?>form attivi</h2>
		<?php
			//filtro per pagina, ordine, verso
					$sql="SELECT * from cliente_form_$lastid WHERE id_richiesta='$lastid'";
					$result=mysql_query($sql) or die (mysql_error());
				//	echo $sql;
					
				//elenco
							echo '<table id="hor-zebra">
					<thead><tr><th scope="col">FORM</th>
					</tr></thead>
					<tbody>';
			
					$i=4;
					$num_fields=mysql_num_fields($result); 
					//echo $num_fields;
					while ($i<$num_fields)

					{
					$th=mysql_field_name($result, $i);
					echo "<tr><td>".strtoupper($th)."</td></tr>";
					$i++;
					} 
			
			?>
			
			</table>
      </p>
	  
	  <p>
	   <h2 class="title"><?php echo $a;?>ultime richieste</h2>
	   
	   <?php
	   //filtro per pagina, ordine, verso
					$sql="SELECT id_richiesta, date_format(data, '%d-%m-%Y %H:%i') as data,letto,cancella from cliente_form_$lastid ORDER BY id_richiesta DESC LIMIT 0,8 ";
					$result=mysql_query($sql) or die (mysql_error());
				//	echo $sql;
					
                    //elenco
					echo '<table id="hor-zebra">
					<thead><tr><th scope="col">ID CONTATTO</th>
					<th scope="col">DATA RICHIESTA</th>
					<th scope="col">STATO</th>
					<th scope="col">AZIONE</th>
					<th scope="col">APPROVAZIONE</th>
					</tr></thead>
					<tbody>';
						$odd="";
						$cont=0;
							while ($row = mysql_fetch_array($result)){
							if ($cont%2==0){$odd="";}
							else {$odd='class="odd"';}
							$cont++;
							//se cancellato lui nn vede
							if ($row['cancella']==0){
							
									echo "<tr ".$odd."><td>".$row['id_richiesta']."</td><td>".$row['data']."";
									
									if ($row['letto']==0){echo "<td><em><strong>Non letto</strong></em></td>";}
									else {echo "<td>Letto</td>";}
									
									echo "<td><a href='viewer.php?u=".$lastid."&id_richiesta=".$row['id_richiesta']."'>Visualizza</a></td>";
									
									echo "<td><img src='images/remove.gif'>&nbsp;<a href='remove.php?u=".$lastid."&id_richiesta=".$row['id_richiesta']."'>Rimuovi</a></td>";
									
									echo "</tr>";
							}
						if ($row['cancella']==1){
							
									echo "<tr ".$odd."><td>".$row['id_richiesta']."</td><td>".$row['data']."";
									
									if ($row['letto']==0){echo "<td><em>N + <strong>Rimosso</strong></em></td>";}
									else {echo "<td>L + <strong>Rimosso</strong></td>";}
									
									echo "<td><a href='viewer.php?u=".$lastid."&id_richiesta=".$row['id_richiesta']."'>Visualizza</a></td>";
									
									echo "<td><img src='images/remove.gif'>&nbsp;<a href='remove.php?u=".$lastid."&id_richiesta=".$row['id_richiesta']."'>Rimuovi</a></td>";
									
									echo "</tr>";
							}
						
							
							}
								echo "</tbody></table>";
	   ?>
	   
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