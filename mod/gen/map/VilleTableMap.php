<?php



/**
 * This class defines the structure of the 'ville' table.
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
class VilleTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.VilleTableMap';

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
        $this->setName('ville');
        $this->setPhpName('Ville');
        $this->setClassname('Ville');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_ville', 'IdVille', 'INTEGER', true, null, null);
        $this->addForeignKey('id_region', 'IdRegion', 'INTEGER', 'region', 'id_region', false, null, null);
        $this->addForeignKey('id_province', 'IdProvince', 'INTEGER', 'province', 'id_province', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 255, null);
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
        $this->addRelation('Region', 'Region', RelationMap::MANY_TO_ONE, array('id_region' => 'id_region', ), 'CASCADE', null);
        $this->addRelation('Province', 'Province', RelationMap::MANY_TO_ONE, array('id_province' => 'id_province', ), 'CASCADE', null);
            $this->addRelation('Account', 'Account', RelationMap::ONE_TO_MANY, array('id_ville' => 'id_ville', ), null, null, 'Accounts');
            $this->addRelation('VilleI18n', 'VilleI18n', RelationMap::ONE_TO_MANY, array('id_ville' => 'id_ville', ), 'CASCADE', null, 'VilleI18ns');
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
  'i18n_traductions' => '{"fr_CA": "Fran??ais","en_US": "Anglais"}',
  'public_interface_root' => './mod/page/',
  'mce_version' => '4.1',
  'default_public' => 'admin',
  'rights_letter' => '"m","r","w","a","d","b"',
  'label_link_type' => 'new',
  'label_link_all' => 'yes',
  'no_include_tiny' => 'yes',
  'simple_web' => 'yes',
  'debug_build' => '1',
  'menu_change' => '{"disconnect":["disconnect","D??connecter", "add", "2000","disconnect"]}',
  'child_colunms' => '{"id_region": ["title"],"id_province": ["title"]}',
  'list_columns_hide_excep' => '["title","id_province"]',
  'search_items' => '{"search":{"Ville":[["title", "%val"]],"Province":[["id_province", "%val"]]}}',
  'sub_table_visible' => '90',
  'parent_menu' => 'Abonn??es',
),
            'i18n' =>  array (
  'i18n_table' => '%TABLE%_i18n',
  'i18n_phpname' => '%PHPNAME%I18n',
  'i18n_columns' => 'name',
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

} // VilleTableMap
