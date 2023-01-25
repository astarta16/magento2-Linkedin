<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Nini\Linkedin\Block\Checkout;

use Magento\Checkout\Helper\Data;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class LayoutProcessor
 */
class Linkedin implements \Magento\Checkout\Block\Checkout\LayoutProcessorInterface
{
    /**
     * Process js Layout of block
     *
     * @param array $jsLayout
     * @return array
     */
    public function process($jsLayout)
    {
        $customAttributeCode = 'linkedin_profile';
        $customField = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.linkedin_profile',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'tooltip' => [
                    'description' => 'Linkedin profile',
                ],
            ],
            'dataScope' => 'shippingAddress.linkedin_profile' . '.' . $customAttributeCode,
            'label' => 'Linkedin profile',
            'provider' => 'checkoutProvider',
            'sortOrder' => 50,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$customAttributeCode] = $customField;
        return $jsLayout;
    }


}