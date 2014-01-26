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

/**
 * Interface Element
 */
interface Ham_Element{
    public function format(Ham_Formatter $formatter);
}

/**
 * Le niveau 0 écrit en 2 lignes dans l'asciidoc
 * Class Level0TwoLine
 */
class Ham_Element_Level0TwoLine implements Ham_Element{
    private $title;
    public function __construct($title){
        $this->title = $title;
    }

    public function format(Ham_Formatter $formatter)
    {
        return $formatter->level0TwoLine($this);
    }

    public function getTitle(){
        return $this->title;
    }
}

/**
 * Le formateur qui contiendra tous les formatages pour chaque Element.
 * Un formateur par "type de document"
 * Class Formatter
 */
abstract class Ham_Formatter{
    /**
     * Renvoi le code du niveau 0, sous une certaine forme (en fonction du type de document)
     * @param Ham_Element_Level0TwoLine $level0TwoLine
     * @return string
     */
    abstract public function level0TwoLine(Ham_Element_Level0TwoLine $level0TwoLine);
}

/**
 * Le document à qui on passe le text
 * Un document par type
 * Chaque type de document doit ajouter ses "Finder"
 * Class Doc
 */
abstract class Ham_Doc{

    /**
     * @var Ham_Finder[]
     */
    private $finders;
    /**
     * @var Ham_Element[]
     */
    private $store;
    private $text;
    private $shortCutText;


    abstract protected function initFinders();

    public function __construct($text){
        $this->text = $text;
        $this->store = array();
        $this->finders = array();
        $this->initFinders();
    }

    //TODO
    public function toGenericDoc(){
        //Renvoi un document générique qui n'a plus de "shortcut", juste un array d'élement surlequelle on fait une boucle et un tostring avec un formatter
        //Idéalement on ne devrait pas passer par un document shortcut intermédiaire
    }

    /**
     * @param Ham_Formatter $formatter
     * @return mixed
     */
    public function toString(Ham_Formatter $formatter)
    {
        $convertedText = $this->getShortCutText();
        foreach($this->store as $id => $element){
            $convertedText = preg_replace('#'.preg_quote($this->getShortCutTag($id),'#').'#', $element->format($formatter), $convertedText, 1);
        }
        return $convertedText;
    }

    protected function addFinder(Ham_Finder $finder){
        $this->finders[] = $finder;
    }

    private function getShortCutText(){
        if($this->shortCutText === null){
            $this->initShortCutText();
        }
        return $this->shortCutText;
    }

    private function initShortCutText(){
        $this->shortCutText = $this->text;
        foreach($this->finders as $finder){
            foreach($finder->getFoundMatches($this->shortCutText) as $shortCutElement){
                $id = $this->addToStore($shortCutElement->getElement());
                $this->shortCutText = preg_replace('#'.preg_quote($shortCutElement->getTextFound(),'#').'#', $this->getShortCutTag($id), $this->shortCutText, 1);
            }
        }
    }

    private function getShortCutTag($id){
        return '{{%%'.$id.'%%}}';
    }

    private function addToStore(Ham_Element $element){
        $id = count($this->store);
        $this->store[] = $element;
        return $id;
    }

}

/**
 * Un finder est un objet qui va trouver les "match" du texte sous forme de tableau de "ConvertElement"
 * Un Finder pour tous les élements de chaque type de document
 * Interface Finder
 */
interface Ham_Finder{

    /**
     * @param string $text
     * @return Ham_ConvertElement[]
     */
    public function getFoundMatches($text);
}

/**
 * Un objet "ConvertElement" possède juste 2 attributs:
 * Le textFound, c'est le texte qui va être remplacé par...
 * ... l'élement en question de type Element
 * Class ConvertElement
 */
class Ham_ConvertElement{

    /**
     * @var string
     */
    private $textFound;
    /**
     * @var Ham_Element
     */
    private $element;

    /**
     * @param string $textFound
     * @param Ham_Element $element
     */
    public function __construct($textFound, Ham_Element $element){
        $this->textFound = (string) $textFound;
        $this->element = $element;
    }

    public function getTextFound(){
        return $this->textFound;
    }

    public function getElement(){
        return $this->element;
    }
}



/**************************
 * TEST EN HTML
 **************************/

class Html_HtmlFormatter extends Ham_Formatter{
    public function level0TwoLine(Ham_Element_Level0TwoLine $level0TwoLine)
    {
        return '<h1>' . $level0TwoLine->getTitle() . '</h1>';
    }
}

/**************************
 * TEST EN ASCII
 **************************/

class Ascii_AsciiFormatter extends Ham_Formatter{
    public function level0TwoLine(Ham_Element_Level0TwoLine $level0TwoLine)
    {
        return $level0TwoLine->getTitle() . PHP_EOL . str_repeat("=",strlen($level0TwoLine->getTitle()));
    }
}
class Ascii_AsciiDoc extends Ham_Doc{
    protected function initFinders(){
        $this->addFinder(new Ascii_Finder_Level0TwoLineFinder());
    }
}


class Ascii_Finder_Level0TwoLineFinder implements Ham_Finder{

    /**
     * @param string $text
     * @return Ham_ConvertElement[]
     */
    public function getFoundMatches($text){
        $level0TwoLinesRegex = '/(.+?)\n([\=]{2,})/m';
        preg_match_all($level0TwoLinesRegex, $text, $matches);

        $converts = array();
        foreach($matches[0] as $id => $asciiTextMatched){
            $converts[] = new Ham_ConvertElement($asciiTextMatched, new Ham_Element_Level0TwoLine($matches[1][$id]));
        }
        return $converts;
    }
}


/**************************
 * EXEMPLE D'UN TEXTE EN ASCII
 **************************/

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

$o = new Ascii_AsciiDoc($asciiText);

echo $o->toString(new Html_HtmlFormatter());
echo '<hr/>';
echo $o->toString(new Ascii_AsciiFormatter());