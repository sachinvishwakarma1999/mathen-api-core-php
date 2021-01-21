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
        // $order_id=$_GET['order_id'];
        // $amount=$_GET['amount'].'00';
        // $fname=$_GET['fname'];
        // $lname=$_GET['lname'];
        // $email=$_GET['email'];
        // $phone=$_GET['phone'];
        // $address=$_GET['address'];
        // $state=$_GET['state'];
        // $city=$_GET['city'];
        // preg_match('/([0-9]+\.[0-9]+)/', $rs, $matches);
        // $float_val= (float) $matches[1];

        return[
            'order_id' => (string)rand(13246512344, $order_id),
            'amount' => $amount,
            // 'cust_first_name' =>$fname,
            // 'cust_last_name' =>$lname,
            // 'cust_email' => $email,
            // 'cust_cell_phone' =>$phone,
            // 'cust_address' => $address,
            // 'cust_state' =>$state,
            // 'cust_city' => $city,
        ];

    }
}
