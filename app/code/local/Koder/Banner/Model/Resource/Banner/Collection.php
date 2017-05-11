<?php

class Koder_Banner_Model_Resource_Banner_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('banner/banner');
        $this->_map['fields']['store'] = 'store_table.store_id';
    }

    /**
     * Add filter by active
     *
     * @return Koder_Banner_Model_Resource_Banner_Collection
     */
    public function addActiveFilter()
    {
        $this->addFilter('is_active', array('eq' => Koder_Banner_Model_Banner::STATUS_ENABLED));

        return $this;
    }

    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return Koder_Banner_Model_Resource_Banner_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        if (!is_array($store)) {
            $store = array($store);
        }

        if ($withAdmin) {
            $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
        }

        $this->addFilter('store', array('in' => $store), 'public');

        return $this;
    }

    /**
     * Join store relation table if there is store filter
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('banner/banner_store')),
                'main_table.id = store_table.banner_id',
                array()
            )->group('main_table.id');

            /*
             * Allow analytic functions usage because of one field grouping
             */
            $this->_useAnalyticFunction = true;
        }
        return parent::_renderFiltersBefore();
    }
}
