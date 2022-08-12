<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <title>Kashier</title>
</head>

<?php
//Require the config file and checking the connection
require_once('config.php');
if($connection == 1):
    $stmt = $conn->prepare("SELECT id, customer_name, customer_email, total_amount, installments_period FROM memberships");
    $stmt->execute();

$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
?>
<body>
    <div class="container">
    <a href="add-new-customer.php"><button class="tableValue-btnOption">Add New +</button></a>
    <a href="./requests/invoices.php"><button class="tableValue-btnOption">All Invoices</button></a>
        <table class="container-table">
            <thead>
                <tr>
                    <th class="containerTable-lblTitle">ID</th>
                    <th class="containerTable-lblTitle">Name</th>
                    <th class="containerTable-lblTitle">Email</th>
                    <th class="containerTable-lblTitle">Installments Period</th>
                    <th class="containerTable-lblTitle">Total Amount</th>
                </tr>
            </thead>
            <tbody class="containerTable-body">
            
            <?php foreach($stmt->fetchAll() as $k=>$c_data): ?>
                <tr>
                <td class="containerTable-lblValue"><?= $c_data['id'] ?></td>
                <td class="containerTable-lblValue"><?= $c_data['customer_name'] ?></td>
                <td class="containerTable-lblValue"><?= $c_data['customer_email'] ?></td>
                <td class="containerTable-lblValue"><?= $c_data['installments_period'] ?></td>
                <td class="containerTable-lblValue"><?= $c_data['total_amount'] ?></td>
                </tr> 
            <?php endforeach; ?>
            
            </tbody>
        </table>
    </div>
</body>

</html>
<?php 
else:
echo "<h3 style='color:white;'>Connection failed: " . $e->getMessage() . '</h3>';
endif;
?>
