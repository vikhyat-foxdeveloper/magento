<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Customer\Model\Session;

class Formview extends Action
{
    protected $_session;

    public function __construct(Context $context, Session $session)
    {
        parent::__construct($context);
        $this->_session = $session;
    }

    public function execute()
    {
        if ($this->_session->isLoggedIn()) {
            $this->_view->loadLayout();
            $this->_view->getLayout()->initMessages();
            $this->_view->renderLayout();
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account/login');
            return $resultRedirect;
        }
    }
}
