<?php
function responseSuccess($responseData){
		$data = array();
		$data['result'] = $responseData['result'];
		$data['message'] = $responseData['message'];
		$data['uploadimage'] = $responseData['uploadimage'];
		$data['headerimage'] = $responseData['headerimage'];
		$data['totalproduct'] = $responseData['totalproduct'];
		//TotalProduct
		$data['statusCode'] = 200;
		$data['status'] = 1;
		echo json_encode($data);
	}
	
	function responseError($responseData){
		$data = array();
		$data['result'] = $responseData['result'];
		$data['message'] = $responseData['message'];
		$data['statusCode'] = 400;
		$data['status'] = 0;
		echo json_encode($data);
	}

	function responseNewSuccess($responseData){

	/*	print_r($responseData);
		exit();*/

		$data = array();
		$data['result'] = $responseData['result'];
		$data['message'] = $responseData['message'];
		/*$data['uploadimage'] = $responseData['uploadimage'];
		$data['headerimage'] = $responseData['headerimage'];
		$data['totalproduct'] = $responseData['totalproduct'];*/
		//TotalProduct
		$data['statusCode'] = 200;
		$data['status'] = 1;
		echo json_encode($data);
		exit();
	}
?>