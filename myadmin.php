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
?>
	  <h2 class="title">Richieste contatti</h2>
	  		<p><img src="images/gestione.gif" title="Gestione Utente">&nbsp;&nbsp;<a href="javascript: history.go(-1)">Gestione Utente</a></p>
				<div class="entry">
					<p>
					<?php
					
					if ($admin==1){
					
						//id_richiesta, data, nome
					if (!isset($_GET['ord'])){$order='id_richiesta';}
					else {$order=$_GET['ord'];}
					
					if (!isset($_GET['ver'])){$ver='DESC';}
					else {$ver=$_GET['ver'];}
					
					if (!isset($_GET['p'])){$pag=0;$limit="".($pag*$resultpage).",".($resultpage)."";}
					else {
					$pag=$_GET['p'];
					
					$limit="".($pag*$resultpage).",".($resultpage)."";
					
					}
					
					
					//per il totale richieste
					$sql3="SELECT * from cliente_form_$user WHERE cancella='0' ";
					$result3=mysql_query($sql3) or die (mysql_error());
					$totr=mysql_num_rows($result3);
					
		##			
	
					//filtro per pagina, ordine, verso
					$sql="SELECT id_richiesta, date_format(data, '%d-%m-%Y %H:%i') as data,letto,cancella from cliente_form_$user ORDER BY $order $ver LIMIT $limit ";
					$result=mysql_query($sql) or die (mysql_error());
					//echo $sql;
					
					//totale / numxpage(20) 89/20= 5 pagine 1, 2, 3.. (0 - 0,20 1- 20-40 2-20,40 ok)
					
					$nump=ceil(($totr/$resultpage)); //x eccesso
							if ($totr==0){
							echo "Nessun contatto ricevuto.";
							}
							else{
						echo "<br>PAGINA: ";
									//pagine
									for ($i=0;$i<$nump;$i++)
										{
											if ($pag==$i){
									 echo " ".$i." ";

										}
										else{
								 echo '<a href="myadmin.php?u='.$user.'&p='.$i.'&ord='.$order.'&ver='.$ver.'">'.$i.'</a> ';
										  }
										 
										  
										}
							//elenco
							echo '<table id="hor-zebra">
					<thead><tr><th scope="col">ID CONTATTO <a href="myadmin.php?u='.$user.'&ord=id_richiesta&ver=ASC"><img src="images/arrow-asc.png"></a>&nbsp;<a href="myadmin.php?u='.$user.'&ord=id_richiesta&ver=DESC"><img src="images/arrow-desc.png"></a></th>
					<th scope="col">DATA RICHIESTA <a href="myadmin.php?u='.$user.'&ord=data&ver=ASC"><img src="images/arrow-asc.png"></a>&nbsp;<a href="myadmin.php?u='.$user.'&ord=data&ver=DESC"><img src="images/arrow-desc.png"></a></th>
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
									
									echo "<td><a href='viewer.php?u=".$user."&id_richiesta=".$row['id_richiesta']."'>Visualizza</a></td>";
									
									echo "<td><img src='images/remove.gif'>&nbsp;<a href='remove.php?u=".$user."&id_richiesta=".$row['id_richiesta']."'>Rimuovi</a></td>";
									
									echo "</tr>";
							}
						if ($row['cancella']==1){
							
									echo "<tr ".$odd."><td>".$row['id_richiesta']."</td><td>".$row['data']."";
									
									if ($row['letto']==0){echo "<td><em>N + <strong>Rimosso</strong></em></td>";}
									else {echo "<td>L + <strong>Rimosso</strong></td>";}
									
									echo "<td><a href='viewer.php?u=".$user."&id_richiesta=".$row['id_richiesta']."'>Visualizza</a></td>";
									
									echo "<td><img src='images/remove.gif'>&nbsp;<a href='remove.php?u=".$user."&id_richiesta=".$row['id_richiesta']."'>Rimuovi</a></td>";
									
									echo "</tr>";
							}
						
							
							}
								echo "</tbody></table>";
							
							}
					
					}
				
					?>
					</p>
					
					
					
			</div>

<?php
echo $cont_end;

$lk='
<li><a href="myadmin.php">I Miei Contatti</a></li>
<li><a href="#">FAQ</a></li>';
side($lk);

echo $footer;

?>