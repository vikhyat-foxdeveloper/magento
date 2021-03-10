<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Model;

use Magento\Framework\Model\AbstractModel;

class Reply extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Jhkinfotech\Ticket\Model\ResourceModel\Reply');
    }
}
