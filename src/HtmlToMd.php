<?php

namespace SimplyDi\SimplyMarkdown;

use League\HTMLToMarkdown\HtmlConverter;

class HtmlToMd
{

    /**
     * @param $html
     * @return string
     */
    public function convert($html): string
    {
        $converter = new HtmlConverter(array('header_style'=>'atx'));
        return $converter->convert($html);
    }
}
