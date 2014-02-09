<?php
/**
 * @author Nicolas De Boose
 */

namespace Ham\Base\Context;


use Ham\Base\Element\Element;
use Ham\Base\Element\Finder;
use Ham\Base\Element\MatchedElement;

abstract class Document
{

    /**
     * @var Finder[]
     */
    private $finders;

    /**
     * @var string
     */
    private $originalText;

    /**
     * @var
     */
    private $taggedText;


    /**
     * @var Element[]
     */
    private $taggedElements;

    /**
     * Call at the end of the constructor
     * @return void
     */
    abstract protected function initFinders();

    /**
     * @param string $originalText
     */
    public function __construct($originalText)
    {
        $this->originalText = $originalText;
        $this->taggedElements = array();
        $this->finders = array();
        $this->initFinders();
    }

    /**
     * @param Formatter $formatter
     * @return string
     */
    public function format(Formatter $formatter)
    {
        $taggedText = $this->getTaggedText();
        foreach ($this->taggedElements as $elementId => $element) {
            $taggedText = $this->replaceTagByCode($taggedText, $elementId, $element->format($formatter));
        }

        return $taggedText;
    }

    /**
     * @param string $subject
     * @param string $elementId
     * @param string $code
     * @return string
     */
    private function replaceTagByCode($subject, $elementId, $code)
    {
        return preg_replace(
            '#' . preg_quote($this->getTag($elementId), '#') . '#',
            $code,
            $subject,
            1
        );
    }

    /**
     * @param Finder $finder
     */
    protected function addFinder(Finder $finder)
    {
        $this->finders[] = $finder;
    }

    /**
     * @return string
     */
    protected function getTaggedText()
    {
        if ($this->taggedText === null) {
            $this->initTaggedText();
        }

        return $this->taggedText;
    }

    private function initTaggedText()
    {
        $currentTaggedText = $this->originalText;
        foreach ($this->finders as $finder) {
            foreach ($finder->getMatches($currentTaggedText) as $matchedElement) {
                $elementId = $this->addToTaggedElement($matchedElement->getElement());
                $currentTaggedText = $this->replaceOriginalElementByTag(
                    $currentTaggedText,
                    $matchedElement->getOriginalText(),
                    $elementId
                );
            }
        }
        $this->taggedText = $currentTaggedText;
    }

    /**
     * @param string $subject
     * @param string $originalElement
     * @param int $elementId
     * @return mixed
     */
    private function replaceOriginalElementByTag($subject, $originalElement, $elementId)
    {
        return preg_replace('#' . preg_quote($originalElement, '#') . '#', $this->getTag($elementId), $subject, 1);
    }


    /**
     * @param int $elementId
     * @return string
     */
    private function getTag($elementId)
    {
        return sprintf('{{--%d--}}', $elementId);
    }

    /**
     * @param Element $element
     * @return int
     */
    private function addToTaggedElement(Element $element)
    {
        $id = count($this->taggedElements);
        $this->taggedElements[] = $element;

        return $id;
    }

}
