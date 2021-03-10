<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Index;
 
use Magento\Framework\App\Action\Context;
use Jhkinfotech\Ticket\Model\TicketFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Zend\Log\Filter\Timestamp;
use Magento\Store\Model\StoreManagerInterface;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Ticket
     */
    protected $_ticket;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $storeManager;

    const  XML_PATH_EMAIL_TEMPLATE = 'ticket/general/jhkinfotech_ticket_front_create';
 
    public function __construct(
        Context $context,
        TicketFactory $ticket,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_ticket = $ticket;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->messageManager = $context->getMessageManager();
        $this->storeManager = $storeManager;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        parent::__construct($context);
    }
    public function execute()
    {
        $post = $this->getRequest()->getParams();
        $templateId = $this->_scopeConfig ->getValue(self::XML_PATH_EMAIL_TEMPLATE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $senderEmail = $this->_scopeConfig ->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $senderName = $this->_scopeConfig ->getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $toEmail = $this->_scopeConfig ->getValue('ticket/general/admin_email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $copyto = $this->_scopeConfig ->getValue('ticket/general/front_reply_copy_to', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $toEmailCC = $post['ccrecipients'];
        $customer_name = $post['customername'];
        // echo $ticket_id = $post['post_id'];
        $subject =  $post['title'];
        $customeremail = $post['customeremail'];
        $status = $post['status'];
        $priority = $post['priority'];
        $department = $post['department'];
        $message =  $post['message'];

        try {
            $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
            $imageAdapter = $this->adapterFactory->create();
            $uploaderFactory->setAllowRenameFiles(true);
            $uploaderFactory->setFilesDispersion(true);
            $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
            $destinationPath = $mediaDirectory->getAbsolutePath('jhkinfotech/ticket');
            $result = $uploaderFactory->save($destinationPath);
            
            if (!$result) {
                throw new LocalizedException(
                    __('File cannot be saved to path: $1', $destinationPath)
                );
            }
            $imagePath = 'jhkinfotech/ticket'.$result['file'];
            $post['image'] = $imagePath;
                
        } catch (\Exception $e) {
            // $this->messageManager->addError($e->getMessage());
        }

        $ticket = $this->_ticket->create();
        $ticket->setData($post);
        $ticket->save();

        if ($ticket->save()) {
            try {
                $templateVars = [
                    'customer_name'  => $customer_name,
                    'subject'  => $subject,
                    'customeremail'  => $customeremail,
                    'status'  => $status,
                    'priority'  => $priority,
                    'department'  => $department,
                    'message'  => $message
                ];
    
                $storeId = $this->storeManager->getStore()->getId();
                $from = ['email' => $senderEmail, 'name' => $senderName];
                $this->_inlineTranslation->suspend();
    
                $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                $templateOptions = [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $storeId
                ];
                    $this->_transportBuilder->setTemplateIdentifier($templateId, $storeScope)
                    ->setTemplateOptions($templateOptions)
                    ->setFrom($from)->setTemplateVars($templateVars);
                
                if (!empty($toEmail)) {
                    $this->_transportBuilder->addTo($toEmail);
                 } 
                //else {
                //     // $this->messageManager->addError($e->getMessage());
                //     // $this->messageManager->addErrorMessage(__('Without Admin configuration "Admin Notification Email" value mail system not working.'));
                // }
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
                $this->messageManager->addSuccessMessage(__('You Submit the Ticket. We\'ll respond to you very soon.'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                // $this->messageManager->addErrorMessage(__('Ticket was not Submit.'));

            }
        } else {
            $this->messageManager->addErrorMessage(__('Ticket was not Submit.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('ticket/index/formview');
        return $resultRedirect;
    }
}
