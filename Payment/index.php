<?php
include '../Payment/lib/Payment.php';
include '../Payment/test/ConfigTest.php';
include('../config.php'); 
$conn->set_charset('utf8');
error_reporting(0);               // disable PHP errors and notices: it can create problems to parse payment URL

(new ConfigTest())->testConfig();       // basic tests
(new Payment()) -> pay();               // forward payment to payzen
// echo "esrgter";
?>