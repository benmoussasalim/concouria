<?php



/**
 * This class defines the structure of the 'grp_taxe' table.
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
class GrpTaxeTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.GrpTaxeTableMap';

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
        $this->setName('grp_taxe');
        $this->setPhpName('GrpTaxe');
        $this->setClassname('GrpTaxe');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_group_taxe_sup', 'IdGroupTaxeSup', 'INTEGER', true, null, null);
        $this->addColumn('calc_id', 'CalcId', 'VARCHAR', false, 20, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 50, null);
        $this->addColumn('defaut', 'Defaut', 'ENUM', true, null, null);
        $this->getColumn('defaut', false)->setValueSet(array (
  0 => 'Non',
  1 => 'Oui',
));
        $this->addColumn('equivalence', 'Equivalence', 'DECIMAL', true, 8, null);
        $this->addColumn('ratio', 'Ratio', 'DECIMAL', true, 10, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addColumn('id_creation', 'IdCreation', 'INTEGER', false, null, null);
        $this->addColumn('id_modification', 'IdModification', 'INTEGER', false, null, null);
        // validators
        $this->addValidator('name', 'required', 'propel.validator.RequiredValidator', '', 'grp_taxe_name_obligatoire');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
            $this->addRelation('Taxe', 'Taxe', RelationMap::ONE_TO_MANY, array('id_group_taxe_sup' => 'id_group_taxe_sup', ), 'CASCADE', null, 'Taxes');
            $this->addRelation('Province', 'Province', RelationMap::ONE_TO_MANY, array('id_group_taxe_sup' => 'id_grp_taxe', ), null, null, 'Provinces');
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
  'calculated_prefix' => '["calc_id","020.id_group_taxe_sup","1"]',
  'child_table' => '["taxe"]',
  'order_list' => '[["name","ASC"]]',
  'search_items' => '{"search":{"Nom":[["name", "%val"]]}}',
  'sub_table_visible' => '20',
  'parent_menu' => 'Vente',
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

} // GrpTaxeTableMap
