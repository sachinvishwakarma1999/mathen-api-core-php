<?php
require_once '../Payment/lib/SignatureAlgorithm.php';
include('../config.php'); 

class Config {
    public $site_id = "55553049";                                       // Shop Id
    public $key = "2476571170939606";                                           // use PRODUCTION certificate

    public $prodActive = false;                                     // keep false until the integration is over
    public $signatureAlgorithm = SignatureAlgorithm::HMAC_SHA_256;  // keep as is
}
