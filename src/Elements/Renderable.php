<?php

namespace Opensistemas\CertGenerator\Elements;


trait Renderable
{

    function getValue($item)
    {

        if (is_string($item)) {
            return $item;

        }

        if (isset($this->vars[$item['key']])) {

            return $this->vars[$item['key']];
        }

        return $item['key'];
    }


    function setFont($font)
    {


        if (isset($font['size'])) {
            $this->builder->setFontSize($font['size']);
        }


        if (isset($font['bg'])) {
            list($r, $g, $b) = sscanf($font['bg'], "#%02x%02x%02x");

            $this->builder->SetFillColor($r, $g, $b);


        }

        if (isset($font['family'])) {

            $this->builder->setFont( $font['family']);


        }

        if (isset($font['color'])) {

            $this->builder->setTextColorArray(sscanf($font['color'], "#%02x%02x%02x"));
        }
    }

}