<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Model\ResourceModel\Ticket;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Jhkinfotech\Ticket\Model\Ticket',
            'Jhkinfotech\Ticket\Model\ResourceModel\Ticket'
        );
    }
}
