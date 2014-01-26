<?php
/**
 * Created by PhpStorm.
 * User: Nikoms
 * Date: 26/01/14
 * Time: 2:40
 */

namespace Ham\Base\Element;


/**
 * Un finder est un objet qui va trouver les "match" du texte sous forme de tableau de "ConvertElement"
 * Un Finder pour tous les élements de chaque type de document
 * Interface Finder
 */
interface Finder
{

    /**
     * @param string $originalText
     * @return MatchedElement[]
     */
    public function getMatches($originalText);
} 