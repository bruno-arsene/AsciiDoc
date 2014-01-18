<?php

/*
 * A two line title consists of a title line, starting hard against the left margin, and an underline. Section underlines consist a repeated character pairs spanning the width of the preceding title (give or take up to two characters):

The default title underlines for each of the document levels are:

Level 0 (top level):     ======================
Level 1:                 ----------------------
Level 2:                 ~~~~~~~~~~~~~~~~~~~~~~
Level 3:                 ^^^^^^^^^^^^^^^^^^^^^^
Level 4 (bottom level):  ++++++++++++++++++++++

Examples:

Level One Section Title
-----------------------

Level 2 Subsection Title
~~~~~~~~~~~~~~~~~~~~~~~~


 */

interface Element{
    public function format(Formatter $formatter);
}

class Level0TwoLine implements Element{
    private $title;
    public function __construct($title){
        $this->title = $title;
    }

    public function format(Formatter $formatter)
    {
        return $formatter->level0TwoLine($this);
    }

    public function getTitle(){
        return $this->title;
    }


}

class ConvertElement{

    /**
     * @var string
     */
    private $text;
    /**
     * @var Element
     */
    private $element;

    /**
     * @param string $text
     * @param Element $element
     */
    public function __construct($text, Element $element){
        $this->text = (string) $text;
        $this->element = $element;
    }

    public function getText(){
        return $this->text;
    }

    public function getElement(){
        return $this->element;
    }
}

interface Finder{

    /**
     * @param string $text
     * @return ConvertElement[]
     */
    public function getFoundMatches($text);

    /**
     * @return string
     */
    public function getShortCutName();
}

class Level0TwoLineAsciiFinder implements Finder{

    /**
     * @param string $text
     * @return ConvertElement[]
     */
    public function getFoundMatches($text){
        $level0TwoLinesRegex = '/([^\n]+)\n([\=]{2,})/m';
        preg_match_all($level0TwoLinesRegex, $text, $matches);

        $converts = array();
        foreach($matches[0] as $id => $asciiTextMatched){
            $converts[] = new ConvertElement($asciiTextMatched, new Level0TwoLine($matches[1][$id]));
        }
        return $converts;

    }

    public function getShortCutName(){
        return 'title';
    }
}


abstract class Formatter{

    private $doc;

    public function __construct(Doc $doc){
        $this->doc = $doc;
    }

    protected function getDoc(){
        return $this->doc;
    }


    public function convert()
    {
        $convertedText = $this->getDoc()->getShortCutText();
        foreach($this->getDoc()->getStore() as $convertElement){
            $convertedText = preg_replace('#'.preg_quote($convertElement->getText(),'#').'#', $convertElement->getElement()->format($this), $convertedText, 1);
        }
        return $convertedText;
    }

    abstract public function level0TwoLine(Level0TwoLine $level0TwoLine);


}

class HtmlFormatter extends Formatter{
    public function level0TwoLine(Level0TwoLine $level0TwoLine)
    {
        return '<h1>' . $level0TwoLine->getTitle() . '</h1>';
    }
}

abstract class Doc{

    /**
     * @var Finder[]
     */
    private $finders;
    /**
     * @var ConvertElement[]
     */
    private $store;
    private $text;
    private $shortCutText;

    public function __construct($text){
        $this->text = $text;
        $this->store = array();
        $this->finders = array();
        $this->initFinders();
    }

    abstract protected function initFinders();

    public function addFinder(Finder $finder){
        $this->finders[] = $finder;
    }

    public function getShortCutText(){
        if($this->shortCutText !==null){
            return $this->shortCutText;
        }
        $this->shortCutText = $this->text;
        foreach($this->finders as $finder){
            foreach($finder->getFoundMatches($this->shortCutText) as $convert){
                $id = $this->addToStore($finder->getShortCutName(), $convert->getElement());
                $originalText = $convert->getText();
                $this->shortCutText = preg_replace('#'.preg_quote($originalText,'#').'#', $this->getShortCutTag($finder->getShortCutName(), $id), $this->shortCutText, 1);
            }
        }
        return $this->shortCutText;
    }

    private function getShortCutTag($shortCutName, $id){
        return '{{'.$shortCutName.':'.$id.'}}';
    }

    private function addToStore($shortCutName, Element $element){
        $id = count($this->store);
        $shortCutTag = $this->getShortCutTag($shortCutName, $id);
        $convertElement = new ConvertElement($shortCutTag, $element);
        $this->store[] = $convertElement;
        return $id;
    }

    public function getStore(){
        return $this->store;
    }


}

class AsciiDoc extends Doc{
    protected function initFinders(){
        $this->addFinder(new Level0TwoLineAsciiFinder());
    }
}

$asciiText = "
Coucou

==

123
==

abc
==

Abc
==

Def
==

Def
==

";

$o = new AsciiDoc($asciiText);

echo nl2br($o->getShortCutText()).'<hr/>';

$htmlFormatter = new HtmlFormatter($o);
echo $htmlFormatter->convert();