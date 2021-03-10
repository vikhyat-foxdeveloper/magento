<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Jhkinfotech\Ticket\Model\TicketFactory;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    protected $_ticket;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        TicketFactory $ticket
    ) {
        $this->_ticket = $ticket;
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Jhkinfotech_Ticket::post');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Jhkinfotech_ticket::post')
            ->addBreadcrumb(__('Ticket'), __('Ticket'))
            ->addBreadcrumb(__('Manage Our Ticket'), __('Manage Our Ticket'));
        return $resultPage;
    }

    /**
     * Edit Ticket post
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('post_id');
        $model = $this->_objectManager->create('Jhkinfotech\Ticket\Model\Post');

        

        $ticket = $this->_ticket->create()->load($id);
        $collection = $ticket->getCollection();
        foreach ($collection as $item) {
            if ($id == $item->getPost_id()) {
                $savevalue = [$item->getticket_id() => 'read'];
                $item->setData('read_status', $savevalue[$item->getticket_id()]);
                $item->save();
                // echo "hello"; exit;
            }
        }
        
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This post no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('ticket_post', $model);

        $statusHelper = $this->_objectManager->get('Jhkinfotech\Ticket\Model\Config\Source\Status');
        $this->_coreRegistry->register('jhkinfotech_ticket_status_list', $statusHelper->toOptionArray());

        $priorityHelper = $this->_objectManager->get('Jhkinfotech\Ticket\Model\Config\Source\Priority');
        $this->_coreRegistry->register('jhkinfotech_ticket_priority_list', $priorityHelper->toOptionArray());

        $departmentHelper = $this->_objectManager->get('Jhkinfotech\Ticket\Model\Config\Source\Department');
        $this->_coreRegistry->register('jhkinfotech_ticket_department_list', $departmentHelper->toOptionArray());
        
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Ticket Post') : __('New Ticket'),
            $id ? __('Edit Ticket Post') : __('New Ticket')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Our Ticket'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Ticket'));

        return $resultPage;
    }
}
