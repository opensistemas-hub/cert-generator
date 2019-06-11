<?php


namespace Opensitemas\CertGenerator\Elements;


use Opensitemas\CertGenerator\Builder;

class Text
{
    /**
     * @var Builder
     */
    private $builder;
    private $element;
    use Renderable;

    public function __construct(Builder $builder, $element, $vars)
    {
        $this->builder = $builder;
        $this->element = $element;
        $this->vars    = $vars;
    }

    public function render()
    {

        if (isset($this->element->font)) {
            $this->setFont($this->element->font);
        }


        $this->builder->writeText($this->element->x, $this->element->y, $this->getValue($this->element->value));

    }


}