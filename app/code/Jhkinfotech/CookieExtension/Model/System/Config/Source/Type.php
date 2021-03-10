<?php
/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\CookieExtension\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Type implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'v-bar', 'label' => __('Bar')],
            ['value' => 'v-box', 'label' => __('Box')]
        ];
    }
}
