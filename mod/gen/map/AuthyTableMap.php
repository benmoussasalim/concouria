<?php



/**
 * This class defines the structure of the 'authy' table.
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
class AuthyTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.AuthyTableMap';

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
        $this->setName('authy');
        $this->setPhpName('Authy');
        $this->setClassname('Authy');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_authy', 'IdAuthy', 'INTEGER', true, null, null);
        $this->addColumn('id_group_creation', 'IdGroupCreation', 'INTEGER', false, null, null);
        $this->addColumn('validation_key', 'ValidationKey', 'VARCHAR', false, 32, null);
        $this->addColumn('username', 'Username', 'VARCHAR', true, 50, null);
        $this->addColumn('passwd_hash', 'PasswdHash', 'VARCHAR', true, 32, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 100, null);
        $this->addColumn('is_root', 'IsRoot', 'ENUM', false, null, null);
        $this->getColumn('is_root', false)->setValueSet(array (
  0 => 'Non',
  1 => 'Oui',
));
        $this->addColumn('group', 'Group', 'ENUM', false, null, null);
        $this->getColumn('group', false)->setValueSet(array (
  0 => 'Normal',
  1 => 'Admin',
));
        $this->addColumn('expire', 'Expire', 'DATE', false, null, null);
        $this->addColumn('deactivate', 'Deactivate', 'ENUM', true, null, null);
        $this->getColumn('deactivate', false)->setValueSet(array (
  0 => 'Oui',
  1 => 'Non',
));
        $this->addColumn('date_requested', 'DateRequested', 'TIMESTAMP', false, null, null);
        $this->addColumn('language', 'Language', 'ENUM', true, null, null);
        $this->getColumn('language', false)->setValueSet(array (
  0 => 'Francais',
  1 => 'Anglais',
));
        $this->addColumn('last_poke', 'LastPoke', 'INTEGER', false, null, null);
        $this->addColumn('last_poke_ip', 'LastPokeIp', 'VARCHAR', false, 16, null);
        $this->addColumn('rights', 'Rights', 'LONGVARCHAR', false, null, null);
        $this->addColumn('wbs_public', 'WbsPublic', 'VARCHAR', false, 100, null);
        $this->addColumn('wbs_private', 'WbsPrivate', 'VARCHAR', false, 100, null);
        $this->addColumn('onglet', 'Onglet', 'LONGVARCHAR', false, null, null);
        $this->addColumn('passwd_hash_temp', 'PasswdHashTemp', 'VARCHAR', false, 32, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addColumn('passwd_date', 'PasswdDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('id_creation', 'IdCreation', 'INTEGER', false, null, null);
        $this->addColumn('id_modification', 'IdModification', 'INTEGER', false, null, null);
        // validators
        $this->addValidator('username', 'required', 'propel.validator.RequiredValidator', '', 'authy_username_required');
        $this->addValidator('passwd_hash', 'required', 'propel.validator.RequiredValidator', '', 'authy_password_required');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
            $this->addRelation('AuthyShortcut', 'AuthyShortcut', RelationMap::ONE_TO_MANY, array('id_authy' => 'id_authy', ), 'CASCADE', 'CASCADE', 'AuthyShortcuts');
            $this->addRelation('Account', 'Account', RelationMap::ONE_TO_MANY, array('id_authy' => 'id_authy', ), 'CASCADE', null, 'Accounts');
            $this->addRelation('AuthyLog', 'AuthyLog', RelationMap::ONE_TO_MANY, array('id_authy' => 'id_authy', ), 'CASCADE', null, 'AuthyLogs');
            $this->addRelation('GroupRightAuthy', 'GroupRightAuthy', RelationMap::ONE_TO_MANY, array('id_authy' => 'id_authy', ), 'CASCADE', null, 'GroupRightAuthys');
        $this->addRelation('GroupRight', 'GroupRight', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'GroupRights');
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
  'admin_columns' => '["root"]',
  'auth_passwd_column' => '["passwd_hash", "passwd_hash_temp"]',
  'auth_rights_column' => 'rights',
  'auth_table' => 'true',
  'auth_table_log' => 'true',
  'auth_unique_con' => 'true',
  'list_columns_hide' => '["rights", "passwd_hash"]',
  'owner_visible' => '["passwd_hash", "language"]',
  'search_items' => '{  "search": {    "Nom": [      [        "username",        "%val"      ]    ],"Courriel": [      [        "email",        "%val"      ]    ]  }}',
  'tabs_column' => '{"Droits":["rights"]}',
  'sub_table_visible' => '20',
  'parent_menu' => 'Abonnées',
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

} // AuthyTableMap
