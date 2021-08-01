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
     * Выводим в алгебраичной форме 12+3i
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
     * Парсим число из строки
     * @param string $complexNumber
     * @return ComplexNumber
     */
    public static function parse(string $complexNumber) : ComplexNumber
    {
        $parser = new Parser($complexNumber);
        $real = $parser->getReal();
        $imaginary = $parser->getImaginary();
        return new ComplexNumber($real,$imaginary);
    }

    /**
     * Выводим в тригонометрической форме
     * @return string
     */
    public function getTrigFormated()
    {

        //a > 0         ---> argz = arctg b/a
        //a < 0 b>0     ---> argz = pi + arctg b/a
        //a < 0 b < 0   ---> argz = -pi + arctg b/a

        $a = $this->real;
        $b = $this->imaginary;

        if ($a == 0) {
            $a = 0.00000000001;
        }

        if ($a > 0) {
            $phi = atan($b / $a);
        } elseif ($b > 0) {
            $phi = pi() + atan($b / $a);
        } elseif ($b < 0) {
            $phi = atan($b / $a) - pi();
        }
        $radius = sqrt(($a * $a) + ($b * $b));
        $string = " $radius * (cos($phi) + sin($phi)*i)";
        return $string;
    }

}