<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block\Adminhtml\Post\Edit;

/**
 * Adminhtml ticket post edit form
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    protected $_wysiwygConfig;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('post_form');
        $this->setTitle(__('Ticket Member Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        // /** @var \Jhkinfotech\Ticket\Model\Post $model */
        $model = $this->_coreRegistry->registry('ticket_post');

        // /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post','enctype' => 'multipart/form-data']]
        );

        $form->setHtmlIdPrefix('post_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Ticket Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getPostId()) {
            $fieldset->addField('post_id', 'hidden', ['name' => 'post_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Subject'), 'title' => __('Title'), 'required' => true]
        );

        $fieldset->addField(
            'customername',
            'text',
            [
                'name' => 'customername',
                'label' => __('Customer Name'),
                'title' => __('customername'),
                'required' => true,
                'class' => 'customername'
            ]
        );

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $FormKey = $objectManager->get('Magento\Framework\Data\Form\FormKey');
        $myKey = $FormKey->getFormKey();
        $urlasfd = $this->getUrl('ticket/customer/customerid');

        $fieldset->addField(
            'customeremail',
            'text',
            [
                'name'      => 'customeremail',
                'label'     => __('Customer Email'),
                'title'     => __('Customer Email'),
                'required'  => true,
                'class'     => 'validate-email'
            ]
        );

        $fieldset->addField(
            'ccrecipients',
            'text',
            [
                'name' => 'ccrecipients',
                'label' => __('CC Recipients'),
                'title' => __('CC Recipients'),
                'required' => false,
                'class' => 'validate-email'
            ]
        );

        $fieldset->addField(
            'store_id',
            'multiselect',
            [
              'name'     => 'store_id',
              'label'    => __('Store Views'),
              'title'    => __('Store Views'),
              'required' => true,
              'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
            ]
        );

        $satus_list = $this->_coreRegistry->registry('jhkinfotech_ticket_status_list');
        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'title' => __('Status'),
                'required' => true,
                'class' => 'status',
                'values' => $satus_list
            ]
        );
        
        $priority_list = $this->_coreRegistry->registry('jhkinfotech_ticket_priority_list');
        $fieldset->addField(
            'priority',
            'select',
            [
                'name' => 'priority',
                'label' => __('Priority'),
                'title' => __('Priority'),
                'required' => true,
                'class' => 'priority',
                'values' => $priority_list
            ]
        );

        $department_list = $this->_coreRegistry->registry('jhkinfotech_ticket_department_list');
        $fieldset->addField(
            'department',
            'select',
            [
                'name' => 'department',
                'label' => __('Department'),
                'title' => __('Department'),
                'required' => true,
                'class' => 'department',
                'values' => $department_list
            ]
        );

         $fieldset->addField(
             'productsku',
             'text',
             [
                'name' => 'productsku',
                'label' => __('Product sku/Order'),
                'title' => __('Product sku'),
                'required' => false,
                'class' => 'productsku'
             ]
         );
        
        $confgiData = $this->_wysiwygConfig->getConfig();
        $confgiData->setplugins([]);
        $confgiData->setadd_variables(0);
        $confgiData->setadd_widgets(0);
        $confgiData->setadd_images(0);
        $confgiData->setinsert_link(0);
        $fieldset->addField(
            'message',
            'editor',
            [
                'name' => 'message',
                'label' => __('Message'),
                'title'     => __('Message'),
                'required' => true,
                'config'    => $confgiData,
                'wysiwyg' => true,
                'rows' => '2',
                'cols' => '5',
                'class' => 'message'
            ]
        );
        $fieldset->addField(
            'image',
            'Jhkinfotech\Ticket\Block\Adminhtml\Helper\Image\Required',
            [
            'name' => 'image',
            'label' => __('Attachment'),
            'title' => __('Attachment'),
            'note' => 'Note - Allow attachment file extension: .jpg, .jpeg, .png, .pdf, .csv, .doc & Filename is too long; must be 90 characters or less',
            'class' => 'image'
            ]
        );
        // )->setAfterElementHtml('
        //     <div for="title" generated="true" class="blank-error" id="lblError" style="color:red;"></div>
        //     <script>
        //         require([
        //              "jquery",
        //         ], function($){
        //             $("body").on("click", "#save", function (e)  {
        //                 if($("#post_image").val()){
        //                     var allowedFiles = [".jpg", ".jpeg", ".png", ".pdf", ".csv", ".doc"];
        //                     var fileUpload = $("#post_image");
        //                     var lblError = $("#lblError");
        //                     var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join("|") + ")$");
        //                     if (!regex.test(fileUpload.val().toLowerCase())) {
        //                         lblError.html("Please upload files having extensions: <b>" + allowedFiles.join(", ") + "</b> only.");
        //                         $("#post_image").attr("required", "true");
        //                         return false;
        //                     }
        //                     lblError.html("");
        //                     return true;
        //                 }
        //             });
        //           });
        //    </script>
        // ');
        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
