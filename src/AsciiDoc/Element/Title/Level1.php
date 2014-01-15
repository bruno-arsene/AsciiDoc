<?php
/**
 * @author Nicolas De Boose
 */

namespace AsciiDoc\Element\Title;

use AsciiDoc\Context\FormatterInterface;
use AsciiDoc\Element\Element;

class Level1 implements Element, TitleInterface
{
    /**
     * @var string
     */
    private $title;

    public function __construct($title)
    {
        $this->title = htmlentities((string)$title);
    }

    /**
     * @param FormatterInterface $formatter
     * @return string
     */
    public function format(FormatterInterface $formatter)
    {
        return $formatter->header($this);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

}
