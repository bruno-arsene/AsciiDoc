<?php

namespace Ham\Ascii;


use Ham\Ascii\Element\Title\Title1Finder;
use Ham\Base\Context\Document;

class AsciiDocument extends Document
{

    private $lines;
    private $currentLine;

    public function __construct($originalText)
    {
        $normalizedEolText = str_replace("\r\n", "\n", $originalText);
        $this->lines = explode("\n", $normalizedEolText);
        $this->currentLine = -1;
        parent::__construct($normalizedEolText);
    }

    public function getCurrent()
    {
        return $this->getLine($this->currentLine);
    }

    public function fetch()
    {
        ++$this->currentLine;

        return $this->getCurrent();
    }

    private function getLine($line)
    {
        if ($line >= 0 && $line < count($this->lines)) {
            return $this->lines[$line];
        }

        return false;
    }

    /**
     * Call at the end of the constructor
     * @return void
     */
    protected function initFinders()
    {
        $this->addFinder(new Title1Finder());
    }
}
