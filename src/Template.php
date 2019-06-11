<?php

namespace Opensitemas\CertGenerator;


use Opensitemas\CertGenerator\Elements\Text;
use Opensitemas\CertGenerator\Elements\TextBox;

class Template
{
    private $settings = [];
    private $template = null;

    public function __construct($file, $template, $vars = [])
    {
        $this->vars = $vars;

        $settings       = json_decode(file_get_contents($file));
        $this->settings = $settings;
        $this->template = $template;
    }

    public function generate($path, $id = null)
    {


        if (empty($id)) {

            $id = Uuid::generate()->string;
        }


        $builder = new Builder();


        foreach ($this->settings->pages as $page) {

            $this->createPage($builder, $this->template, $page->template->page);


            foreach ($page->elements as $element) {

                switch ($element->type) {
                    case 'text':
                        (new Text($builder, $element, $this->vars))->render();
                        break;
                    case 'textBox':
                        (new TextBox($builder, $element, $this->vars))->render();
                        break;

                }


            }


        }

        $destFile = $path . '/' . $id . '.pdf';

        $builder->generate($destFile);

        return $path . '/' . $this->id . '.pdf';

    }

    private function createPage(Builder $builder, $pdf, $pageNumber)
    {
        $builder->readPageFromPdf($pdf, $pageNumber);


    }


}