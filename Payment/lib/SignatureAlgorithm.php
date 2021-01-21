<?php
include('../config.php'); 
$conn->set_charset('utf8');
abstract class SignatureAlgorithm
{
    const HMAC_SHA_256 = "HMAC-SHA-256";
    const SHA_1 = "SHA-1";
}

