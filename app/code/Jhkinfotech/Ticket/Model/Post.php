<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Model;

class Post extends \Magento\Framework\Model\AbstractModel
{

    const BASE_MEDIA_PATH = 'jhkinfotech/ticket/images';
    const CACHE_TAG = 'ticket_post';
    
    protected function _construct()
    {
        $this->_init('Jhkinfotech\Ticket\Model\ResourceModel\Post');
    }
}
