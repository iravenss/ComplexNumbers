<?php
namespace tests;
use PHPUnit\Framework\TestCase;

use CalculatorApp\Calculator;
use CalculatorApp\ComplexNumber;
use CalculatorApp\TrigComplexNumber;
use CalculatorApp\Parser;

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


    public function testParseAlgebraic(){
        $parser = new Parser("12-3i");

        $this->assertEquals(12,$parser->getReal());
        $this->assertEquals(-3,$parser->getImaginary());
    }

    public function testParseTrig(){
        $pi = pi();
        $phi = $pi / 2;
        $string = "2*(cos($phi)+sin($phi)*i)";
        $parser = new Parser($string);
        $this->assertEquals(0,$parser->getReal());
        $this->assertEquals(2,$parser->getImaginary());
    }


    public function testTrigEqualAlgebraic(){
        $algebraicNumber = new ComplexNumber(0,2);

        $pi = pi();
        $phi = $pi / 2;
        $radius = 2;

        $trigNumber = new TrigComplexNumber($radius,$phi);
        $this->assertEquals($algebraicNumber->real,$trigNumber->real);
        $this->assertEquals($algebraicNumber->imaginary,$trigNumber->imaginary);
    }

}