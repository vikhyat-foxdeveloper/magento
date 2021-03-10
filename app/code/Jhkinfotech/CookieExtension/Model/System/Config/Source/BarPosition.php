<?php
/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\CookieExtension\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class BarPosition implements ArrayInterface
{
    const C_TOP = 'v-top';
    const C_BOTTOM = 'v-bottom';

    public function toOptionArray()
    {
        return [
            ['value' => self::C_TOP, 'label' => __('Top')],
            ['value' => self::C_BOTTOM, 'label' => __('Bottom')]
        ];
    }
}
