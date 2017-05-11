<?php

class Koder_Banner_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getPageBanner($key, $secao, $categoria = false)
    {
        $cache = Mage::app()->getCacheInstance();

        $collection = Mage::getResourceSingleton('banner/banner_collection')
            ->initCache(
                $cache,
                $key,
                array(Mage_Catalog_Model_Product::CACHE_TAG)
            )
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->addActiveFilter();

        if ($categoria) {
            $collection->getSelect()
                ->where('categoria_id = '. $categoria);
        }

        $collection->getSelect()
            ->where('secao = '. $secao)
            ->order('ordem');

        return $collection->getFirstItem();
    }

    public function getImageUrl($image, $width, $height)
    {
        if (is_array($image)) {
            $image = $image['file'];
        }

        if (isset($image) && empty($image) === false) {
            $file = Mage::getBaseDir('media') . '/' . Mage::getSingleton('banner/config')->getAdditionalUrl() . $image;

            if (file_exists($file)) {
                $file = Mage::getSingleton('banner/config')->getAdditionalUrl() . $image;
            } else {
                $file = 'placeholder.jpg';
            }
        } else {
            $file = 'placeholder.jpg';
        }

        return Mage::helper('imagem')->crop($file, $width, $height);
    }
}
