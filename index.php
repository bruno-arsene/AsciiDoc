<?php

include('vendor/autoload.php');

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

$o = new \Ham\Ascii\AsciiDocument($asciiText);

echo $o->format(new \Ham\Html\HtmlFormatter());
echo '<hr/>';
echo $o->format(new \Ham\Ascii\AsciiFormatter());