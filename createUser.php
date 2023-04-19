<?php
    require 'vendor/autoload.php';
    use Laminas\Ldap\Attribute;
	use Laminas\Ldap\Ldap;

	ini_set('display_errors', 0);
	#Dades de la nova entrada
	#
	if($_POST['uid']){
    	$uid=$_POST['uid'];
    	$unorg=$_POST['uo'];
    	$num_id=$_POST['uidNumber'];
    	$grup=$_POST['gidNumber'];
    	$dir_pers=$_POST['directory'];
    	$sh=$_POST['shell'];
    	$cn=$_POST['cn'];
    	$sn=$_POST['sn'];
    	$nom=$_POST['givenName'];
    	$mobil=$_POST['mobile'];
    	$adressa=$_POST['postalAddress'];
    	$telefon=$_POST['telephoneNumber'];
    	$titol=$_POST['title'];
    	$descripcio=$_POST['description'];
    	$objcl=array('inetOrgPerson','organizationalPerson','person','posixAccount','shadowAccount','top');
    	#
    	#Afegint la nova entrada
    	$domini = 'dc=fjeclot,dc=net';
    	$opcions = [
            'host' => 'zend-dahuse.fjeclot.net',
    		'username' => "cn=admin,$domini",
       		'password' => 'fjeclot',
       		'bindRequiresDn' => true,
    		'accountDomainName' => 'fjeclot.net',
       		'baseDn' => 'dc=fjeclot,dc=net',
        ];	
    	$ldap = new Ldap($opcions);
    	$ldap->bind();
    	$nova_entrada = [];
    	Attribute::setAttribute($nova_entrada, 'objectClass', $objcl);
    	Attribute::setAttribute($nova_entrada, 'uid', $uid);
    	Attribute::setAttribute($nova_entrada, 'uidNumber', $num_id);
    	Attribute::setAttribute($nova_entrada, 'gidNumber', $grup);
    	Attribute::setAttribute($nova_entrada, 'homeDirectory', $dir_pers);
    	Attribute::setAttribute($nova_entrada, 'loginShell', $sh);
    	Attribute::setAttribute($nova_entrada, 'cn', $cn);
    	Attribute::setAttribute($nova_entrada, 'sn', $sn);
    	Attribute::setAttribute($nova_entrada, 'givenName', $nom);
    	Attribute::setAttribute($nova_entrada, 'mobile', $mobil);
    	Attribute::setAttribute($nova_entrada, 'postalAddress', $adressa);
    	Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telefon);
    	Attribute::setAttribute($nova_entrada, 'title', $titol);
    	Attribute::setAttribute($nova_entrada, 'description', $descripcio);
    	$dn = 'uid='.$uid.',ou='.$unorg.',dc=fjeclot,dc=net';
    	if($ldap->add($dn, $nova_entrada)) echo "Usuari creat";
	}
?>
<html>
	<head>
		<title>
			CREANT USUARI AMB LDAP
		</title>
	</head>
	<body>
		<form action="http://zend-dahuse.fjeclot.net/autent/createUser.php" method="POST">
			uid: <input type="text" name="uid" required><br>
			uo: <input type="text" name="uo"required><br>
			uidNumber: <input type="number" name="uidNumber" required><br>
			gidNumber: <input type="number" name="gidNumber" required><br>
			Directori personal: <input type="text" name="directory" required><br>
			Shell: <input type="text" name="shell" required><br>
			cn: <input type="text" name="cn" required><br>
			sn: <input type="text" name="sn" required><br>
			givenName: <input type="text" name="givenName" required><br>
			PostalAddress: <input type="text" name="postalAddress" required><br>
			mobile: <input type="text" name="mobile" required><br>
			telephoneNumber: <input type="text" name="telephoneNumber" required><br>
			title: <input type="text" name="title" required><br>
			description: <input type="text" name="description" required><br>
			<input type="submit" value="Crear usuari" />
			<input type="reset" value="Neteja" />
		</form><br>
		<a href="http://zend-dahuse.fjeclot.net/autent/menu.php">Torna al menu</a>
	</body>
</html>