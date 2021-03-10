<?php
/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\CookieExtension\Block;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Color extends Field
{
    protected $_cRegistry;

    public function __construct(
        Context $context,
        Registry $cRegistry,
        array $data = []
    ) {
        $this->_coreRegistry = $cRegistry;
        parent::__construct($context, $data);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $base = $this->getBaseUrl();
        $html = $element->getElementHtml();
        $cjsPath = $this->getViewFileUrl('Jhkinfotech_CookieExtension::js');
        if (!$this->_coreRegistry->registry('colorpicker_loaded')) {
            $html .= '<script type="text/javascript" src="' . $cjsPath . '/' . 'jscolor.js"></script>';
            $this->_coreRegistry->registry('colorpicker_loaded', 1);
        }
        $html .= '<script type="text/javascript">
                var el = document.getElementById("' . $element->getHtmlId() . '");
                el.className = el.className + " jscolor{hash:true}";
            </script>';

        return $html;
    }
}
