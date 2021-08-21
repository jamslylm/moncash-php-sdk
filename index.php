<?php

use JLM\MonCash\Configurations;
use JLM\MonCash\Credentials;
use JLM\MonCash\Order;
use JLM\MonCash\PaymentMaker;
use JLM\MonCash\TransactionCaller;

require_once 'vendor/autoload.php'
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon Cash PHP SDK | Jamsy-love MINE</title>
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/sticky-footer.css" rel="stylesheet">
</head>
<?php
// Leave only for debuging purposes
ini_set('display_errors', 1);

// setting credentials for authentication
$client = "c1bf0a27d6bbb217a599c9e25480c11d";
$secret = "oHrr4tbnB1PH0uz6VQNUvVVDNVNvk0WiIXZWBAed4-CBCwilT8yUdS87AZoPrtqN";
$configArray = Configurations::getSandboxConfigs();

$test = new Credentials($client, $secret, $configArray);
if (!isset($_GET['paymentDetails'])) {


    $amount = 350;
    $orderId = 9876543210;

    $theOrder = new Order($orderId, $amount);

    // Call to the payment request
    $paymentObj = PaymentMaker::makePaymentRequest($theOrder, $test, $configArray);

}
?>
<body>
<main role="main" class="container">
    <h1 class="mt-5">Enjoy the Mon-Cash-PHP-SDK</h1>
    <p class="lead">This sample is created in order to show a hands on process to interact with the MonCash PHP SDK
        integration into php projects.</p>
    <hr/>
    <br/>

    <?php
    if (!isset($_GET['paymentDetails'])) {
        ?>
        <p>
            The MonCash Button is generated with the following information: <br/>
        <ul>
            <li><strong>OrderId</strong>: <?= $theOrder->getOrderId() ?></li>
            <li><strong>Amount</strong>: <?= $theOrder->getAmount() ?></li>
        </ul>
        </p>
        <p><a href='<?= $paymentObj->getRedirect(); ?>' target='_blank'><img style="width: 150px;"
                                                                             src='https://moncashbutton.digicelgroup.com/Moncash-middleware/resources/assets/images/MC_button.png'></a>
        </p>
        <p><a class="btn btn-primary btn-lg" style="width:100%;" href='./?paymentDetails=1'>Go to payment details</a>
        </p>
    <?php } ?>

    <?php
    if (isset($_GET["paymentDetails"])) {
        $amount = 90;
        $orderId = 1559796839;

        $theOrder = new Order($orderId, $amount);

        $transactionDetails = TransactionCaller::getTransactionDetailsByOrderIdRequest($theOrder, $test, $configArray);
        ?>
        <h3>Here the details for the issued payment</h3>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <td>Reference</td>
                <td>Transaction ID</td>
                <td>Cost</td>
                <td>Message</td>
                <td>Payer</td>
                <td>Date</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $transactionDetails->getPayment()->getReference(); ?></td>
                <td><?php echo $transactionDetails->getPayment()->getTransactionId(); ?></td>
                <td><?php echo $transactionDetails->getPayment()->getCost(); ?></td>
                <td><?php echo $transactionDetails->getPayment()->getMessage(); ?></td>
                <td><?php echo $transactionDetails->getPayment()->getPayer(); ?></td>
                <td><?php echo date('D M d Y', $transactionDetails->getTimestamp() / 1000); ?></td>
            </tr>
            </tbody>
        </table>
        <p><a class="btn btn-primary btn-lg" style="width:100%;" href='./'>Go back </a></p>
        <?php
    }
    ?>


</main>
</body>
</html>