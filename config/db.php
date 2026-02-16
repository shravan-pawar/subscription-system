<?php
$conn = pg_connect("host=localhost dbname=subscription_system user=postgres password=psql");

if (!$conn) {
    die("Connection failed");
}
?>
