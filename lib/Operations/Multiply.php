<?php


namespace CalculatorApp\Operations;
use CalculatorApp\ComplexNumber as ComplexNumber;


/**
 * Class Multiply
 * @package CalculatorApp\Operations
 */
final class Multiply extends Operation
{

    /**
     * @return string
     */
    public function getOperationSymbol():string
    {
        return " * ";
    }

    /**
     * @param ComplexNumber ...$numbers
     * @return ComplexNumber
     */
    final protected function calc(ComplexNumber ...$numbers) : ComplexNumber
     {
         $result = array_shift($numbers);
         foreach($numbers as $complex)
         {
             $real = ($result->real * $complex->real) - ($result->imaginary * $complex->imaginary);
             $imaginary = ($result->real * $complex->imaginary) +
                 ($result->imaginary * $complex->real);
             $result = new ComplexNumber($real, $imaginary);
         }
         return $result;
     }


}