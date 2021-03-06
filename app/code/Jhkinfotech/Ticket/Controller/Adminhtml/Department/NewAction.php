<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Adminhtml\Department;

class NewAction extends \Magento\Backend\App\Action
{
    protected $coreRegistry = null;
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Jhkinfotech_Ticket::department';

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Create new Department
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Jhkinfotech_Ticket::department');
    }
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultPageFactory = $this->resultPageFactory->create();

        $resultPageFactory->getConfig()->getTitle()->prepend('Manage Departments');

        $FormData = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($FormData)) {
            $model = $this->_objectManager->create('Jhkinfotech\Ticket\Model\Department');
            $model->setData($FormData);
            $this->coreRegistry->register('jhkinfotech_department', $model);
        }

        return $resultPageFactory;
    }
}
