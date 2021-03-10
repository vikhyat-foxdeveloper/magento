<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Model\Config\Source;

class Priority implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            ['value' => 'Low', 'label' => __('Low')],
            ['value' => 'Medium', 'label' => __('Medium')],
            ['value' => 'Urgent', 'label' => __('Urgent')]
            
          ];
    }
}
