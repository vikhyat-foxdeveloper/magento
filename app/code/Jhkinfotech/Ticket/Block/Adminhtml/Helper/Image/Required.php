<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block\Adminhtml\Helper\Image;

class Required extends \Magento\Framework\Data\Form\Element\Image
{
    protected function _getDeleteCheckbox()
    {
        return '';
    }
}
