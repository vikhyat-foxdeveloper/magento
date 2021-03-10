<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Helper;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\View as CustomerViewHelper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ENABLED = 'ticket/ticket/enabled';
    const TITLE_FIELD = 'ticket/general/display_title';
    const LABEL_FIELD  = 'ticket/general/display_title';

    const CREATE_TICKET_MAILTEMPLATE_FIELD  = 'ticket/general/jhkinfotech_ticket_front_create';
    const FRONT_REPLY_TICKET_MAILTEMPLATE_FIELD  = 'ticket/general/jhkinfotech_ticket_front_reply';
    const ADMIN_REPLY_TICKET_MAILTEMPLATE_FIELD  = 'ticket/general/jhkinfotech_ticket_reply_admin';
/**
 * Customer session
 *
 * @var \Magento\Customer\Model\Session
 */
    protected $_customerSession;

/**
 * @var \Magento\Customer\Helper\View
 */
    protected $_customerViewHelper;

/**
 * @param \Magento\Framework\App\Helper\Context $context
 * @param \Magento\Customer\Model\Session $customerSession
 * @param CustomerViewHelper $customerViewHelper
 */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        CustomerViewHelper $customerViewHelper
    ) {
        $this->_customerSession = $customerSession;
        $this->_customerViewHelper = $customerViewHelper;
        parent::__construct($context);
    }

/**
 * Check if enabled
 *
 * @return string|null
 */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue(
            $config,
            ScopeInterface::SCOPE_STORE
        );
    }
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
/**
 * Get user name
 *
 * @return string
 */
    public function getUserName()
    {
        if (!$this->_customerSession->isLoggedIn()) {
            return;
        }
    /**
     @var \Magento\Customer\Api\Data\CustomerInterface $customer
*/

        $customer = $this->_customerSession->getCustomerDataObject();
        return trim($this->_customerViewHelper->getCustomerName($customer));
    }

/**
 * Get user email
 *
 * @return string
 */
    public function getUserEmail()
    {
        if (!$this->_customerSession->isLoggedIn()) {
            return;
        }
    /**
     @var CustomerInterface $customer
*/
        $customer = $this->_customerSession->getCustomerDataObject();
        return $customer->getEmail();
    }
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HELLOWORLD .'general/'. $code, $storeId);
    }
    
    public function getTitle()
    {
        return $this->scopeConfig->getValue(self::TITLE_FIELD, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function getLabel()
    {
        return $this->scopeConfig->getValue(self::LABEL_FIELD, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function getNewticketmailtemplate()
    {
        return $this->scopeConfig->getValue(self::CREATE_TICKET_MAILTEMPLATE_FIELD, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function getfrontreplyticketmailtemplate()
    {
        return $this->scopeConfig->getValue(self::FRONT_REPLY_TICKET_MAILTEMPLATE_FIELD, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function getadminreplyticketmailtemplate()
    {
        return $this->scopeConfig->getValue(self::ADMIN_REPLY_TICKET_MAILTEMPLATE_FIELD, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
