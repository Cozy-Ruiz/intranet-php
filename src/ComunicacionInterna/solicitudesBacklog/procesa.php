<?php error_reporting(0); ?>
<?php
print "<p>Comienzo</p>\n";
for ($i = 0; $i < 100000; $i++) {
    print "<p>$i</p>\n";
}
print "<p>Final</p>\n";
echo $_POST['referencia'];
?>