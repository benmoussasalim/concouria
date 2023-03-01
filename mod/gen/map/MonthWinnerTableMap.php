<?php



/**
 * This class defines the structure of the 'month_winner' table.
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
class MonthWinnerTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.MonthWinnerTableMap';

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
        $this->setName('month_winner');
        $this->setPhpName('MonthWinner');
        $this->setClassname('MonthWinner');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_month_winner', 'IdMonthWinner', 'INTEGER', true, null, null);
        $this->addForeignKey('id_winner', 'IdWinner', 'INTEGER', 'winner', 'id_winner', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 200, null);
        $this->addColumn('onlune', 'Onlune', 'ENUM', true, null, null);
        $this->getColumn('onlune', false)->setValueSet(array (
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
        $this->addRelation('Winner', 'Winner', RelationMap::MANY_TO_ONE, array('id_winner' => 'id_winner', ), null, null);
            $this->addRelation('MonthWinnerI18n', 'MonthWinnerI18n', RelationMap::ONE_TO_MANY, array('id_month_winner' => 'id_month_winner', ), 'CASCADE', null, 'MonthWinnerI18ns');
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
  'list_columns_hide_excep' => '["title","order"]',
  'mce_columns' => '["text"]',
  'order_list' => '[["order","ASC"]]',
  'search_items' => '{"search":{"Nom": [["title", "%val"]]}}',
  'parent_table' => 'winner',
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

} // MonthWinnerTableMap
