<?php

class Koder_Banner_Model_Resource_Banner extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('banner/banner', 'id');
    }

    /**
     * Process page data before deleting
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Koder_Banner_Model_Resource_Banner
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $condition = array(
            'banner_id = ?' => (int) $object->getId(),
        );

        $this->_getWriteAdapter()->delete($this->getTable('banner/banner_store'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     * Process page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Koder_Banner_Model_Resource_Banner
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        // modify create / update dates
        if ($object->isObjectNew() && !$object->hasCreationTime()) {
            $object->setCreationTime(Mage::getSingleton('core/date')->gmtDate());
        }

        $object->setUpdateTime(Mage::getSingleton('core/date')->gmtDate());

        return parent::_beforeSave($object);
    }

    /**
     * Assign page to store views
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Koder_Banner_Model_Resource_Banner
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('banner/banner_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = array(
                'banner_id = ?'     => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );

            $this->_getWriteAdapter()->delete($table, $where);
        }

        if ($insert) {
            $data = array();

            foreach ($insert as $storeId) {
                $data[] = array(
                    'banner_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }

            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }

    /**
     * Perform operations after object load
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Koder_Banner_Model_Resource_Banner
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());

            $object->setData('store_id', $stores);
        }

        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Koder_Banner_Model_Resource_Banner $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('banner_banner_store' => $this->getTable('banner/banner_store')),
                $this->getMainTable() . '.id = banner_banner_store.banner_id',
                array())
                ->where('is_active = ?', 1)
                ->where('banner_banner_store.store_id IN (?)', $storeIds)
                ->order('banner_banner_store.store_id DESC')
                ->limit(1);
        }

        return $select;
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('banner/banner_store'), 'store_id')
            ->where('banner_id = ?',(int)$id);

        return $adapter->fetchCol($select);
    }
}
