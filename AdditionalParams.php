<?php
include('../config.php'); 
$conn->set_charset('utf8');
class AdditionalParams
{
    /**
     * Here add Optional fields you would like to pass to Payzen in order to make it appear in Payzen Back-office
     * @return array of additional parameters (modifiable) to add to the parameters sent to Payzen.
     * refer to https://payzen.io/in/form-payment/quick-start-guide/send-an-html-payment-form-via-post.html
     */
    public function getAdditionalParamsLabels()
    {
        return[
            'order_id' => (string)rand(132465, 97654321),
            'amount' => "5756",
            'cust_first_name' =>"ruchita",
            'cust_last_name' =>"ruchita",
            'cust_email' => "ruchitaselectical@gmail.com",
            'cust_cell_phone' =>"9130847066",
            'cust_address' => "ruchita",
            'cust_state' => "ruchita",
            'cust_city' => "ruchita",
        ];

    }
}
