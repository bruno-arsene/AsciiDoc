<?php
/**
 * Created by PhpStorm.
 * User: Nikoms
 * Date: 26/01/14
 * Time: 2:40
 */

namespace Ham\Base\Element;

/**
 * Class ConvertElement
 */
class MatchedElement
{
    /**
     * @var string
     */
    private $originalText;
    /**
     * @var Element
     */
    private $element;

    /**
     * @param string $originalText Le texte original
     * @param Element $element L'élement qui représente le texte original
     */
    public function __construct($originalText, Element $element)
    {
        $this->originalText = (string)$originalText;
        $this->element = $element;
    }

    /**
     * @return string
     */
    public function getOriginalText()
    {
        return $this->originalText;
    }

    /**
     * @return Element
     */
    public function getElement()
    {
        return $this->element;
    }
} 