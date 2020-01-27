<?php 
include 'dbc.php';
page_protect();

include 'config.php';

if(!checkAdmin()) {
header("Location: login.php");
exit();
}

$page_limit = 10; 


$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @ereg_replace('admin','',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');

// filter GET values
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}

if($post['doBan'] == 'Ban') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysql_query("update users set banned='1' where id='$id'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if($_POST['doUnban'] == 'Unban') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysql_query("update users set banned='0' where id='$id'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if($_POST['doDelete'] == 'Delete') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysql_query("delete from users where id='$id'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if($_POST['doApprove'] == 'Approve') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysql_query("update users set approved='1' where id='$id'");
		
	list($to_email) = mysql_fetch_row(mysql_query("select user_email from users where id='$uid'"));	
 
$message = 
"Hello,\n
Thank you for registering with us. Your account has been activated...\n

*****LOGIN LINK*****\n
http://$host$path/login.php

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

@mail($to_email, "User Activation", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion()); 
	 
	}
 }
 
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];	 
 header("Location: $ret");
 exit();
}

$rs_all = mysql_query("select count(*) as total_all from users") or die(mysql_error());
$rs_active = mysql_query("select count(*) as total_active from users where banned='1'") or die(mysql_error());
$rs_total_pending = mysql_query("select count(*) as tot from users where approved='0'");						   

list($total_pending) = mysql_fetch_row($rs_total_pending);
list($all) = mysql_fetch_row($rs_all);
list($active) = mysql_fetch_row($rs_active);


    echo $header;

	if (isset($_SESSION['user_id'])) {
	
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
		  <h2 class="title">Gestione Utenti</h2>
				<div class="entry">
				<table id="hor-zebra">
					<thead><tr><th scope="col">Totale Utenti</th>
					<th scope="col">Bannati</th>
					</tr></thead>
					<tbody>
					<tr>
          <td><?php echo $all;?></td>
          <td><?php echo $active; ?></td>
        </tr>
		</tbody></table>
		

      <p><?php 
	  if(!empty($msg)) {
	  echo $msg[0];
	  }
	  ?></p>
<form name="form1" method="get" action="admin.php">
<p align="center"><strong>Cerca utente:</strong> &nbsp;
                <input name="q" type="text" id="q" size="40">&nbsp;&nbsp;<input name="doSearch" type="submit" id="doSearch2" value="Search">&nbsp;&nbsp;&nbsp;[ inserisci username o email (vuoto per tutti) ] </p>
              <p align="center"> 
                <input type="radio" name="qoption" value="recent">
                ultimi aggiunti
                <input type="radio" name="qoption" value="banned">
                utenti bannati 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                [ filtro ricerca: si possono non selezionare per cercare tutto ]</p>
            
              </form></td>
    
      <p>
        <?php if ($get['doSearch'] == 'Search') {
	  $cond = '';
	  if($get['qoption'] == 'pending') {
	  $cond = "where `approved`='0' order by date desc";
	  }
	  if($get['qoption'] == 'recent') {
	  $cond = "order by date desc";
	  }
	  if($get['qoption'] == 'banned') {
	  $cond = "where `banned`='1' order by date desc";
	  }
	  
	  if($get['q'] == '') { 
	  $sql = "select * from users $cond"; 
	  } 
	  else { 
	  $sql = "select * from users where `user_email` LIKE '%$_REQUEST[q]%' or `user_name` LIKE '%$_REQUEST[q]%' ";
	  }

	  
	  $rs_total = mysql_query($sql) or die(mysql_error());
	  $total = mysql_num_rows($rs_total);
	  
	  if (!isset($_GET['page']) )
		{ $start=0; } else
		{ $start = ($_GET['page'] - 1) * $page_limit; }
	  
	  $rs_results = mysql_query($sql . " limit $start,$page_limit") or die(mysql_error());
	  $total_pages = ceil($total/$page_limit);
	  
	  ?>
      <p> 
      <p>
      <p align="right"> 
        <?php 
	  
	  // outputting the pages
		if ($total > $page_limit)
		{
		echo "<div><strong>Pages:</strong> ";
		$i = 0;
		while ($i < $page_limit)
		{
		
		
		$page_no = $i+1;
		$qstr = ereg_replace("&page=[0-9]+","",$_SERVER['QUERY_STRING']);
		echo "<a href=\"admin.php?$qstr&page=$page_no\">$page_no</a> ";
		$i++;
		}
		echo "</div>";
		}  ?>
		</p>
		<form name "searchform" action="admin.php" method="post">
		<table id="hor-zebra">
					<thead>
					<tr><th scope="col">ID</th>
					<th scope="col">Data</th>
					<th scope="col">Username</th>
					<th scope="col">Email</th>
					<th scope="col">Ban</th>
					<th scope="col">Azioni</th>
					</tr></thead>
					<tbody>
          <?php 
		  $cont=0;
		  $odd="";
		  while ($rrows = mysql_fetch_array($rs_results)) {
		  	if ($cont%2==0){$odd="";}
		  else {$odd='class="odd"';}
		  $cont++;
		  ?>
          <tr <?php echo $odd;?>> 
            <td><input name="u[]" type="checkbox" value="<?php echo $rrows['id']; ?>" id="u[]"><?php echo $rrows['id']; ?></td>
            <td><?php echo $rrows['date']; ?></td>
            <td> <div align="center"><?php echo $rrows['user_name'];?></div></td>
            <td><?php echo $rrows['user_email']; ?></td>
            <td>
			<span id="ban<? echo $rrows['id']; ?>"> 
              <?php if(!$rrows['banned']) { echo "NO"; } else {echo "SI"; }?>
             </span> </td>
            <td> 
		<?php	
		
		if ($rrows['user_level']==1){echo '<a href="edituser.php?lastid='.$rrows['id'].'"><img src="images/gestione.gif" title="Gestione Utente"></a>';}
		
		?>
			 <a href="javascript:void(0);" onclick='$("#edit<?php echo $rrows['id'];?>").show("slow");' ><img src="images/edit.png" title="Modifica"></a> 
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "ban", id: "<? echo $rrows['id']; ?>" } ,function(data){ $("#ban<? echo $rrows['id']; ?>").html(data); });'><img src="images/nonvisible.png" title="BAN"></a> 
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "unban", id: "<? echo $rrows['id']; ?>" } ,function(data){ $("#ban<? echo $rrows['id']; ?>").html(data); });'><img src="images/visibile.png" title="Rimuovi BAN"></a> 
             
             </td>
          </tr>
          <tr> 
            <td colspan="6">
			<div style="display:none;font: normal 11px arial; padding:10px; background: #e6f3f9" id="edit<?php echo $rrows['id']; ?>">
			<form name="edit<?php echo $rrows['id']; ?>" action="" method="get"> 
			<input type="hidden" name="id<?php echo $rrows['id']; ?>" id="id<?php echo $rrows['id']; ?>" value="<?php echo $rrows['id']; ?>">
			Username: <input name="user_name<?php echo $rrows['id']; ?>" id="user_name<?php echo $rrows['id']; ?>" type="text" size="10" value="<?php echo $rrows['user_name']; ?>" >
			Email:<input id="user_email<?php echo $rrows['id']; ?>" name="user_email<?php echo $rrows['id']; ?>" type="text" size="20" value="<?php echo $rrows['user_email']; ?>" >
			Livello: <input id="user_level<?php echo $rrows['id']; ?>" name="user_level<?php echo $rrows['id']; ?>" type="text" size="5" value="<?php echo $rrows['user_level']; ?>" > 1->utente,5->admin
			<br><br>Nuova Password: <input id="pass<?php echo $rrows['id']; ?>" name="pass<?php echo $rrows['id']; ?>" type="text" size="20" value="" > (lasciare vuoto)
			<input name="doSave" type="button" id="doSave" value="Salva" 
			onclick='$.get("do.php",{ cmd: "edit", pass:$("input#pass<?php echo $rrows['id']; ?>").val(),user_level:$("input#user_level<?php echo $rrows['id']; ?>").val(),user_email:$("input#user_email<?php echo $rrows['id']; ?>").val(),user_name: $("input#user_name<?php echo $rrows['id']; ?>").val(),id: $("input#id<?php echo $rrows['id']; ?>").val() } ,function(data){ $("#msg<?php echo $rrows['id']; ?>").html(data); });'> 
			<a  onclick='$("#edit<?php echo $rrows['id'];?>").hide();' href="javascript:void(0);">chiudi</a>
		  </form>
		  <div style="color:red" id="msg<?php echo $rrows['id']; ?>" name="msg<?php echo $rrows['id']; ?>"></div>
		  </div>
		  </td>
          </tr>
          <?php } ?>
		  </tbody>
        </table>
	    <p><br>
          <input name="doBan" type="submit" id="doBan" value="Ban">
          <input name="doUnban" type="submit" id="doUnban" value="Unban">
          <input name="doDelete" type="submit" id="doDelete" value="Delete">
          <input name="query_str" type="hidden" id="query_str" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
      </form>
	  
	  <?php } ?>
      &nbsp;</p>
	  	  
	</p>
					
</div>	
	  <?php
	  if($_POST['doSubmit'] == 'Create')
{
$rs_dup = mysql_query("select count(*) as total from users where user_name='$post[user_name]' OR user_email='$post[user_email]'") or die(mysql_error());
list($dups) = mysql_fetch_row($rs_dup);

if($dups > 0) {
	die("The user name or email already exists in the system");
	}

if(!empty($_POST['pwd'])) {
  $pwd = $post['pwd'];	
  $hash = PwdHash($post['pwd']);
 }  
 else
 {
  $pwd = GenPwd();
  $hash = PwdHash($pwd);
  
 }
 
mysql_query("INSERT INTO users (`user_name`,`user_email`,`pwd`,`approved`,`date`,`user_level`)
			 VALUES ('$post[user_name]','$post[user_email]','$hash','1',now(),'$post[user_level]')
			 ") or die(mysql_error()); 



$message = 
"Thank you for registering with us. Here are your login details...\n
User Email: $post[user_email] \n
Passwd: $pwd \n

*****LOGIN LINK*****\n
http://$host$path/login.php

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

if($_POST['send'] == '1') {

	mail($post['user_email'], "Login Details", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion()); 
 }
echo "<div class=\"msg\">User created with password $pwd....done.</div>"; 
}

	  ?>
  

<?php
echo $cont_end;


$lk='
<li><a href="register.php">Aggiungi Utente</a></li>
<li><a href="admin.php?q=&doSearch=Search">Elenco Utenti</a></li>

<li><a href="#">FAQ</a></li>';
side($lk);

echo $footer;

?>