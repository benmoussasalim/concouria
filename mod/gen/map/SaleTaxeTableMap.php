<?php



/**
 * This class defines the structure of the 'sale_taxe' table.
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
class SaleTaxeTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.SaleTaxeTableMap';

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
        $this->setName('sale_taxe');
        $this->setPhpName('SaleTaxe');
        $this->setClassname('SaleTaxe');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_sale_taxe', 'IdSaleTaxe', 'INTEGER', true, null, null);
        $this->addForeignKey('id_abonnement', 'IdAbonnement', 'INTEGER', 'abonnement', 'id_abonnement', true, null, null);
        $this->addForeignKey('id_taxe', 'IdTaxe', 'INTEGER', 'taxe', 'id_taxe', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 100, null);
        $this->addColumn('pourcent', 'Pourcent', 'DECIMAL', false, 8, null);
        $this->addColumn('montant', 'Montant', 'DECIMAL', false, 8, null);
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
        $this->addRelation('Abonnement', 'Abonnement', RelationMap::MANY_TO_ONE, array('id_abonnement' => 'id_abonnement', ), 'CASCADE', null);
        $this->addRelation('Taxe', 'Taxe', RelationMap::MANY_TO_ONE, array('id_taxe' => 'id_taxe', ), 'SET NULL', null);
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
  'order_list' => '[["name","asc"]]',
  'parent_table' => 'abonnement',
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

} // SaleTaxeTableMap
