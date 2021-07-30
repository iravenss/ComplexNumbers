<?php

namespace CalculatorApp;


class Calculator
{
    public static function runCli()
    {
        print "".PHP_EOL;
        print "-----------".PHP_EOL;
        print "Выберите операцию: ".PHP_EOL;
        print "1) Сложение".PHP_EOL;
        print "2) Вычитание".PHP_EOL;
        print "3) Умножение".PHP_EOL;
        print "4) Деление".PHP_EOL;

        $action = readline(": ");
        readline_add_history($action);

        print "Введите число Z(1): ".PHP_EOL;
        $z1 = readline(": ");
        readline_add_history($z1);
        $z1 = ComplexNumber::parse($z1);

        print "Введите число Z(2): ".PHP_EOL;
        $z2 = readline(": ");
        readline_add_history($z2);
        $z2 = ComplexNumber::parse($z2);

        print "Результат: ".PHP_EOL;

        if ($action == "1") {
            $operation = new \CalculatorApp\Operations\Sum($z1, $z2);
        } elseif ($action == "2") {
            $operation = new \CalculatorApp\Operations\Dif($z1, $z2);
        }elseif ($action == "3") {
            $operation = new \CalculatorApp\Operations\Multiply($z1, $z2);
        }elseif ($action == "4") {
            $operation = new \CalculatorApp\Operations\Divide($z1, $z2);
        }
        $symbol = $operation->getOperationSymbol();
        $string = $operation->getResult()->getFormated();
        print "-----------".PHP_EOL;
        print "Z(1) ".$symbol." Z(2) = ".$string.PHP_EOL;
        print "-----------".PHP_EOL;
    }
}