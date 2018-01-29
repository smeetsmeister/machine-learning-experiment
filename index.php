<?php

require_once("./classifier.php");

$classifier = new classifier();

//give the classifier some basic orders.

$order1 = [
    'card',
    'envelop',
    'poster'
];

$order2 = [
    'card',
    'envelop'
];

$order3 = [
    'poster',
    'poster-box'
];

$classifier->OrderToTrain($order1);
$classifier->OrderToTrain($order2);
$classifier->OrderToTrain($order3);

echo $classifier->categorize('card');
echo PHP_EOL;
echo $classifier->categorize('poster');