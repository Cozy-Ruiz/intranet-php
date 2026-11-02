<?php
include 'adodb.inc.php';
$db = ADONewConnection('oci8');
$db->Connect('localhost', 'adodb', 'C0yote71', 'FREEPDB1');
$db->debug = true;

//var_dump( $db->MetaIndexes('x') );
//print_r( $db->MetaIndexes('t1') );
//print_r( $db->MetaIndexes('t1', true ) );

print_r( $db->MetaIndexes('t2', true ) );
