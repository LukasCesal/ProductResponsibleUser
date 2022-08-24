<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUser\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Department implements OptionSourceInterface {

    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray ()
    {

        $backendOptions = json_decode($this->scopeConfig->getValue('catalog/responsible_users/departments'), true);
        $options = [];

        foreach ($backendOptions as $option) {
            $options[] = [
                'label' => $option['name'],
                'value' => $option['name'],
            ];
        }

        return $options;
    }
}
