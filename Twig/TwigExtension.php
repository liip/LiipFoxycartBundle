<?php

namespace Liip\FoxycartBundle\Twig;

use Liip\FoxycartBundle\CartValidation;

class TwigExtension extends \Twig_Extension
{
    private $cartValidation;

    /**
     * @param \Liip\FoxycartBundle\CartValidation $cartValidation
     */
    public function __construct(CartValidation $cartValidation)
    {
        $this->cartValidation = $cartValidation;
    }

    public function getFunctions()
    {
        return array(
            'foxycart_hash' => new \Twig_Function_Method($this, 'getHashedValue'),
            'foxycart_link_cart' => new \Twig_Function_Method($this, 'getHashCartLink'),
        );
    }

    public function getHashedValue($productCode, $optionName, $optionValue = '', $method = 'name', $urlencode = false)
    {
        return $this->cartValidation->getHashedValue($productCode, $optionName, $optionValue, $method, $urlencode);
    }

    public function getHashCartLink($parameters, $urlencode = true)
    {
        return $this->cartValidation->getHashCartLink($parameters, $urlencode);
    }

    public function getName()
    {
        return 'foxycart_extension';
    }
}