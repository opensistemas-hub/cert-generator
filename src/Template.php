<?php

namespace Opensistemas\CertGenerator;


use Opensistemas\CertGenerator\Elements\Text;
use Opensistemas\CertGenerator\Elements\TextBox;
use Ramsey\Uuid\Uuid;

class Template
{
    private $settings = [];
    private $template = null;
    private $vars = [];

    static public function create(Array $settings, String $file)
    {

        $template = new Template();
        $template->setSettings($settings);
        $template->setTemplate($file);
        return $template;

    }

    public function generateString(Array $vars = [], String $id = null)
    {
        if (empty($id)) {

            $id = (string)Uuid::uuid4();

        }
        $builder = $this->makeBuilder($vars);

        return $builder->generateString();
    }

    private function makeBuilder(Array $vars)
    {

        $builder = new Builder();


        foreach ($this->settings['pages'] as $page) {

            $this->createPage($builder, $this->template, $page['template']['page']);


            foreach ($page['elements'] as $element) {

                switch ($element['type']) {
                    case 'text':
                        (new Text($builder, $element, $vars))->render();
                        break;
                    case 'textBox':
                        (new TextBox($builder, $element, $vars))->render();
                        break;

                }


            }


        }
        return $builder;

    }

    public function generate(String $path, Array $vars = [], $id = null)
    {


        $builder = $this->makeBuilder($vars);

        return $builder->generate($path);
    }

    public function makeGrid($pages = 1)
    {

        $builder = new Builder();
        for ($page = 1; $page <= $pages; $page++) {


            $builder->readPageFromPdf($this->template, $page);
            $builder->makeGrid();
        }
        return $builder->generateString();
    }


    private function createPage(Builder $builder, $pdf, $pageNumber)
    {
        $builder->readPageFromPdf($pdf, $pageNumber);


    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @param array $settings
     */
    public function setSettings(array $settings): void
    {
        if (!isset($settings['pages'])) {
            throw  new Exception('Bad Settings');
        }
        if (!is_array($settings['pages'])) {
            throw  new Exception('Bad Settings');
        }
        $this->settings = $settings;

    }


    /**
     * @return String
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(String $template): void
    {
        if (!file_exists($template)) {
            throw  new Exception('PDF Template not found');
        }
        $this->template = $template;
    }

    /**
     * @return array
     */
    public function getVars(): array
    {
        return $this->vars;
    }

    /**
     * @param array $vars
     */
    public function setVars(array $vars): void
    {
        $this->vars = $vars;
    }


}