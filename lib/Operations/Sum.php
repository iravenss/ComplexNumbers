<?php


namespace CalculatorApp\Operations;
use CalculatorApp\ComplexNumber as ComplexNumber;


final class Sum extends Operation
{

    public function getOperationSymbol():string
    {
        return " + ";
    }

     final protected function calc(ComplexNumber ...$numbers) : ComplexNumber
     {
         $real = 0;
         $imaginary = 0;
         foreach($numbers as $number)
         {
             $real += $number->real;
             $imaginary += $number->imaginary;
         }
         return new ComplexNumber($real, $imaginary);
     }


}