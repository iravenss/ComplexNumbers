<?php

namespace CalculatorApp\Operations;

use CalculatorApp\ComplexNumber as ComplexNumber;

/**
 * Class Operation
 * @package CalculatorApp\Operations
 */
abstract class Operation
{
    /**
     * @var ComplexNumber
     */
    protected ComplexNumber $result;
    /**
     * Аргументы операции
     * @var array
     */
    protected array $args;

    /**
     * Символ для отображения операции + - / *
     * @return string
     */
    abstract public function getOperationSymbol(): string;

    abstract protected function calc(ComplexNumber ...$numbers) : ComplexNumber;

    public function __construct(ComplexNumber ...$numbers)
    {
        if(!empty($numbers) && count($numbers) < 2)
        {
            throw new \Exception('This function requires at least 2 arguments');
        }
        $this->args = $numbers;
        $this->result = $this->calc(...$numbers);
    }

    /**
     * Получить результат операции
     * @return ComplexNumber
     */
    public function getResult(): ComplexNumber
    {
        return $this->result;
    }

    /**
     * Получить строку вида z1 + z2 = z3
     * @return string
     */
    public function getFormatedString(): string
    {
        $formatedNumbers = [];
        foreach ($this->args as $number) {
            $formatedNumbers[] = $number->getFormated();
        }
        $string = implode($this->getOperationSymbol(), $formatedNumbers);

        $string .= " = " . $this->getResult()->getFormated();
        return $string;
    }


}