<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-12 21:47:12
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-12 22:22:47
 */

namespace Vikhyat\Department\Controller\Adminhtml\Department;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Vikhyat_Department::department_delete';
    /**
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
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
                $model = $this->_objectManager->create('Vikhyat\Department\Model\Department');
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
