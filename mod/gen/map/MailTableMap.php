<?php



/**
 * This class defines the structure of the 'mail' table.
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
class MailTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.MailTableMap';

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
        $this->setName('mail');
        $this->setPhpName('Mail');
        $this->setClassname('Mail');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_mail', 'IdMail', 'INTEGER', true, null, null);
        $this->addForeignKey('id_creation', 'IdCreation', 'INTEGER', 'authy', 'id_authy', true, null, null);
        $this->addForeignKey('id_modification', 'IdModification', 'INTEGER', 'authy', 'id_authy', false, null, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', true, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', true, null, null);
        $this->addColumn('calc_id', 'CalcId', 'VARCHAR', true, 10, null);
        $this->addColumn('status', 'Status', 'ENUM', false, null, null);
        $this->getColumn('status', false)->setValueSet(array (
  0 => 'Publie',
  1 => 'Archive',
));
        $this->addColumn('name', 'Name', 'VARCHAR', true, 100, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AuthyRelatedByIdModification', 'Authy', RelationMap::MANY_TO_ONE, array('id_modification' => 'id_authy', ), null, null);
        $this->addRelation('AuthyRelatedByIdCreation', 'Authy', RelationMap::MANY_TO_ONE, array('id_creation' => 'id_authy', ), null, null);
            $this->addRelation('MailI18n', 'MailI18n', RelationMap::ONE_TO_MANY, array('id_mail' => 'id_mail', ), 'CASCADE', null, 'MailI18ns');
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
  'calculated_prefix' => '["calc_id","WP10.id_mail"]',
  'list_columns_hide' => '["text"]',
  'mce_columns' => '["text"]',
  'readonly_columns' => '["id_mail"]',
  'search_items' => '{"search":{"Name": [["name", "%val"]],"Title":[["title", "%val"]],"Text":[["text", "%val"]]}} ',
  'table_gender' => 'f',
  'sub_table_visible' => '3',
  'parent_menu' => 'Config',
),
            'i18n' =>  array (
  'i18n_table' => '%TABLE%_i18n',
  'i18n_phpname' => '%PHPNAME%I18n',
  'i18n_columns' => 'title,text',
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

} // MailTableMap
