<?php



/**
 * This class defines the structure of the 'taxe' table.
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
class TaxeTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.TaxeTableMap';

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
        $this->setName('taxe');
        $this->setPhpName('Taxe');
        $this->setClassname('Taxe');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_taxe', 'IdTaxe', 'INTEGER', true, null, null);
        $this->addForeignKey('id_group_taxe_sup', 'IdGroupTaxeSup', 'INTEGER', 'grp_taxe', 'id_group_taxe_sup', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 50, null);
        $this->addColumn('code', 'Code', 'VARCHAR', true, 15, null);
        $this->addColumn('pourcent', 'Pourcent', 'DECIMAL', true, 8, null);
        $this->addColumn('taxable', 'Taxable', 'ENUM', true, null, null);
        $this->getColumn('taxable', false)->setValueSet(array (
  0 => 'NonTaxable',
  1 => 'Taxable',
));
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addColumn('id_creation', 'IdCreation', 'INTEGER', false, null, null);
        $this->addColumn('id_modification', 'IdModification', 'INTEGER', false, null, null);
        // validators
        $this->addValidator('pourcent', 'required', 'propel.validator.RequiredValidator', '', 'taxe_pourcent_obligatoire');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('GrpTaxe', 'GrpTaxe', RelationMap::MANY_TO_ONE, array('id_group_taxe_sup' => 'id_group_taxe_sup', ), 'CASCADE', null);
            $this->addRelation('SaleTaxe', 'SaleTaxe', RelationMap::ONE_TO_MANY, array('id_taxe' => 'id_taxe', ), 'SET NULL', null, 'SaleTaxes');
            $this->addRelation('TaxeI18n', 'TaxeI18n', RelationMap::ONE_TO_MANY, array('id_taxe' => 'id_taxe', ), 'CASCADE', null, 'TaxeI18ns');
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
  'order_list' => '[["name","ASC"]]',
  'unit_caption' => '{"pourcent":"%"}',
  'parent_table' => 'grp_taxe',
),
            'i18n' =>  array (
  'i18n_table' => '%TABLE%_i18n',
  'i18n_phpname' => '%PHPNAME%I18n',
  'i18n_columns' => 'title',
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

} // TaxeTableMap
