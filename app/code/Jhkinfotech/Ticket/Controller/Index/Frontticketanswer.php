<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Index;
 
use Magento\Framework\App\Action\Context;
use Jhkinfotech\Ticket\Model\TicketFactory;
use Jhkinfotech\Ticket\Model\ReplyFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;

class Frontticketanswer extends \Magento\Framework\App\Action\Action
{
    protected $_reply;
    protected $_ticket;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $storeManager;

    const  XML_PATH_EMAIL_TEMPLATE_FRONT_REPLY = 'ticket/general/jhkinfotech_ticket_front_reply';

    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ReplyFactory $reply,
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
        $this->storeManager = $storeManager;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_reply = $reply;
        $this->_ticket = $ticket;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
    }
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $templateId = $this->_scopeConfig ->getValue(self::XML_PATH_EMAIL_TEMPLATE_FRONT_REPLY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $senderEmail = $this->_scopeConfig ->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $senderName = $this->_scopeConfig ->getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        
        $postid = $this->getRequest()->getParam('post_id');
        $ticket = $this->_ticket->create();
        $ticket->load($postid);
        $curenr_post_emailid = $ticket->getCustomeremail();
        
        $toEmail = $this->_scopeConfig ->getValue('ticket/general/admin_email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $copyto = $this->_scopeConfig ->getValue('ticket/general/front_reply_copy_to', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $toEmailCC = $ticket->getCcrecipients();
        
        try {
            $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
            $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'csv', 'png', 'pdf', 'doc']);
            $imageAdapter = $this->adapterFactory->create();
            /* start of validated image */
            // $uploaderFactory->addValidateCallback('custom_image_upload',$imageAdapter,'validateUploadFile');
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
                $data['image'] = $imagePath;
                
        } catch (\Exception $e) {
            if ($e->getCode() == 0) {
                // $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('uploaded file extension must have .jpg, .jpeg, .png, .pdf, .csv, .doc.'));
            }
        }

        $reply = $this->_reply->create();
        $reply->setData($data);
        
        $reply->save();

        if (!empty($toEmail) && $reply->save()) {
            try {
                // template variables pass here
                $templateVars = [
                    'customer_name'  => $data['answer_user'],
                    'ticket_id'  => $postid,
                    'message'  => $data['answer']
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
                $this->messageManager->addSuccessMessage(__('Your response is saved.'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        } elseif ($reply->save() && empty($toEmail)) {
            $this->messageManager->addSuccessMessage(__('your response not saved.'));
        } else {
            $this->messageManager->addErrorMessage(__('your response was not saved.'));
        }
        
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('ticket/index/formview');
        return $resultRedirect;
    }
}
