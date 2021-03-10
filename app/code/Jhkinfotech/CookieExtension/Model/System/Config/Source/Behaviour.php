<?php
/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */
 
namespace Jhkinfotech\CookieExtension\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Behaviour implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 365, 'label' => 'Never show again'],
            ['value' => 1, 'label' => 'Hide for the rest of the day'],
            ['value' => 0, 'label' => 'Hide for the rest of the session']
        ];
    }
}
