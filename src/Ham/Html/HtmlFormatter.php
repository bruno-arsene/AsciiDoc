<?php
/**
 * Created by PhpStorm.
 * User: Nikoms
 * Date: 15/01/14
 * Time: 1:04
 */

namespace Ham\Html;


use Ham\Base\Context\Formatter;
use Ham\Base\Element\Title\Title;

class HtmlFormatter implements Formatter
{
    /**
     * @param Title $title
     * @return string
     */
    public function title(Title $title)
    {
        return sprintf("<h%d>%s</h%d>", $title->getLevel(), $title->getTitle(), $title->getLevel());
    }


} 