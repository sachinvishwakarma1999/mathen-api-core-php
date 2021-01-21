<?php
include('../config.php'); 
$conn->set_charset('utf8');
class Utils
{

// ##############################
// ###        HELPERS         ###
// ##############################

    /**
     * return the Integration URL by default.
     * $prodActive : true if integration is On going
     * @param $prodActive
     * @return string
     */
    function getPayzenURL($prodActive)
    {
        if ($prodActive) {
            return 'https://secure.payzen.co.in/vads-payment/entry.silentInit.a';
        }
        return 'https://payzenindia-q08.lyra-labs.fr/vads-payment/entry.silentInit.a';
    }

    /**
     * Function that computes the signature.
     *
     * @param $params : table containing the fields to send in the payment form.
     * @param $key : TEST or PRODUCTION key
     * @param $signature_algo :  either SHA-1 either HMAC_SHA-356 defined in SignatureAlgorithm.php
     * @return string
     */
    function getSignature($params, $key, $signature_algo)
    {

        //Initialization of the variable that will contain the string to encrypt
        $signature_content = "";

        //sorting fields alphabetically
        ksort($params);


        foreach ($params as $name => $value) {

            //Recovery of vads_ fields
            if (substr($name, 0, 5) == 'vads_') {

                //Concatenation with "+"
                $signature_content .= $value . "+";
            }
        }
        //Adding the key at the end
        $signature_content .= $key;

        if ($signature_algo == "SHA-1") {
            //Encoding base64 encoded chain with SHA-1 algorithm
            $signature = sha1($signature_content);
        } else {
            //Encoding base64 encoded chain with HMAC-SHA-256 algorithm
            $signature = base64_encode(hash_hmac('sha256', $signature_content, $key, true));
        }

        return $signature;
    }

    /**
     * Enable debug verifications
     */
    function debug($param, $payzen_backend_url)
    {

        $hasError = false;
        foreach ($param as $key => $value) {

            if (empty($value)) {
                echo('<p id="msgAttention"> Warning: Key <b>' . $key . '</b> is empty. 
                    Please ensure that the minimum parameters required are satisfied</p>');
                $hasError = true;
            }

            if ($hasError) {
                echo('<br/>');
                echo('<p>Please ensure that the minimum parameters required are satisfied</p><br/>');
                echo('<p>This page should return a <b>blank</b> page with a similar json containing the payment link: </p>');
                echo('<p>{"status":"INITIALIZED","redirect_url":"https://payzenindia-q08.lyra-labs.fr:443/vads-payment/exec.silent_init_display.a;jsessionid=7e2DABeD8458F11CfeB5caeB.?RemoteId=cb58614c5b9842fc880730532297aa02&cacheId=660175231905081044491"}</p>');
                exit();
            }
        }
        if (preg_match("/http(.*)payzen(.*)silentInit.entry(.*)/", $payzen_backend_url)) {
            echo('<p>The $payzen_backend_url must be similar to  <b>https://http(.*)payzen(.*)/vads-payment/entry.silentInit.a</b></p>');
            exit();
        }

    }

    /**
     * Call Payzen backend server
     * @param $params
     * @param $payzen_backend_url
     */
    function call_payzen_backend($params, $payzen_backend_url)
    {

        // array to string with '&' separator
        $string_params = "";
        foreach ($params as $key => $value) {
            $string_params = $string_params . $key . "=" . $value . '&';
        }
        $string_params = substr($string_params, 0, strlen($string_params) - 1); //remove last '&'
        $string_params = str_replace("+", "%2B", $string_params);


        // prepare curl options
        $curl_connection = curl_init($payzen_backend_url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $string_params); // set params to post

        // curl request to the payzen backend to get  the URL the webview of the app should target
        $result = curl_exec($curl_connection);

        // we print the result of the request so that the mobile App can retrieve the provided URL for the payment
        print_r($result);

        curl_close($curl_connection);
    }

}


