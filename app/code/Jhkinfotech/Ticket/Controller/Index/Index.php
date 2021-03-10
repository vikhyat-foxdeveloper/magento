<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Http\Context as AuthContext;

class Index extends \Magento\Framework\App\Action\Action
{

    private $customerSession;
    private $authContext;
/**
 * @var \Magento\Framework\App\Cache\TypeListInterface
 */
    protected $_cacheTypeList;

/**
 * @var \Magento\Framework\App\Cache\StateInterface
 */
    protected $_cacheState;

/**
 * @var \Magento\Framework\App\Cache\Frontend\Pool
 */
    protected $_cacheFrontendPool;

/**
 * @var \Magento\Framework\View\Result\PageFactory
 */
    protected $resultPageFactory;

/**
 * @param Action\Context $context
 * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
 * @param \Magento\Framework\App\Cache\StateInterface $cacheState
 * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
 * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
 */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Session $session,
        AuthContext $authContext
    ) {
        parent::__construct($context);
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheState = $cacheState;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $session;
        $this->authContext = $authContext;
    }
/**
 * Flush cache storage
 *
 */
    public function execute()
    {
        if ($this->customerSession->isLoggedIn()) {
            $this->_view->loadLayout();
            $this->_view->getLayout()->initMessages();
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account/login');
            return $resultRedirect;
        }
    }
}
