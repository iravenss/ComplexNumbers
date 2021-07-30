<?php


namespace CalculatorApp\Operations;
use CalculatorApp\ComplexNumber as ComplexNumber;


/**
 * Class Dif
 * @package CalculatorApp\Operations
 */
final class Dif extends Operation
{

    /**
     * @return string
     */
    public function getOperationSymbol():string
    {
        return " - ";
    }

    /**
     * @param ComplexNumber ...$numbers
     * @return ComplexNumber
     */
    final protected function calc(ComplexNumber ...$numbers) : ComplexNumber
     {
         $result = array_shift($numbers);

         foreach($numbers as $number)
         {
             $real = $result->real - $number->real;
             $imaginary = $result->imaginary - $number->imaginary;
             $result = new ComplexNumber($real, $imaginary);
         }
         return $result;
     }


}