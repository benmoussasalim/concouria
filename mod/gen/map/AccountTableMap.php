<?php



/**
 * This class defines the structure of the 'account' table.
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
class AccountTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'gen.map.AccountTableMap';

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
        $this->setName('account');
        $this->setPhpName('Account');
        $this->setClassname('Account');
        $this->setPackage('gen');
        $this->setUseIdGenerator(true);
        // columns
        $this->addColumn('stripe_customer', 'StripeCustomer', 'VARCHAR', false, 150, null);
        $this->addPrimaryKey('id_account', 'IdAccount', 'INTEGER', true, null, null);
        $this->addForeignKey('id_authy', 'IdAuthy', 'INTEGER', 'authy', 'id_authy', true, null, null);
        $this->addColumn('stripe_subscription', 'StripeSubscription', 'VARCHAR', false, 150, null);
        $this->addColumn('couple', 'Couple', 'ENUM', false, null, null);
        $this->getColumn('couple', false)->setValueSet(array (
  0 => 'Non',
  1 => 'Oui',
));
        $this->addColumn('status', 'Status', 'ENUM', true, null, null);
        $this->getColumn('status', false)->setValueSet(array (
  0 => 'Nouveau',
  1 => 'Ancien',
));
        $this->addColumn('export_ready', 'ExportReady', 'ENUM', true, null, null);
        $this->getColumn('export_ready', false)->setValueSet(array (
  0 => 'Non',
  1 => 'Oui',
  2 => 'À renouveler',
));
        $this->addColumn('export_status', 'ExportStatus', 'ENUM', true, null, null);
        $this->getColumn('export_status', false)->setValueSet(array (
  0 => 'Non',
  1 => 'Oui',
));
        $this->addColumn('sexe', 'Sexe', 'ENUM', false, null, null);
        $this->getColumn('sexe', false)->setValueSet(array (
  0 => 'Homme',
  1 => 'Femme',
));
        $this->addColumn('birth_date', 'BirthDate', 'VARCHAR', true, 100, null);
        $this->addColumn('firstname', 'Firstname', 'VARCHAR', true, 255, null);
        $this->addColumn('lastname', 'Lastname', 'VARCHAR', true, 255, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 200, null);
        $this->addColumn('date_expire', 'DateExpire', 'DATE', false, null, null);
        $this->addColumn('home_phone', 'HomePhone', 'VARCHAR', true, 20, null);
        $this->addColumn('other_phone', 'OtherPhone', 'VARCHAR', false, 20, null);
        $this->addColumn('cellphone', 'Cellphone', 'VARCHAR', false, 20, null);
        $this->addColumn('ext_phone', 'ExtPhone', 'VARCHAR', false, 20, null);
        $this->addColumn('reference', 'Reference', 'VARCHAR', true, 250, null);
        $this->addColumn('address', 'Address', 'VARCHAR', true, 255, null);
        $this->addColumn('app', 'App', 'VARCHAR', false, 10, null);
        $this->addColumn('postal_code', 'PostalCode', 'VARCHAR', true, 10, null);
        $this->addColumn('proprietaire', 'Proprietaire', 'ENUM', true, null, null);
        $this->getColumn('proprietaire', false)->setValueSet(array (
  0 => 'Propriétaire',
  1 => 'Locataire',
));
        $this->addForeignKey('id_ville', 'IdVille', 'INTEGER', 'ville', 'id_ville', true, null, null);
        $this->addForeignKey('id_region', 'IdRegion', 'INTEGER', 'region', 'id_region', false, null, null);
        $this->addForeignKey('id_province', 'IdProvince', 'INTEGER', 'province', 'id_province', true, null, null);
        $this->addForeignKey('id_pays', 'IdPays', 'INTEGER', 'pays', 'id_pays', true, null, null);
        $this->addColumn('note', 'Note', 'LONGVARCHAR', false, null, null);
        $this->addColumn('workplace', 'Workplace', 'VARCHAR', false, 255, null);
        $this->addColumn('work', 'Work', 'VARCHAR', false, 255, null);
        $this->addColumn('username_contest', 'UsernameContest', 'VARCHAR', true, 255, null);
        $this->addColumn('email_contest', 'EmailContest', 'VARCHAR', true, 255, null);
        $this->addColumn('password_email_contest', 'PasswordEmailContest', 'VARCHAR', true, 255, null);
        $this->addColumn('password_contest', 'PasswordContest', 'VARCHAR', false, 32, null);
        $this->addColumn('air_miles', 'AirMiles', 'VARCHAR', true, 255, null);
        $this->addColumn('cinoche_username', 'CinocheUsername', 'VARCHAR', false, 255, null);
        $this->addColumn('hershey_username', 'HersheyUsername', 'VARCHAR', false, 255, null);
        $this->addColumn('hershey_password', 'HersheyPassword', 'VARCHAR', false, 32, null);
        $this->addColumn('canton_username', 'CantonUsername', 'VARCHAR', false, 255, null);
        $this->addColumn('presse_username', 'PresseUsername', 'VARCHAR', false, 255, null);
        $this->addColumn('hbc_card', 'HbcCard', 'VARCHAR', false, 255, null);
        $this->addColumn('milliplein_card', 'MillipleinCard', 'VARCHAR', false, 255, null);
        $this->addColumn('metro_card', 'MetroCard', 'LONGVARCHAR', false, null, null);
        $this->addColumn('cinoche_password', 'CinochePassword', 'VARCHAR', false, 32, null);
        $this->addColumn('hotmail_password', 'HotmailPassword', 'VARCHAR', false, 32, null);
        $this->addColumn('facebook_username', 'FacebookUsername', 'VARCHAR', false, 255, null);
        $this->addColumn('facebook_password', 'FacebookPassword', 'VARCHAR', false, 32, null);
        $this->addColumn('casa_username', 'CasaUsername', 'VARCHAR', false, 255, null);
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
        $this->addRelation('Authy', 'Authy', RelationMap::MANY_TO_ONE, array('id_authy' => 'id_authy', ), 'CASCADE', null);
        $this->addRelation('Ville', 'Ville', RelationMap::MANY_TO_ONE, array('id_ville' => 'id_ville', ), null, null);
        $this->addRelation('Region', 'Region', RelationMap::MANY_TO_ONE, array('id_region' => 'id_region', ), null, null);
        $this->addRelation('Province', 'Province', RelationMap::MANY_TO_ONE, array('id_province' => 'id_province', ), null, null);
        $this->addRelation('Pays', 'Pays', RelationMap::MANY_TO_ONE, array('id_pays' => 'id_pays', ), null, null);
            $this->addRelation('Sale', 'Sale', RelationMap::ONE_TO_MANY, array('id_account' => 'id_account', ), 'CASCADE', null, 'Sales');
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
  'child_colunms' => '{  "id_ville": [    "title"  ],  "id_region": [    "title"  ],  "id_province": [    "title"  ],  "id_pays": [    "title"  ],  "id_authy": [    "username"  ],  "id_couple_account": [    "email"  ]}',
  'child_table' => '[  "sale"]',
  'list_columns_hide_excep' => '[  "firstname",  "lastname",  "email",  "export_ready",  "date_expire","date_creation"]',
  'mce_columns' => '["note"]',
  'search_items' => '{"search":{"Sexe":[["sexe", "%val"]],"Prénom":[["firstname", "%val"]],"Nom":[["lastname", "%val"]],"Courriel":[["email", "%val"]],"Status":[["status", "%val"]],"Ville":[["id_ville", "%val"]],"Valide pour les concours":[["export_ready", "%val"]]}}',
  'tabs_column' => '{"Lieu de résidence":["address"],"Travail":["workplace"],"Informations pour les concours":["username_contest"],"Ancien membre":["hbc_card"]}',
  'sub_table_visible' => '10',
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

} // AccountTableMap
