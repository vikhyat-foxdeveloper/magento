<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Jhkinfotech\Ticket\Model\ReplyFactory;

class Detail extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $_reply;

    public function __construct(
        Action\Context $context,
        ReplyFactory $reply,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_reply = $reply;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $postid = $this->getRequest()->getParam('post_id');
        $reply = $this->_reply->create();
        $collection = $reply->getCollection();
        foreach ($collection as $item) {
            if ($postid == $item->getPost_id()) {
                $savevalue = [$item->getReply_id() => 'read'];
                $item->setData('read_status', $savevalue[$item->getReply_id()]);
                $item->save();
            }
        }
        
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
