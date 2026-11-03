<?php
include 'adodb.inc.php';
$db = adonewconnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'adodb');
$db->metacolumnnames('people');
