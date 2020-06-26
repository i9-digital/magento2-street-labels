<?php
namespace I9\StreetLabel\Plugin\Magento\Checkout\Block\Checkout;

class LayoutProcessor
{
    private $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        if ((bool)$this->getConfigValue('show_main_street_label')) {
            return $jsLayout;
        }

        $streetLines = [];

        $requiredLines = explode(',', $this->getConfigValue('required_street_lines'));

        for ($x = 0; $x < (int) $this->getConfigValue('street_lines'); $x++) {
            $streetLines[] = [
                'label' => __($this->getConfigValue('street_line' . $x . '_label')),
                'component' => 'Magento_Ui/js/form/element/abstract',
                'required' => in_array($x, $requiredLines),
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input'
                    ],
                'dataScope' => $x,
                'provider' => 'checkoutProvider',
                'validation' => [
                    'required-entry' => in_array($x, $requiredLines),
                    "min_text_len‌​gth" => 1,
                    "max_text_length" => 255
                ],
            ];
        }

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street'] = [
            'component' => 'Magento_Ui/js/form/components/group',
            'required' => false, //turn false because I removed main label
            'dataScope' => 'shippingAddress.street',
            'provider' => 'checkoutProvider',
            'sortOrder' => 0,
            'type' => 'group',
            'additionalClasses' => 'street show_labels',
            'children' => $streetLines
        ];
        return $jsLayout;
    }

    public function getConfigValue($key)
    {
        return $this->scopeConfig->getValue('customer/address/' . $key, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
