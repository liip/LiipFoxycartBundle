<?php

namespace Liip\FoxycartBundle;

class CartValidation
{
    private $cartUrl;
    private $apiKey;
    private $excludes = array(
        // Cart values
        'cart', 'fcsid', 'empty', 'coupon', 'output', 'sub_token', 'redirect', 'callback', '_',
        // Checkout pre-population values
        'customer_email', 'customer_first_name', 'customer_last_name', 'customer_address1', 'customer_address2',
        'customer_city', 'customer_state', 'customer_postal_code', 'customer_country', 'customer_phone', 'customer_company',
        'shipping_first_name', 'shipping_last_name', 'shipping_address1', 'shipping_address2',
        'shipping_city', 'shipping_state', 'shipping_postal_code', 'shipping_country', 'shipping_phone', 'shipping_company',
    );
    private $prefixes = array(
        'h:', 'x:', '__',
    );

    /**
     * @param string $cartUrl
     * @param string $apiKey
     */
    public function __construct($cartUrl, $apiKey)
    {
        $this->cartUrl = $cartUrl;
        $this->apiKey = $apiKey;
    }

    public function getHashedValue($productCode, $optionName, $optionValue = '', $method = 'name', $urlencode = false)
    {
        if (!$productCode || !$optionName) {
            return false;
        }

        if ($optionValue == '--OPEN--') {
            $hash = hash_hmac('sha256', $productCode.$optionName.$optionValue, $this->apiKey);
            $value = ($urlencode) ? urlencode($optionName).'||'.$hash.'||open' : $optionName.'||'.$hash.'||open';
        } else {
            $hash = hash_hmac('sha256', $productCode.$optionName.$optionValue, $this->apiKey);
            if ($method == 'name') {
                $value = ($urlencode) ? urlencode($optionName).'||'.$hash : $optionName.'||'.$hash;
            } else {
                $value = ($urlencode) ? urlencode($optionValue).'||'.$hash : $optionValue.'||'.$hash;
            }
        }

        return $value;
    }

    public function getHashCartLink($params, $urlencode = true)
    {
        if (isset($params['code'])) {
            $productCode = $params['code'];

            foreach ($params as $key => $value) {
                if (is_scalar($value)) {
                    if (in_array($key, $this->excludes)) {
                        continue;
                    }
                    foreach ($this->prefixes as $prefix) {
                        if (0 === strpos($key, $prefix)) {
                            continue;
                        }
                    }

                    $params[$key] = $this->getHashedValue($productCode, $key, $value, 'value', $urlencode);
                }
            }
        }

        return $this->cartUrl.'?'.http_build_query($params);
    }
}