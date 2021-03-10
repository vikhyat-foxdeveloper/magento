<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-11 23:45:27
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-13 17:43:20
 */

namespace Vikhyat\Department\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Department extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('vikhyat_department', 'department_id');
    }

    /**
     * Perform operations before object save
     *
     * @param AbstractModel $object
     * @return $this
     * @throws LocalizedException
     */
    protected function _beforeSave(AbstractModel $object)
    {
        if (!$this->checkDepartmentAlreadyExist($object)) {
            throw new LocalizedException(
                __('The department already exists.')
            );
        }
    }

    protected function checkSubDepartmentAlreadyExist(AbstractModel $object, $field)
    {
        $select = $this->getConnection()->select()
            ->from(['dcr' => $this->getMainTable()])
            ->where('dcr.'.$field.' = ?', $object->getData($field));
        if ($object->getData('department_id')) {
            $select->where('dcr.department_id <> ?', $object->getData('department_id'));
        }
        if ($this->getConnection()->fetchRow($select)) {
            return false;
        }
        return true;
    }

    protected function checkDepartmentAlreadyExist(AbstractModel $object)
    {
        if (!$this->checkSubDepartmentAlreadyExist($object, 'name') || !$this->checkSubDepartmentAlreadyExist($object, 'name')) {
            return false;
        }
        return true;
    }
}
