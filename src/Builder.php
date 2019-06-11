<?php

namespace Opensitemas\CertGenerator;

use setasign\Fpdi\PdfReader;
use setasign\Fpdi\Tcpdf\Fpdi;

class Builder extends Fpdi
{
    private $extraFonts = [];


    public function Header()
    {
    }

    public function makeGrid()
    {
        $width     = $this->getPageWidth();
        $height    = $this->getPageHeight();
        $base_line = array('width' => .3, 'cap' => 'round', 'join' => 'round', 'color' => array(0, 0, 0));
        $secondary = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1, 'color' => array(0, 0, 0));
        $this->SetFont('helvetica', '', 7);
        $this->SetFillColor(255, 255, 215);
        $this->SetTextColor(0, 0, 0);
        $step    = 10;
        $midText = 2;
        for ($i = 0; $i < $height - $step; $i += $step) {
            if ($i !== 0) {
                $this->SetXY(0, $i);
                $this->Line(7, $i, $width, $i, $base_line);
                $this->SetXY(0, $i - $midText);
                $this->Write(0, $i, '', 0, 'L', true, 0, false, false, 0);
            }
            $this->SetXY(0, $i + 5 - $midText);
            $this->Write(0, $i + 5, '', 0, 'L', true, 0, false, false, 0);

            $this->SetXY(0, $i + 5);

            $this->Line(7, $i + 5, $width, $i + 5, $secondary);
        }
        $base_line = array('width' => .2, 'cap' => 'round', 'join' => 'round', 'color' => array(0, 0, 0));
        $secondary = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1, 'color' => array(0, 0, 0));
        $this->SetTextColor(200, 0, 0);
        for ($i = $step; $i < $width - $step; $i += $step) {
            $this->SetXY($i, 0);
            $this->Line($i, 3, $i, $height, $base_line);
            $this->SetXY($i - $midText, 0);
            $this->Write(0, $i, '', 0, 'L', true, 0, false, false, 0);
            $this->SetXY($i + 5, 0);
            $this->Line($i + 5, 5, $i + 5, $height, $secondary);
            $this->SetXY($i + 5 - $midText, 2);
            $this->Write(0, $i + 5, '', 0, 'L', true, 0, false, false, 0);
        }
        $i = 5;
        $this->SetXY(0, $i - $midText);
        $this->Write(0, $i, '', 0, 'L', true, 0, false, false, 0);

        $this->SetXY(0, $i);

        $this->Line(7, $i, $width, $i, $secondary);

        return $this;
    }

    public function setFont($family, $style = '', $size = null, $fontfile = '', $subset = 'default', $out = true)
    {

        parent::setFont(isset($this->extraFonts[$family]) ? $this->extraFonts[$family] : $family, $style, $size,
            $fontfile, $subset, $out);

        return $this;
    }

    public function writeCheckbox($x, $y, $value, $text = 'X')
    {
        $altura = 4.3;
        $this->SetXY($x, $y + ($value - 1) * $altura);
        $this->Write(0, $text, '', 0, 'L', true, 0, false, false, 0);

        return $this;
    }

    public function importFont($path, $name)
    {

        $fontname = \TCPDF_FONTS::addTTFfont($path, 'TrueTTypeUnicode', '', 32);

        $this->extraFonts[$name] = $fontname;


        return $this;
    }


    public function writeLongText($x, $y, $w = 180, $h = 10, $text = '', $align = 'L', $border = '')
    {

        $this->SetXY($x, $y);
        $this->MultiCell($w, $h, $text, $border, $align, true);

        return $this;
    }

    public function setFontSize($size, $out = true)
    {

        parent::setFontSize($size, $out);

        return $this;

    }

    public function setTextColorArray($color, $ret = false)
    {

        parent::setTextColorArray($color, $ret);

        return $this;
    }

    public function writeText($x, $y, $text = 'X')
    {
        $altura = 4.3;
        $this->SetXY($x, $y);
        $this->Write(0, $text, '', 0, 'L', true, 0, false, false, 0);

        return $this;
    }

    public function readPageFromPdf($sourceFile, $pageNum)
    {
        $pageCount = $this->setSourceFile($sourceFile);
        $pageId    = $this->importPage($pageNum, PdfReader\PageBoundaries::MEDIA_BOX);
        $this->addPage();
        $this->SetMargins(0, 0, 0, true); // put space of 10 on top
        $this->SetAutoPageBreak(true, 0);
        $this->useTemplate($pageId, ['adjustPageSize' => true]);

        return $this;
    }

    public function generate($path)
    {
        return $this->Output($path, 'F');
    }
}

