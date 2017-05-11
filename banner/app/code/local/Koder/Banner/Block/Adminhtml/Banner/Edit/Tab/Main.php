<?php

class Koder_Banner_Block_Adminhtml_Banner_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        /* @var $model Koder_Banner_Model_Banner */
        $model = Mage::registry('banner');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('banner_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('banner')->__('Informações')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('nome', 'text', array(
            'name'      => 'nome',
            'label'     => Mage::helper('banner')->__('Nome'),
            'title'     => Mage::helper('banner')->__('Nome'),
            'required'  => false,
            'disabled'  => $isElementDisabled
        ));

        $fieldset->addField('imagem', 'image', array(
            'name'      => 'imagem',
            'label'     => Mage::helper('banner')->__('Imagem'),
            'title'     => Mage::helper('banner')->__('Imagem'),
            'required'  => true,
            'disabled'  => $isElementDisabled,
            'after_element_html' => '<small>Imagem: 1920px X 692px</small>'
        ));

        $fieldset->addField('imagem_tablet', 'image', array(
            'name'      => 'imagem_tablet',
            'label'     => Mage::helper('banner')->__('Imagem Tablet'),
            'title'     => Mage::helper('banner')->__('Imagem Tablet'),
            'required'  => true,
            'disabled'  => $isElementDisabled,
            'after_element_html' => '<small>Imagem: 991px X 692px</small>'
        ));

        $fieldset->addField('imagem_smartphone', 'image', array(
            'name'      => 'imagem_smartphone',
            'label'     => Mage::helper('banner')->__('Imagem Smartphone'),
            'title'     => Mage::helper('banner')->__('Imagem Smartphone'),
            'required'  => true,
            'disabled'  => $isElementDisabled,
            'after_element_html' => '<small>Imagem: 768px X 692px</small>'
        ));

        $fieldset->addField('ordem', 'text', array(
            'name'      => 'ordem',
            'label'     => Mage::helper('banner')->__('Ordem'),
            'title'     => Mage::helper('banner')->__('Ordem'),
            'required'  => false,
            'disabled'  => $isElementDisabled
        ));

        $fieldset->addField('link', 'text', array(
            'name'      => 'link',
            'label'     => Mage::helper('banner')->__('Link'),
            'title'     => Mage::helper('banner')->__('Link'),
            'required'  => false,
            'disabled'  => $isElementDisabled
        ));

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField('store_id', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('banner')->__('Store View'),
                'title'     => Mage::helper('banner')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                'disabled'  => $isElementDisabled,
            ));
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        }
        else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField('is_active', 'select', array(
            'name'      => 'is_active',
            'label'     => Mage::helper('banner')->__('Status'),
            'title'     => Mage::helper('banner')->__('Status'),
            'required'  => true,
            'options'   => $model->getAvailableStatuses(),
            'disabled'  => $isElementDisabled,
        ));
        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $fieldset->addField('secao', 'select', array(
            'name'      => 'secao',
            'label'     => Mage::helper('banner')->__('Seção'),
            'title'     => Mage::helper('banner')->__('Seção'),
            'required'  => true,
            'options'   => $model->getSecoes(),
            'disabled'  => $isElementDisabled,
        ));

        $fieldset->addField('categoria_id', 'select', array(
            'name'      => 'categoria_id',
            'label'     => Mage::helper('banner')->__('Categoria'),
            'title'     => Mage::helper('banner')->__('Categoria'),
            'required'  => false,
            'options'   => Mage::getModel('catalogo/category')->getCategoriesTreeView(),
            'disabled'  => $isElementDisabled
        ));

        $form->setValues($model->getData());

//      Corrige a url da imagem
        if ($model->getId()){
            $imagem = $form->getElement('imagem')->getValue();
            if($imagem) {
                $form->getElement('imagem')->setValue('banner/banner' . $imagem);
            }

            $imagem_tablet = $form->getElement('imagem_tablet')->getValue();
            if($imagem_tablet) {
                $form->getElement('imagem_tablet')->setValue('banner/banner' . $imagem_tablet);
            }

            $imagem_smartphone = $form->getElement('imagem_smartphone')->getValue();
            if($imagem_smartphone) {
                $form->getElement('imagem_smartphone')->setValue('banner/banner' . $imagem_smartphone);
            }
        }

        Mage::dispatchEvent('banner_adminhtml_banner_edit_tab_main_prepare_form', array('form' => $form));

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('cms')->__('Informações');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('cms')->__('Informações');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/banner');
    }
}
