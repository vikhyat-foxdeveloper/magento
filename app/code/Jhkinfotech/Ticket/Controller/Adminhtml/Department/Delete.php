<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Adminhtml\Department;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Jhkinfotech_Ticket::department';
    /**
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Jhkinfotech_Ticket::department');
    }
    public function execute()
    {
        // check if we know what should be deleted
        $department_id = $this->getRequest()->getParam('department_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($department_id) {
            $department_name = '';
            try {
                // init model and delete
                $model = $this->_objectManager->create('Jhkinfotech\Ticket\Model\Department');
                $model->load($department_id);
                $department_name = $model->getDefaultName();
                $model->delete();
                $this->messageManager->addSuccess(__('The '.$department_name.' Department has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['department_id' => $department_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('Department to delete was not found.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
