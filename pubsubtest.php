<?php

use PHPUnit\Framework\TestCase;	

require_once("EventEmitter.php");
require_once("subscriber.php");


class pubsubtest extends TestCase
{    
    public function testInstanceOf()
    {
        $pub = new Applicaton\PubSub\EventEmitter("test");
        $this->assertInstanceOf("Applicaton\PubSub\EventEmitter",$pub);  
    }

    public function testsub() {

       $pub = new Applicaton\PubSub\EventEmitter("test");
       $pub->setDataByKey("1","AAA");

       $sub1 = new Applicaton\PubSub\Subscriber("1", function ($pub) {
	echo "1:" . $pub->getData()[1] . PHP_EOL;
       }, 10 );

       $pub->attach($sub1);
       
       $pub->emit();
       $this->expectOutputString("1:AAA".PHP_EOL);
   }

   public function testsub2() {

       $pub = new Applicaton\PubSub\EventEmitter("test");
       $pub->setDataByKey("1","AAA");
       $pub->setDataByKey("2","BBB");
       $pub->setDataByKey("3","CCC");

       $sub1 = new Applicaton\PubSub\Subscriber("1", function ($pub) {
        echo "1:" . $pub->getData()[1] . PHP_EOL;
       }, 10 );


       $sub2 = new Applicaton\PubSub\Subscriber("2", function ($pub) {
	echo "2:" . $pub->getData()[2] . PHP_EOL;
       }, 20 );

      $sub3 = new Applicaton\PubSub\Subscriber("3", function ($pub) {
	echo "3:" . $pub->getData()[3] . PHP_EOL;
      }, 30 );

       $pub->attach($sub3);
       $pub->attach($sub1);
       $pub->attach($sub2);
 
       $pub->emit();
       $this->expectOutputString("3:CCC".PHP_EOL."2:BBB".PHP_EOL."1:AAA".PHP_EOL);
   }


}

