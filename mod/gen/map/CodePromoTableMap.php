<?php



/**
 * This class defines the structure of the 'code_promo' table.
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
class CodePromoTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.CodePromoTableMap';

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
        $this->setName('code_promo');
        $this->setPhpName('CodePromo');
        $this->setClassname('CodePromo');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addColumn('code', 'Code', 'VARCHAR', true, 50, null);
        $this->addPrimaryKey('id_code_promo', 'IdCodePromo', 'INTEGER', true, null, null);
        $this->addColumn('date_debut', 'DateDebut', 'DATE', false, null, null);
        $this->addColumn('date_fin', 'DateFin', 'DATE', false, null, null);
        $this->addColumn('type', 'Type', 'ENUM', true, null, null);
        $this->getColumn('type', false)->setValueSet(array (
  0 => 'Non unique',
  1 => 'Unique',
));
        $this->addColumn('used', 'Used', 'ENUM', true, null, null);
        $this->getColumn('used', false)->setValueSet(array (
  0 => 'Actif',
  1 => 'Inactif',
));
        $this->addColumn('montant', 'Montant', 'DECIMAL', false, 8, 0);
        $this->addColumn('pourcent', 'Pourcent', 'INTEGER', false, null, null);
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
  'order_list' => '[["date_fin","desc"]]',
  'search_items' => '{"search":{"Code":[["title", "%val"]], "Utilisé":[["used", "%val"]]}}',
  'unit_caption' => '{"montant":"$","pourcent":"%"}',
  'sub_table_visible' => '8',
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

} // CodePromoTableMap
