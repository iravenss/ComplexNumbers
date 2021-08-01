<?php

namespace CalculatorApp;

/**
 * Class Parser
 * @package CalculatorApp
 */
class Parser
{
    /**
     * @var float
     */
    private float $real;
    /**
     * @var float
     */
    private float $imaginary;

    /**
     * Parser constructor.
     * @param string $complexNumber
     */
    public function __construct(string $complexNumber)
    {

        $form = $this->detectForm($complexNumber);

        if ($form == "algebraic") {
            $this->parseAlgebraic($complexNumber);
        } elseif ($form == "trig") {
            $this->parseTrig($complexNumber);
        }

    }

    /**
     * @return float
     */
    public function getReal(): float
    {
        return $this->real;
    }

    /**
     * @return float
     */
    public function getImaginary(): float
    {
        return $this->imaginary;
    }

    /**
     * Определяем форму записи числа
     * @param string $complexNumber
     * @return string
     */
    private function detectForm(string $complexNumber): string
    {
        if (str_contains($complexNumber, 'sin') && str_contains($complexNumber, 'cos')) {
            $form = "trig";
        } else {
            $form = "algebraic";
        }
        return $form;
    }

    /**
     * Парсим тригонометрическую форму
     * @param $complexNumber
     * @return void
     */
    private function parseTrig($complexNumber)
    {
        $isValidFormat = preg_match(
            '`(\d+\.?\d*|\d*\.?\d+)([*]?)(\(cos\(([^)]*)\))([+])(sin\(([^)]*)\)\*i\))`',
            $complexNumber
        );
        if (!$isValidFormat) {
            throw new \Exception("Invalid complex number trigonometric format");
        }

        preg_match(
            '`^([+]?(\d+\.?\d*|\d*\.?\d+))`',
            $complexNumber,
            $complexParts
        );
        $parts['z'] = $complexParts[1];
        preg_match(
            '`cos\(([^)]*)\)`',
            $complexNumber,
            $complexParts
        );

        $parts['cosPhi'] = $complexParts[1];
        preg_match(
            '`\+sin\(([^)]*)\)`',
            $complexNumber,
            $complexParts
        );
        $parts['sinPhi'] = $complexParts[1];

        foreach ($parts as $part => $value) {
            if (!is_numeric($value)) {
                throw new \Exception("Invalid number of part [$part]");
            }
        }

        if ($parts['cosPhi'] != $parts['sinPhi']) {
            throw new \Exception("Phi in cos part and Phi in sin part are not same");
        }

        $phi = $parts['cosPhi'];
        $radius = $parts['z'];

        $this->real = $radius * cos($phi);
        $this->imaginary = $radius * sin($phi);

    }


    /**
     * @constant    Regexp to split an input string into real and imaginary components and suffix
     */
    const NUMBER_SPLIT_REGEXP_ALG =
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
     *  Парсим алгебраическую форму
     * Даный метод позаимствовал из github
     * @link https://github.com/MarkBaker/PHPComplex
     * @param $complexNumber
     * @return void
     */
    private function parseAlgebraic($complexNumber)
    {
        // Test for real number, with no imaginary part
        if (is_numeric($complexNumber)) {
            throw new \Exception('Invalid complex number');
            // return [$complexNumber, 0, null];
        }

        // Fix silly human errors
        $complexNumber = str_replace(
            ['+-', '-+', '++', '--'],
            ['-', '-', '+', '+'],
            $complexNumber
        );

        // Basic validation of string, to parse out real and imaginary parts, and any suffix
        $validComplex = preg_match(
            self::NUMBER_SPLIT_REGEXP_ALG,
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
            throw new \Exception('Invalid complex number');
            //return [0, $imaginary, $complexParts[2]];
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

        $this->real = $complexParts[1];
        $this->imaginary = $complexParts[4];

    }

}