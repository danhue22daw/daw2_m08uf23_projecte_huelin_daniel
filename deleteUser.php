<?php
	require 'vendor/autoload.php';
	use Laminas\Ldap\Attribute;
	use Laminas\Ldap\Ldap;
	
	ini_set('display_errors', 0);
	#
	# Entrada a esborrar: usuari 3 creat amb el projecte zendldap2
	#
	if($_POST['uid']){
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
    	# Esborrant l'entrada
    	#
    	$ldap = new Ldap($opcions);
    	$ldap->bind();
    	try{
    	    $ldap->delete($dn);
    	    echo "<b>Usuari esborrat</b><br>"; 
    	} catch (Exception $e){
    	   echo "<b>Aquest usuari no existeix</b><br>";
    	}
	}
?>

<html>
	<head>
		<title>
			ESBORRANT USUARI AMB LDAP
		</title>
	</head>
	<body>
		<form action="http://zend-dahuse.fjeclot.net/autent/deleteUser.php" method="POST">
			UID: <input type="text" name="uid" required><br>
			Unitat Organitzativa: <input type="text" name="ou" required><br>
			<input type="submit" value="Esborra usuari" />
			<input type="reset" value="Neteja" />
		</form><br>
		<a href="http://zend-dahuse.fjeclot.net/autent/menu.php">Torna al menu</a>
	</body>
</html>