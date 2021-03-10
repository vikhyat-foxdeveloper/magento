<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-11 23:48:21
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-12 17:58:16
 */

namespace Vikhyat\Department\Model\ResourceModel\Department;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection

{
    protected $_idFieldName = 'department_id';
    /**
     * Define resource model.
     */

    protected function _construct()
    {
        $this->_init('Vikhyat\Department\Model\Department', 'Vikhyat\Department\Model\ResourceModel\Department');
        
    }
    
    
}
