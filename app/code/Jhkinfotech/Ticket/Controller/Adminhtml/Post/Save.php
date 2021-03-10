<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\TestFramework\ErrorLog\Logger;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Customer\Model\CustomerFactory;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Action
{

    protected $_customer;
    protected $storeManager;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    // protected $storeManager;
    /**
     * @param Action\Context $context
     */
    const  XML_PATH_EMAIL_TEMPLATE_ADMIN_TICKET = 'ticket/general/jhkinfotech_ticket_front_create';
    const  XML_PATH_EMAIL_TEMPLATE_ADMIN_TICKET_COPY_TO = 'ticket/general/new_ticket_copy_to';

    public function __construct(
        Context $context,
        CustomerFactory $customer,
        StoreManagerInterface $storemanager,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        array $data = []
    ) {
        $this->_customer = $customer;
        $this->storeManager = $storemanager;
        parent::__construct($context);
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Jhkinfotech_Ticket::post');
    }

    public function getStoreUrl()
    {
        $storeUrl = $this->storeManager->getStore()->getBaseUrl();
        return $storeUrl;
    }
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $mailtrnsafer = $this->_scopeConfig ->getValue('ticket/general/admin_email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($this->getRequest()->getPostValue('status') == 'Closed') {
            $templateId = 'ticket_general_jhkinfotech_ticket_close';
            $senderEmail = $this->_scopeConfig ->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $senderName = $this->_scopeConfig ->getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $copyto = $this->_scopeConfig ->getValue(self::XML_PATH_EMAIL_TEMPLATE_ADMIN_TICKET_COPY_TO, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $toEmail = $this->getRequest()->getParam('customeremail');
            $toEmailCC = $this->getRequest()->getParam('ccrecipients');
            
        } else {
            $templateId = $this->_scopeConfig ->getValue(self::XML_PATH_EMAIL_TEMPLATE_ADMIN_TICKET, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $senderEmail = $this->_scopeConfig ->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $senderName = $this->_scopeConfig ->getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $copyto = $this->_scopeConfig ->getValue(self::XML_PATH_EMAIL_TEMPLATE_ADMIN_TICKET_COPY_TO, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $toEmail = $this->getRequest()->getParam('customeremail');
            $toEmailCC = $this->getRequest()->getParam('ccrecipients');
        }
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Jhkinfotech\Ticket\Model\Post $model */
            $model = $this->_objectManager->create('Jhkinfotech\Ticket\Model\Post');

            $id = $this->getRequest()->getParam('post_id');
            
            if ($id) {
                $model->load($id);
            }
            try {
                $uploader = $this->_objectManager->create('Magento\MediaStorage\Model\File\Uploader', ['fileId' => 'image']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'pdf' , 'csv', 'png', 'doc']);
                /** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
                $imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                    ->getDirectoryRead(DirectoryList::MEDIA);
                $result = $uploader->save(
                    $mediaDirectory->getAbsolutePath(\Jhkinfotech\Ticket\Model\Post::BASE_MEDIA_PATH)
                );
                $data['image'] = \Jhkinfotech\Ticket\Model\Post::BASE_MEDIA_PATH.$result['file'];
            } catch (\Exception $e) {
                if ($e->getCode() == 0) {
                        // $this->messageManager->addError($e->getMessage());
                        $this->messageManager->addException($e, __('uploaded file extension must have .jpg, .jpeg, .png, .pdf, .csv, .doc.'));
                }
                if (isset($data['image']) && isset($data['image']['value'])) {
                    
                    if (isset($data['image']['delete'])) {
                        $data['image'] = null;
                        $data['delete_image'] = true;
                    } elseif (isset($data['image']['value'])) {
                        $data['image'] = $data['image']['value'];
                    } else {
                            $data['image'] = null;
                    }
                }
            }
                
            $data['store_id'] = implode(',', $this->getRequest()->getParam('store_id'));
            
            $model->setData($data);
            
            $this->_eventManager->dispatch(
                'ticket_post_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );

            $email = $this->getRequest()->getParam('customeremail');
            $customer = $this->_customer->create();
            $collection = $customer->getCollection();
            $collection->addFieldToSelect('email');
            foreach ($collection as $customerid) {
                if ($customerid->getemail() == $this->getRequest()->getParam('customeremail')) {
                    $customergetid =  $customerid->getId();
                }
            }
            if (!empty($customergetid)) {
                $model->setData('customer_id', $customergetid);
            }

            try {
                $model->save();
                if (!empty($mailtrnsafer) && $model->save()) {
                    if ($data['status'] == 'Closed') {
                        // template variables pass here
                        $templateVars = [
                            'ticket_subject' => $data['title'],
                            'customer_name'  => $data['customername'],
                            'ticket_id'     => $data['post_id']
                            
                        ];
            
                        $storeId = $this->storeManager->getStore()->getId();
            
                        $from = ['email' => $senderEmail, 'name' => $senderName];
                        $this->_inlineTranslation->suspend();
            
                        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                        $templateOptions = [
                            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                            'store' => $storeId
                        ];
                        $transport = $this->_transportBuilder->setTemplateIdentifier($templateId, $storeScope)
                            ->setTemplateOptions($templateOptions)
                            ->setTemplateVars($templateVars)
                            ->setFrom($from)
                            ->addTo($toEmail);
                        if (!empty($copyto)) {
                            $arr = explode(",", $copyto);
                            foreach ($arr as $pri) {
                                $this->_transportBuilder->addBcc($pri);
                            }
                        }
                        if (!empty($toEmailCC)) {
                            $this->_transportBuilder->addCc($toEmailCC);
                        }
                        $transport = $this->_transportBuilder->getTransport();
                        $transport->sendMessage();
                        $this->_inlineTranslation->resume();
                        $this->messageManager->addSuccessMessage(__('You Submit This Ticket.'));
                    } else {
                        // template variables pass here
                        $templateVars = [
                            'customer_name'  => $data['customername'],
                            // 'ticket_id'  => $data['post_id'],
                            'subject'  => $data['title'],
                            'customeremail'  => $data['customeremail'],
                            'status'  => $data['status'],
                            'priority'  => $data['priority'],
                            'department'  => $data['department'],
                            'message'  => $data['message']
                        ];
            
                        $storeId = $this->storeManager->getStore()->getId();
            
                        $from = ['email' => $senderEmail, 'name' => $senderName];
                        $this->_inlineTranslation->suspend();
            
                        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                        $templateOptions = [
                            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                            'store' => $storeId
                        ];
                        $transport = $this->_transportBuilder->setTemplateIdentifier($templateId, $storeScope)
                            ->setTemplateOptions($templateOptions)
                            ->setTemplateVars($templateVars)
                            ->setFrom($from)
                            ->addTo($toEmail);
                        if (!empty($copyto)) {
                            $arr = explode(",", $copyto);
                            foreach ($arr as $pri) {
                                $this->_transportBuilder->addBcc($pri);
                            }
                        }
                        if (!empty($toEmailCC)) {
                            $this->_transportBuilder->addCc($toEmailCC);
                        }
                        $transport = $this->_transportBuilder->getTransport();
                        $transport->sendMessage();
                        $this->_inlineTranslation->resume();
                        $this->messageManager->addSuccessMessage(__('You Submit The Ticket.'));
                    }
                } elseif ($model->save() && empty($mailtrnsafer)) {
                    $this->messageManager->addSuccessMessage(__('You Submit the Ticket. We\'ll respond to you very soon.'));
                } else {
                    $this->messageManager->addError($e->getMessage());
                }
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // $this->messageManager->addException($e, __('Something went wrong while saving the Ticket.'));
                $this->messageManager->addError($e->getMessage());
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
