<?php

namespace CalculatorApp;

/**
 * Class ComplexNumber
 * @package CalculatorApp
 */
class ComplexNumber
{
    private float $real;
    private float $imaginary;
    private string $symbol;

    /**
     * ComplexNumber constructor.
     * @param float $real
     * @param float $imaginary
     * @param string $symbol
     */
    public function __construct(float $real, float $imaginary, $symbol = "i")
    {
        $this->real = $real;
        $this->imaginary = $imaginary;
        $this->symbol = $symbol;
    }

    /**
     * Читаем приватное свойство
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Выводим в стандартный вид 12+3i
     * @return string
     */
    public function getFormated(): string
    {
        $operation = "+";
        if ($this->imaginary < 0) {
            $operation = "";
        }
        return $this->real . $operation . $this->imaginary . $this->symbol;

    }

    /**
     * @constant    Regexp to split an input string into real and imaginary components and suffix
     */
    const NUMBER_SPLIT_REGEXP =
        '` ^
            (                                   # Real part
                [-+]?(\d+\.?\d*|\d*\.?\d+)          # Real value (integer or float)
                ([Ee][-+]?[0-2]?\d{1,3})?           # Optional real exponent for scientific format
            )
            (                                   # Imaginary part
                [-+]?(\d+\.?\d*|\d*\.?\d+)          # Imaginary value (integer or float)
                ([Ee][-+]?[0-2]?\d{1,3})?           # Optional imaginary exponent for scientific format
            )?
            (                                   # Imaginary part is optional
                ([-+]?)                             # Imaginary (implicit 1 or -1) only
                ([ij]?)                             # Imaginary i or j - depending on whether mathematical or engineering
            )
        $`uix';


    /**
     * Парсим строку в число
     * Даный метод позаимствовал из github
     * @link https://github.com/MarkBaker/PHPComplex
     * @param $complexNumber
     * @return array|ComplexNumber
     */
    public static function parse($complexNumber)
    {
        // Test for real number, with no imaginary part
        if (is_numeric($complexNumber)) {
            return [$complexNumber, 0, null];
        }

        // Fix silly human errors
        $complexNumber = str_replace(
            ['+-', '-+', '++', '--'],
            ['-', '-', '+', '+'],
            $complexNumber
        );

        // Basic validation of string, to parse out real and imaginary parts, and any suffix
        $validComplex = preg_match(
            self::NUMBER_SPLIT_REGEXP,
            $complexNumber,
            $complexParts
        );

        if (!$validComplex) {
            // Neither real nor imaginary part, so test to see if we actually have a suffix
            $validComplex = preg_match('/^([\-\+]?)([ij])$/ui', $complexNumber, $complexParts);
            if (!$validComplex) {
                throw new \Exception('Invalid complex number');
            }
            // We have a suffix, so set the real to 0, the imaginary to either 1 or -1 (as defined by the sign)
            $imaginary = 1;
            if ($complexParts[1] === '-') {
                $imaginary = 0 - $imaginary;
            }
            return [0, $imaginary, $complexParts[2]];
        }

        // If we don't have an imaginary part, identify whether it should be +1 or -1...
        if (($complexParts[4] === '') && ($complexParts[9] !== '')) {
            if ($complexParts[7] !== $complexParts[9]) {
                $complexParts[4] = 1;
                if ($complexParts[8] === '-') {
                    $complexParts[4] = -1;
                }
            } else {
                // ... or if we have only the real and no imaginary part
                //  (in which case our real should be the imaginary)
                $complexParts[4] = $complexParts[1];
                $complexParts[1] = 0;
            }
        }


         return new ComplexNumber($complexParts[1],$complexParts[4]);
    }


}