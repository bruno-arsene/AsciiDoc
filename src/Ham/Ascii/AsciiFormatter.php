<?php
/**
 * Created by PhpStorm.
 * User: Nikoms
 * Date: 15/01/14
 * Time: 1:04
 */

namespace Ham\Ascii;


use Ham\Base\Context\Formatter;
use Ham\Base\Element\Title\Title;

class AsciiFormatter implements Formatter
{
    /**
     * @param Title $header
     * @param int $level
     * @return string
     */
    public function title(Title $header, $level)
    {
        return sprintf('<h%d>%s</h%d>', $level, $header->getTitle(), $level);
    }


} 