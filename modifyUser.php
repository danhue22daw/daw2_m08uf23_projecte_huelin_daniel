<?php
	require 'vendor/autoload.php';
	use Laminas\Ldap\Attribute;
	use Laminas\Ldap\Ldap;
	ini_set('display_errors', 0);
	if($_POST['attribute']){
    	
    	#
    	# Atribut a modificar --> Número d'idenficador d'usuari
    	#
    	$atribut=$_POST['attribute']; # El número identificador d'usuar té el nom d'atribut uidNumber
    	$nou_contingut=$_POST['value'];
    	if($atribut == 'gidNumber' || $atribut ==  'uidNumber'){
    	    $nou_contingut = intval($nou_contingut);
    	}
    	#
    	# Entrada a modificar
    	#
    	$uid = $_POST['uid'];
    	$unorg = $_POST['ou'];
    	$dn = 'uid='.$uid.',ou='.$unorg.',dc=fjeclot,dc=net';
    	#
    	#Opcions de la connexió al servidor i base de dades LDAP
    	$opcions = [
    		'host' => 'zend-dahuse.fjeclot.net',
    		'username' => 'cn=admin,dc=fjeclot,dc=net',
    		'password' => 'fjeclot',
    		'bindRequiresDn' => true,
    		'accountDomainName' => 'fjeclot.net',
    		'baseDn' => 'dc=fjeclot,dc=net',		
    	];
    	#
    	# Modificant l'entrada
    	#
    	$ldap = new Ldap($opcions);
    	$ldap->bind();
    	$entrada = $ldap->getEntry($dn);
    	if ($entrada){
    		Attribute::setAttribute($entrada,$atribut,$nou_contingut);
    		$ldap->update($dn, $entrada);
    		echo "Usuari modificat"; 
    	} else echo "<b>Aquest usuari no existeix</b><br><br>";	
	}
?>

<html>
	<head>
		<title>
			MODIFICANT USUARI AMB LDAP
		</title>
	</head>
	<body>
		<form action="http://zend-dahuse.fjeclot.net/autent/modifyUser.php" method="POST">
			UID: <input type="text" name="uid" required><br>
			Unitat Organitzativa: <input type="text" name="ou" required><br>
			<label>Selecciona l'atribut que vulguis modificar:</label><br>
			<input type="radio" name="attribute" value="uidNumber"/><label>uidNUmber</label><br>
			<input type="radio" name="attribute" value="gidNumber"/><label>gidNUmber</label><br>
			<input type="radio" name="attribute" value="homeDirectory"/><label>Directori Personal</label><br>
			<input type="radio" name="attribute" value="loginShell"/><label>Shell</label><br>
			<input type="radio" name="attribute" value="cn"/><label>cn</label><br>
			<input type="radio" name="attribute" value="sn"/><label>sn</label><br>
			<input type="radio" name="attribute" value="givenName"/><label>givenName</label><br>
			<input type="radio" name="attribute" value="postalAddress"/><label>postalAddress</label><br>
			<input type="radio" name="attribute" value="mobile"/><label>mobile</label><br>
			<input type="radio" name="attribute" value="telephoneNumber"/><label>telephoneNumber</label><br>
			<input type="radio" name="attribute" value="title"/><label>title</label><br>
			<input type="radio" name="attribute" value="description"/><label>description</label><br>
			<label>Inserta el nou valor:</label><br>
			<input type="text" name="value"/><br>
			<input type="submit" value="Modifica l'usuari" />
			<input type="reset" value="Neteja" />
		</form><br>
		<a href="http://zend-dahuse.fjeclot.net/autent/menu.php">Torna al menu</a>
	</body>
</html>