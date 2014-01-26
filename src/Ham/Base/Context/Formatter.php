<?php
namespace Ham\Base\Context;


use Ham\Base\Element\Title\Title;

interface Formatter
{

    /**
     * @param Title $title
     * @return string
     */
    public function title(Title $title);
} 