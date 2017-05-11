<?php

class Koder_Banner_Block_Home extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('home/banner.phtml');
    }

    /**
     * Prepare block text and determine whether block output enabled or not
     * Prevent blocks recursion if needed
     *
     * @return Koder_Banner_Block_Home
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();

        $key = 'banner-home';
        $cache = Mage::app()->getCacheInstance();

        $collection = Mage::getResourceSingleton('banner/banner_collection')
            ->initCache(
                $cache,
                $key,
                array(Mage_Catalog_Model_Product::CACHE_TAG)
            )
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->addActiveFilter();

        $collection->getSelect()
            ->where('secao = 0')
            ->order('ordem');

        $this->setCollection($collection);
        
        return $this;
    }
}
