<?php
require_once 'adodb.inc.php';
require_once 'adodb-datadict.inc.php';
require_once 'adodb-exceptions.inc.php';

$hostname = 'localhost';
$username = 'root';
$password = 'C0yote71';
$database = 'adodb';
$tbl      = 'tbl_1035';

$db = ADONewConnection ('mysqli');
$db->Connect ($hostname, $username, $password, $database) ;
$dict = newDataDictionary($db);

$db->debug = true;
var_dump($db->MetaColumns('xxx'));
die;

try {
	$db->execute("DROP TABLE $tbl");
} catch (Exception $e) {}
$sql = $dict->createTableSQL($tbl, <<<DEFINITION
	id       I     NOTNULL AUTO KEY,
	column1  C(30) NOTNULL,
	column2  N(10),
	txt      X
	DEFINITION
);
print_r($sql);
if ( $dict->executeSQLArray($sql) != 2) {
	echo $db->ErrorMsg();
	die;
}
echo "Test table created \n";

$dict->debug = true;
# unchanged ID column, increased size of column1, add new column
$sql = $dict->changeTableSQL($tbl, <<<DEFINITION
	id       I     NOTNULL AUTO KEY,
	column1  C(40) NOTNULL,
	added    I
	DEFINITION,
	false, false);
print_r($sql);
$dict->executesqlarray($sql, false);
