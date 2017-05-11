<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'banner/banner'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('banner/banner'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        'unsigned'  => true
    ), 'Banner ID')
    
    ->addColumn('nome', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
    ), 'Banner Nome')
    
    ->addColumn('imagem', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Banner Imagem')

    ->addColumn('imagem_tablet', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Banner Imagem Tablet')

    ->addColumn('imagem_smartphone', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Banner Imagem Smartphone')
    
    ->addColumn('link', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
    ), 'Banner Link')
    
    ->addColumn('ordem', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => true,
        'unsigned'  => true,
    	'default'   => '0'
    ), 'Banner Ordem')
    
    ->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Banner Creation Time')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Banner Modification Time')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
    ), 'Is Banner Active')
    ->setComment('Banner Table');
$installer->getConnection()->createTable($table);

/**
 * Create table 'banner/banner_store'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('banner/banner_store'))
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Block ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($installer->getIdxName('banner/banner_store', array('store_id')),
        array('store_id'))
    ->addForeignKey($installer->getFkName('banner/banner_store', 'banner_id', 'banner/banner', 'id'),
        'banner_id', $installer->getTable('banner/banner'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('banner/banner_store', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('LinhaTempo Acontecimento To Store Linkage Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
