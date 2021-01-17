<?php

namespace Vbcod\HtmlElement;

/**
 * Class Element
 * @package Vbcod\HtmlElement
 */
class Element
{
    private $tag = 'div';

    private $closed = true;

    /* @var Attribute[] */
    private $attributes = array();

    private $classList = array();

    private $innerHtml = '';

    private $outerHtml = '';

    public function render()
    {
        $attributesRendered = $this->renderAttributes();
        $attributesRendered = $attributesRendered ? ' '.$attributesRendered : '';

        $this->outerHtml = "<{$this->tag}{$attributesRendered}>";
        if($this->closed){
            $this->outerHtml .= $this->innerHtml;
            $this->outerHtml .= "</{$this->tag}>";
        }

        return $this->outerHtml;
    }

    public function setInnerHtml($innerHtml){
        $this->innerHtml = $innerHtml;

        return $this;
    }

    public function setTag($tag){
        $this->tag = $tag;

        return $this;
    }

    public function getTag(){
        return $this->tag;
    }

    public function addClass($className)
    {
        $this->classList[] = $className;

        return $this;
    }

    public function removeClass($className)
    {
        foreach ($this->classList as $k => $clsName){
            if($this->classList[$k] === $className){
                unset($this->classList[$k]);
            }
        }

        return $this;
    }

    public function markClosed()
    {
        $this->closed = true;

        return $this;
    }

    public function markNotClosed()
    {
        $this->closed = false;

        return $this;
    }

    public function setAttribute($name,$value)
    {
        $name = $this->cleanAttributeName($name);

        $this->attributes[$name] = $value;

        return $this;
    }

    public function getAttribute($name)
    {
        $name = $this->cleanAttributeName($name);

        if(empty($this->attributes[$name])){
            return '';
        }

        return $this->attributes[$name];
    }

    public function removeAttribute($name)
    {
        unset($this->attributes[$name]);

        return $this;
    }

    public static function cleanTag($tag){
        return trim(strtolower($tag));
    }

    private function getClassesAsArrayFromClassAttributeValue($value)
    {
        $value = trim($value);
        $value = preg_replace('/\s/', ' ', $value);

        return explode(' ',$value);
    }

    private function renderAttributes()
    {
        $attributesRendered = array();

        $classesListByAttributes    =
            $this->getClassesAsArrayFromClassAttributeValue($this->getAttribute('class'));

        $this->classList            = array_merge($this->classList,$classesListByAttributes);

        $this->removeAttribute('class');

        $attrsWithoutClass  = $this->attributes;

        $this->attributes   = array();

        $this->setAttribute('class',implode(' ',$this->classList));

        $this->attributes = array_merge($this->attributes,$attrsWithoutClass);

        foreach ($this->attributes as $name => $value){
            $attribute = new Attribute($name,$value);
            $attributeRendered = $attribute->render();

            if($attributeRendered){
                $attributesRendered[] = $attributeRendered;
            }
        }

        return implode(' ',$attributesRendered);
    }

    private function cleanAttributeName($name)
    {
        return trim(strtolower($name));
    }
}