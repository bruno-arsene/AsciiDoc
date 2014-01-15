<?php
namespace AsciiDoc\Context;


use AsciiDoc\Element\Title\TitleInterface;

interface FormatterInterface {

    /**
     * @param TitleInterface $header
     * @return string
     */
    public function header(TitleInterface $header);
} 