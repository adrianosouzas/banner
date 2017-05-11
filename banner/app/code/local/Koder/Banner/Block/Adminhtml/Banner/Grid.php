<?php

class Koder_Banner_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_cols = array(
        'id' => array(
            'header' => 'ID',
            'type'   => 'number'
        ),
    	'nome' => array(
    		'header' => 'Nome'
    	),
    	'ordem' => array(
    		'header' => 'Ordem'
    	)
    );

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

        $this->setId('bannerBannerGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('banner/banner')->getCollection();

        if (!Mage::app()->isSingleStoreMode()) {
            $collection->getSelect()
                ->join(
                    array('banner_banner_store'=> 'banner_banner_store'),
                    'banner_banner_store.categoria_id = main_table.id',
                    array()
                );
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $column = array(
            'type' => 'string'
        );

        foreach ($this->_cols as $index => $col) {
            if (!isset($col['index'])) {
                $col['index'] = $index;
            }

            $this->addColumn($index, array_merge($column, $col));
        }

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn(
                'store_id',
                array(
                    'header' => Mage::helper('cms')->__('Store View'),
                    'index' => 'store_id',
                    'type'  => 'options',
                    'options'   => Mage::getModel('core/store')->getCollection()->toOptionHash()
                )
            );
        }

        $this->addColumn(
            'is_active',
            array(
                'header'    => Mage::helper('cms')->__('Status'),
                'index'     => 'is_active',
                'type'      => 'options',
                'options'   => array(
                    0 => Mage::helper('cms')->__('Disabled'),
                    1 => Mage::helper('cms')->__('Enabled')
                ),
            )
        );

        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
