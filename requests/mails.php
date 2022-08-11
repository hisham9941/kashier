<?php

require_once('../config.php');

$start_due_date = date("Y-m-d");
$end_due_date = date("Y-m-d") . 'T00:00:00.000Z';
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://test-api.kashier.io/paymentRequests/MID-1902-526?currency=EGP&paymentStatus=unpaid&startDueDate=' . $start_due_date .'&endDueDate=' . $end_due_date . '',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: 33ae559e34af351df6ed66b3b714d29d$b6a06d0b28b9c1f1e1c8e5ef774996866f7e55a3782e069a744fb3056ea5ffececb7e402a3c65a98377faa47c6414fb8',
    'Cookie: AWSALB=3RgRfkMcMg2tMdzfQXA2kzm4kH5DijdOeqMq+8XiqNGIgP0VY0zB4xHj1pGr1gAkLroKauHF3FgjhcYkZpiIjWP5laXPt6EzEllX4YdyjPhZCNjwY4yD1aVhkpIp; AWSALBCORS=3RgRfkMcMg2tMdzfQXA2kzm4kH5DijdOeqMq+8XiqNGIgP0VY0zB4xHj1pGr1gAkLroKauHF3FgjhcYkZpiIjWP5laXPt6EzEllX4YdyjPhZCNjwY4yD1aVhkpIp'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$result = json_decode($response, false);

$kashier_response_ids = [];
$kashier_response_payment_ids = [];
foreach($result->response->data as $response_id){
    // echo $response_id->_id . '<br>';
    array_push($kashier_response_ids,$response_id->_id);
    $kashier_response_payment_ids[$response_id->_id] = $response_id->paymentRequestId;
}

$stmt = $conn->prepare("SELECT * FROM memberships WHERE kashier_id IN ('" . implode("','", $kashier_response_ids) . "')");
$stmt->execute();
$customer_get_mail_sql = $stmt->fetchAll();
// $customer_get_mail_sql[$i]['customer_email'];


$kashier_sql_list = [];

echo 'Total Invoices Will Be Sent: ' . count($customer_get_mail_sql) . '<br>';



for($i=0; $i<count($customer_get_mail_sql); $i++){
    $kashier_sql_list[$customer_get_mail_sql[$i]['kashier_id']] = [$customer_get_mail_sql[$i]['customer_email'],$customer_get_mail_sql[$i]['customer_name']];

    $request_customr_name =  $kashier_sql_list[$customer_get_mail_sql[$i]['kashier_id']][1];
    $request_customer_email =  $kashier_sql_list[$customer_get_mail_sql[$i]['kashier_id']][0];
    $request_customer_payment_id =  $kashier_response_payment_ids[$customer_get_mail_sql[$i]['kashier_id']];

    echo $i . ' - ' . $request_customr_name . ' ' . $request_customer_email . ' ' . $request_customer_payment_id . '<br>';

    sendmail($request_customr_name, $request_customer_email, $request_customer_payment_id);
}


function sendmail($request_customr_name, $request_customer_email, $request_customer_payment_id){

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://test-api.kashier.io/paymentRequest/sendInvoiceBy',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('operation' => 'email','customerEmail' => $request_customr_name,'subDomainUrl' => 'http://merchant.kashier.io/en/prepay','urlIdentifier' => $request_customer_payment_id,'customerName' => $request_customr_name),
  CURLOPT_HTTPHEADER => array(
    'Authorization: 33ae559e34af351df6ed66b3b714d29d$b6a06d0b28b9c1f1e1c8e5ef774996866f7e55a3782e069a744fb3056ea5ffececb7e402a3c65a98377faa47c6414fb8',
    'Cookie: AWSALB=Y3KPZs9vtonZySggqe3wjsPxLoxisoRelD9Jg6Z0knJTOT1fKWX00WQpBmrPu4CtbkpOW1ZRtV/mapTLtqc65bYgy3uJty/BC8RtZ76qKcezJCw3l0HCcQLWW1vd; AWSALBCORS=Y3KPZs9vtonZySggqe3wjsPxLoxisoRelD9Jg6Z0knJTOT1fKWX00WQpBmrPu4CtbkpOW1ZRtV/mapTLtqc65bYgy3uJty/BC8RtZ76qKcezJCw3l0HCcQLWW1vd'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

}