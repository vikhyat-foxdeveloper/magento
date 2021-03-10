<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-13 00:05:54
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-13 00:12:38
 */

namespace Vikhyat\Department\Block\Adminhtml;

/**
 * Adminhtml cms blocks content block
 */
class Department extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Vikhyat_Department';
        $this->_controller = 'adminhtml_department';
        $this->_headerText = __('Departments Manager');
        $this->_addButtonLabel = __('Add New Department');
        parent::_construct();
    }
}
