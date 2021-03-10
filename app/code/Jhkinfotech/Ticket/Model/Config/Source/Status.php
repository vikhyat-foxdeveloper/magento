<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Model\Config\Source;

class Status implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            ['value' => 'Open', 'label' => __('Open')],
            ['value' => 'Pending', 'label' => __('Pending')],
            ['value' => 'Closed', 'label' => __('Closed')]
            
          ];
    }
}
