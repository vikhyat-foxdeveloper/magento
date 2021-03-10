<?php
/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\CookieExtension\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Fontsize implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 16, 'label' => __('Small')],
            ['value' => 18, 'label' => __('Medium')],
            ['value' => 20, 'label' => __('Large')]
        ];
    }
}
