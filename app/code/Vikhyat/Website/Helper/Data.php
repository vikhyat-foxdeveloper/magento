<?php
namespace Vikhyat\Website\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{	
	/**
     * Retrieve store config value
     * @param  string $path
     * @return mixed
     */
    public function getConfig($path)
    {
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}