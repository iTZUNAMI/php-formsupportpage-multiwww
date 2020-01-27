<?php 
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
************************************************************/
include 'dbc.php';
page_protect();

include 'config.php';

$err = array();
$msg = array();

if($_POST['doUpdate'] == 'Update')  
{


$rs_pwd = mysql_query("select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysql_fetch_row($rs_pwd);
$old_salt = substr($old,0,9);

//check for old password in md5 format
	if($old === PwdHash($_POST['pwd_old'],$old_salt))
	{
	$newsha1 = PwdHash($_POST['pwd_new']);
	mysql_query("update users set pwd='$newsha1' where id='$_SESSION[user_id]'");
	$msg[] = "Nuova password aggiornata";
	//header("Location: mysettings.php?msg=Your new password is updated");
	} else
	{
	 $err[] = "Vecchia password invalida";
	 //header("Location: mysettings.php?msg=Your old password is invalid");
	}

}

if($_POST['doSave'] == 'Save')  
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


mysql_query("UPDATE users SET
			`full_name` = '$data[name]',
			`address` = '$data[address]',
			`tel` = '$data[tel]',
			`fax` = '$data[fax]',
			`country` = '$data[country]',
			`website` = '$data[web]'
			 WHERE id='$_SESSION[user_id]'
			") or die(mysql_error());

//header("Location: mysettings.php?msg=Profile Sucessfully saved");
$msg[] = "Profilo aggiornato";
 }
 
$rs_settings = mysql_query("select * from users where id='$_SESSION[user_id]'"); 

echo $header;

	if (isset($_SESSION['user_id'])) {
	
	$var="";
	
	if (checkAdmin()) {
	$var='
	<li><a href="admin.php">Gestione Clienti</a></li>
	<li><a href="admin.php?q=&doSearch=Search">Elenco Clienti</a></li>
	<li><a href="register.php">Nuovo Cliente</a></li>
	  <li><a href="mysettings.php">Impostazioni</a></li>
   <li><a href="logout.php">ESCI</a></li>
	';
	
	$admin=1;
	}
	else{
	$var='
   <li><a href="myaccount.php">I Miei Contatti</a></li>
   <li><a href="mysettings.php">Impostazioni</a></li>
   <li><a href="logout.php">ESCI</a></li>';
	}
	menu($var);
	}

	echo $header_2;
	echo $cont;
?>

        <?php	
	if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* Error - $e <br>";
	    }
	  echo "</div>";	
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"msg\">" . $msg[0] . "</div>";

	   }
	  ?>
      </p>
	  <?php while ($row_settings = mysql_fetch_array($rs_settings)) {?>
      <form action="mysettings.php" method="post" name="myform" id="myform">
        <table id="hor-zebra">
          <tr> 
            <td colspan="2">Nome Cliente<br> <input name="name" type="text" id="name"  class="required" value="<? echo $row_settings['full_name']; ?>" size="50"> 
             </td>
          </tr>
          <tr> 
            <td colspan="2">Contatti<br> 
              <textarea name="address" cols="40" rows="4" class="required" id="address"><? echo $row_settings['address']; ?></textarea> 
            </td>
          </tr>
          <tr> 
            <td>Provincia</td>
            <td><input name="country" type="text" id="country" value="<? echo $row_settings['country']; ?>" ></td>
          </tr>
          <tr> 
            <td width="27%">Telefono</td>
            <td width="73%"><input name="tel" type="text" id="tel" class="required" value="<? echo $row_settings['tel']; ?>"></td>
          </tr>
          <tr> 
            <td>Fax</td>
            <td><input name="fax" type="text" id="fax" value="<? echo $row_settings['fax']; ?>"></td>
          </tr>
          <tr> 
            <td>Sito Web</td>
            <td><input name="web" type="text" id="web" class="optional defaultInvalid url" value="<? echo $row_settings['website']; ?>"> 
              </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>Username</td>
            <td><input name="user_name" type="text" id="web2" value="<? echo $row_settings['user_name']; ?>" disabled></td>
          </tr>
          <tr> 
            <td>Email</td>
            <td><input name="user_email" type="text" id="web3"  value="<? echo $row_settings['user_email']; ?>" disabled></td>
          </tr>
        </table>
        <p align="center"> 
		<br>
          <input name="doSave" type="submit" id="doSave" value="Save">
        </p>
      </form>
	  
	  <?php } ?>
	  <br>
      <h3 class="titlehdr">Cambia Password</h3>
      <form name="pform" id="pform" method="post" action="">
        <table id="hor-zebra">
          <tr> 
            <td width="31%">Vecchia Password</td>
            <td width="69%"><input name="pwd_old" type="password" class="required password"  id="pwd_old"></td>
          </tr>
          <tr> 
            <td>Nuova Password</td>
            <td><input name="pwd_new" type="password" id="pwd_new" class="required password"  ></td>
          </tr>
        </table>
        <p align="center"> 
		<br>
          <input name="doUpdate" type="submit" id="doUpdate" value="Update">
        </p>
        <p>&nbsp; </p>
      </form>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
	   
      <p align="right">&nbsp; </p></td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

<?php
echo $cont_end;


side(1);

echo $footer;

?>
