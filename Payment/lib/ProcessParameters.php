<?php
require_once '../Payment/config/AdditionalParams.php';
include('../config.php'); 
$conn->set_charset('utf8');

class ProcessParameters
{
    private $postedParams;

    public function __construct()
    {
        $this->postedParams = !empty($_POST['payzenParams']) ? json_decode($_POST['payzenParams'], true) : [];
    }


    public function getAdditionalParameters()
    {
        $params [] = [];

        $predefinedLabels =  (new AdditionalParams()) -> getAdditionalParamsLabels();


        foreach ( $predefinedLabels as $label => $value ){
            if(isset($this->postedParams[$label]) || empty($predefinedLabels[$label]) ){
                $params["vads_".$label] = $this->postedParams[$label];
            }else{
                if(!empty($predefinedLabels[$label])){
                    $params["vads_".$label] = $predefinedLabels[$label];
                }
            }
        }
        return $params;
    }

    public function getAmountParameter(){
        global $postedParams;

        return  ['vads_amount' => isset($postedParams['amount'])? $postedParams['amount'] : ''];
    }
}
