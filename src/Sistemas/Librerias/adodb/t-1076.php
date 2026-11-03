<?php
define( 'XMLS_DEBUG', true );
include 'adodb.inc.php';
$db = newAdoConnection('sqlite3');
$dsnString= 't1076-sqlite.db';
$db->connect($dsnString);
//$db->debug = true;

include_once "adodb-xmlschema03.inc.php";

$db->debug=true;

$schema = new adoSchema($db);

$xml='<?xml version="1.0"?>
<schema version="0.3">
	<table name="meta_test">
		<field name="interval" type="I4">
			<AUTO/>
			<UNSIGNED/>
			<PRIMARY/>
		</field>
		<field name="name" type="C" size="50">
			<NOTNULL/>
		</field>
		<field name="dbtype" type="C" size="20"/>
		<field name="connection" type="C" size="10"/>
		<field name="host" type="C" size="255"/>
		<field name="port" type="I4">
			<UNSIGNED/>
		</field>
		<field name="user" type="C" size="32"/>
		<field name="password" type="C" size="255"/>

		<index name="meta_index_1">
			<col>name</col>
			<col>interval</col>
		</index>
	</table>

</schema>';

$schema->parseSchemaString($xml);
$res=$schema->printSQL();

print_r($db->getAll('SELECT * FROM meta_test'));
