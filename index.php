<?php
/*
Написать код на языке PHP:

Вывести нумерацию столбиком по заданному по шаблону до 100. Шаблоном состоит из префикса (букв) и числа (1-6 цифра).

Пример шаблона: $tpl = "УШП-001.
Еще примеры:
• Если шаблон задан «УШП-001», то следующие должны быть: УШП-002, УШП-003 и т.д. до УШП-100.
• Если шаблон задан «ИП-03», то следующие должны быть ИП-03, ИП-04, ИП-05 и т.д. до ИП-99
 */
function templateGeneration ($tpl)
{
    $prefixAndZeros = explode('-', $tpl);
    $prefix = $prefixAndZeros[0];
    $countZero = strlen($prefixAndZeros[1]);
    $numbers = range(1, 100);
    $numberingByPattern = array_map(function ($number) use ($countZero, $prefix) {
        $formattedNumber = str_pad($number, $countZero, '0', STR_PAD_LEFT);
        return "$prefix-$formattedNumber";
    }, $numbers);
    return implode("\n", $numberingByPattern) . PHP_EOL;
}
print_r(templateGeneration("УШП-001"));
