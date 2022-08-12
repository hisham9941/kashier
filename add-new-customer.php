<?php
require_once('config.php');
if($connection == 1){
?>
<link rel="stylesheet" href="style.css">
    <form action="requests/send.php" method="post" class="wpcf7-form" >
        <h1 style="text-align:center; color:white; padding-bottom:5%">Please Add Customer's Details</h1>
        <p>
           <span class="wpcf7-form-control-wrap Name">
             <input type="text" name="name" size="40" class="nameinput wpcf7-form-control wpcf7-text wpcf7-validates-as-required" placeholder="Customer Name" required>
          </span>
          <span class="wpcf7-form-control-wrap Email">
            <input type="email" name="email"  size="40" class="emailinput wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" placeholder="Customer Email" required>
          </span>
          <span class="wpcf7-form-control-wrap total">
             <input type="number" name="total" size="40" class="nameinput wpcf7-form-control wpcf7-text wpcf7-validates-as-required" placeholder="Total Amount" required>
          </span>
          <span class="wpcf7-form-control-wrap Subject flat">
            <select name="installments" class="indent wpcf7-form-control wpcf7-select wpcf7-validates-as-required" required>
              <option disabled selected value>Installments Period</option>
              <option value="full">Full</option>
              <option value="2months">2 Months</option>
              <option value="3months">3 Months</option>
            </select>
          </span>
          <input type="submit" value="Send" class="wpcf7-form-control wpcf7-submit btn">
      </p>
  </form>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $total = $_POST["total"];
  $installments = $_POST["installments"];
}


}else{
echo "<h3 style='color:white;'>Connection failed: " . $e->getMessage() . '</h3>';
}
?>