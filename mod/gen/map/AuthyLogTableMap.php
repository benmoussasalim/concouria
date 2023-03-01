<?php



/**
 * This class defines the structure of the 'authy_log' table.
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
class AuthyLogTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.AuthyLogTableMap';

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
        $this->setName('authy_log');
        $this->setPhpName('AuthyLog');
        $this->setClassname('AuthyLog');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_authy_log', 'IdAuthyLog', 'INTEGER', true, null, null);
        $this->addForeignKey('id_authy', 'IdAuthy', 'INTEGER', 'authy', 'id_authy', false, null, null);
        $this->addColumn('timestamp', 'Timestamp', 'INTEGER', false, null, null);
        $this->addColumn('login', 'Login', 'VARCHAR', false, 50, null);
        $this->addColumn('userid', 'Userid', 'INTEGER', false, null, null);
        $this->addColumn('result', 'Result', 'VARCHAR', false, 100, null);
        $this->addColumn('ip', 'Ip', 'VARCHAR', false, 16, null);
        $this->addColumn('count', 'Count', 'INTEGER', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
  'public_interface' => '{    "page":{}    ,"formulaire":{}    ,"invoice":{}    ,"rappel":{}   }',
  'propel_runtime' => '1.7.1',
  'i18n_langs' => '["fr_CA","en_US"]',
  'i18n_traductions' => '{"fr_CA": "Français","en_US": "Anglais"}',
  'public_interface_root' => './mod/page/',
  'mce_version' => '4.0.11',
  'default_public' => 'page',
  'rights_letter' => '"m","r","w","a","d","b"',
  'label_link_type' => 'new',
  'label_link_all' => 'yes',
  'no_include_tiny' => 'yes',
  'simple_web' => 'yes',
  'debug_build' => '0',
  'menu_change' => '{    "SimpleWeb":["","SimpleWeb", "add", "10", "SimpleWeb"]    ,"Abonnées":["","Abonnées", "add", "5", "Account"]    ,"Vente":["","Vente", "add", "2", "Sale"]   }',
  'add_hooks' => '{"beforeForm":["label","block","content","abonnement","account"],"beforeList":["label","account"],"beforeSave":["block","content"],"beforeDelete":[],"beforeListSearch":[""],"beforeListTr":["brand"],"beforeFileSwf":[],"beforeFormSet":[],"moreCols":[""],"afterDelete":[],"afterSave":[],"afterTryLog":[],"actionRow":[],"afterQuickForm":[],"returnSaveEventCustom":[],"child.bulkUpdateFormBefore":[],"child.moreCols":[],"child.beforeList":[""],"child.beforeListTr":[""],"child.eventHook":[""]}',
  'auth_rights_special' => 'full',
  'auto_complete_hide_ajout' => 'yes',
  'bind_othertabs_std' => 'yes',
  'browser_detect' => 'true',
  'ckeditor' => '4.4.5',
  'dashboard' => '{
  "graphColor": "rgba(138,197,63,0.5)",
  "graphText": "#8ac53f"
}',
  'index_gen' => 'true',
  'menu_hide' => '["Disconnect"]',
  'right_panel' => 'disabled',
  'soft_expert' => 'yes',
  'support' => '[ "support@progexpert.com" ]',
),
        );
    } // getBehaviors()

} // AuthyLogTableMap
