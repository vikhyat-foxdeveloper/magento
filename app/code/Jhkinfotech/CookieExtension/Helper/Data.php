<?php
/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\CookieExtension\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const ENABLE_DISABLE = 'cookieextension/general/enabledisable';
    const C_TYPE = 'cookieextension/general/type';
    const C_BAR_POSITION = 'cookieextension/general/bar_position';
    const C_BOX_POSITION = 'cookieextension/general/box_position';
    const C_BEHAVIOUR = 'cookieextension/general/behaviour';
    const C_AUTO_HIDE_AFTER = 'cookieextension/general/auto_hide_after';
    const C_AUTO_ACCEPT = 'cookieextension/general/auto_accept';
    const C_EXPIRE = 'cookieextension/general/expire';
    const C_SHOW = 'cookieextension/content/show';
    const C_CUSTOM_MESSAGE = 'cookieextension/content/custom_message';
    const C_MODEL_TITLE = 'cookieextension/content/model_title';
    const C_DISPLAY_TITLE = 'cookieextension/content/display_title';
    const C_CUSTOM_ACCEPT = 'cookieextension/content/custom_accept';
    const C_CUSTOM_CLOSE = 'cookieextension/content/custom_close';
    const C_DISPLAY_DECLINE = 'cookieextension/content/deny_button';
    const C_CUSTOM_MORE_INFO = 'cookieextension/content/custom_more_info';
    const C_NEWTAB = 'cookieextension/content/newtab';
    const C_CMS_PAGE = 'cookieextension/content/cms_page';
    const C_FONT_FAMILY = 'cookieextension/display_style/font_family';
    const C_MODEL_TEXT_ALIGN = 'cookieextension/display_style/model_text_align';
    const C_MODEL_TITLE_SIZE = 'cookieextension/display_style/model_title_size';
    const C_MODEL_MESSAGE_SIZE = 'cookieextension/display_style/model_message_size';
    const C_HEADER_BACKGROUND_COLOR = 'cookieextension/design_style/header_background_color';
    const C_HEADER_BACKGROUND_OPACITY = 'cookieextension/design_style/header_background_opacity';
    const C_HEADER_FONT_COLOR = 'cookieextension/design_style/header_font_color';
    const C_HEADER_BOTTOM_BORDER_COLOR = 'cookieextension/design_style/header_bottom_border_color';
    const C_FOOTER_TOP_BORDER_COLOR = 'cookieextension/design_style/footer_top_border_color';
    const C_ACCEPT_BUTTON_BACKGROUND_COLOR = 'cookieextension/design_style/accept_button_background_color';
    const C_CLOSE_BUTTON_BACKGROUND_COLOR = 'cookieextension/design_style/close_button_background_color';
    const C_CLOSE_BUTTON_COLOR = 'cookieextension/design_style/close_button_color';
    const C_ACCEPT_BUTTON_COLOR = 'cookieextension/design_style/accept_button_color';
    const C_MODEL_TITLE_COLOR = 'cookieextension/design_style/model_title_color';
    
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    public function enableDisable()
    {
        return $this->scopeConfig->getValue(
            self::ENABLE_DISABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getType()
    {
        return $this->scopeConfig->getValue(
            self::C_TYPE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getBarPosition()
    {
        return $this->scopeConfig->getValue(
            self::C_BAR_POSITION,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getBoxPosition()
    {
        return $this->scopeConfig->getValue(
            self::C_BOX_POSITION,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getBehaviour()
    {
        return $this->scopeConfig->getValue(
            self::C_BEHAVIOUR,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getAutohide()
    {
        return $this->scopeConfig->getValue(
            self::C_AUTO_HIDE_AFTER,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getAutoAccept()
    {
        return $this->scopeConfig->getValue(
            self::C_AUTO_ACCEPT,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getAutoExpire()
    {
        return $this->scopeConfig->getValue(
            self::C_EXPIRE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getShow()
    {
        return $this->scopeConfig->getValue(
            self::C_SHOW,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getEnableNoticeTitle()
    {
        return $this->scopeConfig->getValue(
            self::C_DISPLAY_TITLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getCustomMessage()
    {
        return $this->scopeConfig->getValue(
            self::C_CUSTOM_MESSAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function modelTitle()
    {
        return $this->scopeConfig->getValue(
            self::C_MODEL_TITLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getCustomAccept()
    {
        return $this->scopeConfig->getValue(
            self::C_CUSTOM_ACCEPT,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getEnableCustomDecline()
    {
        return $this->scopeConfig->getValue(
            self::C_DISPLAY_DECLINE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getCustomDecline()
    {
        return $this->scopeConfig->getValue(
            self::C_CUSTOM_CLOSE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function newTab()
    {
        return $this->scopeConfig->getValue(
            self::C_NEWTAB,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomMoreInfo()
    {
        return $this->scopeConfig->getValue(
            self::C_CUSTOM_MORE_INFO,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function cmsPage()
    {
        return $this->scopeConfig->getValue(
            self::C_CMS_PAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function headerTextFontFamily()
    {
        return $this->scopeConfig->getValue(
            self::C_FONT_FAMILY,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function modelTextAlign()
    {
        return $this->scopeConfig->getValue(
            self::C_MODEL_TEXT_ALIGN,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function modelTitleFontSize()
    {
        return $this->scopeConfig->getValue(
            self::C_MODEL_TITLE_SIZE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function modelMessageSize()
    {
        return $this->scopeConfig->getValue(
            self::C_MODEL_MESSAGE_SIZE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function headerBackgroundColor()
    {
        return $this->scopeConfig->getValue(
            self::C_HEADER_BACKGROUND_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function headerBackgroundOpacity()
    {
        return $this->scopeConfig->getValue(
            self::C_HEADER_BACKGROUND_OPACITY,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function headerFontColor()
    {
        return $this->scopeConfig->getValue(
            self::C_HEADER_FONT_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function headerBottomBorderColor()
    {
        return $this->scopeConfig->getValue(
            self::C_HEADER_BOTTOM_BORDER_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function containerTopBorderColor()
    {
        return $this->scopeConfig->getValue(
            self::C_FOOTER_TOP_BORDER_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function acceptButtonBackgroundColor()
    {
        return $this->scopeConfig->getValue(
            self::C_ACCEPT_BUTTON_BACKGROUND_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function closeButtonBackgroundColor()
    {
        return $this->scopeConfig->getValue(
            self::C_CLOSE_BUTTON_BACKGROUND_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function closeButtonColor()
    {
        return $this->scopeConfig->getValue(
            self::C_CLOSE_BUTTON_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function acceptButtonColor()
    {
        return $this->scopeConfig->getValue(
            self::C_ACCEPT_BUTTON_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function modelTitleColor()
    {
        return $this->scopeConfig->getValue(
            self::C_MODEL_TITLE_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }
}
