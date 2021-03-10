<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block\Index;

use Magento\Framework\View\Element\Template\Context;
use Jhkinfotech\Ticket\Model\TicketFactory;
use Jhkinfotech\Ticket\Model\ReplyFactory;
use Jhkinfotech\Ticket\Helper\Data as HelperData;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Formview extends \Magento\Framework\View\Element\Template
{
    public $helperData;

    protected $scopeConfig;

    public function __construct(
        Context $context,
        TicketFactory $ticket,
        ReplyFactory $reply,
        HelperData $helper
    ) {
        $this->_ticket = $ticket;
        $this->_reply  = $reply;
        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
        $this->helper = $helper;
    }

    public function getConfig($config)
    {
        return $this->scopeConfig->getValue(
            $config,
            ScopeInterface::SCOPE_STORE
        );
    }
    public function isTitle()
    {
        return $this->getConfig('ticket/general/display_title');
    }
    public function _prepareLayout()
    {
        parent::_prepareLayout();

        if ($this->getTicketCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'ticket.index.formview'
            )
            ->setAvailableLimit([20 => 20, 40 => 40, 80 => 80, 100 => 100])
                ->setShowPerPage(true)->setCollection(
                    $this->getTicketCollection()
                );
            $this->setChild('pager', $pager);
            $this->getTicketCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getTicketCollection()
    {
        //get values of current page
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        //get values of current limit
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 20;
        
        $ticket = $this->_ticket->create();
        $collection = $ticket->getCollection();
        $collection->setOrder('post_id', 'DESC');
        $collection->setOrder('read_status', 'ASC');

        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        
        return $collection;
    }
    public function getTitle()
    {
        $display_title = $this->helperData->getGeneralConfig('display_title');
        return $display_title;
    }
    public function getreplydata()
    {
        $reply = $this->_reply->create();
        $collection = $reply->getCollection();
        $collection->addFieldToSelect('read_status');
        $collection->addFieldToSelect('post_id');

        return $collection;
    }
}
