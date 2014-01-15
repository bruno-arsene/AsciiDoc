<?php

namespace AsciiDoc\Element;


use AsciiDoc\Context\FormatterInterface;

interface Element
{
    public function format(FormatterInterface $formatter);
}
