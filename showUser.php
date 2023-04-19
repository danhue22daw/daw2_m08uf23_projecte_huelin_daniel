<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;
ini_set('display_errors',0);
if ($_GET['usr'] && $_GET['ou']){
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
    $entrada='uid='.$_GET['usr'].',ou='.$_GET['ou'].',dc=fjeclot,dc=net';
    $usuari=$ldap->getEntry($entrada);
    if($usuari){
        echo "<b><u>".$usuari["dn"]."</b></u><br>";
        foreach ($usuari as $atribut => $dada) {
            if ($atribut != "dn") echo $atribut.": ".$dada[0].'<br>';
        }
    }else{
        echo "No hi ha cap usuari amb uid '".$_GET['usr']."' de la ou '".$_GET['ou']."'";
    }
}
?>
<html>
<head>
<title>
MOSTRANT DADES D'USUARIS DE LA BASE DE DADES LDAP
</title>
</head>
<body>
<h2>Formulari de selecció d'usuari</h2>
<form action="http://zend-dahuse.fjeclot.net/autent/showUser.php" method="GET">
Unitat organitzativa: <input type="text" name="ou"><br>
Usuari: <input type="text" name="usr"><br>
<input type="submit" value="Mostra l'usuari"/>
<input type="reset"/>
</form><br>
		<a href="http://zend-dahuse.fjeclot.net/autent/menu.php">Torna al menu</a>
</body>
</html>