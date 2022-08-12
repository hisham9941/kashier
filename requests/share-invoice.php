<?php

//Function to send the First Invoice after submitting the form
function shareInvoice($request_customr_name, $request_customer_email, $request_customer_payment_id){
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
      CURLOPT_POSTFIELDS => array('operation' => 'email','customerEmail' => $request_customer_email,'subDomainUrl' => 'http://merchant.kashier.io/en/prepay','urlIdentifier' => $request_customer_payment_id,'customerName' => $request_customr_name),
      CURLOPT_HTTPHEADER => array(
        'Authorization: 33ae559e34af351df6ed66b3b714d29d$b6a06d0b28b9c1f1e1c8e5ef774996866f7e55a3782e069a744fb3056ea5ffececb7e402a3c65a98377faa47c6414fb8',
        'Cookie: AWSALB=Y3KPZs9vtonZySggqe3wjsPxLoxisoRelD9Jg6Z0knJTOT1fKWX00WQpBmrPu4CtbkpOW1ZRtV/mapTLtqc65bYgy3uJty/BC8RtZ76qKcezJCw3l0HCcQLWW1vd; AWSALBCORS=Y3KPZs9vtonZySggqe3wjsPxLoxisoRelD9Jg6Z0knJTOT1fKWX00WQpBmrPu4CtbkpOW1ZRtV/mapTLtqc65bYgy3uJty/BC8RtZ76qKcezJCw3l0HCcQLWW1vd'
      ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
    // echo $response;
    }