<?php
/**
 * Created by PhpStorm.
 * User: Nikoms
 * Date: 15/01/14
 * Time: 0:58
 */

namespace Ham\Base\Element\Title;


use Ham\Base\Context\Formatter;
use Ham\Base\Element\Element;

abstract class Title implements Element
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
     * @param Formatter $formatter
     * @return string
     */
    public function format(Formatter $formatter)
    {
        return $formatter->title($this, $this->getLevel());
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    abstract protected function getLevel();

} 