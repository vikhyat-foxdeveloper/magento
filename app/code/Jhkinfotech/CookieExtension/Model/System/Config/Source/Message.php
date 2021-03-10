<?php
/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */
 
namespace Jhkinfotech\CookieExtension\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Message implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'default', 'label' => __('Default message')],
            ['value' => 'custom', 'label' => __('Custom message')]
        ];
    }
}
