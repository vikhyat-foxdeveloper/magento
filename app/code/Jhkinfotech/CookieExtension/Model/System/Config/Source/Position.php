<?php

namespace Jhkinfotech\CookieExtension\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Position implements ArrayInterface
{
    const C_TOPLEFT = 'v-top-left';
    const C_TOPRIGHT = 'v-top-right';
    const C_BOTTOMLEFT = 'v-bottom-left';
    const C_BOTTOMRIGHT = 'v-bottom-right';
    const C_CENTER = 'v-center';

    public function toOptionArray()
    {
        return [
            ['value' => self::C_TOPLEFT, 'label' => __('Top left')],
            ['value' => self::C_TOPRIGHT, 'label' => __('Top right')],
            ['value' => self::C_BOTTOMLEFT, 'label' => __('Bottom left')],
            ['value' => self::C_BOTTOMRIGHT, 'label' => __('Bottom right')],
            ['value' => self::C_CENTER, 'label' => __('Center')]
        ];
    }
}
