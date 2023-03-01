<?php



/**
 * This class defines the structure of the 'group_right' table.
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
class GroupRightTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.GroupRightTableMap';

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
        $this->setName('group_right');
        $this->setPhpName('GroupRight');
        $this->setClassname('GroupRight');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_group_right', 'IdGroupRight', 'INTEGER', true, null, null);
        $this->addColumn('id_creation', 'IdCreation', 'INTEGER', true, null, null);
        $this->addColumn('id_modification', 'IdModification', 'INTEGER', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 50, null);
        $this->addColumn('desc', 'Desc', 'VARCHAR', true, 32, null);
        $this->addColumn('rights_admin', 'RightsAdmin', 'VARCHAR', true, 1023, null);
        $this->addColumn('rights_owner', 'RightsOwner', 'VARCHAR', true, 1023, null);
        $this->addColumn('rights_group', 'RightsGroup', 'VARCHAR', true, 1023, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        // validators
        $this->addValidator('name', 'required', 'propel.validator.RequiredValidator', '', 'group_name_required');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
            $this->addRelation('GroupRightAuthy', 'GroupRightAuthy', RelationMap::ONE_TO_MANY, array('id_group_right' => 'id_group_right', ), 'CASCADE', null, 'GroupRightAuthys');
        $this->addRelation('Authy', 'Authy', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Authys');
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
  'auth_rights_column' => '["rights_admin", "rights_owner", "rights_group"]',
  'bulk_update_child' => '{"group_right_authy":["primary", "is_set"]}',
  'child_colunms' => '{ "id_creation": ["username"] }',
  'tabs_column' => '{"Droits admin":["rights_admin"],"Droits propriétaire":["rights_owner"], "Droits groupe":["rights_group"] }',
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

} // GroupRightTableMap
