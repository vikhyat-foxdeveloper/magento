<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-13 01:08:32
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2017-11-11 23:02:48
 */

namespace Vikhyat\Department\Controller\Adminhtml\Department;

class NewAction extends \Magento\Backend\App\Action
{
    protected $coreRegistry = null;
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Vikhyat_Department::department_create';

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Create new Department
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultPageFactory = $this->resultPageFactory->create();

        $FormData = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($FormData)) {
            $model = $this->_objectManager->create('Vikhyat\Department\Model\Department');
            $model->setData($FormData);
            $this->coreRegistry->register('vikhyat_department', $model);
        }

        

        return $resultPageFactory;
    }
}
