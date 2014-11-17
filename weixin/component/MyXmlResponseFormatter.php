<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/17
 * Time: 下午1:11
 */

namespace weixin\component;

use yii\web\XmlResponseFormatter;
use DOMElement;
use DOMText;
use yii\helpers\StringHelper;
use yii\base\Arrayable;
use DOMCdataSection;

class MyXmlResponseFormatter extends XmlResponseFormatter{
    public $rootTag = "xml";
    const CDATA = '---cdata---';

    /**
     * @param DOMElement $element
     * @param mixed $data
     */
    protected function buildXml($element, $data)
    {
        if (is_object($data)) {
            $child = new DOMElement(StringHelper::basename(get_class($data)));
            $element->appendChild($child);
            if ($data instanceof Arrayable) {
                $this->buildXml($child, $data->toArray());
            } else {
                $array = [];
                foreach ($data as $name => $value) {
                    $array[$name] = $value;
                }
                $this->buildXml($child, $array);
            }
        } elseif (is_array($data)) {
            foreach ($data as $name => $value) {
                if (is_int($name) && is_object($value)) {
                    $this->buildXml($element, $value);
                } elseif (is_array($value) || is_object($value)) {
                    $child = new DOMElement(is_int($name) ? $this->itemTag : $name);
                    $element->appendChild($child);
                    if(array_key_exists(self::CDATA, $value)){
                        $child->appendChild(new DOMCdataSection((string) $value[0]));
                    }else{
                        $this->buildXml($child, $value);
                    }
                } else {
                    $child = new DOMElement(is_int($name) ? $this->itemTag : $name);
                    $element->appendChild($child);
                    $child->appendChild(new DOMText((string) $value));
                }
            }
        } else {
            $element->appendChild(new DOMText((string) $data));
        }
    }
}