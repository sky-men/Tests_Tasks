<?php

/**
 * Нахождение полиндрома
 *
 * файл и текст в кодировке UTF-8
 */

mb_internal_encoding('UTF-8');

/**
 * Аналог strrev() для UTF-8
 * @param string $str
 * @return string
 */
function utf8_strrev($str)
{
    preg_match_all('/./us', $str, $ar);
    return join('', array_reverse($ar[0]));
}

/**
 * Если строка - полиндромом
 * @param string $str
 * @return bool
 */
function isPalendrone($str)
{
    return $str == utf8_strrev($str);
}

/**
 * Для предварительной подготовки текста
 * @param string $str
 * @return mixed
 */
function prepareText($str)
{
    return str_replace(' ', '', mb_strtolower($str));
}

/**
 * Функция нахождения полиндрома.
 *  - если строка является полиндромом, то она выводится полностью
 *  - если строка не является полиндромом - выводится самый длинный под-полиндром этой строки, т.е. самая длинная часть строки, являющаяся полиндромом
 *  - если подполиндромы отсутствуют в строке - выводится первый символ строки
 *
 * @param string $str
 * @return string
 */
function palindrome($str)
{
    $orig_str = $str;

    $str = prepareText($str);

    if (isPalendrone($str)) {
        return $orig_str;
    } else {
        $longest = '';
        $length = mb_strlen($str);

        for ($i = 0; $i < $length - 1; $i++) {
            for ($j = $length - $i; $j > 1; $j--) {
                if (isPalendrone(mb_substr($str, $i, $j))) {
                    $new = mb_substr($str, $i, $j);
                    if (mb_strlen($new) > mb_strlen($longest)) {
                        $longest = $new;
                    }
                    break;
                }
            }
        }

        if (!empty($longest)) {
            return $longest; // TODO тут возвращяется "сырой" текст полидрома, - в нижнем регистре и без пробелов. Сделать нахождение его в оригинальном тексте
        } else {
            return mb_substr($orig_str, 0, 1);
        }
    }
}


$str = 'ЛевыйТекст ---- Level Аргентина манит негра -----  ЛевыйТекст';
$str = 'ЛевыйТекст';


//Примеры

echo palindrome('Level'); //Выведет 'Level'

echo '<br>';

echo palindrome('Sum summus mus'); //Выведет 'Sum summus mus'

echo '<br>';

echo palindrome('Аргентина манит негра'); //Выведет 'Аргентина манит негра'

echo '<br>';

echo palindrome('ЛевыйТекст  Аргентина манит негра  ЛевыйТекст'); //Выведет 'аргентинаманитнегра'

echo '<br>';

echo palindrome('ЛевыйТекст Level Аргентина манит негра  ЛевыйТекст'); //Выведет 'аргентинаманитнегра'

echo '<br>';

echo palindrome('ЛевыйТекст'); //Выведет 'Л'