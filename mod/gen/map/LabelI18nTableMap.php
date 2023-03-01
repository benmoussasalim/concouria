<?php



/**
 * This class defines the structure of the 'label_i18n' table.
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
class LabelI18nTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.LabelI18nTableMap';

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
        $this->setName('label_i18n');
        $this->setPhpName('LabelI18n');
        $this->setClassname('LabelI18n');
        $this->setPackage('gen');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id_label', 'IdLabel', 'INTEGER' , 'label', 'id_label', true, null, null);
        $this->addPrimaryKey('locale', 'Locale', 'VARCHAR', true, 40, 'en_US');
        $this->addColumn('text', 'Text', 'LONGVARCHAR', true, null, null);
        $this->addColumn('date_creation', 'DateCreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('date_modification', 'DateModification', 'TIMESTAMP', false, null, null);
        $this->addColumn('id_creation', 'IdCreation', 'INTEGER', false, null, null);
        $this->addColumn('id_modification', 'IdModification', 'INTEGER', false, null, null);
        // validators
        $this->addValidator('text', 'required', 'propel.validator.RequiredValidator', '', 'message_label_obligatoire');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Label', 'Label', RelationMap::MANY_TO_ONE, array('id_label' => 'id_label', ), 'CASCADE', null);
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
  'exclude' => 'none',
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

} // LabelI18nTableMap
