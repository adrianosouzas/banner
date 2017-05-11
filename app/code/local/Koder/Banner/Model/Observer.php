<?php

class Koder_Banner_Model_Observer
{
    public function onBannerBannerPrepareSave(Varien_Event_Observer $observer)
    {
        $model = $observer->getData('entity');

        if (isset($_FILES['imagem']) && isset($_FILES['imagem']['size']) && $_FILES['imagem']['size'] > 0) {
            $uploader = new Mage_Core_Model_File_Uploader('imagem');
            $uploader->setAllowedExtensions(array('jpg','gif','png'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);

            $result = $uploader->save(Mage::getSingleton('banner/config')->getBaseMediaPath());

            $model->setImagem($result['file']);
        } else {
            $model->unsetData('imagem');
        }

        if (isset($_FILES['imagem_tablet']) && isset($_FILES['imagem_tablet']['size']) && $_FILES['imagem_tablet']['size'] > 0) {
            $uploader = new Mage_Core_Model_File_Uploader('imagem_tablet');
            $uploader->setAllowedExtensions(array('jpg','gif','png'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);

            $result = $uploader->save(Mage::getSingleton('banner/config')->getBaseMediaPath());

            $model->setImagemTablet($result['file']);
        } else {
            $model->unsetData('imagem_tablet');
        }

        if (isset($_FILES['imagem_smartphone']) && isset($_FILES['imagem_smartphone']['size']) && $_FILES['imagem_smartphone']['size'] > 0) {
            $uploader = new Mage_Core_Model_File_Uploader('imagem_smartphone');
            $uploader->setAllowedExtensions(array('jpg','gif','png'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);

            $result = $uploader->save(Mage::getSingleton('banner/config')->getBaseMediaPath());

            $model->setImagemSmartphone($result['file']);
        } else {
            $model->unsetData('imagem_smartphone');
        }
    }
}
