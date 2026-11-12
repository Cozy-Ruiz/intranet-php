<?php
include 'adodb.inc.php';
//$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
$db = NewADOConnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'adodb');
//print_r($rs = $db->execute('SHOW DATABASES'));
//die;
//$db->SetFetchMode(ADODB_FETCH_NUM);
print_r( $db->metaDatabases() );
