<?php

class Koder_Banner_Model_Config extends Mage_Catalog_Model_Product_Media_Config {
    public function getAdditionalPath()
    {
        return 'banner' . DS . 'banner';
    }

    public function getAdditionalUrl()
    {
        return 'banner/banner';
    }

    public function getBaseMediaPath()
    {
        return Mage::getBaseDir('media') .DS. $this->getAdditionalPath();
    }

    public function getBaseMediaUrl()
    {
        return Mage::getBaseUrl('media') . $this->getAdditionalUrl();
    }

    public function getBaseTmpMediaPath()
    {
        return Mage::getBaseDir('media') .DS. 'tmp' .DS. $this->getAdditionalPath();
    }

    public function getBaseTmpMediaUrl()
    {
        return Mage::getBaseUrl('media') . 'tmp/' . $this->getAdditionalUrl();
    }
}
