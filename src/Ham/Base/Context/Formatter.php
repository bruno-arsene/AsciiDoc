<?php
namespace Ham\Base\Context;


use Ham\Base\Element\Title\Title;

interface Formatter
{

    /**
     * @param Title $header
     * @param int $level
     * @return string
     */
    public function title(Title $header, $level);
} 