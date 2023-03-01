<?php



/**
 * This class defines the structure of the 'group_right_authy' table.
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
class GroupRightAuthyTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.GroupRightAuthyTableMap';

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
        $this->setName('group_right_authy');
        $this->setPhpName('GroupRightAuthy');
        $this->setClassname('GroupRightAuthy');
        $this->setPackage('gen');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addColumn('id_creation', 'IdCreation', 'INTEGER', true, null, null);
        $this->addColumn('id_modification', 'IdModification', 'INTEGER', false, null, null);
        $this->addColumn('date_creation', 'DateCreation', 'DATE', true, null, null);
        $this->addColumn('date_modification', 'DateModification', 'DATE', true, null, null);
        $this->addForeignPrimaryKey('id_authy', 'IdAuthy', 'INTEGER' , 'authy', 'id_authy', true, null, null);
        $this->addForeignPrimaryKey('id_group_right', 'IdGroupRight', 'INTEGER' , 'group_right', 'id_group_right', true, null, null);
        $this->addColumn('is_set', 'IsSet', 'ENUM', true, null, null);
        $this->getColumn('is_set', false)->setValueSet(array (
  0 => 'Non Membre',
  1 => 'Membre',
));
        $this->addColumn('primary', 'Primary', 'ENUM', false, null, null);
        $this->getColumn('primary', false)->setValueSet(array (
  0 => 'Non',
  1 => 'Oui',
));
        // validators
        $this->addValidator('id_group_right', 'required', 'propel.validator.RequiredValidator', '', 'group_authy_id_group_required');
        $this->addValidator('id_authy', 'required', 'propel.validator.RequiredValidator', '', 'group_authy_id_authy_list_required');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('GroupRight', 'GroupRight', RelationMap::MANY_TO_ONE, array('id_group_right' => 'id_group_right', ), 'CASCADE', null);
        $this->addRelation('Authy', 'Authy', RelationMap::MANY_TO_ONE, array('id_authy' => 'id_authy', ), 'CASCADE', null);
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
            'TableStampBehavior' =>  array (
  'create_column' => 'date_creation',
  'update_column' => 'date_modification',
  'create_id_column' => 'id_creation',
  'group_id_column' => 'id_group_creation',
  'update_id_column' => 'id_modification',
  'exclude' => 'all',
  'foreign_keys' => 'none',
  'passwd_column' => 'passwd_date',
),
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
  'checkbox_all_child' => 'yes',
  'child_colunms' => '{"id_group_right": ["name"]}',
  'form_columns_hide' => '["id_group_right"]',
  'is_cross_reff_create' => 'yes',
  'is_cross_reff_def_keys' => '["id_authy","id_group_right"]',
  'parent_table' => 'authy',
),
        );
    } // getBehaviors()

} // GroupRightAuthyTableMap
