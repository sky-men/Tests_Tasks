<?php

namespace app\parsers;

use \app\core\BaseParser;

/**
 * Class EmptyParser пустышка
 *
 * @package app\parsers
 */
class EmptyParser extends BaseParser
{
    public function startURL(): string
    {
        return 'http://www.lipsum.com';
    }

    public function parse(array $page): bool
    {
        return true;
    }
}