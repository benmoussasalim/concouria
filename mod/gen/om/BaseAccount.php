<?php


/**
 * Base class that represents a row from the 'account' table.
 *
 * Compte
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseAccount extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'AccountPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AccountPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the stripe_customer field.
     * @var        string
     */
    protected $stripe_customer;

    /**
     * The value for the id_account field.
     * @var        int
     */
    protected $id_account;

    /**
     * The value for the id_authy field.
     * @var        int
     */
    protected $id_authy;

    /**
     * The value for the stripe_subscription field.
     * @var        string
     */
    protected $stripe_subscription;

    /**
     * The value for the couple field.
     * @var        int
     */
    protected $couple;

    /**
     * The value for the status field.
     * @var        int
     */
    protected $status;

    /**
     * The value for the export_ready field.
     * @var        int
     */
    protected $export_ready;

    /**
     * The value for the export_status field.
     * @var        int
     */
    protected $export_status;

    /**
     * The value for the sexe field.
     * @var        int
     */
    protected $sexe;

    /**
     * The value for the birth_date field.
     * @var        string
     */
    protected $birth_date;

    /**
     * The value for the firstname field.
     * @var        string
     */
    protected $firstname;

    /**
     * The value for the lastname field.
     * @var        string
     */
    protected $lastname;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the date_expire field.
     * @var        string
     */
    protected $date_expire;

    /**
     * The value for the home_phone field.
     * @var        string
     */
    protected $home_phone;

    /**
     * The value for the other_phone field.
     * @var        string
     */
    protected $other_phone;

    /**
     * The value for the cellphone field.
     * @var        string
     */
    protected $cellphone;

    /**
     * The value for the ext_phone field.
     * @var        string
     */
    protected $ext_phone;

    /**
     * The value for the reference field.
     * @var        string
     */
    protected $reference;

    /**
     * The value for the address field.
     * @var        string
     */
    protected $address;

    /**
     * The value for the app field.
     * @var        string
     */
    protected $app;

    /**
     * The value for the postal_code field.
     * @var        string
     */
    protected $postal_code;

    /**
     * The value for the proprietaire field.
     * @var        int
     */
    protected $proprietaire;

    /**
     * The value for the id_ville field.
     * @var        int
     */
    protected $id_ville;

    /**
     * The value for the id_region field.
     * @var        int
     */
    protected $id_region;

    /**
     * The value for the id_province field.
     * @var        int
     */
    protected $id_province;

    /**
     * The value for the id_pays field.
     * @var        int
     */
    protected $id_pays;

    /**
     * The value for the note field.
     * @var        string
     */
    protected $note;

    /**
     * The value for the workplace field.
     * @var        string
     */
    protected $workplace;

    /**
     * The value for the work field.
     * @var        string
     */
    protected $work;

    /**
     * The value for the username_contest field.
     * @var        string
     */
    protected $username_contest;

    /**
     * The value for the email_contest field.
     * @var        string
     */
    protected $email_contest;

    /**
     * The value for the password_email_contest field.
     * @var        string
     */
    protected $password_email_contest;

    /**
     * The value for the password_contest field.
     * @var        string
     */
    protected $password_contest;

    /**
     * The value for the air_miles field.
     * @var        string
     */
    protected $air_miles;

    /**
     * The value for the cinoche_username field.
     * @var        string
     */
    protected $cinoche_username;

    /**
     * The value for the hershey_username field.
     * @var        string
     */
    protected $hershey_username;

    /**
     * The value for the hershey_password field.
     * @var        string
     */
    protected $hershey_password;

    /**
     * The value for the canton_username field.
     * @var        string
     */
    protected $canton_username;

    /**
     * The value for the presse_username field.
     * @var        string
     */
    protected $presse_username;

    /**
     * The value for the hbc_card field.
     * @var        string
     */
    protected $hbc_card;

    /**
     * The value for the milliplein_card field.
     * @var        string
     */
    protected $milliplein_card;

    /**
     * The value for the metro_card field.
     * @var        string
     */
    protected $metro_card;

    /**
     * The value for the cinoche_password field.
     * @var        string
     */
    protected $cinoche_password;

    /**
     * The value for the hotmail_password field.
     * @var        string
     */
    protected $hotmail_password;

    /**
     * The value for the facebook_username field.
     * @var        string
     */
    protected $facebook_username;

    /**
     * The value for the facebook_password field.
     * @var        string
     */
    protected $facebook_password;

    /**
     * The value for the casa_username field.
     * @var        string
     */
    protected $casa_username;

    /**
     * The value for the date_creation field.
     * @var        string
     */
    protected $date_creation;

    /**
     * Whether the lazy-loaded $date_creation value has been loaded from database.
     * This is necessary to avoid repeated lookups if $date_creation column is null in the db.
     * @var        boolean
     */
    protected $date_creation_isLoaded = false;

    /**
     * The value for the date_modification field.
     * @var        string
     */
    protected $date_modification;

    /**
     * Whether the lazy-loaded $date_modification value has been loaded from database.
     * This is necessary to avoid repeated lookups if $date_modification column is null in the db.
     * @var        boolean
     */
    protected $date_modification_isLoaded = false;

    /**
     * The value for the id_creation field.
     * @var        int
     */
    protected $id_creation;

    /**
     * The value for the id_modification field.
     * @var        int
     */
    protected $id_modification;

    /**
     * @var        Authy
     */
    protected $aAuthy;

    /**
     * @var        Ville
     */
    protected $aVille;

    /**
     * @var        Region
     */
    protected $aRegion;

    /**
     * @var        Province
     */
    protected $aProvince;

    /**
     * @var        Pays
     */
    protected $aPays;

    /**
     * @var        PropelObjectCollection|Sale[] Collection to store aggregation of Sale objects.
     */
    protected $collSales;
    protected $collSalesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $salesScheduledForDeletion = null;

    /**
     * Get the [stripe_customer] column value.
     *
     * @return string
     */
    public function getStripeCustomer()
    {

        return $this->stripe_customer;
    }

    /**
     * Get the [id_account] column value.
     *
     * @return int
     */
    public function getIdAccount()
    {

        return $this->id_account;
    }

    /**
     * Get the [id_authy] column value.
     * Usager associé
     * @return int
     */
    public function getIdAuthy()
    {

        return $this->id_authy;
    }

    /**
     * Get the [stripe_subscription] column value.
     *
     * @return string
     */
    public function getStripeSubscription()
    {

        return $this->stripe_subscription;
    }

    /**
     * Get the [couple] column value.
     * Participation couple
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getCouple()
    {
        if (null === $this->couple) {
            return null;
        }
        $valueSet = AccountPeer::getValueSet(AccountPeer::COUPLE);
        if (!isset($valueSet[$this->couple])) {
            throw new PropelException('Unknown stored enum key: ' . $this->couple);
        }

        return $valueSet[$this->couple];
    }

    /**
     * Get the [status] column value.
     * Status
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getStatus()
    {
        if (null === $this->status) {
            return null;
        }
        $valueSet = AccountPeer::getValueSet(AccountPeer::STATUS);
        if (!isset($valueSet[$this->status])) {
            throw new PropelException('Unknown stored enum key: ' . $this->status);
        }

        return $valueSet[$this->status];
    }

    /**
     * Get the [export_ready] column value.
     * Valide pour les concours
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getExportReady()
    {
        if (null === $this->export_ready) {
            return null;
        }
        $valueSet = AccountPeer::getValueSet(AccountPeer::EXPORT_READY);
        if (!isset($valueSet[$this->export_ready])) {
            throw new PropelException('Unknown stored enum key: ' . $this->export_ready);
        }

        return $valueSet[$this->export_ready];
    }

    /**
     * Get the [export_status] column value.
     * Déjà exporté
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getExportStatus()
    {
        if (null === $this->export_status) {
            return null;
        }
        $valueSet = AccountPeer::getValueSet(AccountPeer::EXPORT_STATUS);
        if (!isset($valueSet[$this->export_status])) {
            throw new PropelException('Unknown stored enum key: ' . $this->export_status);
        }

        return $valueSet[$this->export_status];
    }

    /**
     * Get the [sexe] column value.
     * Sexe
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getSexe()
    {
        if (null === $this->sexe) {
            return null;
        }
        $valueSet = AccountPeer::getValueSet(AccountPeer::SEXE);
        if (!isset($valueSet[$this->sexe])) {
            throw new PropelException('Unknown stored enum key: ' . $this->sexe);
        }

        return $valueSet[$this->sexe];
    }

    /**
     * Get the [birth_date] column value.
     * Date de naissance
     * @return string
     */
    public function getBirthDate()
    {

        return $this->birth_date;
    }

    /**
     * Get the [firstname] column value.
     * Prénom
     * @return string
     */
    public function getFirstname()
    {

        return $this->firstname;
    }

    /**
     * Get the [lastname] column value.
     * Nom
     * @return string
     */
    public function getLastname()
    {

        return $this->lastname;
    }

    /**
     * Get the [email] column value.
     * Courriel
     * @return string
     */
    public function getEmail()
    {

        return $this->email;
    }

    /**
     * Get the [optionally formatted] temporal [date_expire] column value.
     * Date d'expiration
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateExpire($format = 'Y-m-d')
    {
        if ($this->date_expire === null) {
            return null;
        }

        if ($this->date_expire === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date_expire);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_expire, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [home_phone] column value.
     * Téléphone résidence
     * @return string
     */
    public function getHomePhone()
    {

        return $this->home_phone;
    }

    /**
     * Get the [other_phone] column value.
     * Autre téléphone
     * @return string
     */
    public function getOtherPhone()
    {

        return $this->other_phone;
    }

    /**
     * Get the [cellphone] column value.
     * Téléphone cellulaire
     * @return string
     */
    public function getCellphone()
    {

        return $this->cellphone;
    }

    /**
     * Get the [ext_phone] column value.
     * Extension
     * @return string
     */
    public function getExtPhone()
    {

        return $this->ext_phone;
    }

    /**
     * Get the [reference] column value.
     * Référence
     * @return string
     */
    public function getReference()
    {

        return $this->reference;
    }

    /**
     * Get the [address] column value.
     * Adresse
     * @return string
     */
    public function getAddress()
    {

        return $this->address;
    }

    /**
     * Get the [app] column value.
     * Appartement
     * @return string
     */
    public function getApp()
    {

        return $this->app;
    }

    /**
     * Get the [postal_code] column value.
     * Code Postal
     * @return string
     */
    public function getPostalCode()
    {

        return $this->postal_code;
    }

    /**
     * Get the [proprietaire] column value.
     * Propriété
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getProprietaire()
    {
        if (null === $this->proprietaire) {
            return null;
        }
        $valueSet = AccountPeer::getValueSet(AccountPeer::PROPRIETAIRE);
        if (!isset($valueSet[$this->proprietaire])) {
            throw new PropelException('Unknown stored enum key: ' . $this->proprietaire);
        }

        return $valueSet[$this->proprietaire];
    }

    /**
     * Get the [id_ville] column value.
     * Ville
     * @return int
     */
    public function getIdVille()
    {

        return $this->id_ville;
    }

    /**
     * Get the [id_region] column value.
     * Région
     * @return int
     */
    public function getIdRegion()
    {

        return $this->id_region;
    }

    /**
     * Get the [id_province] column value.
     * Province
     * @return int
     */
    public function getIdProvince()
    {

        return $this->id_province;
    }

    /**
     * Get the [id_pays] column value.
     * Pays
     * @return int
     */
    public function getIdPays()
    {

        return $this->id_pays;
    }

    /**
     * Get the [note] column value.
     * Note(s)
     * @return string
     */
    public function getNote()
    {

        return $this->note;
    }

    /**
     * Get the [workplace] column value.
     * Lieu de travail
     * @return string
     */
    public function getWorkplace()
    {

        return $this->workplace;
    }

    /**
     * Get the [work] column value.
     * Emploi
     * @return string
     */
    public function getWork()
    {

        return $this->work;
    }

    /**
     * Get the [username_contest] column value.
     * Compte utilisateur
     * @return string
     */
    public function getUsernameContest()
    {

        return $this->username_contest;
    }

    /**
     * Get the [email_contest] column value.
     * Courriel pour les concours
     * @return string
     */
    public function getEmailContest()
    {

        return $this->email_contest;
    }

    /**
     * Get the [password_email_contest] column value.
     * Mot de passe du courriel
     * @return string
     */
    public function getPasswordEmailContest()
    {

        return $this->password_email_contest;
    }

    /**
     * Get the [password_contest] column value.
     * Mot de passe pour les concours
     * @return string
     */
    public function getPasswordContest()
    {

        return $this->password_contest;
    }

    /**
     * Get the [air_miles] column value.
     * Carte Air Miles
     * @return string
     */
    public function getAirMiles()
    {

        return $this->air_miles;
    }

    /**
     * Get the [cinoche_username] column value.
     * Compte Cinoche
     * @return string
     */
    public function getCinocheUsername()
    {

        return $this->cinoche_username;
    }

    /**
     * Get the [hershey_username] column value.
     * Compte Hershey
     * @return string
     */
    public function getHersheyUsername()
    {

        return $this->hershey_username;
    }

    /**
     * Get the [hershey_password] column value.
     * Mot de passe Hershey
     * @return string
     */
    public function getHersheyPassword()
    {

        return $this->hershey_password;
    }

    /**
     * Get the [canton_username] column value.
     * Compte Canton de l'Est
     * @return string
     */
    public function getCantonUsername()
    {

        return $this->canton_username;
    }

    /**
     * Get the [presse_username] column value.
     * Compte La Presse
     * @return string
     */
    public function getPresseUsername()
    {

        return $this->presse_username;
    }

    /**
     * Get the [hbc_card] column value.
     * Carte HBC
     * @return string
     */
    public function getHbcCard()
    {

        return $this->hbc_card;
    }

    /**
     * Get the [milliplein_card] column value.
     * Carte Milliplein
     * @return string
     */
    public function getMillipleinCard()
    {

        return $this->milliplein_card;
    }

    /**
     * Get the [metro_card] column value.
     * Carte Métro
     * @return string
     */
    public function getMetroCard()
    {

        return $this->metro_card;
    }

    /**
     * Get the [cinoche_password] column value.
     * Mot de passe (Cinoche)
     * @return string
     */
    public function getCinochePassword()
    {

        return $this->cinoche_password;
    }

    /**
     * Get the [hotmail_password] column value.
     * Mot de passe hotmail
     * @return string
     */
    public function getHotmailPassword()
    {

        return $this->hotmail_password;
    }

    /**
     * Get the [facebook_username] column value.
     * Compte Facebook
     * @return string
     */
    public function getFacebookUsername()
    {

        return $this->facebook_username;
    }

    /**
     * Get the [facebook_password] column value.
     * Mot de passe Facebook
     * @return string
     */
    public function getFacebookPassword()
    {

        return $this->facebook_password;
    }

    /**
     * Get the [casa_username] column value.
     * Compte Casa
     * @return string
     */
    public function getCasaUsername()
    {

        return $this->casa_username;
    }

    /**
     * Get the [optionally formatted] temporal [date_creation] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateCreation($format = 'Y-m-d H:i:s', $con = null)
    {
        if (!$this->date_creation_isLoaded && $this->date_creation === null && !$this->isNew()) {
            $this->loadDateCreation($con);
        }

        if ($this->date_creation === null) {
            return null;
        }

        if ($this->date_creation === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date_creation);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_creation, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Load the value for the lazy-loaded [date_creation] column.
     *
     * This method performs an additional query to return the value for
     * the [date_creation] column, since it is not populated by
     * the hydrate() method.
     *
     * @param  PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadDateCreation(PropelPDO $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(AccountPeer::DATE_CREATION);
        try {
            $stmt = AccountPeer::doSelectStmt($c, $con);
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $stmt->closeCursor();
            $this->date_creation = ($row[0] !== null) ? (string) $row[0] : null;
            $this->date_creation_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [date_creation] column on demand.", $e);
        }
    }
    /**
     * Get the [optionally formatted] temporal [date_modification] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateModification($format = 'Y-m-d H:i:s', $con = null)
    {
        if (!$this->date_modification_isLoaded && $this->date_modification === null && !$this->isNew()) {
            $this->loadDateModification($con);
        }

        if ($this->date_modification === null) {
            return null;
        }

        if ($this->date_modification === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date_modification);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_modification, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Load the value for the lazy-loaded [date_modification] column.
     *
     * This method performs an additional query to return the value for
     * the [date_modification] column, since it is not populated by
     * the hydrate() method.
     *
     * @param  PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadDateModification(PropelPDO $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(AccountPeer::DATE_MODIFICATION);
        try {
            $stmt = AccountPeer::doSelectStmt($c, $con);
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $stmt->closeCursor();
            $this->date_modification = ($row[0] !== null) ? (string) $row[0] : null;
            $this->date_modification_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [date_modification] column on demand.", $e);
        }
    }
    /**
     * Get the [id_creation] column value.
     *
     * @return int
     */
    public function getIdCreation()
    {

        return $this->id_creation;
    }

    /**
     * Get the [id_modification] column value.
     *
     * @return int
     */
    public function getIdModification()
    {

        return $this->id_modification;
    }

    /**
     * Set the value of [stripe_customer] column.
     *
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setStripeCustomer($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->stripe_customer !== $v) {
            $this->stripe_customer = $v;
            $this->modifiedColumns[] = AccountPeer::STRIPE_CUSTOMER;
        }


        return $this;
    } // setStripeCustomer()

    /**
     * Set the value of [id_account] column.
     *
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setIdAccount($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_account !== $v) {
            $this->id_account = $v;
            $this->modifiedColumns[] = AccountPeer::ID_ACCOUNT;
        }


        return $this;
    } // setIdAccount()

    /**
     * Set the value of [id_authy] column.
     * Usager associé
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setIdAuthy($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_authy !== $v) {
            $this->id_authy = $v;
            $this->modifiedColumns[] = AccountPeer::ID_AUTHY;
        }

        if ($this->aAuthy !== null && $this->aAuthy->getIdAuthy() !== $v) {
            $this->aAuthy = null;
        }


        return $this;
    } // setIdAuthy()

    /**
     * Set the value of [stripe_subscription] column.
     *
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setStripeSubscription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->stripe_subscription !== $v) {
            $this->stripe_subscription = $v;
            $this->modifiedColumns[] = AccountPeer::STRIPE_SUBSCRIPTION;
        }


        return $this;
    } // setStripeSubscription()

    /**
     * Set the value of [couple] column.
     * Participation couple
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setCouple($v)
    {
        if ($v !== null) {
            $valueSet = AccountPeer::getValueSet(AccountPeer::COUPLE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->couple !== $v) {
            $this->couple = $v;
            $this->modifiedColumns[] = AccountPeer::COUPLE;
        }


        return $this;
    } // setCouple()

    /**
     * Set the value of [status] column.
     * Status
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $valueSet = AccountPeer::getValueSet(AccountPeer::STATUS);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[] = AccountPeer::STATUS;
        }


        return $this;
    } // setStatus()

    /**
     * Set the value of [export_ready] column.
     * Valide pour les concours
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setExportReady($v)
    {
        if ($v !== null) {
            $valueSet = AccountPeer::getValueSet(AccountPeer::EXPORT_READY);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->export_ready !== $v) {
            $this->export_ready = $v;
            $this->modifiedColumns[] = AccountPeer::EXPORT_READY;
        }


        return $this;
    } // setExportReady()

    /**
     * Set the value of [export_status] column.
     * Déjà exporté
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setExportStatus($v)
    {
        if ($v !== null) {
            $valueSet = AccountPeer::getValueSet(AccountPeer::EXPORT_STATUS);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->export_status !== $v) {
            $this->export_status = $v;
            $this->modifiedColumns[] = AccountPeer::EXPORT_STATUS;
        }


        return $this;
    } // setExportStatus()

    /**
     * Set the value of [sexe] column.
     * Sexe
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setSexe($v)
    {
        if ($v !== null) {
            $valueSet = AccountPeer::getValueSet(AccountPeer::SEXE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->sexe !== $v) {
            $this->sexe = $v;
            $this->modifiedColumns[] = AccountPeer::SEXE;
        }


        return $this;
    } // setSexe()

    /**
     * Set the value of [birth_date] column.
     * Date de naissance
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setBirthDate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->birth_date !== $v) {
            $this->birth_date = $v;
            $this->modifiedColumns[] = AccountPeer::BIRTH_DATE;
        }


        return $this;
    } // setBirthDate()

    /**
     * Set the value of [firstname] column.
     * Prénom
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setFirstname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->firstname !== $v) {
            $this->firstname = $v;
            $this->modifiedColumns[] = AccountPeer::FIRSTNAME;
        }


        return $this;
    } // setFirstname()

    /**
     * Set the value of [lastname] column.
     * Nom
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setLastname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lastname !== $v) {
            $this->lastname = $v;
            $this->modifiedColumns[] = AccountPeer::LASTNAME;
        }


        return $this;
    } // setLastname()

    /**
     * Set the value of [email] column.
     * Courriel
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[] = AccountPeer::EMAIL;
        }


        return $this;
    } // setEmail()

    /**
     * Sets the value of [date_expire] column to a normalized version of the date/time value specified.
     * Date d'expiration
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Account The current object (for fluent API support)
     */
    public function setDateExpire($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_expire !== null || $dt !== null) {
            $currentDateAsString = ($this->date_expire !== null && $tmpDt = new DateTime($this->date_expire)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_expire = $newDateAsString;
                $this->modifiedColumns[] = AccountPeer::DATE_EXPIRE;
            }
        } // if either are not null


        return $this;
    } // setDateExpire()

    /**
     * Set the value of [home_phone] column.
     * Téléphone résidence
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setHomePhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->home_phone !== $v) {
            $this->home_phone = $v;
            $this->modifiedColumns[] = AccountPeer::HOME_PHONE;
        }


        return $this;
    } // setHomePhone()

    /**
     * Set the value of [other_phone] column.
     * Autre téléphone
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setOtherPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->other_phone !== $v) {
            $this->other_phone = $v;
            $this->modifiedColumns[] = AccountPeer::OTHER_PHONE;
        }


        return $this;
    } // setOtherPhone()

    /**
     * Set the value of [cellphone] column.
     * Téléphone cellulaire
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setCellphone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cellphone !== $v) {
            $this->cellphone = $v;
            $this->modifiedColumns[] = AccountPeer::CELLPHONE;
        }


        return $this;
    } // setCellphone()

    /**
     * Set the value of [ext_phone] column.
     * Extension
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setExtPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ext_phone !== $v) {
            $this->ext_phone = $v;
            $this->modifiedColumns[] = AccountPeer::EXT_PHONE;
        }


        return $this;
    } // setExtPhone()

    /**
     * Set the value of [reference] column.
     * Référence
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setReference($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->reference !== $v) {
            $this->reference = $v;
            $this->modifiedColumns[] = AccountPeer::REFERENCE;
        }


        return $this;
    } // setReference()

    /**
     * Set the value of [address] column.
     * Adresse
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[] = AccountPeer::ADDRESS;
        }


        return $this;
    } // setAddress()

    /**
     * Set the value of [app] column.
     * Appartement
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setApp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->app !== $v) {
            $this->app = $v;
            $this->modifiedColumns[] = AccountPeer::APP;
        }


        return $this;
    } // setApp()

    /**
     * Set the value of [postal_code] column.
     * Code Postal
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setPostalCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->postal_code !== $v) {
            $this->postal_code = $v;
            $this->modifiedColumns[] = AccountPeer::POSTAL_CODE;
        }


        return $this;
    } // setPostalCode()

    /**
     * Set the value of [proprietaire] column.
     * Propriété
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setProprietaire($v)
    {
        if ($v !== null) {
            $valueSet = AccountPeer::getValueSet(AccountPeer::PROPRIETAIRE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->proprietaire !== $v) {
            $this->proprietaire = $v;
            $this->modifiedColumns[] = AccountPeer::PROPRIETAIRE;
        }


        return $this;
    } // setProprietaire()

    /**
     * Set the value of [id_ville] column.
     * Ville
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setIdVille($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_ville !== $v) {
            $this->id_ville = $v;
            $this->modifiedColumns[] = AccountPeer::ID_VILLE;
        }

        if ($this->aVille !== null && $this->aVille->getIdVille() !== $v) {
            $this->aVille = null;
        }


        return $this;
    } // setIdVille()

    /**
     * Set the value of [id_region] column.
     * Région
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setIdRegion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_region !== $v) {
            $this->id_region = $v;
            $this->modifiedColumns[] = AccountPeer::ID_REGION;
        }

        if ($this->aRegion !== null && $this->aRegion->getIdRegion() !== $v) {
            $this->aRegion = null;
        }


        return $this;
    } // setIdRegion()

    /**
     * Set the value of [id_province] column.
     * Province
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setIdProvince($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_province !== $v) {
            $this->id_province = $v;
            $this->modifiedColumns[] = AccountPeer::ID_PROVINCE;
        }

        if ($this->aProvince !== null && $this->aProvince->getIdProvince() !== $v) {
            $this->aProvince = null;
        }


        return $this;
    } // setIdProvince()

    /**
     * Set the value of [id_pays] column.
     * Pays
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setIdPays($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_pays !== $v) {
            $this->id_pays = $v;
            $this->modifiedColumns[] = AccountPeer::ID_PAYS;
        }

        if ($this->aPays !== null && $this->aPays->getIdPays() !== $v) {
            $this->aPays = null;
        }


        return $this;
    } // setIdPays()

    /**
     * Set the value of [note] column.
     * Note(s)
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->note !== $v) {
            $this->note = $v;
            $this->modifiedColumns[] = AccountPeer::NOTE;
        }


        return $this;
    } // setNote()

    /**
     * Set the value of [workplace] column.
     * Lieu de travail
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setWorkplace($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->workplace !== $v) {
            $this->workplace = $v;
            $this->modifiedColumns[] = AccountPeer::WORKPLACE;
        }


        return $this;
    } // setWorkplace()

    /**
     * Set the value of [work] column.
     * Emploi
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setWork($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->work !== $v) {
            $this->work = $v;
            $this->modifiedColumns[] = AccountPeer::WORK;
        }


        return $this;
    } // setWork()

    /**
     * Set the value of [username_contest] column.
     * Compte utilisateur
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setUsernameContest($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username_contest !== $v) {
            $this->username_contest = $v;
            $this->modifiedColumns[] = AccountPeer::USERNAME_CONTEST;
        }


        return $this;
    } // setUsernameContest()

    /**
     * Set the value of [email_contest] column.
     * Courriel pour les concours
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setEmailContest($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email_contest !== $v) {
            $this->email_contest = $v;
            $this->modifiedColumns[] = AccountPeer::EMAIL_CONTEST;
        }


        return $this;
    } // setEmailContest()

    /**
     * Set the value of [password_email_contest] column.
     * Mot de passe du courriel
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setPasswordEmailContest($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password_email_contest !== $v) {
            $this->password_email_contest = $v;
            $this->modifiedColumns[] = AccountPeer::PASSWORD_EMAIL_CONTEST;
        }


        return $this;
    } // setPasswordEmailContest()

    /**
     * Set the value of [password_contest] column.
     * Mot de passe pour les concours
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setPasswordContest($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password_contest !== $v) {
            $this->password_contest = $v;
            $this->modifiedColumns[] = AccountPeer::PASSWORD_CONTEST;
        }


        return $this;
    } // setPasswordContest()

    /**
     * Set the value of [air_miles] column.
     * Carte Air Miles
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setAirMiles($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->air_miles !== $v) {
            $this->air_miles = $v;
            $this->modifiedColumns[] = AccountPeer::AIR_MILES;
        }


        return $this;
    } // setAirMiles()

    /**
     * Set the value of [cinoche_username] column.
     * Compte Cinoche
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setCinocheUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cinoche_username !== $v) {
            $this->cinoche_username = $v;
            $this->modifiedColumns[] = AccountPeer::CINOCHE_USERNAME;
        }


        return $this;
    } // setCinocheUsername()

    /**
     * Set the value of [hershey_username] column.
     * Compte Hershey
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setHersheyUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hershey_username !== $v) {
            $this->hershey_username = $v;
            $this->modifiedColumns[] = AccountPeer::HERSHEY_USERNAME;
        }


        return $this;
    } // setHersheyUsername()

    /**
     * Set the value of [hershey_password] column.
     * Mot de passe Hershey
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setHersheyPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hershey_password !== $v) {
            $this->hershey_password = $v;
            $this->modifiedColumns[] = AccountPeer::HERSHEY_PASSWORD;
        }


        return $this;
    } // setHersheyPassword()

    /**
     * Set the value of [canton_username] column.
     * Compte Canton de l'Est
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setCantonUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->canton_username !== $v) {
            $this->canton_username = $v;
            $this->modifiedColumns[] = AccountPeer::CANTON_USERNAME;
        }


        return $this;
    } // setCantonUsername()

    /**
     * Set the value of [presse_username] column.
     * Compte La Presse
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setPresseUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->presse_username !== $v) {
            $this->presse_username = $v;
            $this->modifiedColumns[] = AccountPeer::PRESSE_USERNAME;
        }


        return $this;
    } // setPresseUsername()

    /**
     * Set the value of [hbc_card] column.
     * Carte HBC
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setHbcCard($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hbc_card !== $v) {
            $this->hbc_card = $v;
            $this->modifiedColumns[] = AccountPeer::HBC_CARD;
        }


        return $this;
    } // setHbcCard()

    /**
     * Set the value of [milliplein_card] column.
     * Carte Milliplein
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setMillipleinCard($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->milliplein_card !== $v) {
            $this->milliplein_card = $v;
            $this->modifiedColumns[] = AccountPeer::MILLIPLEIN_CARD;
        }


        return $this;
    } // setMillipleinCard()

    /**
     * Set the value of [metro_card] column.
     * Carte Métro
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setMetroCard($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->metro_card !== $v) {
            $this->metro_card = $v;
            $this->modifiedColumns[] = AccountPeer::METRO_CARD;
        }


        return $this;
    } // setMetroCard()

    /**
     * Set the value of [cinoche_password] column.
     * Mot de passe (Cinoche)
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setCinochePassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cinoche_password !== $v) {
            $this->cinoche_password = $v;
            $this->modifiedColumns[] = AccountPeer::CINOCHE_PASSWORD;
        }


        return $this;
    } // setCinochePassword()

    /**
     * Set the value of [hotmail_password] column.
     * Mot de passe hotmail
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setHotmailPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hotmail_password !== $v) {
            $this->hotmail_password = $v;
            $this->modifiedColumns[] = AccountPeer::HOTMAIL_PASSWORD;
        }


        return $this;
    } // setHotmailPassword()

    /**
     * Set the value of [facebook_username] column.
     * Compte Facebook
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setFacebookUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->facebook_username !== $v) {
            $this->facebook_username = $v;
            $this->modifiedColumns[] = AccountPeer::FACEBOOK_USERNAME;
        }


        return $this;
    } // setFacebookUsername()

    /**
     * Set the value of [facebook_password] column.
     * Mot de passe Facebook
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setFacebookPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->facebook_password !== $v) {
            $this->facebook_password = $v;
            $this->modifiedColumns[] = AccountPeer::FACEBOOK_PASSWORD;
        }


        return $this;
    } // setFacebookPassword()

    /**
     * Set the value of [casa_username] column.
     * Compte Casa
     * @param  string $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setCasaUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->casa_username !== $v) {
            $this->casa_username = $v;
            $this->modifiedColumns[] = AccountPeer::CASA_USERNAME;
        }


        return $this;
    } // setCasaUsername()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Account The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = AccountPeer::DATE_CREATION;
        }

        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getDateCreation() method is called.
        $this->date_creation_isLoaded = true;

        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_creation !== null || $dt !== null) {
            $currentDateAsString = ($this->date_creation !== null && $tmpDt = new DateTime($this->date_creation)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_creation = $newDateAsString;
                $this->modifiedColumns[] = AccountPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Account The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = AccountPeer::DATE_MODIFICATION;
        }

        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getDateModification() method is called.
        $this->date_modification_isLoaded = true;

        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_modification !== null || $dt !== null) {
            $currentDateAsString = ($this->date_modification !== null && $tmpDt = new DateTime($this->date_modification)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_modification = $newDateAsString;
                $this->modifiedColumns[] = AccountPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = AccountPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Account The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = AccountPeer::ID_MODIFICATION;
        }


        return $this;
    } // setIdModification()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->stripe_customer = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
            $this->id_account = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->id_authy = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->stripe_subscription = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->couple = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->status = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->export_ready = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->export_status = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->sexe = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->birth_date = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->firstname = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->lastname = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->email = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->date_expire = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->home_phone = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->other_phone = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
            $this->cellphone = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
            $this->ext_phone = ($row[$startcol + 17] !== null) ? (string) $row[$startcol + 17] : null;
            $this->reference = ($row[$startcol + 18] !== null) ? (string) $row[$startcol + 18] : null;
            $this->address = ($row[$startcol + 19] !== null) ? (string) $row[$startcol + 19] : null;
            $this->app = ($row[$startcol + 20] !== null) ? (string) $row[$startcol + 20] : null;
            $this->postal_code = ($row[$startcol + 21] !== null) ? (string) $row[$startcol + 21] : null;
            $this->proprietaire = ($row[$startcol + 22] !== null) ? (int) $row[$startcol + 22] : null;
            $this->id_ville = ($row[$startcol + 23] !== null) ? (int) $row[$startcol + 23] : null;
            $this->id_region = ($row[$startcol + 24] !== null) ? (int) $row[$startcol + 24] : null;
            $this->id_province = ($row[$startcol + 25] !== null) ? (int) $row[$startcol + 25] : null;
            $this->id_pays = ($row[$startcol + 26] !== null) ? (int) $row[$startcol + 26] : null;
            $this->note = ($row[$startcol + 27] !== null) ? (string) $row[$startcol + 27] : null;
            $this->workplace = ($row[$startcol + 28] !== null) ? (string) $row[$startcol + 28] : null;
            $this->work = ($row[$startcol + 29] !== null) ? (string) $row[$startcol + 29] : null;
            $this->username_contest = ($row[$startcol + 30] !== null) ? (string) $row[$startcol + 30] : null;
            $this->email_contest = ($row[$startcol + 31] !== null) ? (string) $row[$startcol + 31] : null;
            $this->password_email_contest = ($row[$startcol + 32] !== null) ? (string) $row[$startcol + 32] : null;
            $this->password_contest = ($row[$startcol + 33] !== null) ? (string) $row[$startcol + 33] : null;
            $this->air_miles = ($row[$startcol + 34] !== null) ? (string) $row[$startcol + 34] : null;
            $this->cinoche_username = ($row[$startcol + 35] !== null) ? (string) $row[$startcol + 35] : null;
            $this->hershey_username = ($row[$startcol + 36] !== null) ? (string) $row[$startcol + 36] : null;
            $this->hershey_password = ($row[$startcol + 37] !== null) ? (string) $row[$startcol + 37] : null;
            $this->canton_username = ($row[$startcol + 38] !== null) ? (string) $row[$startcol + 38] : null;
            $this->presse_username = ($row[$startcol + 39] !== null) ? (string) $row[$startcol + 39] : null;
            $this->hbc_card = ($row[$startcol + 40] !== null) ? (string) $row[$startcol + 40] : null;
            $this->milliplein_card = ($row[$startcol + 41] !== null) ? (string) $row[$startcol + 41] : null;
            $this->metro_card = ($row[$startcol + 42] !== null) ? (string) $row[$startcol + 42] : null;
            $this->cinoche_password = ($row[$startcol + 43] !== null) ? (string) $row[$startcol + 43] : null;
            $this->hotmail_password = ($row[$startcol + 44] !== null) ? (string) $row[$startcol + 44] : null;
            $this->facebook_username = ($row[$startcol + 45] !== null) ? (string) $row[$startcol + 45] : null;
            $this->facebook_password = ($row[$startcol + 46] !== null) ? (string) $row[$startcol + 46] : null;
            $this->casa_username = ($row[$startcol + 47] !== null) ? (string) $row[$startcol + 47] : null;
            $this->id_creation = ($row[$startcol + 48] !== null) ? (int) $row[$startcol + 48] : null;
            $this->id_modification = ($row[$startcol + 49] !== null) ? (int) $row[$startcol + 49] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 50; // 50 = AccountPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Account object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency(){

        if ($this->aAuthy !== null && $this->id_authy !== $this->aAuthy->getIdAuthy()) {
            $this->aAuthy = null;
        }
        if ($this->aVille !== null && $this->id_ville !== $this->aVille->getIdVille()) {
            $this->aVille = null;
        }
        if ($this->aRegion !== null && $this->id_region !== $this->aRegion->getIdRegion()) {
            $this->aRegion = null;
        }
        if ($this->aProvince !== null && $this->id_province !== $this->aProvince->getIdProvince()) {
            $this->aProvince = null;
        }
        if ($this->aPays !== null && $this->id_pays !== $this->aPays->getIdPays()) {
            $this->aPays = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = AccountPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) { throw new PropelException('Cannot find matching row in the database to reload object values.');}
        $this->hydrate($row, 0, true); // rehydrate

        // Reset the date_creation lazy-load column
        $this->date_creation = null;
        $this->date_creation_isLoaded = false;

        // Reset the date_modification lazy-load column
        $this->date_modification = null;
        $this->date_modification_isLoaded = false;

        if ($deep) {  // also de-associate any related objects?

            $this->aAuthy = null;
            $this->aVille = null;
            $this->aRegion = null;
            $this->aProvince = null;
            $this->aPays = null;
            $this->collSales = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Account';}
        $needeRight='d';
        if(!$_SESSION[_AUTH_VAR]->hasRights($_SESSION['CurrentRights'],$needeRight,$this)){
            if(is_array($_SESSION['CurrentRights'])){
                foreach($_SESSION['CurrentRights'] as $Rigths){if($Rigths){$Entite = _($Rigths);}}
            }else{
                $Entite = $_SESSION['CurrentRights'];
            }$failureMap['Rights'] = new ValidationFailed('Rights', _('Droit insuffisant').'<br>'._($Entite).'-'.$needeRight, NULL);
            $this->validationFailures = $failureMap;
            return false;
        }
        mem_clean('Account');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = AccountQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
            $deleteQuery->delete($con);
            $con->commit();
            $this->setDeleted(true);
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
        return true;
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            if (!$isInsert) {
                // TableStampBehavior behavior
                if ($this->isModified() ) {
                    $this->setDateCreation( $this->getDateCreation() );
                        $this->setDateModification(time());

                    if(!$this->getIdCreation())
                        $this->setIdCreation( ($_SESSION[_AUTH_VAR]->get('id'))?$_SESSION[_AUTH_VAR]->get('id'):null );
                    if($this->getIdModification() != $_SESSION[_AUTH_VAR]->get('id'))
                        $this->setIdModification( ($_SESSION[_AUTH_VAR]->get('id'))?$_SESSION[_AUTH_VAR]->get('id'):null );

                        mem_clean('Account');
                }
            }
            if ($isInsert) {
                // TableStampBehavior behavior

                    $this->setDateCreation(time());
                    $this->setDateModification(time());

                    if(!$this->getIdCreation())
                        $this->setIdCreation( ($_SESSION[_AUTH_VAR]->get('id'))?$_SESSION[_AUTH_VAR]->get('id'):null );
                    if($this->getIdModification() != $_SESSION[_AUTH_VAR]->get('id'))
                        $this->setIdModification( ($_SESSION[_AUTH_VAR]->get('id'))?$_SESSION[_AUTH_VAR]->get('id'):null );

                        mem_clean('Account');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            AccountPeer::addInstanceToPool($this);

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAuthy !== null) {
                if ($this->aAuthy->isModified() || $this->aAuthy->isNew()) {
                    $affectedRows += $this->aAuthy->save($con);
                }
                $this->setAuthy($this->aAuthy);
            }

            if ($this->aVille !== null) {
                if ($this->aVille->isModified() || $this->aVille->isNew()) {
                    $affectedRows += $this->aVille->save($con);
                }
                $this->setVille($this->aVille);
            }

            if ($this->aRegion !== null) {
                if ($this->aRegion->isModified() || $this->aRegion->isNew()) {
                    $affectedRows += $this->aRegion->save($con);
                }
                $this->setRegion($this->aRegion);
            }

            if ($this->aProvince !== null) {
                if ($this->aProvince->isModified() || $this->aProvince->isNew()) {
                    $affectedRows += $this->aProvince->save($con);
                }
                $this->setProvince($this->aProvince);
            }

            if ($this->aPays !== null) {
                if ($this->aPays->isModified() || $this->aPays->isNew()) {
                    $affectedRows += $this->aPays->save($con);
                }
                $this->setPays($this->aPays);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->salesScheduledForDeletion !== null) {
                if (!$this->salesScheduledForDeletion->isEmpty()) {
                    SaleQuery::create()
                        ->filterByPrimaryKeys($this->salesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->salesScheduledForDeletion = null;
                }
            }

            if ($this->collSales !== null) {
                foreach ($this->collSales as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = AccountPeer::ID_ACCOUNT;
        if (null !== $this->id_account) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AccountPeer::ID_ACCOUNT . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AccountPeer::STRIPE_CUSTOMER)) {
            $modifiedColumns[':p' . $index++]  = '`stripe_customer`';
        }
        if ($this->isColumnModified(AccountPeer::ID_ACCOUNT)) {
            $modifiedColumns[':p' . $index++]  = '`id_account`';
        }
        if ($this->isColumnModified(AccountPeer::ID_AUTHY)) {
            $modifiedColumns[':p' . $index++]  = '`id_authy`';
        }
        if ($this->isColumnModified(AccountPeer::STRIPE_SUBSCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`stripe_subscription`';
        }
        if ($this->isColumnModified(AccountPeer::COUPLE)) {
            $modifiedColumns[':p' . $index++]  = '`couple`';
        }
        if ($this->isColumnModified(AccountPeer::STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`status`';
        }
        if ($this->isColumnModified(AccountPeer::EXPORT_READY)) {
            $modifiedColumns[':p' . $index++]  = '`export_ready`';
        }
        if ($this->isColumnModified(AccountPeer::EXPORT_STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`export_status`';
        }
        if ($this->isColumnModified(AccountPeer::SEXE)) {
            $modifiedColumns[':p' . $index++]  = '`sexe`';
        }
        if ($this->isColumnModified(AccountPeer::BIRTH_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`birth_date`';
        }
        if ($this->isColumnModified(AccountPeer::FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`firstname`';
        }
        if ($this->isColumnModified(AccountPeer::LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`lastname`';
        }
        if ($this->isColumnModified(AccountPeer::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(AccountPeer::DATE_EXPIRE)) {
            $modifiedColumns[':p' . $index++]  = '`date_expire`';
        }
        if ($this->isColumnModified(AccountPeer::HOME_PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`home_phone`';
        }
        if ($this->isColumnModified(AccountPeer::OTHER_PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`other_phone`';
        }
        if ($this->isColumnModified(AccountPeer::CELLPHONE)) {
            $modifiedColumns[':p' . $index++]  = '`cellphone`';
        }
        if ($this->isColumnModified(AccountPeer::EXT_PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`ext_phone`';
        }
        if ($this->isColumnModified(AccountPeer::REFERENCE)) {
            $modifiedColumns[':p' . $index++]  = '`reference`';
        }
        if ($this->isColumnModified(AccountPeer::ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = '`address`';
        }
        if ($this->isColumnModified(AccountPeer::APP)) {
            $modifiedColumns[':p' . $index++]  = '`app`';
        }
        if ($this->isColumnModified(AccountPeer::POSTAL_CODE)) {
            $modifiedColumns[':p' . $index++]  = '`postal_code`';
        }
        if ($this->isColumnModified(AccountPeer::PROPRIETAIRE)) {
            $modifiedColumns[':p' . $index++]  = '`proprietaire`';
        }
        if ($this->isColumnModified(AccountPeer::ID_VILLE)) {
            $modifiedColumns[':p' . $index++]  = '`id_ville`';
        }
        if ($this->isColumnModified(AccountPeer::ID_REGION)) {
            $modifiedColumns[':p' . $index++]  = '`id_region`';
        }
        if ($this->isColumnModified(AccountPeer::ID_PROVINCE)) {
            $modifiedColumns[':p' . $index++]  = '`id_province`';
        }
        if ($this->isColumnModified(AccountPeer::ID_PAYS)) {
            $modifiedColumns[':p' . $index++]  = '`id_pays`';
        }
        if ($this->isColumnModified(AccountPeer::NOTE)) {
            $modifiedColumns[':p' . $index++]  = '`note`';
        }
        if ($this->isColumnModified(AccountPeer::WORKPLACE)) {
            $modifiedColumns[':p' . $index++]  = '`workplace`';
        }
        if ($this->isColumnModified(AccountPeer::WORK)) {
            $modifiedColumns[':p' . $index++]  = '`work`';
        }
        if ($this->isColumnModified(AccountPeer::USERNAME_CONTEST)) {
            $modifiedColumns[':p' . $index++]  = '`username_contest`';
        }
        if ($this->isColumnModified(AccountPeer::EMAIL_CONTEST)) {
            $modifiedColumns[':p' . $index++]  = '`email_contest`';
        }
        if ($this->isColumnModified(AccountPeer::PASSWORD_EMAIL_CONTEST)) {
            $modifiedColumns[':p' . $index++]  = '`password_email_contest`';
        }
        if ($this->isColumnModified(AccountPeer::PASSWORD_CONTEST)) {
            $modifiedColumns[':p' . $index++]  = '`password_contest`';
        }
        if ($this->isColumnModified(AccountPeer::AIR_MILES)) {
            $modifiedColumns[':p' . $index++]  = '`air_miles`';
        }
        if ($this->isColumnModified(AccountPeer::CINOCHE_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`cinoche_username`';
        }
        if ($this->isColumnModified(AccountPeer::HERSHEY_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`hershey_username`';
        }
        if ($this->isColumnModified(AccountPeer::HERSHEY_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`hershey_password`';
        }
        if ($this->isColumnModified(AccountPeer::CANTON_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`canton_username`';
        }
        if ($this->isColumnModified(AccountPeer::PRESSE_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`presse_username`';
        }
        if ($this->isColumnModified(AccountPeer::HBC_CARD)) {
            $modifiedColumns[':p' . $index++]  = '`hbc_card`';
        }
        if ($this->isColumnModified(AccountPeer::MILLIPLEIN_CARD)) {
            $modifiedColumns[':p' . $index++]  = '`milliplein_card`';
        }
        if ($this->isColumnModified(AccountPeer::METRO_CARD)) {
            $modifiedColumns[':p' . $index++]  = '`metro_card`';
        }
        if ($this->isColumnModified(AccountPeer::CINOCHE_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`cinoche_password`';
        }
        if ($this->isColumnModified(AccountPeer::HOTMAIL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`hotmail_password`';
        }
        if ($this->isColumnModified(AccountPeer::FACEBOOK_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`facebook_username`';
        }
        if ($this->isColumnModified(AccountPeer::FACEBOOK_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`facebook_password`';
        }
        if ($this->isColumnModified(AccountPeer::CASA_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`casa_username`';
        }
        if ($this->isColumnModified(AccountPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(AccountPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(AccountPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(AccountPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `account` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`stripe_customer`':
                        $stmt->bindValue($identifier, $this->stripe_customer, PDO::PARAM_STR);
                        break;
                    case '`id_account`':
                        $stmt->bindValue($identifier, $this->id_account, PDO::PARAM_INT);
                        break;
                    case '`id_authy`':
                        $stmt->bindValue($identifier, $this->id_authy, PDO::PARAM_INT);
                        break;
                    case '`stripe_subscription`':
                        $stmt->bindValue($identifier, $this->stripe_subscription, PDO::PARAM_STR);
                        break;
                    case '`couple`':
                        $stmt->bindValue($identifier, $this->couple, PDO::PARAM_INT);
                        break;
                    case '`status`':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case '`export_ready`':
                        $stmt->bindValue($identifier, $this->export_ready, PDO::PARAM_INT);
                        break;
                    case '`export_status`':
                        $stmt->bindValue($identifier, $this->export_status, PDO::PARAM_INT);
                        break;
                    case '`sexe`':
                        $stmt->bindValue($identifier, $this->sexe, PDO::PARAM_INT);
                        break;
                    case '`birth_date`':
                        $stmt->bindValue($identifier, $this->birth_date, PDO::PARAM_STR);
                        break;
                    case '`firstname`':
                        $stmt->bindValue($identifier, $this->firstname, PDO::PARAM_STR);
                        break;
                    case '`lastname`':
                        $stmt->bindValue($identifier, $this->lastname, PDO::PARAM_STR);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`date_expire`':
                        $stmt->bindValue($identifier, $this->date_expire, PDO::PARAM_STR);
                        break;
                    case '`home_phone`':
                        $stmt->bindValue($identifier, $this->home_phone, PDO::PARAM_STR);
                        break;
                    case '`other_phone`':
                        $stmt->bindValue($identifier, $this->other_phone, PDO::PARAM_STR);
                        break;
                    case '`cellphone`':
                        $stmt->bindValue($identifier, $this->cellphone, PDO::PARAM_STR);
                        break;
                    case '`ext_phone`':
                        $stmt->bindValue($identifier, $this->ext_phone, PDO::PARAM_STR);
                        break;
                    case '`reference`':
                        $stmt->bindValue($identifier, $this->reference, PDO::PARAM_STR);
                        break;
                    case '`address`':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case '`app`':
                        $stmt->bindValue($identifier, $this->app, PDO::PARAM_STR);
                        break;
                    case '`postal_code`':
                        $stmt->bindValue($identifier, $this->postal_code, PDO::PARAM_STR);
                        break;
                    case '`proprietaire`':
                        $stmt->bindValue($identifier, $this->proprietaire, PDO::PARAM_INT);
                        break;
                    case '`id_ville`':
                        $stmt->bindValue($identifier, $this->id_ville, PDO::PARAM_INT);
                        break;
                    case '`id_region`':
                        $stmt->bindValue($identifier, $this->id_region, PDO::PARAM_INT);
                        break;
                    case '`id_province`':
                        $stmt->bindValue($identifier, $this->id_province, PDO::PARAM_INT);
                        break;
                    case '`id_pays`':
                        $stmt->bindValue($identifier, $this->id_pays, PDO::PARAM_INT);
                        break;
                    case '`note`':
                        $stmt->bindValue($identifier, $this->note, PDO::PARAM_STR);
                        break;
                    case '`workplace`':
                        $stmt->bindValue($identifier, $this->workplace, PDO::PARAM_STR);
                        break;
                    case '`work`':
                        $stmt->bindValue($identifier, $this->work, PDO::PARAM_STR);
                        break;
                    case '`username_contest`':
                        $stmt->bindValue($identifier, $this->username_contest, PDO::PARAM_STR);
                        break;
                    case '`email_contest`':
                        $stmt->bindValue($identifier, $this->email_contest, PDO::PARAM_STR);
                        break;
                    case '`password_email_contest`':
                        $stmt->bindValue($identifier, $this->password_email_contest, PDO::PARAM_STR);
                        break;
                    case '`password_contest`':
                        $stmt->bindValue($identifier, $this->password_contest, PDO::PARAM_STR);
                        break;
                    case '`air_miles`':
                        $stmt->bindValue($identifier, $this->air_miles, PDO::PARAM_STR);
                        break;
                    case '`cinoche_username`':
                        $stmt->bindValue($identifier, $this->cinoche_username, PDO::PARAM_STR);
                        break;
                    case '`hershey_username`':
                        $stmt->bindValue($identifier, $this->hershey_username, PDO::PARAM_STR);
                        break;
                    case '`hershey_password`':
                        $stmt->bindValue($identifier, $this->hershey_password, PDO::PARAM_STR);
                        break;
                    case '`canton_username`':
                        $stmt->bindValue($identifier, $this->canton_username, PDO::PARAM_STR);
                        break;
                    case '`presse_username`':
                        $stmt->bindValue($identifier, $this->presse_username, PDO::PARAM_STR);
                        break;
                    case '`hbc_card`':
                        $stmt->bindValue($identifier, $this->hbc_card, PDO::PARAM_STR);
                        break;
                    case '`milliplein_card`':
                        $stmt->bindValue($identifier, $this->milliplein_card, PDO::PARAM_STR);
                        break;
                    case '`metro_card`':
                        $stmt->bindValue($identifier, $this->metro_card, PDO::PARAM_STR);
                        break;
                    case '`cinoche_password`':
                        $stmt->bindValue($identifier, $this->cinoche_password, PDO::PARAM_STR);
                        break;
                    case '`hotmail_password`':
                        $stmt->bindValue($identifier, $this->hotmail_password, PDO::PARAM_STR);
                        break;
                    case '`facebook_username`':
                        $stmt->bindValue($identifier, $this->facebook_username, PDO::PARAM_STR);
                        break;
                    case '`facebook_password`':
                        $stmt->bindValue($identifier, $this->facebook_password, PDO::PARAM_STR);
                        break;
                    case '`casa_username`':
                        $stmt->bindValue($identifier, $this->casa_username, PDO::PARAM_STR);
                        break;
                    case '`date_creation`':
                        $stmt->bindValue($identifier, $this->date_creation, PDO::PARAM_STR);
                        break;
                    case '`date_modification`':
                        $stmt->bindValue($identifier, $this->date_modification, PDO::PARAM_STR);
                        break;
                    case '`id_creation`':
                        $stmt->bindValue($identifier, $this->id_creation, PDO::PARAM_INT);
                        break;
                    case '`id_modification`':
                        $stmt->bindValue($identifier, $this->id_modification, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setIdAccount($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null){
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;
            $failureMap = array();

// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Account';}
        $needeRight='a';
        if($this->getPrimaryKey()){$needeRight='w';}
        if(!$_SESSION[_AUTH_VAR]->hasRights($_SESSION['CurrentRights'],$needeRight,$this)){
            if(is_array($_SESSION['CurrentRights'])){
                foreach($_SESSION['CurrentRights'] as $Rigths){if($Rigths){$Entite = _($Rigths);}}
            }else{ $Entite = _($_SESSION['CurrentRights']);
            }$failureMap['Rights'] = new ValidationFailed('Rights', _('Droit insuffisant').'<br>'.$Entite.'-'.$needeRight, NULL);
        }


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAuthy !== null) {
                if (!$this->aAuthy->validate($columns)) {$failureMap = array_merge($failureMap, $this->aAuthy->getValidationFailures()); }
            }

            if ($this->aVille !== null) {
                if (!$this->aVille->validate($columns)) {$failureMap = array_merge($failureMap, $this->aVille->getValidationFailures()); }
            }

            if ($this->aRegion !== null) {
                if (!$this->aRegion->validate($columns)) {$failureMap = array_merge($failureMap, $this->aRegion->getValidationFailures()); }
            }

            if ($this->aProvince !== null) {
                if (!$this->aProvince->validate($columns)) {$failureMap = array_merge($failureMap, $this->aProvince->getValidationFailures()); }
            }

            if ($this->aPays !== null) {
                if (!$this->aPays->validate($columns)) {$failureMap = array_merge($failureMap, $this->aPays->getValidationFailures()); }
            }

            if (($retval = AccountPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collSales !== null) {
                    foreach ($this->collSales as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AccountPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Account'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Account'][$this->getPrimaryKey()] = true;
        $keys = AccountPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getStripeCustomer(),
            $keys[1] => $this->getIdAccount(),
            $keys[2] => $this->getIdAuthy(),
            $keys[3] => $this->getStripeSubscription(),
            $keys[4] => $this->getCouple(),
            $keys[5] => $this->getStatus(),
            $keys[6] => $this->getExportReady(),
            $keys[7] => $this->getExportStatus(),
            $keys[8] => $this->getSexe(),
            $keys[9] => $this->getBirthDate(),
            $keys[10] => $this->getFirstname(),
            $keys[11] => $this->getLastname(),
            $keys[12] => $this->getEmail(),
            $keys[13] => $this->getDateExpire(),
            $keys[14] => $this->getHomePhone(),
            $keys[15] => $this->getOtherPhone(),
            $keys[16] => $this->getCellphone(),
            $keys[17] => $this->getExtPhone(),
            $keys[18] => $this->getReference(),
            $keys[19] => $this->getAddress(),
            $keys[20] => $this->getApp(),
            $keys[21] => $this->getPostalCode(),
            $keys[22] => $this->getProprietaire(),
            $keys[23] => $this->getIdVille(),
            $keys[24] => $this->getIdRegion(),
            $keys[25] => $this->getIdProvince(),
            $keys[26] => $this->getIdPays(),
            $keys[27] => $this->getNote(),
            $keys[28] => $this->getWorkplace(),
            $keys[29] => $this->getWork(),
            $keys[30] => $this->getUsernameContest(),
            $keys[31] => $this->getEmailContest(),
            $keys[32] => $this->getPasswordEmailContest(),
            $keys[33] => $this->getPasswordContest(),
            $keys[34] => $this->getAirMiles(),
            $keys[35] => $this->getCinocheUsername(),
            $keys[36] => $this->getHersheyUsername(),
            $keys[37] => $this->getHersheyPassword(),
            $keys[38] => $this->getCantonUsername(),
            $keys[39] => $this->getPresseUsername(),
            $keys[40] => $this->getHbcCard(),
            $keys[41] => $this->getMillipleinCard(),
            $keys[42] => $this->getMetroCard(),
            $keys[43] => $this->getCinochePassword(),
            $keys[44] => $this->getHotmailPassword(),
            $keys[45] => $this->getFacebookUsername(),
            $keys[46] => $this->getFacebookPassword(),
            $keys[47] => $this->getCasaUsername(),
            $keys[48] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[49] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[50] => $this->getIdCreation(),
            $keys[51] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAuthy) {
                $result['Authy'] = $this->aAuthy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aVille) {
                $result['Ville'] = $this->aVille->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aRegion) {
                $result['Region'] = $this->aRegion->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProvince) {
                $result['Province'] = $this->aProvince->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPays) {
                $result['Pays'] = $this->aPays->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSales) {
                $result['Sales'] = $this->collSales->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AccountPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setStripeCustomer($value);
                break;
            case 1:
                $this->setIdAccount($value);
                break;
            case 2:
                $this->setIdAuthy($value);
                break;
            case 3:
                $this->setStripeSubscription($value);
                break;
            case 4:
                $valueSet = AccountPeer::getValueSet(AccountPeer::COUPLE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setCouple($value);
                break;
            case 5:
                $valueSet = AccountPeer::getValueSet(AccountPeer::STATUS);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setStatus($value);
                break;
            case 6:
                $valueSet = AccountPeer::getValueSet(AccountPeer::EXPORT_READY);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setExportReady($value);
                break;
            case 7:
                $valueSet = AccountPeer::getValueSet(AccountPeer::EXPORT_STATUS);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setExportStatus($value);
                break;
            case 8:
                $valueSet = AccountPeer::getValueSet(AccountPeer::SEXE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setSexe($value);
                break;
            case 9:
                $this->setBirthDate($value);
                break;
            case 10:
                $this->setFirstname($value);
                break;
            case 11:
                $this->setLastname($value);
                break;
            case 12:
                $this->setEmail($value);
                break;
            case 13:
                $this->setDateExpire($value);
                break;
            case 14:
                $this->setHomePhone($value);
                break;
            case 15:
                $this->setOtherPhone($value);
                break;
            case 16:
                $this->setCellphone($value);
                break;
            case 17:
                $this->setExtPhone($value);
                break;
            case 18:
                $this->setReference($value);
                break;
            case 19:
                $this->setAddress($value);
                break;
            case 20:
                $this->setApp($value);
                break;
            case 21:
                $this->setPostalCode($value);
                break;
            case 22:
                $valueSet = AccountPeer::getValueSet(AccountPeer::PROPRIETAIRE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setProprietaire($value);
                break;
            case 23:
                $this->setIdVille($value);
                break;
            case 24:
                $this->setIdRegion($value);
                break;
            case 25:
                $this->setIdProvince($value);
                break;
            case 26:
                $this->setIdPays($value);
                break;
            case 27:
                $this->setNote($value);
                break;
            case 28:
                $this->setWorkplace($value);
                break;
            case 29:
                $this->setWork($value);
                break;
            case 30:
                $this->setUsernameContest($value);
                break;
            case 31:
                $this->setEmailContest($value);
                break;
            case 32:
                $this->setPasswordEmailContest($value);
                break;
            case 33:
                $this->setPasswordContest($value);
                break;
            case 34:
                $this->setAirMiles($value);
                break;
            case 35:
                $this->setCinocheUsername($value);
                break;
            case 36:
                $this->setHersheyUsername($value);
                break;
            case 37:
                $this->setHersheyPassword($value);
                break;
            case 38:
                $this->setCantonUsername($value);
                break;
            case 39:
                $this->setPresseUsername($value);
                break;
            case 40:
                $this->setHbcCard($value);
                break;
            case 41:
                $this->setMillipleinCard($value);
                break;
            case 42:
                $this->setMetroCard($value);
                break;
            case 43:
                $this->setCinochePassword($value);
                break;
            case 44:
                $this->setHotmailPassword($value);
                break;
            case 45:
                $this->setFacebookUsername($value);
                break;
            case 46:
                $this->setFacebookPassword($value);
                break;
            case 47:
                $this->setCasaUsername($value);
                break;
            case 48:
                $this->setDateCreation($value);
                break;
            case 49:
                $this->setDateModification($value);
                break;
            case 50:
                $this->setIdCreation($value);
                break;
            case 51:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = AccountPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setStripeCustomer($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdAccount($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setIdAuthy($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setStripeSubscription($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCouple($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setStatus($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setExportReady($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setExportStatus($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setSexe($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setBirthDate($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setFirstname($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setLastname($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setEmail($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setDateExpire($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setHomePhone($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setOtherPhone($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setCellphone($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setExtPhone($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setReference($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setAddress($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setApp($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setPostalCode($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setProprietaire($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setIdVille($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setIdRegion($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setIdProvince($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setIdPays($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setNote($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setWorkplace($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setWork($arr[$keys[29]]);
        if (array_key_exists($keys[30], $arr)) $this->setUsernameContest($arr[$keys[30]]);
        if (array_key_exists($keys[31], $arr)) $this->setEmailContest($arr[$keys[31]]);
        if (array_key_exists($keys[32], $arr)) $this->setPasswordEmailContest($arr[$keys[32]]);
        if (array_key_exists($keys[33], $arr)) $this->setPasswordContest($arr[$keys[33]]);
        if (array_key_exists($keys[34], $arr)) $this->setAirMiles($arr[$keys[34]]);
        if (array_key_exists($keys[35], $arr)) $this->setCinocheUsername($arr[$keys[35]]);
        if (array_key_exists($keys[36], $arr)) $this->setHersheyUsername($arr[$keys[36]]);
        if (array_key_exists($keys[37], $arr)) $this->setHersheyPassword($arr[$keys[37]]);
        if (array_key_exists($keys[38], $arr)) $this->setCantonUsername($arr[$keys[38]]);
        if (array_key_exists($keys[39], $arr)) $this->setPresseUsername($arr[$keys[39]]);
        if (array_key_exists($keys[40], $arr)) $this->setHbcCard($arr[$keys[40]]);
        if (array_key_exists($keys[41], $arr)) $this->setMillipleinCard($arr[$keys[41]]);
        if (array_key_exists($keys[42], $arr)) $this->setMetroCard($arr[$keys[42]]);
        if (array_key_exists($keys[43], $arr)) $this->setCinochePassword($arr[$keys[43]]);
        if (array_key_exists($keys[44], $arr)) $this->setHotmailPassword($arr[$keys[44]]);
        if (array_key_exists($keys[45], $arr)) $this->setFacebookUsername($arr[$keys[45]]);
        if (array_key_exists($keys[46], $arr)) $this->setFacebookPassword($arr[$keys[46]]);
        if (array_key_exists($keys[47], $arr)) $this->setCasaUsername($arr[$keys[47]]);
        if (array_key_exists($keys[48], $arr)) $this->setDateCreation($arr[$keys[48]]);
        if (array_key_exists($keys[49], $arr)) $this->setDateModification($arr[$keys[49]]);
        if (array_key_exists($keys[50], $arr)) $this->setIdCreation($arr[$keys[50]]);
        if (array_key_exists($keys[51], $arr)) $this->setIdModification($arr[$keys[51]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(AccountPeer::DATABASE_NAME);

        if ($this->isColumnModified(AccountPeer::STRIPE_CUSTOMER)) $criteria->add(AccountPeer::STRIPE_CUSTOMER, $this->stripe_customer);
        if ($this->isColumnModified(AccountPeer::ID_ACCOUNT)) $criteria->add(AccountPeer::ID_ACCOUNT, $this->id_account);
        if ($this->isColumnModified(AccountPeer::ID_AUTHY)) $criteria->add(AccountPeer::ID_AUTHY, $this->id_authy);
        if ($this->isColumnModified(AccountPeer::STRIPE_SUBSCRIPTION)) $criteria->add(AccountPeer::STRIPE_SUBSCRIPTION, $this->stripe_subscription);
        if ($this->isColumnModified(AccountPeer::COUPLE)) $criteria->add(AccountPeer::COUPLE, $this->couple);
        if ($this->isColumnModified(AccountPeer::STATUS)) $criteria->add(AccountPeer::STATUS, $this->status);
        if ($this->isColumnModified(AccountPeer::EXPORT_READY)) $criteria->add(AccountPeer::EXPORT_READY, $this->export_ready);
        if ($this->isColumnModified(AccountPeer::EXPORT_STATUS)) $criteria->add(AccountPeer::EXPORT_STATUS, $this->export_status);
        if ($this->isColumnModified(AccountPeer::SEXE)) $criteria->add(AccountPeer::SEXE, $this->sexe);
        if ($this->isColumnModified(AccountPeer::BIRTH_DATE)) $criteria->add(AccountPeer::BIRTH_DATE, $this->birth_date);
        if ($this->isColumnModified(AccountPeer::FIRSTNAME)) $criteria->add(AccountPeer::FIRSTNAME, $this->firstname);
        if ($this->isColumnModified(AccountPeer::LASTNAME)) $criteria->add(AccountPeer::LASTNAME, $this->lastname);
        if ($this->isColumnModified(AccountPeer::EMAIL)) $criteria->add(AccountPeer::EMAIL, $this->email);
        if ($this->isColumnModified(AccountPeer::DATE_EXPIRE)) $criteria->add(AccountPeer::DATE_EXPIRE, $this->date_expire);
        if ($this->isColumnModified(AccountPeer::HOME_PHONE)) $criteria->add(AccountPeer::HOME_PHONE, $this->home_phone);
        if ($this->isColumnModified(AccountPeer::OTHER_PHONE)) $criteria->add(AccountPeer::OTHER_PHONE, $this->other_phone);
        if ($this->isColumnModified(AccountPeer::CELLPHONE)) $criteria->add(AccountPeer::CELLPHONE, $this->cellphone);
        if ($this->isColumnModified(AccountPeer::EXT_PHONE)) $criteria->add(AccountPeer::EXT_PHONE, $this->ext_phone);
        if ($this->isColumnModified(AccountPeer::REFERENCE)) $criteria->add(AccountPeer::REFERENCE, $this->reference);
        if ($this->isColumnModified(AccountPeer::ADDRESS)) $criteria->add(AccountPeer::ADDRESS, $this->address);
        if ($this->isColumnModified(AccountPeer::APP)) $criteria->add(AccountPeer::APP, $this->app);
        if ($this->isColumnModified(AccountPeer::POSTAL_CODE)) $criteria->add(AccountPeer::POSTAL_CODE, $this->postal_code);
        if ($this->isColumnModified(AccountPeer::PROPRIETAIRE)) $criteria->add(AccountPeer::PROPRIETAIRE, $this->proprietaire);
        if ($this->isColumnModified(AccountPeer::ID_VILLE)) $criteria->add(AccountPeer::ID_VILLE, $this->id_ville);
        if ($this->isColumnModified(AccountPeer::ID_REGION)) $criteria->add(AccountPeer::ID_REGION, $this->id_region);
        if ($this->isColumnModified(AccountPeer::ID_PROVINCE)) $criteria->add(AccountPeer::ID_PROVINCE, $this->id_province);
        if ($this->isColumnModified(AccountPeer::ID_PAYS)) $criteria->add(AccountPeer::ID_PAYS, $this->id_pays);
        if ($this->isColumnModified(AccountPeer::NOTE)) $criteria->add(AccountPeer::NOTE, $this->note);
        if ($this->isColumnModified(AccountPeer::WORKPLACE)) $criteria->add(AccountPeer::WORKPLACE, $this->workplace);
        if ($this->isColumnModified(AccountPeer::WORK)) $criteria->add(AccountPeer::WORK, $this->work);
        if ($this->isColumnModified(AccountPeer::USERNAME_CONTEST)) $criteria->add(AccountPeer::USERNAME_CONTEST, $this->username_contest);
        if ($this->isColumnModified(AccountPeer::EMAIL_CONTEST)) $criteria->add(AccountPeer::EMAIL_CONTEST, $this->email_contest);
        if ($this->isColumnModified(AccountPeer::PASSWORD_EMAIL_CONTEST)) $criteria->add(AccountPeer::PASSWORD_EMAIL_CONTEST, $this->password_email_contest);
        if ($this->isColumnModified(AccountPeer::PASSWORD_CONTEST)) $criteria->add(AccountPeer::PASSWORD_CONTEST, $this->password_contest);
        if ($this->isColumnModified(AccountPeer::AIR_MILES)) $criteria->add(AccountPeer::AIR_MILES, $this->air_miles);
        if ($this->isColumnModified(AccountPeer::CINOCHE_USERNAME)) $criteria->add(AccountPeer::CINOCHE_USERNAME, $this->cinoche_username);
        if ($this->isColumnModified(AccountPeer::HERSHEY_USERNAME)) $criteria->add(AccountPeer::HERSHEY_USERNAME, $this->hershey_username);
        if ($this->isColumnModified(AccountPeer::HERSHEY_PASSWORD)) $criteria->add(AccountPeer::HERSHEY_PASSWORD, $this->hershey_password);
        if ($this->isColumnModified(AccountPeer::CANTON_USERNAME)) $criteria->add(AccountPeer::CANTON_USERNAME, $this->canton_username);
        if ($this->isColumnModified(AccountPeer::PRESSE_USERNAME)) $criteria->add(AccountPeer::PRESSE_USERNAME, $this->presse_username);
        if ($this->isColumnModified(AccountPeer::HBC_CARD)) $criteria->add(AccountPeer::HBC_CARD, $this->hbc_card);
        if ($this->isColumnModified(AccountPeer::MILLIPLEIN_CARD)) $criteria->add(AccountPeer::MILLIPLEIN_CARD, $this->milliplein_card);
        if ($this->isColumnModified(AccountPeer::METRO_CARD)) $criteria->add(AccountPeer::METRO_CARD, $this->metro_card);
        if ($this->isColumnModified(AccountPeer::CINOCHE_PASSWORD)) $criteria->add(AccountPeer::CINOCHE_PASSWORD, $this->cinoche_password);
        if ($this->isColumnModified(AccountPeer::HOTMAIL_PASSWORD)) $criteria->add(AccountPeer::HOTMAIL_PASSWORD, $this->hotmail_password);
        if ($this->isColumnModified(AccountPeer::FACEBOOK_USERNAME)) $criteria->add(AccountPeer::FACEBOOK_USERNAME, $this->facebook_username);
        if ($this->isColumnModified(AccountPeer::FACEBOOK_PASSWORD)) $criteria->add(AccountPeer::FACEBOOK_PASSWORD, $this->facebook_password);
        if ($this->isColumnModified(AccountPeer::CASA_USERNAME)) $criteria->add(AccountPeer::CASA_USERNAME, $this->casa_username);
        if ($this->isColumnModified(AccountPeer::DATE_CREATION)) $criteria->add(AccountPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(AccountPeer::DATE_MODIFICATION)) $criteria->add(AccountPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(AccountPeer::ID_CREATION)) $criteria->add(AccountPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(AccountPeer::ID_MODIFICATION)) $criteria->add(AccountPeer::ID_MODIFICATION, $this->id_modification);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(AccountPeer::DATABASE_NAME);
        $criteria->add(AccountPeer::ID_ACCOUNT, $this->id_account);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdAccount();
    }

    /**
     * Generic method to set the primary key (id_account column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdAccount($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdAccount();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Account (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setStripeCustomer($this->getStripeCustomer());
        $copyObj->setIdAuthy($this->getIdAuthy());
        $copyObj->setStripeSubscription($this->getStripeSubscription());
        $copyObj->setCouple($this->getCouple());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setExportReady($this->getExportReady());
        $copyObj->setExportStatus($this->getExportStatus());
        $copyObj->setSexe($this->getSexe());
        $copyObj->setBirthDate($this->getBirthDate());
        $copyObj->setFirstname($this->getFirstname());
        $copyObj->setLastname($this->getLastname());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setDateExpire($this->getDateExpire());
        $copyObj->setHomePhone($this->getHomePhone());
        $copyObj->setOtherPhone($this->getOtherPhone());
        $copyObj->setCellphone($this->getCellphone());
        $copyObj->setExtPhone($this->getExtPhone());
        $copyObj->setReference($this->getReference());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setApp($this->getApp());
        $copyObj->setPostalCode($this->getPostalCode());
        $copyObj->setProprietaire($this->getProprietaire());
        $copyObj->setIdVille($this->getIdVille());
        $copyObj->setIdRegion($this->getIdRegion());
        $copyObj->setIdProvince($this->getIdProvince());
        $copyObj->setIdPays($this->getIdPays());
        $copyObj->setNote($this->getNote());
        $copyObj->setWorkplace($this->getWorkplace());
        $copyObj->setWork($this->getWork());
        $copyObj->setUsernameContest($this->getUsernameContest());
        $copyObj->setEmailContest($this->getEmailContest());
        $copyObj->setPasswordEmailContest($this->getPasswordEmailContest());
        $copyObj->setPasswordContest($this->getPasswordContest());
        $copyObj->setAirMiles($this->getAirMiles());
        $copyObj->setCinocheUsername($this->getCinocheUsername());
        $copyObj->setHersheyUsername($this->getHersheyUsername());
        $copyObj->setHersheyPassword($this->getHersheyPassword());
        $copyObj->setCantonUsername($this->getCantonUsername());
        $copyObj->setPresseUsername($this->getPresseUsername());
        $copyObj->setHbcCard($this->getHbcCard());
        $copyObj->setMillipleinCard($this->getMillipleinCard());
        $copyObj->setMetroCard($this->getMetroCard());
        $copyObj->setCinochePassword($this->getCinochePassword());
        $copyObj->setHotmailPassword($this->getHotmailPassword());
        $copyObj->setFacebookUsername($this->getFacebookUsername());
        $copyObj->setFacebookPassword($this->getFacebookPassword());
        $copyObj->setCasaUsername($this->getCasaUsername());
        $copyObj->setDateCreation($this->getDateCreation());
        $copyObj->setDateModification($this->getDateModification());
        $copyObj->setIdCreation($this->getIdCreation());
        $copyObj->setIdModification($this->getIdModification());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getSales() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSale($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdAccount(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Account Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false){
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);
        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return AccountPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AccountPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return Account The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthy(Authy $v = null)
    {
        if ($v === null) {
            $this->setIdAuthy(NULL);
        } else {
            $this->setIdAuthy($v->getIdAuthy());
        }

        $this->aAuthy = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Authy object, it will not be re-added.
        if ($v !== null) {
            $v->addAccount($this);
        }


        return $this;
    }


    /**
     * Get the associated Authy object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Authy The associated Authy object.
     * @throws PropelException
     */
    public function getAuthy(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthy === null && ($this->id_authy !== null) && $doQuery) {
            $this->aAuthy = AuthyQuery::create()->findPk($this->id_authy, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthy->addAccounts($this);
             */
        }

        return $this->aAuthy;
    }

    /**
     * Declares an association between this object and a Ville object.
     *
     * @param                  Ville $v
     * @return Account The current object (for fluent API support)
     * @throws PropelException
     */
    public function setVille(Ville $v = null)
    {
        if ($v === null) {
            $this->setIdVille(NULL);
        } else {
            $this->setIdVille($v->getIdVille());
        }

        $this->aVille = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Ville object, it will not be re-added.
        if ($v !== null) {
            $v->addAccount($this);
        }


        return $this;
    }


    /**
     * Get the associated Ville object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Ville The associated Ville object.
     * @throws PropelException
     */
    public function getVille(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aVille === null && ($this->id_ville !== null) && $doQuery) {
            $this->aVille = VilleQuery::create()->findPk($this->id_ville, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aVille->addAccounts($this);
             */
        }

        return $this->aVille;
    }

    /**
     * Declares an association between this object and a Region object.
     *
     * @param                  Region $v
     * @return Account The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRegion(Region $v = null)
    {
        if ($v === null) {
            $this->setIdRegion(NULL);
        } else {
            $this->setIdRegion($v->getIdRegion());
        }

        $this->aRegion = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Region object, it will not be re-added.
        if ($v !== null) {
            $v->addAccount($this);
        }


        return $this;
    }


    /**
     * Get the associated Region object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Region The associated Region object.
     * @throws PropelException
     */
    public function getRegion(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aRegion === null && ($this->id_region !== null) && $doQuery) {
            $this->aRegion = RegionQuery::create()->findPk($this->id_region, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRegion->addAccounts($this);
             */
        }

        return $this->aRegion;
    }

    /**
     * Declares an association between this object and a Province object.
     *
     * @param                  Province $v
     * @return Account The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProvince(Province $v = null)
    {
        if ($v === null) {
            $this->setIdProvince(NULL);
        } else {
            $this->setIdProvince($v->getIdProvince());
        }

        $this->aProvince = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Province object, it will not be re-added.
        if ($v !== null) {
            $v->addAccount($this);
        }


        return $this;
    }


    /**
     * Get the associated Province object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Province The associated Province object.
     * @throws PropelException
     */
    public function getProvince(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aProvince === null && ($this->id_province !== null) && $doQuery) {
            $this->aProvince = ProvinceQuery::create()->findPk($this->id_province, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProvince->addAccounts($this);
             */
        }

        return $this->aProvince;
    }

    /**
     * Declares an association between this object and a Pays object.
     *
     * @param                  Pays $v
     * @return Account The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPays(Pays $v = null)
    {
        if ($v === null) {
            $this->setIdPays(NULL);
        } else {
            $this->setIdPays($v->getIdPays());
        }

        $this->aPays = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Pays object, it will not be re-added.
        if ($v !== null) {
            $v->addAccount($this);
        }


        return $this;
    }


    /**
     * Get the associated Pays object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Pays The associated Pays object.
     * @throws PropelException
     */
    public function getPays(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aPays === null && ($this->id_pays !== null) && $doQuery) {
            $this->aPays = PaysQuery::create()->findPk($this->id_pays, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPays->addAccounts($this);
             */
        }

        return $this->aPays;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Sale' == $relationName) {
            $this->initSales();
        }
    }

    /**
     * Clears out the collSales collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Account The current object (for fluent API support)
     * @see        addSales()
     */
    public function clearSales()
    {
        $this->collSales = null; // important to set this to null since that means it is uninitialized
        $this->collSalesPartial = null;

        return $this;
    }

    /**
     * reset is the collSales collection loaded partially
     *
     * @return void
     */
    public function resetPartialSales($v = true)
    {
        $this->collSalesPartial = $v;
    }

    /**
     * Initializes the collSales collection.
     *
     * By default this just sets the collSales collection to an empty array (like clearcollSales());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSales($overrideExisting = true)
    {
        if (null !== $this->collSales && !$overrideExisting) {
            return;
        }
        $this->collSales = new PropelObjectCollection();
        $this->collSales->setModel('Sale');
    }

    /**
     * Gets an array of Sale objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Account is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Sale[] List of Sale objects
     * @throws PropelException
     */
    public function getSales($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSalesPartial && !$this->isNew();
        if (null === $this->collSales || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSales) {
                // return empty collection
                $this->initSales();
            } else {
                $collSales = SaleQuery::create(null, $criteria)
                    ->filterByAccount($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSalesPartial && count($collSales)) {
                      $this->initSales(false);

                      foreach ($collSales as $obj) {
                        if (false == $this->collSales->contains($obj)) {
                          $this->collSales->append($obj);
                        }
                      }

                      $this->collSalesPartial = true;
                    }

                    $collSales->getInternalIterator()->rewind();

                    return $collSales;
                }

                if ($partial && $this->collSales) {
                    foreach ($this->collSales as $obj) {
                        if ($obj->isNew()) {
                            $collSales[] = $obj;
                        }
                    }
                }

                $this->collSales = $collSales;
                $this->collSalesPartial = false;
            }
        }

        return $this->collSales;
    }

    /**
     * Sets a collection of Sale objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $sales A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Account The current object (for fluent API support)
     */
    public function setSales(PropelCollection $sales, PropelPDO $con = null)
    {
        $salesToDelete = $this->getSales(new Criteria(), $con)->diff($sales);


        $this->salesScheduledForDeletion = $salesToDelete;

        foreach ($salesToDelete as $saleRemoved) {
            $saleRemoved->setAccount(null);
        }

        $this->collSales = null;
        foreach ($sales as $sale) {
            $this->addSale($sale);
        }

        $this->collSales = $sales;
        $this->collSalesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Sale objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Sale objects.
     * @throws PropelException
     */
    public function countSales(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSalesPartial && !$this->isNew();
        if (null === $this->collSales || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSales) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSales());
            }
            $query = SaleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAccount($this)
                ->count($con);
        }

        return count($this->collSales);
    }

    /**
     * Method called to associate a Sale object to this object
     * through the Sale foreign key attribute.
     *
     * @param    Sale $l Sale
     * @return Account The current object (for fluent API support)
     */
    public function addSale(Sale $l)
    {
        if ($this->collSales === null) {
            $this->initSales();
            $this->collSalesPartial = true;
        }

        if (!in_array($l, $this->collSales->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSale($l);

            if ($this->salesScheduledForDeletion and $this->salesScheduledForDeletion->contains($l)) {
                $this->salesScheduledForDeletion->remove($this->salesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Sale $sale The sale object to add.
     */
    protected function doAddSale($sale)
    {
        $this->collSales[]= $sale;
        $sale->setAccount($this);
    }

    /**
     * @param	Sale $sale The sale object to remove.
     * @return Account The current object (for fluent API support)
     */
    public function removeSale($sale)
    {
        if ($this->getSales()->contains($sale)) {
            $this->collSales->remove($this->collSales->search($sale));
            if (null === $this->salesScheduledForDeletion) {
                $this->salesScheduledForDeletion = clone $this->collSales;
                $this->salesScheduledForDeletion->clear();
            }
            $this->salesScheduledForDeletion[]= clone $sale;
            $sale->setAccount(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->stripe_customer = null;
        $this->id_account = null;
        $this->id_authy = null;
        $this->stripe_subscription = null;
        $this->couple = null;
        $this->status = null;
        $this->export_ready = null;
        $this->export_status = null;
        $this->sexe = null;
        $this->birth_date = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->email = null;
        $this->date_expire = null;
        $this->home_phone = null;
        $this->other_phone = null;
        $this->cellphone = null;
        $this->ext_phone = null;
        $this->reference = null;
        $this->address = null;
        $this->app = null;
        $this->postal_code = null;
        $this->proprietaire = null;
        $this->id_ville = null;
        $this->id_region = null;
        $this->id_province = null;
        $this->id_pays = null;
        $this->note = null;
        $this->workplace = null;
        $this->work = null;
        $this->username_contest = null;
        $this->email_contest = null;
        $this->password_email_contest = null;
        $this->password_contest = null;
        $this->air_miles = null;
        $this->cinoche_username = null;
        $this->hershey_username = null;
        $this->hershey_password = null;
        $this->canton_username = null;
        $this->presse_username = null;
        $this->hbc_card = null;
        $this->milliplein_card = null;
        $this->metro_card = null;
        $this->cinoche_password = null;
        $this->hotmail_password = null;
        $this->facebook_username = null;
        $this->facebook_password = null;
        $this->casa_username = null;
        $this->date_creation = null;
        $this->date_creation_isLoaded = false;
        $this->date_modification = null;
        $this->date_modification_isLoaded = false;
        $this->id_creation = null;
        $this->id_modification = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collSales) {
                foreach ($this->collSales as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAuthy instanceof Persistent) {
              $this->aAuthy->clearAllReferences($deep);
            }
            if ($this->aVille instanceof Persistent) {
              $this->aVille->clearAllReferences($deep);
            }
            if ($this->aRegion instanceof Persistent) {
              $this->aRegion->clearAllReferences($deep);
            }
            if ($this->aProvince instanceof Persistent) {
              $this->aProvince->clearAllReferences($deep);
            }
            if ($this->aPays instanceof Persistent) {
              $this->aPays->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collSales instanceof PropelCollection) {
            $this->collSales->clearIterator();
        }
        $this->collSales = null;
        $this->aAuthy = null;
        $this->aVille = null;
        $this->aRegion = null;
        $this->aProvince = null;
        $this->aPays = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AccountPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // TableStampBehavior behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     * @return     Account The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = AccountPeer::DATE_MODIFICATION;
        return $this;
    }

}
