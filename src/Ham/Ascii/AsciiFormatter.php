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
     * @param Title $title
     * @return string
     */
    public function title(Title $title)
    {
        return sprintf("%s\n%s", $title->getTitle(), str_repeat("=", strlen($title->getTitle())));
    }


} 