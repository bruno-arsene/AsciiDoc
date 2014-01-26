<?php
/**
 * @author Nicolas De Boose
 */

namespace Ham\Base\Element\Title;

use Ham\Base\Context\Formatter;
use Ham\Base\Element\Element;

class Level1 extends Title
{
    /**
     * @return int
     */
    protected function getLevel()
    {
        return 1;
    }

}
