<?php

namespace Vbcod\HtmlElement;

class Attribute
{
    private $name = '';
    private $value = '';
    private $outerHtml = '';

    public function __construct($name='', $value='')
    {
        $this->name  = $name;
        $this->value = $value;

        return $this;
    }

    public function render()
    {
        $this->outerHtml = "{$this->name}=\"{$this->value}\"";

        return $this->outerHtml;
    }

    public function getOuterHtml()
    {
        $this->render();
        return $this->outerHtml;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->name;
    }

    public function setName($newName = '')
    {
        $this->name = $newName;

        return $this;
    }

    public function setValue($newValue = '')
    {
        $this->value = $newValue;

        return $this;
    }
}