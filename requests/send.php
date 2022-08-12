<?php
require_once('../config.php');
if($connection == 1){
  //Get the data submitted by the form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $total = $_POST["total"];
        $installments = $_POST["installments"];
    }

    // SELECT LAST ID TO ADD SPECIFIC ID
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id FROM memberships ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $invoice_last_id = $stmt->fetchAll()[0]['id'];
    $invoice_id = $invoice_last_id + 1;
    


//INSERT DATA INTO DATABASE
function dbinsert($invoice_id, $name, $email, $total, $installments, $installments_amount, $kashier_id, $conn){
  $sql = "INSERT INTO memberships (id, customer_name, customer_email, total_amount, installments_period, installments_amount, kashier_id)
  VALUES ('$invoice_id', '$name', '$email', '$total', '$installments', '$installments_amount', '$kashier_id')";
  $conn->exec($sql);
//GET ID OF LAST INSERTED DATA
  $invoice_id = $conn->lastInsertId();

  // echo "New record created successfully";
}
$due_date;
$quantity;
$total_per_due_date;
$due_date;

//Sending data to KASHIER and getting back with information needed to be saved in DB      
function requestinvoice($total, $name, $due_date, $invoice_id, $total_per_due_date, $email){
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://test-api.kashier.io/paymentRequest?currency=EGP',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "paymentType": "professional",
  "merchantId": "MID-1902-526",
  "totalAmount": "'.$total.'",
  "customerName": "'.$name.'",
  "description": "some description",
  "dueDate": "'.$due_date.'",
  "invoiceReferenceId": "'.$invoice_id.'",
  "invoiceItems": [
    {
      "description": "invoice item description",
      "quantity": "1",
      "itemName": "Membership",
      "unitPrice": "'.$total_per_due_date.'",
      "subTotal": "'.$total_per_due_date.'"
    }
  ],
  "state": "submitted",
  "tax": 0
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: 33ae559e34af351df6ed66b3b714d29d$b6a06d0b28b9c1f1e1c8e5ef774996866f7e55a3782e069a744fb3056ea5ffececb7e402a3c65a98377faa47c6414fb8',
    'Content-Type: application/json',
    'Cookie: AWSALB=Icd17fF/IhYthSbKH/xALRibaBTnC2nOzP4NlJetdZ8Il5RF8oTplBWe7Bjk/3/liTks8oX9m1josaYMWgggH7znCqEq6z/dcaZtLhqFWzxhtJOfZsh6vf1sEcU8; AWSALBCORS=Icd17fF/IhYthSbKH/xALRibaBTnC2nOzP4NlJetdZ8Il5RF8oTplBWe7Bjk/3/liTks8oX9m1josaYMWgggH7znCqEq6z/dcaZtLhqFWzxhtJOfZsh6vf1sEcU8'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
// echo $response;
$kashier_response = json_decode($response, false);
global $kashier_id;
$kashier_id = $kashier_response->response->_id;

//Setting Data to send first invoice after submitting the customer data
$mail_due_date = date("Y-m-d", strtotime($kashier_response->response->dueDate));
if($mail_due_date == date("Y-m-d")){
  require_once('share-invoice.php');
  $request_customr_name = $kashier_response->response->customerName;
  $request_customer_email = $email;
  $request_customer_payment_id = $kashier_response->response->paymentRequestId;
  
  shareInvoice($request_customr_name, $request_customer_email, $request_customer_payment_id);

  //If response is success display message
  if($kashier_response->status == 'SUCCESS'){
    echo '<h1 style="text-align:center; color:green;">3ash ya kotch</h1><br>' . 
    '<img src="../img/animation.gif" style="margin-left:auto; margin-right:auto; width:300px; display:block;"><br>' . 
    '<a href="../add-new-customer.php" style="margin-left: auto; margin-right: auto; display: block; text-align: center;">
    <button style="background: grey; color: #ffffff; height: 55px; width: 260px; border-radius: 20px; font-size: 20px;">Add Another +</button></a>';
  }else{
    echo '<h1 style="color:red; text-align:center;">Something Went Wrong</h1>';
  }
}
}



//INSTALLMENTS CONDITIONS
if ($installments == 'full'){
    $due_date = date("Y-m-d");
    $quantity = 1;
    $total_per_due_date = round($total, 2);
    $installments_amount = $total_per_due_date;
    requestinvoice($total, $name, $due_date, $invoice_id, $total_per_due_date, $email);
    dbinsert($invoice_id, $name, $email, $total, $installments, $installments_amount, $kashier_id, $conn);
    
}elseif($installments == '2months'){
    $quantity = 2;
    $total_per_due_date = round(($total / 2) ,2);
    $installments_amount = $total_per_due_date;
    for($i=0; $i<2; $i++){
      $invoice_id = $invoice_id + $i;
      requestinvoice($total, $name, date("Y-m-d",strtotime("+$i months")), $invoice_id, $total_per_due_date, $email);
      dbinsert($invoice_id, $name, $email, $total, $installments, $installments_amount, $kashier_id, $conn);
    }
}elseif($installments == '3months'){
    $quantity = 3;
    $total_per_due_date = round(($total / 3) ,2);
    $installments_amount = $total_per_due_date;
    for($i=0; $i<3; $i++){
      $invoice_id = $invoice_id + $i;
      requestinvoice($total, $name, date("Y-m-d",strtotime("+$i months")), $invoice_id, $total_per_due_date, $email);
      dbinsert($invoice_id, $name, $email, $total, $installments, $installments_amount, $kashier_id, $conn);
    }
}

}else{
    echo "<h3 style='color:white;'>Connection failed: " . $e->getMessage() . '</h3>';
}