<?php

namespace Liip\FoxycartBundle\Twig;

use Liip\FoxycartBundle\CartValidation;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class TwigExtension extends \Twig_Extension
{
    /**
     * @var \Liip\FoxycartBundle\CartValidation
     */
    private $cartValidation;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @param CartValidation $cartValidation
     * @param ContainerInterface $container
     */
    public function __construct(CartValidation $cartValidation, ContainerInterface $container)
    {
        $this->cartValidation = $cartValidation;
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'foxycart_head' => new \Twig_Function_Method($this, 'getFoxycartHead', array('is_safe' => array('html'))),
            'foxycart_hash' => new \Twig_Function_Method($this, 'getHashedValue'),
            'foxycart_link_cart' => new \Twig_Function_Method($this, 'getHashCartLink'),
            'foxycart_url_cart' => new \Twig_Function_Method($this, 'getCartLink'),
        );
    }

    public function getFoxycartHead($colorbox = true)
    {
        return $this->container->get('templating')->render('LiipFoxycartBundle::head.html.twig', array('colorbox' => $colorbox));
    }

    public function getHashedValue($productCode, $optionName, $optionValue = '', $method = 'name', $urlencode = false)
    {
        return $this->cartValidation->getHashedValue($productCode, $optionName, $optionValue, $method, $urlencode);
    }

    public function getHashCartLink($parameters, $urlencode = true)
    {
        return $this->cartValidation->getHashCartLink($parameters, $urlencode);
    }

    public function getCartLink()
    {
        return $this->container->getParameter('foxycart_cart_url');
    }

    public function getName()
    {
        return 'foxycart_extension';
    }
}