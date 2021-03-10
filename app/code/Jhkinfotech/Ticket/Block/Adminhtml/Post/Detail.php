<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block\Adminhtml\Post;

use Magento\Framework\View\Element\Template\Context;
use Jhkinfotech\Ticket\Model\PostFactory;

/**
 * post View block
 */
class Detail extends \Magento\Framework\View\Element\Template
{

    protected $authSession;

    public function __construct(
        PostFactory $post,
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey
    ) {
        $this->_post = $post;
        parent::__construct($context);
        $this->formKey = $formKey;
    }
      
    public function getSingleData()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        $post = $this->_post->create();
        $singleData = $post->load($post_id);
        return $singleData;
    }

    public function getFormKey()
    {
         return $this->formKey->getFormKey();
    }
}
