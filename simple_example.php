<?php

namespace Applicaton\PubSub;

require_once("EventEmitter.php");
require_once("subscriber.php");

$pub = new EventEmitter("test");
$pub->setDataByKey("1","AAA");
$pub->setDataByKey("2","BBB");
$pub->setDataByKey("3","CCC");

$sub1 = new Subscriber("1", function ($pub) {
					echo "1:" . $pub->getData()[1] . PHP_EOL;
}, 10 );

$sub2 = new Subscriber("2", function ($pub) {
					echo "2:" . $pub->getData()[2] . PHP_EOL;
}, 20 );

$sub3 = new Subscriber("3", function ($pub) {
					echo "3:" . $pub->getData()[3] . PHP_EOL;
}, 30 );


$pub->attach($sub2);
$pub->attach($sub1);
$pub->attach($sub3);
$pub->emit();

