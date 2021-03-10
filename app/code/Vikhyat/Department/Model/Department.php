<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-11 23:42:05
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-12 19:10:27
 */

namespace Vikhyat\Department\Model;

class Department extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'department';
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Vikhyat\Department\Model\ResourceModel\Department');
    }
}
