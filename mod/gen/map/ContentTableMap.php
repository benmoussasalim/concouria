<?php



/**
 * This class defines the structure of the 'content' table.
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
class ContentTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.ContentTableMap';

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
        $this->setName('content');
        $this->setPhpName('Content');
        $this->setClassname('Content');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_content', 'IdContent', 'INTEGER', true, null, null);
        $this->addColumn('status', 'Status', 'ENUM', false, null, null);
        $this->getColumn('status', false)->setValueSet(array (
  0 => 'Brouillon',
  1 => 'Publié',
  2 => 'Désactivé',
));
        $this->addColumn('menu_visible', 'MenuVisible', 'ENUM', false, null, null);
        $this->getColumn('menu_visible', false)->setValueSet(array (
  0 => 'Oui',
  1 => 'Non',
));
        $this->addColumn('slug', 'Slug', 'VARCHAR', true, 100, null);
        $this->addColumn('home', 'Home', 'ENUM', true, null, null);
        $this->getColumn('home', false)->setValueSet(array (
  0 => 'Non',
  1 => 'Oui',
));
        $this->addColumn('order', 'Order', 'INTEGER', true, null, 0);
        $this->addForeignKey('id_menu', 'IdMenu', 'INTEGER', 'menu', 'id_menu', false, null, null);
        $this->addColumn('name_menu', 'NameMenu', 'VARCHAR', true, 100, null);
        $this->addColumn('type', 'Type', 'ENUM', false, null, null);
        $this->getColumn('type', false)->setValueSet(array (
  0 => 'Contenu fixe',
  1 => 'Contenu dynamique',
  2 => 'Nouvelles',
));
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
        $this->addRelation('Menu', 'Menu', RelationMap::MANY_TO_ONE, array('id_menu' => 'id_menu', ), null, null);
            $this->addRelation('Block', 'Block', RelationMap::ONE_TO_MANY, array('id_content' => 'id_content', ), 'CASCADE', null, 'Blocks');
            $this->addRelation('ContentFile', 'ContentFile', RelationMap::ONE_TO_MANY, array('id_content' => 'id_content', ), 'CASCADE', null, 'ContentFiles');
            $this->addRelation('ContentI18nVersion', 'ContentI18nVersion', RelationMap::ONE_TO_MANY, array('id_content' => 'id_content', ), 'CASCADE', null, 'ContentI18nVersions');
            $this->addRelation('ContentI18n', 'ContentI18n', RelationMap::ONE_TO_MANY, array('id_content' => 'id_content', ), 'CASCADE', null, 'ContentI18ns');
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
  'child_colunms' => '{"id_menu": ["title"]}',
  'child_table' => '["content_file","block"]',
  'copy_link' => '["content_file"]',
  'file_swf_show_img_child' => '["content_file"]',
  'list_columns_hide_excep' => '["name_menu","status","type","order"]',
  'mce_columns' => '["text"]',
  'order_list' => '[["order","ASC"]]',
  'readonly_columns' => '["slug","status","id_content"]',
  'search_items' => '{"search":{"Nom": [["name_menu", "%val"]],"Status":[["status","%val"]]}}',
  'titre_colum' => '["name_menu"]',
  'sub_table_visible' => '3',
  'parent_menu' => 'SimpleWeb',
),
            'i18n' =>  array (
  'i18n_table' => '%TABLE%_i18n',
  'i18n_phpname' => '%PHPNAME%I18n',
  'i18n_columns' => 'name,text,meta_keyword,meta_description,meta_title,version',
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

} // ContentTableMap
