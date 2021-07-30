<?php


namespace CalculatorApp\Operations;
use CalculatorApp\ComplexNumber as ComplexNumber;


/**
 * Class Divide
 * @package CalculatorApp\Operations
 */
final class Divide extends Operation
{

    public function getOperationSymbol():string
    {
        return " / ";
    }

     final protected function calc(ComplexNumber ...$numbers) : ComplexNumber
     {
         $result = array_shift($numbers);

         foreach($numbers as $complex)
         {
             if($complex->real == 0.0 && $complex->imaginary == 0.0)
             {
                 throw new InvalidArgumentException('Division by zero');
             }
             $delta1 = ($result->real * $complex->real) +
                 ($result->imaginary * $complex->imaginary);
             $delta2 = ($result->imaginary * $complex->real) -
                 ($result->real * $complex->imaginary);
             $delta3 = ($complex->real * $complex->real) +
                 ($complex->imaginary * $complex->imaginary);

             $real = $delta1 / $delta3;
             $imaginary = $delta2 / $delta3;

             $result = new ComplexNumber($real, $imaginary);
         }

         return $result;
     }


}