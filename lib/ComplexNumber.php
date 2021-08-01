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

}