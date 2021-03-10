<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-13 00:44:50
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-13 00:50:31
 */

namespace Vikhyat\Department\Block\Adminhtml\Department;

use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Department edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'vikhyat_department_id';
        $this->_blockGroup = 'Vikhyat_Department';
        $this->_controller = 'adminhtml_department';
        parent::_construct();

        if ($this->_isAllowedAction('Vikhyat_Department::department_edit')) {
            $this->buttonList->update('save', 'label', __('Save Department'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => [
                                'event' => 'saveAndContinueEdit',
                                'target' => '#edit_form'
                            ],
                        ],
                    ]
                ],
                -100
            );

            $department = $this->_coreRegistry->registry('vikhyat_department');
            if(!empty($department)) {
                if ($department->getDepartmentId()) {
                    $this->buttonList->add(
                        'delete',
                        [
                            'label'   => __('Delete'),
                            'class'   => 'delete',
                            'onclick' => 'deleteConfirm("Are you sure you want to delete this Department?", "'.$this->getDeleteUrl().'")'
                        ],
                        -100
                    );
                }
            }
        } else {
            $this->buttonList->remove('save');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Retrieve delete Url.
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl(
            '*/*/delete',
            [
                '_current' => true,
                'id' => $this->getRequest()->getParam('department_id')
            ]
        );
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            [
                '_current' => true,
                'back' => 'edit',
                'active_tab' => ''
            ]
        );
    }
}
