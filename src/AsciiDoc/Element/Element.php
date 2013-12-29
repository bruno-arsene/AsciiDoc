<?php
/**
 * @author Nicolas De Boose
 */

namespace AsciiDoc\Element;


interface Element
{
    public function toHtml();
    public function toAscii();
}
