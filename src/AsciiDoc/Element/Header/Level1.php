<?php
/**
 * @author Nicolas De Boose
 */

namespace AsciiDoc\Element\Header;

use AsciiDoc\Element\Element;

class Level1 implements Element
{
    /**
     * @var string
     */
    private $title;

    public function __construct($title)
    {
        $this->title = htmlentities((string)$title);
    }

    public function toHtml()
    {
        return sprintf('<h1>%s</h1>', $this->title);
    }

    public function toAscii()
    {
        return sprintf('==%s', $this->title);
    }

}
