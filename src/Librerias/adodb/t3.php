<?php
//declare(strict_types=1)
include 'adodb.inc.php';

$db = newAdoConnection('mysqli');
$db->connect("localhost", 'root', 'C0yote71', 'adodb');
if(!$db->isConnected()){
    var_dump($db);
    exit(0);
}

print_r($db->metaIndexes('sessions2', false));
print_r($db->metaIndexes('sessions2', true));
die;
//$db->debug = true;
$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
$db->setFetchMode(ADODB_FETCH_BOTH);
$query  = "SELECT * FROM people LIMIT 1";
$rs = $db->execute($query);
print_r($rs->GetArray());


/**
 * @return array
 */
function f(): array {
	return [1];
}

echo chr(f()[0]);
