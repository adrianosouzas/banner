<?php

class Koder_Banner_Model_Banner extends Mage_Core_Model_Abstract
{
    const CACHE_TAG              = 'banner_banner';
    protected $_cacheTag         = 'banner_banner';
    protected $_eventPrefix      = 'banner_banner';
    protected $_eventObject      = 'banner';
    protected $_canAffectOptions = false;

    /**
     * Banner's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected function _construct()
    {
        $this->_init('banner/banner');
    }

    /**
     * Prepare banner's statuses.
     * Available event banner_banner_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        $statuses = new Varien_Object(array(
            self::STATUS_ENABLED => Mage::helper('cms')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('cms')->__('Disabled'),
        ));

        Mage::dispatchEvent('banner_banner_get_available_statuses', array('statuses' => $statuses));

        return $statuses->getData();
    }

    /**
     * Prepare banner's sections.
     * Available event banner_banner_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getSecoes()
    {
        $secoes = new Varien_Object(array(
            0 => Mage::helper('cms')->__('Home'),
            1 => Mage::helper('cms')->__('Quem Somos'),
            2 => Mage::helper('cms')->__('Contato'),
            3 => Mage::helper('cms')->__('Onde Comprar'),
            4 => Mage::helper('cms')->__('Categoria')
        ));

        Mage::dispatchEvent('banner_banner_get_available_secoes', array('secoes' => $secoes));

        return $secoes->getData();
    }
}
