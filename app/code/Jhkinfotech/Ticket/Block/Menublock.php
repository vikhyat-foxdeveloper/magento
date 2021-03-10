<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block;

use Magento\Framework\View\Element\Html\Link\Current;
use Magento\Store\Model\ScopeInterface;

class Menublock extends Current
{
    public function _toHtml()
    {
        $isEnable = $this->_scopeConfig ->getValue('ticket/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $isPagetitle = $this->_scopeConfig ->getValue('ticket/general/display_title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (!$isEnable == '1' || !$isPagetitle) {
            return '';
        }
        return parent::_toHtml();
    }
}
