<?php

require 'src/models/Product.php';
require 'config.php';

class productClassTest extends PHPUnit_Framework_TestCase {
    
    public function testProductCreation(){
        global $conn;
        $testName = 'Chicken';
        $testPrice = 100;
        $testDescription = 'Super good chicken';
        
        $testProduct1 = new Product;
        $testProduct1->create($conn, $testName, $testPrice, $testDescription);
        
        $testProduct2 = new Product;
        $testProduct2->setName($testName);
        $testProduct2->setPrice($testPrice);
        $testProduct2->setDescription($testDescription);

        $this->assertEquals($testProduct1->getName(), $testProduct2->getName());
        $this->assertEquals($testProduct1->getPrice(), $testProduct2->getPrice());
        $this->assertEquals($testProduct1->getDescription(), $testProduct2->getDescription());
        
        
    }

}
