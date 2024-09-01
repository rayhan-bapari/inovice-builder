<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Invoice Template</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    require_once 'invoice.php';
    $invoice = new Invoice('INV-001', 'ORD-001');
    $invoice->setClientDetails('Md.Rayhan Bapari, +8801626317700');
    $invoice->addItem('Product 1', 2, 100);
    $invoice->addItem('Product 2', 3, 150);
    $invoice->addItem('Product 3', 1, 200);
    $invoice->addTax(10);
    $invoice->applyDiscount(5);
    echo $invoice->generateInvoice();
    ?>
</body>

</html>
