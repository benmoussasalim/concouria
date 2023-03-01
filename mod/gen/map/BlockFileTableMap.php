<?php



/**
 * This class defines the structure of the 'block_file' table.
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
class BlockFileTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.BlockFileTableMap';

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
        $this->setName('block_file');
        $this->setPhpName('BlockFile');
        $this->setClassname('BlockFile');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_block_file', 'IdBlockFile', 'INTEGER', true, null, null);
        $this->addForeignKey('id_block', 'IdBlock', 'INTEGER', 'block', 'id_block', true, null, null);
        $this->addColumn('ext', 'Ext', 'VARCHAR', false, 100, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 100, null);
        $this->addColumn('desc', 'Desc', 'LONGVARCHAR', false, null, null);
        $this->addColumn('index', 'Index', 'INTEGER', true, null, 0);
        $this->addColumn('size', 'Size', 'INTEGER', false, null, null);
        $this->addColumn('fichier', 'Fichier', 'VARCHAR', false, 255, null);
        $this->addColumn('blob', 'Blob', 'BLOB', false, null, null);
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
        $this->addRelation('Block', 'Block', RelationMap::MANY_TO_ONE, array('id_block' => 'id_block', ), 'CASCADE', null);
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
  'file_upload' => '{     "thumbnail": "Yes",     "filters" : {      "max_file_size" : "10mb",      "mime_types": [       {"title" : "images", "extensions" : "jpg,png,pdf,doc,docx"}      ]     },     "image_support":"yes"    }',
  'order_list' => '[["name","ASC"]]',
  'readonly_columns' => '["size","name"]',
  'parent_table' => 'block',
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

} // BlockFileTableMap
