<?php


/**
 * Base static class for performing query and update operations on the 'account' table.
 *
 * Compte
 *
 * @package propel.generator.gen.om
 */
abstract class BaseAccountPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'account';

    /** the related Propel class for this table */
    const OM_CLASS = 'Account';

    /** the related TableMap class for this table */
    const TM_CLASS = 'AccountTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 52;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 50;

    const STRIPE_CUSTOMER = 'account.stripe_customer';

    const ID_ACCOUNT = 'account.id_account';

    const ID_AUTHY = 'account.id_authy';

    const STRIPE_SUBSCRIPTION = 'account.stripe_subscription';

    const COUPLE = 'account.couple';

    const STATUS = 'account.status';

    const EXPORT_READY = 'account.export_ready';

    const EXPORT_STATUS = 'account.export_status';

    const SEXE = 'account.sexe';

    const BIRTH_DATE = 'account.birth_date';

    const FIRSTNAME = 'account.firstname';

    const LASTNAME = 'account.lastname';

    const EMAIL = 'account.email';

    const DATE_EXPIRE = 'account.date_expire';

    const HOME_PHONE = 'account.home_phone';

    const OTHER_PHONE = 'account.other_phone';

    const CELLPHONE = 'account.cellphone';

    const EXT_PHONE = 'account.ext_phone';

    const REFERENCE = 'account.reference';

    const ADDRESS = 'account.address';

    const APP = 'account.app';

    const POSTAL_CODE = 'account.postal_code';

    const PROPRIETAIRE = 'account.proprietaire';

    const ID_VILLE = 'account.id_ville';

    const ID_REGION = 'account.id_region';

    const ID_PROVINCE = 'account.id_province';

    const ID_PAYS = 'account.id_pays';

    const NOTE = 'account.note';

    const WORKPLACE = 'account.workplace';

    const WORK = 'account.work';

    const USERNAME_CONTEST = 'account.username_contest';

    const EMAIL_CONTEST = 'account.email_contest';

    const PASSWORD_EMAIL_CONTEST = 'account.password_email_contest';

    const PASSWORD_CONTEST = 'account.password_contest';

    const AIR_MILES = 'account.air_miles';

    const CINOCHE_USERNAME = 'account.cinoche_username';

    const HERSHEY_USERNAME = 'account.hershey_username';

    const HERSHEY_PASSWORD = 'account.hershey_password';

    const CANTON_USERNAME = 'account.canton_username';

    const PRESSE_USERNAME = 'account.presse_username';

    const HBC_CARD = 'account.hbc_card';

    const MILLIPLEIN_CARD = 'account.milliplein_card';

    const METRO_CARD = 'account.metro_card';

    const CINOCHE_PASSWORD = 'account.cinoche_password';

    const HOTMAIL_PASSWORD = 'account.hotmail_password';

    const FACEBOOK_USERNAME = 'account.facebook_username';

    const FACEBOOK_PASSWORD = 'account.facebook_password';

    const CASA_USERNAME = 'account.casa_username';

    const DATE_CREATION = 'account.date_creation';

    const DATE_MODIFICATION = 'account.date_modification';

    const ID_CREATION = 'account.id_creation';

    const ID_MODIFICATION = 'account.id_modification';

    const COUPLE_NON = 'Non';
    const COUPLE_OUI = 'Oui';

    const STATUS_NOUVEAU = 'Nouveau';
    const STATUS_ANCIEN = 'Ancien';

    const EXPORT_READY_NON = 'Non';
    const EXPORT_READY_OUI = 'Oui';
    const EXPORT_READY_À_RENOUVELER = 'À renouveler';

    const EXPORT_STATUS_NON = 'Non';
    const EXPORT_STATUS_OUI = 'Oui';

    const SEXE_HOMME = 'Homme';
    const SEXE_FEMME = 'Femme';

    const PROPRIETAIRE_PROPRIéTAIRE = 'Propriétaire';
    const PROPRIETAIRE_LOCATAIRE = 'Locataire';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Account objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Account[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. AccountPeer::$fieldNames[AccountPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('StripeCustomer', 'IdAccount', 'IdAuthy', 'StripeSubscription', 'Couple', 'Status', 'ExportReady', 'ExportStatus', 'Sexe', 'BirthDate', 'Firstname', 'Lastname', 'Email', 'DateExpire', 'HomePhone', 'OtherPhone', 'Cellphone', 'ExtPhone', 'Reference', 'Address', 'App', 'PostalCode', 'Proprietaire', 'IdVille', 'IdRegion', 'IdProvince', 'IdPays', 'Note', 'Workplace', 'Work', 'UsernameContest', 'EmailContest', 'PasswordEmailContest', 'PasswordContest', 'AirMiles', 'CinocheUsername', 'HersheyUsername', 'HersheyPassword', 'CantonUsername', 'PresseUsername', 'HbcCard', 'MillipleinCard', 'MetroCard', 'CinochePassword', 'HotmailPassword', 'FacebookUsername', 'FacebookPassword', 'CasaUsername', 'DateCreation', 'DateModification', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('stripeCustomer', 'idAccount', 'idAuthy', 'stripeSubscription', 'couple', 'status', 'exportReady', 'exportStatus', 'sexe', 'birthDate', 'firstname', 'lastname', 'email', 'dateExpire', 'homePhone', 'otherPhone', 'cellphone', 'extPhone', 'reference', 'address', 'app', 'postalCode', 'proprietaire', 'idVille', 'idRegion', 'idProvince', 'idPays', 'note', 'workplace', 'work', 'usernameContest', 'emailContest', 'passwordEmailContest', 'passwordContest', 'airMiles', 'cinocheUsername', 'hersheyUsername', 'hersheyPassword', 'cantonUsername', 'presseUsername', 'hbcCard', 'millipleinCard', 'metroCard', 'cinochePassword', 'hotmailPassword', 'facebookUsername', 'facebookPassword', 'casaUsername', 'dateCreation', 'dateModification', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (AccountPeer::STRIPE_CUSTOMER, AccountPeer::ID_ACCOUNT, AccountPeer::ID_AUTHY, AccountPeer::STRIPE_SUBSCRIPTION, AccountPeer::COUPLE, AccountPeer::STATUS, AccountPeer::EXPORT_READY, AccountPeer::EXPORT_STATUS, AccountPeer::SEXE, AccountPeer::BIRTH_DATE, AccountPeer::FIRSTNAME, AccountPeer::LASTNAME, AccountPeer::EMAIL, AccountPeer::DATE_EXPIRE, AccountPeer::HOME_PHONE, AccountPeer::OTHER_PHONE, AccountPeer::CELLPHONE, AccountPeer::EXT_PHONE, AccountPeer::REFERENCE, AccountPeer::ADDRESS, AccountPeer::APP, AccountPeer::POSTAL_CODE, AccountPeer::PROPRIETAIRE, AccountPeer::ID_VILLE, AccountPeer::ID_REGION, AccountPeer::ID_PROVINCE, AccountPeer::ID_PAYS, AccountPeer::NOTE, AccountPeer::WORKPLACE, AccountPeer::WORK, AccountPeer::USERNAME_CONTEST, AccountPeer::EMAIL_CONTEST, AccountPeer::PASSWORD_EMAIL_CONTEST, AccountPeer::PASSWORD_CONTEST, AccountPeer::AIR_MILES, AccountPeer::CINOCHE_USERNAME, AccountPeer::HERSHEY_USERNAME, AccountPeer::HERSHEY_PASSWORD, AccountPeer::CANTON_USERNAME, AccountPeer::PRESSE_USERNAME, AccountPeer::HBC_CARD, AccountPeer::MILLIPLEIN_CARD, AccountPeer::METRO_CARD, AccountPeer::CINOCHE_PASSWORD, AccountPeer::HOTMAIL_PASSWORD, AccountPeer::FACEBOOK_USERNAME, AccountPeer::FACEBOOK_PASSWORD, AccountPeer::CASA_USERNAME, AccountPeer::DATE_CREATION, AccountPeer::DATE_MODIFICATION, AccountPeer::ID_CREATION, AccountPeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('STRIPE_CUSTOMER', 'ID_ACCOUNT', 'ID_AUTHY', 'STRIPE_SUBSCRIPTION', 'COUPLE', 'STATUS', 'EXPORT_READY', 'EXPORT_STATUS', 'SEXE', 'BIRTH_DATE', 'FIRSTNAME', 'LASTNAME', 'EMAIL', 'DATE_EXPIRE', 'HOME_PHONE', 'OTHER_PHONE', 'CELLPHONE', 'EXT_PHONE', 'REFERENCE', 'ADDRESS', 'APP', 'POSTAL_CODE', 'PROPRIETAIRE', 'ID_VILLE', 'ID_REGION', 'ID_PROVINCE', 'ID_PAYS', 'NOTE', 'WORKPLACE', 'WORK', 'USERNAME_CONTEST', 'EMAIL_CONTEST', 'PASSWORD_EMAIL_CONTEST', 'PASSWORD_CONTEST', 'AIR_MILES', 'CINOCHE_USERNAME', 'HERSHEY_USERNAME', 'HERSHEY_PASSWORD', 'CANTON_USERNAME', 'PRESSE_USERNAME', 'HBC_CARD', 'MILLIPLEIN_CARD', 'METRO_CARD', 'CINOCHE_PASSWORD', 'HOTMAIL_PASSWORD', 'FACEBOOK_USERNAME', 'FACEBOOK_PASSWORD', 'CASA_USERNAME', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('stripe_customer', 'id_account', 'id_authy', 'stripe_subscription', 'couple', 'status', 'export_ready', 'export_status', 'sexe', 'birth_date', 'firstname', 'lastname', 'email', 'date_expire', 'home_phone', 'other_phone', 'cellphone', 'ext_phone', 'reference', 'address', 'app', 'postal_code', 'proprietaire', 'id_ville', 'id_region', 'id_province', 'id_pays', 'note', 'workplace', 'work', 'username_contest', 'email_contest', 'password_email_contest', 'password_contest', 'air_miles', 'cinoche_username', 'hershey_username', 'hershey_password', 'canton_username', 'presse_username', 'hbc_card', 'milliplein_card', 'metro_card', 'cinoche_password', 'hotmail_password', 'facebook_username', 'facebook_password', 'casa_username', 'date_creation', 'date_modification', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. AccountPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('StripeCustomer' => 0, 'IdAccount' => 1, 'IdAuthy' => 2, 'StripeSubscription' => 3, 'Couple' => 4, 'Status' => 5, 'ExportReady' => 6, 'ExportStatus' => 7, 'Sexe' => 8, 'BirthDate' => 9, 'Firstname' => 10, 'Lastname' => 11, 'Email' => 12, 'DateExpire' => 13, 'HomePhone' => 14, 'OtherPhone' => 15, 'Cellphone' => 16, 'ExtPhone' => 17, 'Reference' => 18, 'Address' => 19, 'App' => 20, 'PostalCode' => 21, 'Proprietaire' => 22, 'IdVille' => 23, 'IdRegion' => 24, 'IdProvince' => 25, 'IdPays' => 26, 'Note' => 27, 'Workplace' => 28, 'Work' => 29, 'UsernameContest' => 30, 'EmailContest' => 31, 'PasswordEmailContest' => 32, 'PasswordContest' => 33, 'AirMiles' => 34, 'CinocheUsername' => 35, 'HersheyUsername' => 36, 'HersheyPassword' => 37, 'CantonUsername' => 38, 'PresseUsername' => 39, 'HbcCard' => 40, 'MillipleinCard' => 41, 'MetroCard' => 42, 'CinochePassword' => 43, 'HotmailPassword' => 44, 'FacebookUsername' => 45, 'FacebookPassword' => 46, 'CasaUsername' => 47, 'DateCreation' => 48, 'DateModification' => 49, 'IdCreation' => 50, 'IdModification' => 51, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('stripeCustomer' => 0, 'idAccount' => 1, 'idAuthy' => 2, 'stripeSubscription' => 3, 'couple' => 4, 'status' => 5, 'exportReady' => 6, 'exportStatus' => 7, 'sexe' => 8, 'birthDate' => 9, 'firstname' => 10, 'lastname' => 11, 'email' => 12, 'dateExpire' => 13, 'homePhone' => 14, 'otherPhone' => 15, 'cellphone' => 16, 'extPhone' => 17, 'reference' => 18, 'address' => 19, 'app' => 20, 'postalCode' => 21, 'proprietaire' => 22, 'idVille' => 23, 'idRegion' => 24, 'idProvince' => 25, 'idPays' => 26, 'note' => 27, 'workplace' => 28, 'work' => 29, 'usernameContest' => 30, 'emailContest' => 31, 'passwordEmailContest' => 32, 'passwordContest' => 33, 'airMiles' => 34, 'cinocheUsername' => 35, 'hersheyUsername' => 36, 'hersheyPassword' => 37, 'cantonUsername' => 38, 'presseUsername' => 39, 'hbcCard' => 40, 'millipleinCard' => 41, 'metroCard' => 42, 'cinochePassword' => 43, 'hotmailPassword' => 44, 'facebookUsername' => 45, 'facebookPassword' => 46, 'casaUsername' => 47, 'dateCreation' => 48, 'dateModification' => 49, 'idCreation' => 50, 'idModification' => 51, ),
        BasePeer::TYPE_COLNAME => array (AccountPeer::STRIPE_CUSTOMER => 0, AccountPeer::ID_ACCOUNT => 1, AccountPeer::ID_AUTHY => 2, AccountPeer::STRIPE_SUBSCRIPTION => 3, AccountPeer::COUPLE => 4, AccountPeer::STATUS => 5, AccountPeer::EXPORT_READY => 6, AccountPeer::EXPORT_STATUS => 7, AccountPeer::SEXE => 8, AccountPeer::BIRTH_DATE => 9, AccountPeer::FIRSTNAME => 10, AccountPeer::LASTNAME => 11, AccountPeer::EMAIL => 12, AccountPeer::DATE_EXPIRE => 13, AccountPeer::HOME_PHONE => 14, AccountPeer::OTHER_PHONE => 15, AccountPeer::CELLPHONE => 16, AccountPeer::EXT_PHONE => 17, AccountPeer::REFERENCE => 18, AccountPeer::ADDRESS => 19, AccountPeer::APP => 20, AccountPeer::POSTAL_CODE => 21, AccountPeer::PROPRIETAIRE => 22, AccountPeer::ID_VILLE => 23, AccountPeer::ID_REGION => 24, AccountPeer::ID_PROVINCE => 25, AccountPeer::ID_PAYS => 26, AccountPeer::NOTE => 27, AccountPeer::WORKPLACE => 28, AccountPeer::WORK => 29, AccountPeer::USERNAME_CONTEST => 30, AccountPeer::EMAIL_CONTEST => 31, AccountPeer::PASSWORD_EMAIL_CONTEST => 32, AccountPeer::PASSWORD_CONTEST => 33, AccountPeer::AIR_MILES => 34, AccountPeer::CINOCHE_USERNAME => 35, AccountPeer::HERSHEY_USERNAME => 36, AccountPeer::HERSHEY_PASSWORD => 37, AccountPeer::CANTON_USERNAME => 38, AccountPeer::PRESSE_USERNAME => 39, AccountPeer::HBC_CARD => 40, AccountPeer::MILLIPLEIN_CARD => 41, AccountPeer::METRO_CARD => 42, AccountPeer::CINOCHE_PASSWORD => 43, AccountPeer::HOTMAIL_PASSWORD => 44, AccountPeer::FACEBOOK_USERNAME => 45, AccountPeer::FACEBOOK_PASSWORD => 46, AccountPeer::CASA_USERNAME => 47, AccountPeer::DATE_CREATION => 48, AccountPeer::DATE_MODIFICATION => 49, AccountPeer::ID_CREATION => 50, AccountPeer::ID_MODIFICATION => 51, ),
        BasePeer::TYPE_RAW_COLNAME => array ('STRIPE_CUSTOMER' => 0, 'ID_ACCOUNT' => 1, 'ID_AUTHY' => 2, 'STRIPE_SUBSCRIPTION' => 3, 'COUPLE' => 4, 'STATUS' => 5, 'EXPORT_READY' => 6, 'EXPORT_STATUS' => 7, 'SEXE' => 8, 'BIRTH_DATE' => 9, 'FIRSTNAME' => 10, 'LASTNAME' => 11, 'EMAIL' => 12, 'DATE_EXPIRE' => 13, 'HOME_PHONE' => 14, 'OTHER_PHONE' => 15, 'CELLPHONE' => 16, 'EXT_PHONE' => 17, 'REFERENCE' => 18, 'ADDRESS' => 19, 'APP' => 20, 'POSTAL_CODE' => 21, 'PROPRIETAIRE' => 22, 'ID_VILLE' => 23, 'ID_REGION' => 24, 'ID_PROVINCE' => 25, 'ID_PAYS' => 26, 'NOTE' => 27, 'WORKPLACE' => 28, 'WORK' => 29, 'USERNAME_CONTEST' => 30, 'EMAIL_CONTEST' => 31, 'PASSWORD_EMAIL_CONTEST' => 32, 'PASSWORD_CONTEST' => 33, 'AIR_MILES' => 34, 'CINOCHE_USERNAME' => 35, 'HERSHEY_USERNAME' => 36, 'HERSHEY_PASSWORD' => 37, 'CANTON_USERNAME' => 38, 'PRESSE_USERNAME' => 39, 'HBC_CARD' => 40, 'MILLIPLEIN_CARD' => 41, 'METRO_CARD' => 42, 'CINOCHE_PASSWORD' => 43, 'HOTMAIL_PASSWORD' => 44, 'FACEBOOK_USERNAME' => 45, 'FACEBOOK_PASSWORD' => 46, 'CASA_USERNAME' => 47, 'DATE_CREATION' => 48, 'DATE_MODIFICATION' => 49, 'ID_CREATION' => 50, 'ID_MODIFICATION' => 51, ),
        BasePeer::TYPE_FIELDNAME => array ('stripe_customer' => 0, 'id_account' => 1, 'id_authy' => 2, 'stripe_subscription' => 3, 'couple' => 4, 'status' => 5, 'export_ready' => 6, 'export_status' => 7, 'sexe' => 8, 'birth_date' => 9, 'firstname' => 10, 'lastname' => 11, 'email' => 12, 'date_expire' => 13, 'home_phone' => 14, 'other_phone' => 15, 'cellphone' => 16, 'ext_phone' => 17, 'reference' => 18, 'address' => 19, 'app' => 20, 'postal_code' => 21, 'proprietaire' => 22, 'id_ville' => 23, 'id_region' => 24, 'id_province' => 25, 'id_pays' => 26, 'note' => 27, 'workplace' => 28, 'work' => 29, 'username_contest' => 30, 'email_contest' => 31, 'password_email_contest' => 32, 'password_contest' => 33, 'air_miles' => 34, 'cinoche_username' => 35, 'hershey_username' => 36, 'hershey_password' => 37, 'canton_username' => 38, 'presse_username' => 39, 'hbc_card' => 40, 'milliplein_card' => 41, 'metro_card' => 42, 'cinoche_password' => 43, 'hotmail_password' => 44, 'facebook_username' => 45, 'facebook_password' => 46, 'casa_username' => 47, 'date_creation' => 48, 'date_modification' => 49, 'id_creation' => 50, 'id_modification' => 51, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        AccountPeer::COUPLE => array(
            AccountPeer::COUPLE_NON,
            AccountPeer::COUPLE_OUI,
        ),
        AccountPeer::STATUS => array(
            AccountPeer::STATUS_NOUVEAU,
            AccountPeer::STATUS_ANCIEN,
        ),
        AccountPeer::EXPORT_READY => array(
            AccountPeer::EXPORT_READY_NON,
            AccountPeer::EXPORT_READY_OUI,
            AccountPeer::EXPORT_READY_À_RENOUVELER,
        ),
        AccountPeer::EXPORT_STATUS => array(
            AccountPeer::EXPORT_STATUS_NON,
            AccountPeer::EXPORT_STATUS_OUI,
        ),
        AccountPeer::SEXE => array(
            AccountPeer::SEXE_HOMME,
            AccountPeer::SEXE_FEMME,
        ),
        AccountPeer::PROPRIETAIRE => array(
            AccountPeer::PROPRIETAIRE_PROPRIéTAIRE,
            AccountPeer::PROPRIETAIRE_LOCATAIRE,
        ),
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = AccountPeer::getFieldNames($toType);
        $key = isset(AccountPeer::$fieldKeys[$fromType][$name]) ? AccountPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(AccountPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, AccountPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return AccountPeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return AccountPeer::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM column
     *
     * @param string $colname The ENUM column name.
     *
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = AccountPeer::getValueSets();

        if (!isset($valueSets[$colname])) {
            throw new PropelException(sprintf('Column "%s" has no ValueSet.', $colname));
        }

        return $valueSets[$colname];
    }

    /**
     * Gets the SQL value for the ENUM column value
     *
     * @param string $colname ENUM column name.
     * @param string $enumVal ENUM value.
     *
     * @return int SQL value
     */
    public static function getSqlValueForEnum($colname, $enumVal)
    {
        $values = AccountPeer::getValueSet($colname);
        if (!in_array($enumVal, $values)) {
            throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $colname));
        }

        return array_search($enumVal, $values);
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. AccountPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(AccountPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AccountPeer::STRIPE_CUSTOMER);
            $criteria->addSelectColumn(AccountPeer::ID_ACCOUNT);
            $criteria->addSelectColumn(AccountPeer::ID_AUTHY);
            $criteria->addSelectColumn(AccountPeer::STRIPE_SUBSCRIPTION);
            $criteria->addSelectColumn(AccountPeer::COUPLE);
            $criteria->addSelectColumn(AccountPeer::STATUS);
            $criteria->addSelectColumn(AccountPeer::EXPORT_READY);
            $criteria->addSelectColumn(AccountPeer::EXPORT_STATUS);
            $criteria->addSelectColumn(AccountPeer::SEXE);
            $criteria->addSelectColumn(AccountPeer::BIRTH_DATE);
            $criteria->addSelectColumn(AccountPeer::FIRSTNAME);
            $criteria->addSelectColumn(AccountPeer::LASTNAME);
            $criteria->addSelectColumn(AccountPeer::EMAIL);
            $criteria->addSelectColumn(AccountPeer::DATE_EXPIRE);
            $criteria->addSelectColumn(AccountPeer::HOME_PHONE);
            $criteria->addSelectColumn(AccountPeer::OTHER_PHONE);
            $criteria->addSelectColumn(AccountPeer::CELLPHONE);
            $criteria->addSelectColumn(AccountPeer::EXT_PHONE);
            $criteria->addSelectColumn(AccountPeer::REFERENCE);
            $criteria->addSelectColumn(AccountPeer::ADDRESS);
            $criteria->addSelectColumn(AccountPeer::APP);
            $criteria->addSelectColumn(AccountPeer::POSTAL_CODE);
            $criteria->addSelectColumn(AccountPeer::PROPRIETAIRE);
            $criteria->addSelectColumn(AccountPeer::ID_VILLE);
            $criteria->addSelectColumn(AccountPeer::ID_REGION);
            $criteria->addSelectColumn(AccountPeer::ID_PROVINCE);
            $criteria->addSelectColumn(AccountPeer::ID_PAYS);
            $criteria->addSelectColumn(AccountPeer::NOTE);
            $criteria->addSelectColumn(AccountPeer::WORKPLACE);
            $criteria->addSelectColumn(AccountPeer::WORK);
            $criteria->addSelectColumn(AccountPeer::USERNAME_CONTEST);
            $criteria->addSelectColumn(AccountPeer::EMAIL_CONTEST);
            $criteria->addSelectColumn(AccountPeer::PASSWORD_EMAIL_CONTEST);
            $criteria->addSelectColumn(AccountPeer::PASSWORD_CONTEST);
            $criteria->addSelectColumn(AccountPeer::AIR_MILES);
            $criteria->addSelectColumn(AccountPeer::CINOCHE_USERNAME);
            $criteria->addSelectColumn(AccountPeer::HERSHEY_USERNAME);
            $criteria->addSelectColumn(AccountPeer::HERSHEY_PASSWORD);
            $criteria->addSelectColumn(AccountPeer::CANTON_USERNAME);
            $criteria->addSelectColumn(AccountPeer::PRESSE_USERNAME);
            $criteria->addSelectColumn(AccountPeer::HBC_CARD);
            $criteria->addSelectColumn(AccountPeer::MILLIPLEIN_CARD);
            $criteria->addSelectColumn(AccountPeer::METRO_CARD);
            $criteria->addSelectColumn(AccountPeer::CINOCHE_PASSWORD);
            $criteria->addSelectColumn(AccountPeer::HOTMAIL_PASSWORD);
            $criteria->addSelectColumn(AccountPeer::FACEBOOK_USERNAME);
            $criteria->addSelectColumn(AccountPeer::FACEBOOK_PASSWORD);
            $criteria->addSelectColumn(AccountPeer::CASA_USERNAME);
            $criteria->addSelectColumn(AccountPeer::ID_CREATION);
            $criteria->addSelectColumn(AccountPeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.stripe_customer');
            $criteria->addSelectColumn($alias . '.id_account');
            $criteria->addSelectColumn($alias . '.id_authy');
            $criteria->addSelectColumn($alias . '.stripe_subscription');
            $criteria->addSelectColumn($alias . '.couple');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.export_ready');
            $criteria->addSelectColumn($alias . '.export_status');
            $criteria->addSelectColumn($alias . '.sexe');
            $criteria->addSelectColumn($alias . '.birth_date');
            $criteria->addSelectColumn($alias . '.firstname');
            $criteria->addSelectColumn($alias . '.lastname');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.date_expire');
            $criteria->addSelectColumn($alias . '.home_phone');
            $criteria->addSelectColumn($alias . '.other_phone');
            $criteria->addSelectColumn($alias . '.cellphone');
            $criteria->addSelectColumn($alias . '.ext_phone');
            $criteria->addSelectColumn($alias . '.reference');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.app');
            $criteria->addSelectColumn($alias . '.postal_code');
            $criteria->addSelectColumn($alias . '.proprietaire');
            $criteria->addSelectColumn($alias . '.id_ville');
            $criteria->addSelectColumn($alias . '.id_region');
            $criteria->addSelectColumn($alias . '.id_province');
            $criteria->addSelectColumn($alias . '.id_pays');
            $criteria->addSelectColumn($alias . '.note');
            $criteria->addSelectColumn($alias . '.workplace');
            $criteria->addSelectColumn($alias . '.work');
            $criteria->addSelectColumn($alias . '.username_contest');
            $criteria->addSelectColumn($alias . '.email_contest');
            $criteria->addSelectColumn($alias . '.password_email_contest');
            $criteria->addSelectColumn($alias . '.password_contest');
            $criteria->addSelectColumn($alias . '.air_miles');
            $criteria->addSelectColumn($alias . '.cinoche_username');
            $criteria->addSelectColumn($alias . '.hershey_username');
            $criteria->addSelectColumn($alias . '.hershey_password');
            $criteria->addSelectColumn($alias . '.canton_username');
            $criteria->addSelectColumn($alias . '.presse_username');
            $criteria->addSelectColumn($alias . '.hbc_card');
            $criteria->addSelectColumn($alias . '.milliplein_card');
            $criteria->addSelectColumn($alias . '.metro_card');
            $criteria->addSelectColumn($alias . '.cinoche_password');
            $criteria->addSelectColumn($alias . '.hotmail_password');
            $criteria->addSelectColumn($alias . '.facebook_username');
            $criteria->addSelectColumn($alias . '.facebook_password');
            $criteria->addSelectColumn($alias . '.casa_username');
            $criteria->addSelectColumn($alias . '.id_creation');
            $criteria->addSelectColumn($alias . '.id_modification');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(AccountPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return Account
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = AccountPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return AccountPeer::populateObjects(AccountPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            AccountPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param Account $obj A Account object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdAccount();
            } // if key === null
            AccountPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A Account object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Account) {
                $key = (string) $value->getIdAccount();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Account object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(AccountPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Account Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(AccountPeer::$instances[$key])) {
                return AccountPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (AccountPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        AccountPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to account
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {

        SalePeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol + 1] === null) {
            return null;
        }

        return (string) $row[$startcol + 1];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol + 1];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = AccountPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = AccountPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AccountPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (Account object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = AccountPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = AccountPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + AccountPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AccountPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            AccountPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function getCoupleSqlValue($enumVal)
    {
        return AccountPeer::getSqlValueForEnum(AccountPeer::COUPLE, $enumVal);
    }

    public static function getStatusSqlValue($enumVal)
    {
        return AccountPeer::getSqlValueForEnum(AccountPeer::STATUS, $enumVal);
    }

    public static function getExportReadySqlValue($enumVal)
    {
        return AccountPeer::getSqlValueForEnum(AccountPeer::EXPORT_READY, $enumVal);
    }

    public static function getExportStatusSqlValue($enumVal)
    {
        return AccountPeer::getSqlValueForEnum(AccountPeer::EXPORT_STATUS, $enumVal);
    }

    public static function getSexeSqlValue($enumVal)
    {
        return AccountPeer::getSqlValueForEnum(AccountPeer::SEXE, $enumVal);
    }

    public static function getProprietaireSqlValue($enumVal)
    {
        return AccountPeer::getSqlValueForEnum(AccountPeer::PROPRIETAIRE, $enumVal);
    }

    public static function doCountJoinAuthy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    public static function doCountJoinVille(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    public static function doCountJoinRegion(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    public static function doCountJoinProvince(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    public static function doCountJoinPays(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinAuthy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol = AccountPeer::NUM_HYDRATE_COLUMNS;
        AuthyPeer::addSelectColumns($criteria);

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AuthyPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Account) to $obj2 (Authy)
                $obj2->addAccount($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinVille(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol = AccountPeer::NUM_HYDRATE_COLUMNS;
        VillePeer::addSelectColumns($criteria);

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = VillePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = VillePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = VillePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    VillePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Account) to $obj2 (Ville)
                $obj2->addAccount($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinRegion(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol = AccountPeer::NUM_HYDRATE_COLUMNS;
        RegionPeer::addSelectColumns($criteria);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = RegionPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = RegionPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = RegionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    RegionPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Account) to $obj2 (Region)
                $obj2->addAccount($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinProvince(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol = AccountPeer::NUM_HYDRATE_COLUMNS;
        ProvincePeer::addSelectColumns($criteria);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ProvincePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ProvincePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ProvincePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ProvincePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Account) to $obj2 (Province)
                $obj2->addAccount($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinPays(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol = AccountPeer::NUM_HYDRATE_COLUMNS;
        PaysPeer::addSelectColumns($criteria);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = PaysPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = PaysPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = PaysPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    PaysPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Account) to $obj2 (Pays)
                $obj2->addAccount($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol2 = AccountPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        VillePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + VillePeer::NUM_HYDRATE_COLUMNS;

        RegionPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + RegionPeer::NUM_HYDRATE_COLUMNS;

        ProvincePeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + ProvincePeer::NUM_HYDRATE_COLUMNS;

        PaysPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + PaysPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Authy rows

            $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AuthyPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Account) to the collection in $obj2 (Authy)
                $obj2->addAccount($obj1);
            } // if joined row not null

            // Add objects for joined Ville rows

            $key3 = VillePeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = VillePeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = VillePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    VillePeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Account) to the collection in $obj3 (Ville)
                $obj3->addAccount($obj1);
            } // if joined row not null

            // Add objects for joined Region rows

            $key4 = RegionPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = RegionPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = RegionPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    RegionPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (Account) to the collection in $obj4 (Region)
                $obj4->addAccount($obj1);
            } // if joined row not null

            // Add objects for joined Province rows

            $key5 = ProvincePeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = ProvincePeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = ProvincePeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    ProvincePeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (Account) to the collection in $obj5 (Province)
                $obj5->addAccount($obj1);
            } // if joined row not null

            // Add objects for joined Pays rows

            $key6 = PaysPeer::getPrimaryKeyHashFromRow($row, $startcol6);
            if ($key6 !== null) {
                $obj6 = PaysPeer::getInstanceFromPool($key6);
                if (!$obj6) {

                    $cls = PaysPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    PaysPeer::addInstanceToPool($obj6, $key6);
                } // if obj6 loaded

                // Add the $obj1 (Account) to the collection in $obj6 (Pays)
                $obj6->addAccount($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doCountJoinAllExceptAuthy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doCountJoinAllExceptVille(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doCountJoinAllExceptRegion(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doCountJoinAllExceptProvince(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doCountJoinAllExceptPays(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AccountPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AccountPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinAllExceptAuthy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol2 = AccountPeer::NUM_HYDRATE_COLUMNS;

        VillePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + VillePeer::NUM_HYDRATE_COLUMNS;

        RegionPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + RegionPeer::NUM_HYDRATE_COLUMNS;

        ProvincePeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProvincePeer::NUM_HYDRATE_COLUMNS;

        PaysPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + PaysPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Ville rows

                $key2 = VillePeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = VillePeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = VillePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    VillePeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Account) to the collection in $obj2 (Ville)
                $obj2->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Region rows

                $key3 = RegionPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = RegionPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = RegionPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    RegionPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Account) to the collection in $obj3 (Region)
                $obj3->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Province rows

                $key4 = ProvincePeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ProvincePeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ProvincePeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ProvincePeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Account) to the collection in $obj4 (Province)
                $obj4->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Pays rows

                $key5 = PaysPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = PaysPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = PaysPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    PaysPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Account) to the collection in $obj5 (Pays)
                $obj5->addAccount($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinAllExceptVille(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol2 = AccountPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        RegionPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + RegionPeer::NUM_HYDRATE_COLUMNS;

        ProvincePeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProvincePeer::NUM_HYDRATE_COLUMNS;

        PaysPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + PaysPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Authy rows

                $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AuthyPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Account) to the collection in $obj2 (Authy)
                $obj2->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Region rows

                $key3 = RegionPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = RegionPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = RegionPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    RegionPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Account) to the collection in $obj3 (Region)
                $obj3->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Province rows

                $key4 = ProvincePeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ProvincePeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ProvincePeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ProvincePeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Account) to the collection in $obj4 (Province)
                $obj4->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Pays rows

                $key5 = PaysPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = PaysPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = PaysPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    PaysPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Account) to the collection in $obj5 (Pays)
                $obj5->addAccount($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinAllExceptRegion(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol2 = AccountPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        VillePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + VillePeer::NUM_HYDRATE_COLUMNS;

        ProvincePeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProvincePeer::NUM_HYDRATE_COLUMNS;

        PaysPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + PaysPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Authy rows

                $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AuthyPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Account) to the collection in $obj2 (Authy)
                $obj2->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Ville rows

                $key3 = VillePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = VillePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = VillePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    VillePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Account) to the collection in $obj3 (Ville)
                $obj3->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Province rows

                $key4 = ProvincePeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ProvincePeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ProvincePeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ProvincePeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Account) to the collection in $obj4 (Province)
                $obj4->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Pays rows

                $key5 = PaysPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = PaysPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = PaysPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    PaysPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Account) to the collection in $obj5 (Pays)
                $obj5->addAccount($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinAllExceptProvince(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol2 = AccountPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        VillePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + VillePeer::NUM_HYDRATE_COLUMNS;

        RegionPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + RegionPeer::NUM_HYDRATE_COLUMNS;

        PaysPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + PaysPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PAYS, PaysPeer::ID_PAYS, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Authy rows

                $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AuthyPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Account) to the collection in $obj2 (Authy)
                $obj2->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Ville rows

                $key3 = VillePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = VillePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = VillePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    VillePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Account) to the collection in $obj3 (Ville)
                $obj3->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Region rows

                $key4 = RegionPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = RegionPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = RegionPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    RegionPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Account) to the collection in $obj4 (Region)
                $obj4->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Pays rows

                $key5 = PaysPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = PaysPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = PaysPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    PaysPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Account) to the collection in $obj5 (Pays)
                $obj5->addAccount($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinAllExceptPays(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AccountPeer::DATABASE_NAME);
        }

        AccountPeer::addSelectColumns($criteria);
        $startcol2 = AccountPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        VillePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + VillePeer::NUM_HYDRATE_COLUMNS;

        RegionPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + RegionPeer::NUM_HYDRATE_COLUMNS;

        ProvincePeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + ProvincePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AccountPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_VILLE, VillePeer::ID_VILLE, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_REGION, RegionPeer::ID_REGION, $join_behavior);

        $criteria->addJoin(AccountPeer::ID_PROVINCE, ProvincePeer::ID_PROVINCE, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AccountPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AccountPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AccountPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AccountPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Authy rows

                $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AuthyPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Account) to the collection in $obj2 (Authy)
                $obj2->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Ville rows

                $key3 = VillePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = VillePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = VillePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    VillePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Account) to the collection in $obj3 (Ville)
                $obj3->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Region rows

                $key4 = RegionPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = RegionPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = RegionPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    RegionPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Account) to the collection in $obj4 (Region)
                $obj4->addAccount($obj1);

            } // if joined row is not null

                // Add objects for joined Province rows

                $key5 = ProvincePeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = ProvincePeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = ProvincePeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    ProvincePeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Account) to the collection in $obj5 (Province)
                $obj5->addAccount($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(AccountPeer::DATABASE_NAME)->getTable(AccountPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseAccountPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseAccountPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \AccountTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return AccountPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Account or Criteria object.
     *
     * @param      mixed $values Criteria or Account object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Account object
        }

        if ($criteria->containsKey(AccountPeer::ID_ACCOUNT) && $criteria->keyContainsValue(AccountPeer::ID_ACCOUNT) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AccountPeer::ID_ACCOUNT.')');
        }


        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Account or Criteria object.
     *
     * @param      mixed $values Criteria or Account object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(AccountPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(AccountPeer::ID_ACCOUNT);
            $value = $criteria->remove(AccountPeer::ID_ACCOUNT);
            if ($value) {
                $selectCriteria->add(AccountPeer::ID_ACCOUNT, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(AccountPeer::TABLE_NAME);
            }

        } else { // $values is Account object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the account table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(AccountPeer::TABLE_NAME, $con, AccountPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccountPeer::clearInstancePool();
            AccountPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }


     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            AccountPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Account) { // it's a model object
            // invalidate the cache for this single object
            AccountPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AccountPeer::DATABASE_NAME);
            $criteria->add(AccountPeer::ID_ACCOUNT, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                AccountPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(AccountPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            AccountPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Account object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Account $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(AccountPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(AccountPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(AccountPeer::DATABASE_NAME, AccountPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Account
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = AccountPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(AccountPeer::DATABASE_NAME);
        $criteria->add(AccountPeer::ID_ACCOUNT, $pk);

        $v = AccountPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Account[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(AccountPeer::DATABASE_NAME);
            $criteria->add(AccountPeer::ID_ACCOUNT, $pks, Criteria::IN);
            $objs = AccountPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseAccountPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseAccountPeer::buildTableMap();

