<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Model\Config\Source;

class Department implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        $options = [];
        $propertyMap = [
            'value' => 'name',
            'department_id' => 'department_id',
            
        ];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('Jhkinfotech\Ticket\Model\Department');
        $datacollection = $model->getCollection();

        foreach ($datacollection as $item1) {
            $option = [];
            foreach ($propertyMap as $code => $field) {
                $option[$code] = $item1->getData($field);
            }
            $option['label'] = $item1->getname();
            $options[] = $option;
        }
        if (count($options) > 0) {
            array_unshift(
                $options,
                ['department_id' => '', 'value' => '', 'label' => __('Please Select a Department.')]
            );
        }
        return $options;
    }
}
