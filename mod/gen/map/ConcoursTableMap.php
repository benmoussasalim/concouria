<?php



/**
 * This class defines the structure of the 'concours' table.
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
class ConcoursTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.ConcoursTableMap';

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
        $this->setName('concours');
        $this->setPhpName('Concours');
        $this->setClassname('Concours');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_concours', 'IdConcours', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 200, null);
        $this->addColumn('url', 'Url', 'VARCHAR', false, 255, null);
        $this->addColumn('price', 'Price', 'VARCHAR', true, 150, null);
        $this->addColumn('date', 'Date', 'DATE', true, null, null);
        $this->addColumn('online', 'Online', 'ENUM', true, null, null);
        $this->getColumn('online', false)->setValueSet(array (
  0 => 'Oui',
  1 => 'Non',
));
        $this->addColumn('order', 'Order', 'INTEGER', false, null, null);
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
            $this->addRelation('ConcoursFile', 'ConcoursFile', RelationMap::ONE_TO_MANY, array('id_concours' => 'id_concours', ), 'CASCADE', null, 'ConcoursFiles');
            $this->addRelation('ConcoursI18n', 'ConcoursI18n', RelationMap::ONE_TO_MANY, array('id_concours' => 'id_concours', ), 'CASCADE', null, 'ConcoursI18ns');
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
  'bulk_update' => '["online"]',
  'child_table' => '["concours_file"]',
  'del_all' => 'yes',
  'list_columns_hide_excep' => '["title","order","online","date","price"]',
  'mce_columns' => '["text"]',
  'order_list' => '[["order","ASC"]]',
  'search_items' => '{"search":{"Nom": [["title", "%val"]],"Date du tirage": [["date", "%val"]],"En ligne": [["online", "%val"]]}}',
  'table_visible' => '11',
),
            'i18n' =>  array (
  'i18n_table' => '%TABLE%_i18n',
  'i18n_phpname' => '%PHPNAME%I18n',
  'i18n_columns' => 'name,text',
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

} // ConcoursTableMap
