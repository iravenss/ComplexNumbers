<?php
namespace tests;
use PHPUnit\Framework\TestCase;

use CalculatorApp\Calculator;
use CalculatorApp\ComplexNumber;

class CalculatorTest extends TestCase
{
    public function testOperationSum(){

        $anyNum = new ComplexNumber(35,45);
        $operation = new \CalculatorApp\Operations\Sum($anyNum,$anyNum);
        $result = $operation->getResult();

        $this->assertEquals(70,$result->real);
        $this->assertEquals(90,$result->imaginary);
    }

    public function testOperationDif(){

        $num1 = new ComplexNumber(24,24);
        $num2 = new ComplexNumber(14,12);
        $operation = new \CalculatorApp\Operations\Dif($num1,$num2);
        $result = $operation->getResult();
        $this->assertEquals(10,$result->real);
        $this->assertEquals(12,$result->imaginary);
    }

    public function testMultiply(){

        $num1 = new ComplexNumber(2,3);
        $num2 = new ComplexNumber(-1,1);
        $operation = new \CalculatorApp\Operations\Multiply($num1,$num2);
        $result = $operation->getResult();
        $this->assertEquals(-5,$result->real);
        $this->assertEquals(-1,$result->imaginary);
    }


    public function testDivide(){
        $num1 = new ComplexNumber(13,1);
        $num2 = new ComplexNumber(7,-6);
        $operation = new \CalculatorApp\Operations\Divide($num1,$num2);
        $result = $operation->getResult();
        $this->assertEquals(1,$result->real);
        $this->assertEquals(1,$result->imaginary);

    }





}