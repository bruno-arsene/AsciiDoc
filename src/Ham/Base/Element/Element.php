<?php

namespace Ham\Base\Element;


use Ham\Base\Context\Formatter;

interface Element
{
    public function format(Formatter $formatter);
}
