<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block\Index;

use Jhkinfotech\Ticket\Block\BaseBlock;

class Index extends BaseBlock
{
/**
 * Returns action url for contact form. Form submit URL
 *
 * @return string
 */
    public function getFormAction()
    {
        return $this->getUrl('ticket/Index/post', ['_secure' => true]);
    }
}
