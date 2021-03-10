<?php
/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */
 
namespace Jhkinfotech\CookieExtension\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Textalign implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'left', 'label' => __('Left')],
            ['value' => 'center', 'label' => __('Center')],
            ['value' => 'right', 'label' => __('Right')]
        ];
    }
}
