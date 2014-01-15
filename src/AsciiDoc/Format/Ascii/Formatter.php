<?php
/**
 * Created by PhpStorm.
 * User: Nikoms
 * Date: 15/01/14
 * Time: 1:04
 */

namespace AsciiDoc\Format\Ascii;


use AsciiDoc\Context\FormatterInterface;
use AsciiDoc\Element\Title\TitleInterface;

class Formatter implements FormatterInterface
{
    /**
     * @param TitleInterface $header
     * @return string
     */
    public function header(TitleInterface $header)
    {
        return sprintf('<h1>%s</h1>', $header->getTitle());
    }


} 