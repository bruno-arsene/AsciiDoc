<?php
/**
 * Created by PhpStorm.
 * User: Nikoms
 * Date: 26/01/14
 * Time: 3:15
 */

namespace Ham\Ascii\Element\Title;


use Ham\Base\Element\Finder;
use Ham\Base\Element\MatchedElement;
use Ham\Base\Element\Title\Level1;

class Title1Finder implements Finder
{

    /**
     * @param string $originalText
     * @return MatchedElement[]
     */
    public function getMatches($originalText)
    {
        $level0TwoLinesRegex = '/(.+?)\n([\=]{2,})/m';
        preg_match_all($level0TwoLinesRegex, $originalText, $matches);

        $matchedElements = array();
        foreach ($matches[0] as $id => $asciiTextMatched) {
            $matchedElements[] = new MatchedElement($asciiTextMatched, new Level1($matches[1][$id]));
        }

        return $matchedElements;
    }
} 