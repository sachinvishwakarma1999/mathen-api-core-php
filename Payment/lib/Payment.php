<?php
require_once '../Payment/lib/SignatureAlgorithm.php';
require_once '../Payment/config/Config.php';
require_once '../Payment/lib/Utils.php';
require_once '../Payment/lib/ProcessParameters.php';
include('../config.php'); 
$conn->set_charset('utf8');
class Payment
{
    private $utils;
    private $config;
    private $postedParams;

    public function __construct()
    {
        // getting the parameters from json object to an associative object
        $this->postedParams = !empty($_POST['payzenParams']) ? json_decode($_POST['payzenParams'], true) : [];
        $this->config = new Config();
        $this->utils = new Utils();
    }

    /**
     * Process the payment with the posted data, the config and forward it to Payzen Platform
     */
    public function pay()
    {
        $itemsToPost = $this->preparePayzenForm();
        $this->utils->call_payzen_backend($itemsToPost, $this-> utils -> getPayzenURL($this->config->prodActive));
    }

    /**
     * @return array with configured PayZen parameters
     */
    private function preparePayzenForm()
    {
       $params =  $this->getParams();
        $params['signature'] = $this->utils->getSignature(   $params,
                                                            $this->config->key,
                                                           $this->config->signatureAlgorithm);
       return $params;
    }




    private function getParams()
    {
        $paramProcessor = new ProcessParameters();

        $additionalParams = $paramProcessor -> getAdditionalParameters();
        $amountParam = $paramProcessor -> getAmountParameter();
        $params =['vads_site_id' => $this->config->site_id];

        return array_merge($params , $amountParam, $additionalParams, $this->getDefaultParams());
    }

    /**
     * @return array of default Payzen mandatory parameters configuration
     */
    private function getDefaultParams()
    {
        // prepare payzen transaction MANDATORY parameters
        $param['vads_ctx_mode'] = "PRODUCTION";
        $param['vads_page_action'] = "PAYMENT";
        $param['vads_action_mode'] = "INTERACTIVE";
        $param['vads_payment_config'] = "SINGLE";
        $param['vads_version'] = "V2";
        $param['vads_trans_id'] = gmdate("His"); //generate transaction id - should be unique throughout the day
        $param['vads_trans_date'] = gmdate("YmdHis");
        $param['vads_currency'] = "356"; //INR
        $param['vads_return_mode'] = 'GET';
        $param['vads_url_return'] = 'http://webview.return';
        $param['vads_url_success'] = 'http://webview.success';
        $param['vads_url_refused'] = 'http://webview.refused';
        $param['vads_url_cancel'] = 'http://webview.cancel';
        $param['vads_url_error'] = 'http://webview.error';
        $param['vads_language'] = "en";
        // $conn->set_charset('utf8');
        return $param;
        // print_r($param);
    }
}
