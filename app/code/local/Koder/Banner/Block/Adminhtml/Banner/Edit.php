<?php

class Koder_Banner_Block_Adminhtml_Banner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'banner';
        $this->_controller = 'adminhtml_banner';

        $this->_updateButton('save', 'label', Mage::helper('banner')->__('Salvar'));
        $this->_updateButton('delete', 'label', Mage::helper('banner')->__('Excluir'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Salvar e Continuar Editando'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('banner_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'banner_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'banner_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderCssClass()
    {
        return 'icon-head head-order-date';
    }

    public function getHeaderText()
    {
        $banner = Mage::registry('banner');

        if ($banner->getId()) {
            return Mage::helper('banner')->__('Editar Banner');
        } else {
            return Mage::helper('banner')->__('Adicionar Banner');
        }
    }
}
