<?php
/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */
 
namespace Jhkinfotech\CookieExtension\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Target implements ArrayInterface
{
    const C_SAME_WINDOW = '_self';
    const C_NEW_WINDOW = '_blank';

    public function toOptionArray()
    {
        return [
            ['value' => self::C_SAME_WINDOW, 'label' => __('Same Window')],
            ['value' => self::C_NEW_WINDOW, 'label' => __('New Window')]
        ];
    }
}
