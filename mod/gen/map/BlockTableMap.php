<?php



/**
 * This class defines the structure of the 'block' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.gen.map
 */
class BlockTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.BlockTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('block');
        $this->setPhpName('Block');
        $this->setClassname('Block');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_block', 'IdBlock', 'INTEGER', true, null, null);
        $this->addForeignKey('id_content', 'IdContent', 'INTEGER', 'content', 'id_content', false, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 200, null);
        $this->addColumn('status', 'Status', 'ENUM', false, null, null);
        $this->getColumn('status', false)->setValueSet(array (
  0 => 'Brouillon',
  1 => 'Publié',
  2 => 'Désactivé',
));
        $this->addColumn('type', 'Type', 'ENUM', false, null, null);
        $this->getColumn('type', false)->setValueSet(array (
  0 => 'Contenu fixe',
  1 => 'Contenu dynamique',
  2 => 'Slideshow',
  3 => 'Menu',
  4 => 'Conteneur',
));
        $this->addForeignKey('id_parent', 'IdParent', 'INTEGER', 'block', 'id_block', false, null, null);
        $this->addColumn('position', 'Position', 'ENUM', false, null, null);
        $this->getColumn('position', false)->setValueSet(array (
  0 => 'En haut',
  1 => 'En bas',
));
        $this->addColumn('order', 'Order', 'INTEGER', true, null, 0);
        $this->addColumn('display', 'Display', 'ENUM', false, null, null);
        $this->getColumn('display', false)->setValueSet(array (
  0 => 'Toutes les pages',
  1 => 'Accueil seulement',
  2 => 'Manuel',
));
        $this->addColumn('slug', 'Slug', 'VARCHAR', true, 100, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addColumn('id_creation', 'IdCreation', 'INTEGER', false, null, null);
        $this->addColumn('id_modification', 'IdModification', 'INTEGER', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('BlockRelatedByIdParent', 'Block', RelationMap::MANY_TO_ONE, array('id_parent' => 'id_block', ), 'CASCADE', null);
        $this->addRelation('Content', 'Content', RelationMap::MANY_TO_ONE, array('id_content' => 'id_content', ), 'CASCADE', null);
            $this->addRelation('BlockRelatedByIdBlock', 'Block', RelationMap::ONE_TO_MANY, array('id_block' => 'id_parent', ), 'CASCADE', null, 'BlocksRelatedByIdBlock');
            $this->addRelation('BlockFile', 'BlockFile', RelationMap::ONE_TO_MANY, array('id_block' => 'id_block', ), 'CASCADE', null, 'BlockFiles');
            $this->addRelation('BlockI18nVersion', 'BlockI18nVersion', RelationMap::ONE_TO_MANY, array('id_block' => 'id_block', ), 'CASCADE', null, 'BlockI18nVersions');
            $this->addRelation('BlockI18n', 'BlockI18n', RelationMap::ONE_TO_MANY, array('id_block' => 'id_block', ), 'CASCADE', null, 'BlockI18ns');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'progxform' =>  array (
  'override_Act' => 'true',
  'public_interface' => 'yes',
  'propel_runtime' => '1.7.1',
  'i18n_langs' => '["fr_CA","en_US"]',
  'i18n_traductions' => '{"fr_CA": "Français","en_US": "Anglais"}',
  'public_interface_root' => './mod/page/',
  'mce_version' => '4.1',
  'default_public' => 'admin',
  'rights_letter' => '"m","r","w","a","d","b"',
  'label_link_type' => 'new',
  'label_link_all' => 'yes',
  'no_include_tiny' => 'yes',
  'simple_web' => 'yes',
  'debug_build' => '1',
  'menu_change' => '{"disconnect":["disconnect","Déconnecter", "add", "2000","disconnect"]}',
  'child_colunms' => '{"id_parent": ["title"],"id_content": ["name_menu"]}',
  'child_table' => '["block_file"]',
  'copy_link' => '["block_file"]',
  'file_swf_show_img_child' => '["block_file"]',
  'list_columns_hide_excep' => '["title","status","type","id_parent","order","display"]',
  'mce_columns' => '["text"]',
  'order_list' => '[["order","ASC"]]',
  'readonly_columns' => '["slug","status","id_block"]',
  'search_items' => '{"search":{"Nom": [["title", "%val"]]}}',
  'tabs_column' => '{"Avancé":["slug"]}',
  'titre_colum' => '["title"]',
  'sub_table_visible' => '2',
  'parent_table' => 'content',
  'parent_menu' => 'SimpleWeb',
),
            'i18n' =>  array (
  'i18n_table' => '%TABLE%_i18n',
  'i18n_phpname' => '%PHPNAME%I18n',
  'i18n_columns' => 'text,version',
  'i18n_pk_name' => NULL,
  'locale_column' => 'locale',
  'default_locale' => NULL,
  'locale_alias' => '',
  'skipSqlRunRun' => NULL,
),
            'TableStampBehavior' =>  array (
  'create_column' => 'date_creation',
  'update_column' => 'date_modification',
  'create_id_column' => 'id_creation',
  'group_id_column' => 'id_group_creation',
  'update_id_column' => 'id_modification',
  'exclude' => 'none',
  'foreign_keys' => 'none',
  'passwd_column' => 'passwd_date',
),
        );
    } // getBehaviors()

} // BlockTableMap
