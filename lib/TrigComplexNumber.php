<?php

namespace CalculatorApp;

/**
 * Class ComplexNumber
 * @package CalculatorApp
 */
class TrigComplexNumber extends ComplexNumber
{
    public function __construct(float $radius, float $phi)
    {
        $this->radius = $radius;
        $this->phi = $phi;
        $this->real = $radius * cos($phi);
        $this->imaginary = $radius * sin($phi);

    }

}