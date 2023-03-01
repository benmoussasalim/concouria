<?php


/**
 * Base class that represents a row from the 'authy' table.
 *
 * Usagers
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseAuthy extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'AuthyPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AuthyPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_authy field.
     * @var        int
     */
    protected $id_authy;

    /**
     * The value for the id_group_creation field.
     * @var        int
     */
    protected $id_group_creation;

    /**
     * The value for the validation_key field.
     * @var        string
     */
    protected $validation_key;

    /**
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the passwd_hash field.
     * @var        string
     */
    protected $passwd_hash;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the is_root field.
     * @var        int
     */
    protected $is_root;

    /**
     * The value for the group field.
     * @var        int
     */
    protected $group;

    /**
     * The value for the expire field.
     * @var        string
     */
    protected $expire;

    /**
     * The value for the deactivate field.
     * @var        int
     */
    protected $deactivate;

    /**
     * The value for the date_requested field.
     * @var        string
     */
    protected $date_requested;

    /**
     * The value for the language field.
     * @var        int
     */
    protected $language;

    /**
     * The value for the last_poke field.
     * @var        int
     */
    protected $last_poke;

    /**
     * The value for the last_poke_ip field.
     * @var        string
     */
    protected $last_poke_ip;

    /**
     * The value for the rights field.
     * @var        string
     */
    protected $rights;

    /**
     * The value for the wbs_public field.
     * @var        string
     */
    protected $wbs_public;

    /**
     * The value for the wbs_private field.
     * @var        string
     */
    protected $wbs_private;

    /**
     * The value for the onglet field.
     * @var        string
     */
    protected $onglet;

    /**
     * The value for the passwd_hash_temp field.
     * @var        string
     */
    protected $passwd_hash_temp;

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
     * The value for the passwd_date field.
     * @var        string
     */
    protected $passwd_date;

    /**
     * Whether the lazy-loaded $passwd_date value has been loaded from database.
     * This is necessary to avoid repeated lookups if $passwd_date column is null in the db.
     * @var        boolean
     */
    protected $passwd_date_isLoaded = false;

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
     * @var        PropelObjectCollection|AuthyShortcut[] Collection to store aggregation of AuthyShortcut objects.
     */
    protected $collAuthyShortcuts;
    protected $collAuthyShortcutsPartial;

    /**
     * @var        PropelObjectCollection|Mail[] Collection to store aggregation of Mail objects.
     */
    protected $collMailsRelatedByIdModification;
    protected $collMailsRelatedByIdModificationPartial;

    /**
     * @var        PropelObjectCollection|Mail[] Collection to store aggregation of Mail objects.
     */
    protected $collMailsRelatedByIdCreation;
    protected $collMailsRelatedByIdCreationPartial;

    /**
     * @var        PropelObjectCollection|Account[] Collection to store aggregation of Account objects.
     */
    protected $collAccounts;
    protected $collAccountsPartial;

    /**
     * @var        PropelObjectCollection|AuthyLog[] Collection to store aggregation of AuthyLog objects.
     */
    protected $collAuthyLogs;
    protected $collAuthyLogsPartial;

    /**
     * @var        PropelObjectCollection|GroupRightAuthy[] Collection to store aggregation of GroupRightAuthy objects.
     */
    protected $collGroupRightAuthys;
    protected $collGroupRightAuthysPartial;

    /**
     * @var        PropelObjectCollection|GroupRight[] Collection to store aggregation Xrel of GroupRight objects.
     */
    protected $collGroupRights;

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
    protected $groupRightsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $authyShortcutsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $mailsRelatedByIdModificationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $mailsRelatedByIdCreationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $accountsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $authyLogsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $groupRightAuthysScheduledForDeletion = null;

    /**
     * Get the [id_authy] column value.
     *
     * @return int
     */
    public function getIdAuthy()
    {

        return $this->id_authy;
    }

    /**
     * Get the [id_group_creation] column value.
     *
     * @return int
     */
    public function getIdGroupCreation()
    {

        return $this->id_group_creation;
    }

    /**
     * Get the [validation_key] column value.
     *
     * @return string
     */
    public function getValidationKey()
    {

        return $this->validation_key;
    }

    /**
     * Get the [username] column value.
     * Nom d'usager
     * @return string
     */
    public function getUsername()
    {

        return $this->username;
    }

    /**
     * Get the [passwd_hash] column value.
     * Mot de passe
     * @return string
     */
    public function getPasswdHash()
    {

        return $this->passwd_hash;
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
     * Get the [is_root] column value.
     * Root
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getIsRoot()
    {
        if (null === $this->is_root) {
            return null;
        }
        $valueSet = AuthyPeer::getValueSet(AuthyPeer::IS_ROOT);
        if (!isset($valueSet[$this->is_root])) {
            throw new PropelException('Unknown stored enum key: ' . $this->is_root);
        }

        return $valueSet[$this->is_root];
    }

    /**
     * Get the [group] column value.
     * Groupe
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getGroup()
    {
        if (null === $this->group) {
            return null;
        }
        $valueSet = AuthyPeer::getValueSet(AuthyPeer::GROUP);
        if (!isset($valueSet[$this->group])) {
            throw new PropelException('Unknown stored enum key: ' . $this->group);
        }

        return $valueSet[$this->group];
    }

    /**
     * Get the [optionally formatted] temporal [expire] column value.
     * Expiration
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getExpire($format = 'Y-m-d')
    {
        if ($this->expire === null) {
            return null;
        }

        if ($this->expire === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->expire);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->expire, true), $x);
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
     * Get the [deactivate] column value.
     * Désactive
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getDeactivate()
    {
        if (null === $this->deactivate) {
            return null;
        }
        $valueSet = AuthyPeer::getValueSet(AuthyPeer::DEACTIVATE);
        if (!isset($valueSet[$this->deactivate])) {
            throw new PropelException('Unknown stored enum key: ' . $this->deactivate);
        }

        return $valueSet[$this->deactivate];
    }

    /**
     * Get the [optionally formatted] temporal [date_requested] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateRequested($format = 'Y-m-d H:i:s')
    {
        if ($this->date_requested === null) {
            return null;
        }

        if ($this->date_requested === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date_requested);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_requested, true), $x);
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
     * Get the [language] column value.
     *
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getLanguage()
    {
        if (null === $this->language) {
            return null;
        }
        $valueSet = AuthyPeer::getValueSet(AuthyPeer::LANGUAGE);
        if (!isset($valueSet[$this->language])) {
            throw new PropelException('Unknown stored enum key: ' . $this->language);
        }

        return $valueSet[$this->language];
    }

    /**
     * Get the [last_poke] column value.
     *
     * @return int
     */
    public function getLastPoke()
    {

        return $this->last_poke;
    }

    /**
     * Get the [last_poke_ip] column value.
     *
     * @return string
     */
    public function getLastPokeIp()
    {

        return $this->last_poke_ip;
    }

    /**
     * Get the [rights] column value.
     * Droits
     * @return string
     */
    public function getRights()
    {

        return $this->rights;
    }

    /**
     * Get the [wbs_public] column value.
     *
     * @return string
     */
    public function getWbsPublic()
    {

        return $this->wbs_public;
    }

    /**
     * Get the [wbs_private] column value.
     *
     * @return string
     */
    public function getWbsPrivate()
    {

        return $this->wbs_private;
    }

    /**
     * Get the [onglet] column value.
     *
     * @return string
     */
    public function getOnglet()
    {

        return $this->onglet;
    }

    /**
     * Get the [passwd_hash_temp] column value.
     *
     * @return string
     */
    public function getPasswdHashTemp()
    {

        return $this->passwd_hash_temp;
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
        $c->addSelectColumn(AuthyPeer::DATE_CREATION);
        try {
            $stmt = AuthyPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(AuthyPeer::DATE_MODIFICATION);
        try {
            $stmt = AuthyPeer::doSelectStmt($c, $con);
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $stmt->closeCursor();
            $this->date_modification = ($row[0] !== null) ? (string) $row[0] : null;
            $this->date_modification_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [date_modification] column on demand.", $e);
        }
    }
    /**
     * Get the [optionally formatted] temporal [passwd_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPasswdDate($format = 'Y-m-d H:i:s', $con = null)
    {
        if (!$this->passwd_date_isLoaded && $this->passwd_date === null && !$this->isNew()) {
            $this->loadPasswdDate($con);
        }

        if ($this->passwd_date === null) {
            return null;
        }

        if ($this->passwd_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->passwd_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->passwd_date, true), $x);
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
     * Load the value for the lazy-loaded [passwd_date] column.
     *
     * This method performs an additional query to return the value for
     * the [passwd_date] column, since it is not populated by
     * the hydrate() method.
     *
     * @param  PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadPasswdDate(PropelPDO $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(AuthyPeer::PASSWD_DATE);
        try {
            $stmt = AuthyPeer::doSelectStmt($c, $con);
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $stmt->closeCursor();
            $this->passwd_date = ($row[0] !== null) ? (string) $row[0] : null;
            $this->passwd_date_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [passwd_date] column on demand.", $e);
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
     * Set the value of [id_authy] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setIdAuthy($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_authy !== $v) {
            $this->id_authy = $v;
            $this->modifiedColumns[] = AuthyPeer::ID_AUTHY;
        }


        return $this;
    } // setIdAuthy()

    /**
     * Set the value of [id_group_creation] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setIdGroupCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_group_creation !== $v) {
            $this->id_group_creation = $v;
            $this->modifiedColumns[] = AuthyPeer::ID_GROUP_CREATION;
        }


        return $this;
    } // setIdGroupCreation()

    /**
     * Set the value of [validation_key] column.
     *
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setValidationKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->validation_key !== $v) {
            $this->validation_key = $v;
            $this->modifiedColumns[] = AuthyPeer::VALIDATION_KEY;
        }


        return $this;
    } // setValidationKey()

    /**
     * Set the value of [username] column.
     * Nom d'usager
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[] = AuthyPeer::USERNAME;
        }


        return $this;
    } // setUsername()

    /**
     * Set the value of [passwd_hash] column.
     * Mot de passe
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setPasswdHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->passwd_hash !== $v) {
            $this->passwd_hash = $v;
            $this->modifiedColumns[] = AuthyPeer::PASSWD_HASH;
        }


        return $this;
    } // setPasswdHash()

    /**
     * Set the value of [email] column.
     * Courriel
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[] = AuthyPeer::EMAIL;
        }


        return $this;
    } // setEmail()

    /**
     * Set the value of [is_root] column.
     * Root
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setIsRoot($v)
    {
        if ($v !== null) {
            $valueSet = AuthyPeer::getValueSet(AuthyPeer::IS_ROOT);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->is_root !== $v) {
            $this->is_root = $v;
            $this->modifiedColumns[] = AuthyPeer::IS_ROOT;
        }


        return $this;
    } // setIsRoot()

    /**
     * Set the value of [group] column.
     * Groupe
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setGroup($v)
    {
        if ($v !== null) {
            $valueSet = AuthyPeer::getValueSet(AuthyPeer::GROUP);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->group !== $v) {
            $this->group = $v;
            $this->modifiedColumns[] = AuthyPeer::GROUP;
        }


        return $this;
    } // setGroup()

    /**
     * Sets the value of [expire] column to a normalized version of the date/time value specified.
     * Expiration
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Authy The current object (for fluent API support)
     */
    public function setExpire($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->expire !== null || $dt !== null) {
            $currentDateAsString = ($this->expire !== null && $tmpDt = new DateTime($this->expire)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->expire = $newDateAsString;
                $this->modifiedColumns[] = AuthyPeer::EXPIRE;
            }
        } // if either are not null


        return $this;
    } // setExpire()

    /**
     * Set the value of [deactivate] column.
     * Désactive
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setDeactivate($v)
    {
        if ($v !== null) {
            $valueSet = AuthyPeer::getValueSet(AuthyPeer::DEACTIVATE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->deactivate !== $v) {
            $this->deactivate = $v;
            $this->modifiedColumns[] = AuthyPeer::DEACTIVATE;
        }


        return $this;
    } // setDeactivate()

    /**
     * Sets the value of [date_requested] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Authy The current object (for fluent API support)
     */
    public function setDateRequested($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_requested !== null || $dt !== null) {
            $currentDateAsString = ($this->date_requested !== null && $tmpDt = new DateTime($this->date_requested)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_requested = $newDateAsString;
                $this->modifiedColumns[] = AuthyPeer::DATE_REQUESTED;
            }
        } // if either are not null


        return $this;
    } // setDateRequested()

    /**
     * Set the value of [language] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setLanguage($v)
    {
        if ($v !== null) {
            $valueSet = AuthyPeer::getValueSet(AuthyPeer::LANGUAGE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->language !== $v) {
            $this->language = $v;
            $this->modifiedColumns[] = AuthyPeer::LANGUAGE;
        }


        return $this;
    } // setLanguage()

    /**
     * Set the value of [last_poke] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setLastPoke($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->last_poke !== $v) {
            $this->last_poke = $v;
            $this->modifiedColumns[] = AuthyPeer::LAST_POKE;
        }


        return $this;
    } // setLastPoke()

    /**
     * Set the value of [last_poke_ip] column.
     *
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setLastPokeIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_poke_ip !== $v) {
            $this->last_poke_ip = $v;
            $this->modifiedColumns[] = AuthyPeer::LAST_POKE_IP;
        }


        return $this;
    } // setLastPokeIp()

    /**
     * Set the value of [rights] column.
     * Droits
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setRights($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rights !== $v) {
            $this->rights = $v;
            $this->modifiedColumns[] = AuthyPeer::RIGHTS;
        }


        return $this;
    } // setRights()

    /**
     * Set the value of [wbs_public] column.
     *
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setWbsPublic($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->wbs_public !== $v) {
            $this->wbs_public = $v;
            $this->modifiedColumns[] = AuthyPeer::WBS_PUBLIC;
        }


        return $this;
    } // setWbsPublic()

    /**
     * Set the value of [wbs_private] column.
     *
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setWbsPrivate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->wbs_private !== $v) {
            $this->wbs_private = $v;
            $this->modifiedColumns[] = AuthyPeer::WBS_PRIVATE;
        }


        return $this;
    } // setWbsPrivate()

    /**
     * Set the value of [onglet] column.
     *
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setOnglet($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->onglet !== $v) {
            $this->onglet = $v;
            $this->modifiedColumns[] = AuthyPeer::ONGLET;
        }


        return $this;
    } // setOnglet()

    /**
     * Set the value of [passwd_hash_temp] column.
     *
     * @param  string $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setPasswdHashTemp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->passwd_hash_temp !== $v) {
            $this->passwd_hash_temp = $v;
            $this->modifiedColumns[] = AuthyPeer::PASSWD_HASH_TEMP;
        }


        return $this;
    } // setPasswdHashTemp()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Authy The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = AuthyPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = AuthyPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Authy The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = AuthyPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = AuthyPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Sets the value of [passwd_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Authy The current object (for fluent API support)
     */
    public function setPasswdDate($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->passwd_date_isLoaded && $v === null) {
            $this->modifiedColumns[] = AuthyPeer::PASSWD_DATE;
        }

        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getPasswdDate() method is called.
        $this->passwd_date_isLoaded = true;

        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->passwd_date !== null || $dt !== null) {
            $currentDateAsString = ($this->passwd_date !== null && $tmpDt = new DateTime($this->passwd_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->passwd_date = $newDateAsString;
                $this->modifiedColumns[] = AuthyPeer::PASSWD_DATE;
            }
        } // if either are not null


        return $this;
    } // setPasswdDate()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = AuthyPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Authy The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = AuthyPeer::ID_MODIFICATION;
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

            $this->id_authy = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_group_creation = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->validation_key = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->username = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->passwd_hash = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->email = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->is_root = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->group = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->expire = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->deactivate = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->date_requested = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->language = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->last_poke = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
            $this->last_poke_ip = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->rights = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->wbs_public = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
            $this->wbs_private = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
            $this->onglet = ($row[$startcol + 17] !== null) ? (string) $row[$startcol + 17] : null;
            $this->passwd_hash_temp = ($row[$startcol + 18] !== null) ? (string) $row[$startcol + 18] : null;
            $this->id_creation = ($row[$startcol + 19] !== null) ? (int) $row[$startcol + 19] : null;
            $this->id_modification = ($row[$startcol + 20] !== null) ? (int) $row[$startcol + 20] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 21; // 21 = AuthyPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Authy object", $e);
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

    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = AuthyPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

        // Reset the passwd_date lazy-load column
        $this->passwd_date = null;
        $this->passwd_date_isLoaded = false;

        if ($deep) {  // also de-associate any related objects?

            $this->collAuthyShortcuts = null;
            $this->collMailsRelatedByIdModification = null;
            $this->collMailsRelatedByIdCreation = null;
            $this->collAccounts = null;
            $this->collAuthyLogs = null;
            $this->collGroupRightAuthys = null;
            $this->collGroupRights = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Authy';}
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
        mem_clean('Authy');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = AuthyQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            if (!$isInsert) {
                // TableStampBehavior behavior
                if ($this->isModified() ) {
                    $this->setDateCreation( $this->getDateCreation() );
                        $this->setDateModification(time());
                        $this->setPasswdDate(time());
                    if(!$this->getIdCreation())
                        $this->setIdCreation( ($_SESSION[_AUTH_VAR]->get('id'))?$_SESSION[_AUTH_VAR]->get('id'):null );
                    if($this->getIdModification() != $_SESSION[_AUTH_VAR]->get('id'))
                        $this->setIdModification( ($_SESSION[_AUTH_VAR]->get('id'))?$_SESSION[_AUTH_VAR]->get('id'):null );

                        mem_clean('Authy');
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

                        mem_clean('Authy');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            AuthyPeer::addInstanceToPool($this);

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

            if ($this->groupRightsScheduledForDeletion !== null) {
                if (!$this->groupRightsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->groupRightsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    GroupRightAuthyQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->groupRightsScheduledForDeletion = null;
                }

                foreach ($this->getGroupRights() as $groupRight) {
                    if ($groupRight->isModified()) {
                        $groupRight->save($con);
                    }
                }
            } elseif ($this->collGroupRights) {
                foreach ($this->collGroupRights as $groupRight) {
                    if ($groupRight->isModified()) {
                        $groupRight->save($con);
                    }
                }
            }

            if ($this->authyShortcutsScheduledForDeletion !== null) {
                if (!$this->authyShortcutsScheduledForDeletion->isEmpty()) {
                    AuthyShortcutQuery::create()
                        ->filterByPrimaryKeys($this->authyShortcutsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->authyShortcutsScheduledForDeletion = null;
                }
            }

            if ($this->collAuthyShortcuts !== null) {
                foreach ($this->collAuthyShortcuts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->mailsRelatedByIdModificationScheduledForDeletion !== null) {
                if (!$this->mailsRelatedByIdModificationScheduledForDeletion->isEmpty()) {
                    foreach ($this->mailsRelatedByIdModificationScheduledForDeletion as $mailRelatedByIdModification) {
                        // need to save related object because we set the relation to null
                        $mailRelatedByIdModification->save($con);
                    }
                    $this->mailsRelatedByIdModificationScheduledForDeletion = null;
                }
            }

            if ($this->collMailsRelatedByIdModification !== null) {
                foreach ($this->collMailsRelatedByIdModification as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->mailsRelatedByIdCreationScheduledForDeletion !== null) {
                if (!$this->mailsRelatedByIdCreationScheduledForDeletion->isEmpty()) {
                    MailQuery::create()
                        ->filterByPrimaryKeys($this->mailsRelatedByIdCreationScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mailsRelatedByIdCreationScheduledForDeletion = null;
                }
            }

            if ($this->collMailsRelatedByIdCreation !== null) {
                foreach ($this->collMailsRelatedByIdCreation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->accountsScheduledForDeletion !== null) {
                if (!$this->accountsScheduledForDeletion->isEmpty()) {
                    AccountQuery::create()
                        ->filterByPrimaryKeys($this->accountsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->accountsScheduledForDeletion = null;
                }
            }

            if ($this->collAccounts !== null) {
                foreach ($this->collAccounts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->authyLogsScheduledForDeletion !== null) {
                if (!$this->authyLogsScheduledForDeletion->isEmpty()) {
                    AuthyLogQuery::create()
                        ->filterByPrimaryKeys($this->authyLogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->authyLogsScheduledForDeletion = null;
                }
            }

            if ($this->collAuthyLogs !== null) {
                foreach ($this->collAuthyLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->groupRightAuthysScheduledForDeletion !== null) {
                if (!$this->groupRightAuthysScheduledForDeletion->isEmpty()) {
                    GroupRightAuthyQuery::create()
                        ->filterByPrimaryKeys($this->groupRightAuthysScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->groupRightAuthysScheduledForDeletion = null;
                }
            }

            if ($this->collGroupRightAuthys !== null) {
                foreach ($this->collGroupRightAuthys as $referrerFK) {
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

        $this->modifiedColumns[] = AuthyPeer::ID_AUTHY;
        if (null !== $this->id_authy) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AuthyPeer::ID_AUTHY . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AuthyPeer::ID_AUTHY)) {
            $modifiedColumns[':p' . $index++]  = '`id_authy`';
        }
        if ($this->isColumnModified(AuthyPeer::ID_GROUP_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_group_creation`';
        }
        if ($this->isColumnModified(AuthyPeer::VALIDATION_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`validation_key`';
        }
        if ($this->isColumnModified(AuthyPeer::USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`username`';
        }
        if ($this->isColumnModified(AuthyPeer::PASSWD_HASH)) {
            $modifiedColumns[':p' . $index++]  = '`passwd_hash`';
        }
        if ($this->isColumnModified(AuthyPeer::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(AuthyPeer::IS_ROOT)) {
            $modifiedColumns[':p' . $index++]  = '`is_root`';
        }
        if ($this->isColumnModified(AuthyPeer::GROUP)) {
            $modifiedColumns[':p' . $index++]  = '`group`';
        }
        if ($this->isColumnModified(AuthyPeer::EXPIRE)) {
            $modifiedColumns[':p' . $index++]  = '`expire`';
        }
        if ($this->isColumnModified(AuthyPeer::DEACTIVATE)) {
            $modifiedColumns[':p' . $index++]  = '`deactivate`';
        }
        if ($this->isColumnModified(AuthyPeer::DATE_REQUESTED)) {
            $modifiedColumns[':p' . $index++]  = '`date_requested`';
        }
        if ($this->isColumnModified(AuthyPeer::LANGUAGE)) {
            $modifiedColumns[':p' . $index++]  = '`language`';
        }
        if ($this->isColumnModified(AuthyPeer::LAST_POKE)) {
            $modifiedColumns[':p' . $index++]  = '`last_poke`';
        }
        if ($this->isColumnModified(AuthyPeer::LAST_POKE_IP)) {
            $modifiedColumns[':p' . $index++]  = '`last_poke_ip`';
        }
        if ($this->isColumnModified(AuthyPeer::RIGHTS)) {
            $modifiedColumns[':p' . $index++]  = '`rights`';
        }
        if ($this->isColumnModified(AuthyPeer::WBS_PUBLIC)) {
            $modifiedColumns[':p' . $index++]  = '`wbs_public`';
        }
        if ($this->isColumnModified(AuthyPeer::WBS_PRIVATE)) {
            $modifiedColumns[':p' . $index++]  = '`wbs_private`';
        }
        if ($this->isColumnModified(AuthyPeer::ONGLET)) {
            $modifiedColumns[':p' . $index++]  = '`onglet`';
        }
        if ($this->isColumnModified(AuthyPeer::PASSWD_HASH_TEMP)) {
            $modifiedColumns[':p' . $index++]  = '`passwd_hash_temp`';
        }
        if ($this->isColumnModified(AuthyPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(AuthyPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(AuthyPeer::PASSWD_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`passwd_date`';
        }
        if ($this->isColumnModified(AuthyPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(AuthyPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `authy` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_authy`':
                        $stmt->bindValue($identifier, $this->id_authy, PDO::PARAM_INT);
                        break;
                    case '`id_group_creation`':
                        $stmt->bindValue($identifier, $this->id_group_creation, PDO::PARAM_INT);
                        break;
                    case '`validation_key`':
                        $stmt->bindValue($identifier, $this->validation_key, PDO::PARAM_STR);
                        break;
                    case '`username`':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case '`passwd_hash`':
                        $stmt->bindValue($identifier, $this->passwd_hash, PDO::PARAM_STR);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`is_root`':
                        $stmt->bindValue($identifier, $this->is_root, PDO::PARAM_INT);
                        break;
                    case '`group`':
                        $stmt->bindValue($identifier, $this->group, PDO::PARAM_INT);
                        break;
                    case '`expire`':
                        $stmt->bindValue($identifier, $this->expire, PDO::PARAM_STR);
                        break;
                    case '`deactivate`':
                        $stmt->bindValue($identifier, $this->deactivate, PDO::PARAM_INT);
                        break;
                    case '`date_requested`':
                        $stmt->bindValue($identifier, $this->date_requested, PDO::PARAM_STR);
                        break;
                    case '`language`':
                        $stmt->bindValue($identifier, $this->language, PDO::PARAM_INT);
                        break;
                    case '`last_poke`':
                        $stmt->bindValue($identifier, $this->last_poke, PDO::PARAM_INT);
                        break;
                    case '`last_poke_ip`':
                        $stmt->bindValue($identifier, $this->last_poke_ip, PDO::PARAM_STR);
                        break;
                    case '`rights`':
                        $stmt->bindValue($identifier, $this->rights, PDO::PARAM_STR);
                        break;
                    case '`wbs_public`':
                        $stmt->bindValue($identifier, $this->wbs_public, PDO::PARAM_STR);
                        break;
                    case '`wbs_private`':
                        $stmt->bindValue($identifier, $this->wbs_private, PDO::PARAM_STR);
                        break;
                    case '`onglet`':
                        $stmt->bindValue($identifier, $this->onglet, PDO::PARAM_STR);
                        break;
                    case '`passwd_hash_temp`':
                        $stmt->bindValue($identifier, $this->passwd_hash_temp, PDO::PARAM_STR);
                        break;
                    case '`date_creation`':
                        $stmt->bindValue($identifier, $this->date_creation, PDO::PARAM_STR);
                        break;
                    case '`date_modification`':
                        $stmt->bindValue($identifier, $this->date_modification, PDO::PARAM_STR);
                        break;
                    case '`passwd_date`':
                        $stmt->bindValue($identifier, $this->passwd_date, PDO::PARAM_STR);
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
        $this->setIdAuthy($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Authy';}
        $needeRight='a';
        if($this->getPrimaryKey()){$needeRight='w';}
        if(!$_SESSION[_AUTH_VAR]->hasRights($_SESSION['CurrentRights'],$needeRight,$this)){
            if(is_array($_SESSION['CurrentRights'])){
                foreach($_SESSION['CurrentRights'] as $Rigths){if($Rigths){$Entite = _($Rigths);}}
            }else{ $Entite = _($_SESSION['CurrentRights']);
            }$failureMap['Rights'] = new ValidationFailed('Rights', _('Droit insuffisant').'<br>'.$Entite.'-'.$needeRight, NULL);
        }

            if (($retval = AuthyPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AuthyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Authy'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Authy'][$this->getPrimaryKey()] = true;
        $keys = AuthyPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdAuthy(),
            $keys[1] => $this->getIdGroupCreation(),
            $keys[2] => $this->getValidationKey(),
            $keys[3] => $this->getUsername(),
            $keys[4] => $this->getPasswdHash(),
            $keys[5] => $this->getEmail(),
            $keys[6] => $this->getIsRoot(),
            $keys[7] => $this->getGroup(),
            $keys[8] => $this->getExpire(),
            $keys[9] => $this->getDeactivate(),
            $keys[10] => $this->getDateRequested(),
            $keys[11] => $this->getLanguage(),
            $keys[12] => $this->getLastPoke(),
            $keys[13] => $this->getLastPokeIp(),
            $keys[14] => $this->getRights(),
            $keys[15] => $this->getWbsPublic(),
            $keys[16] => $this->getWbsPrivate(),
            $keys[17] => $this->getOnglet(),
            $keys[18] => $this->getPasswdHashTemp(),
            $keys[19] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[20] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[21] => ($includeLazyLoadColumns) ? $this->getPasswdDate() : null,
            $keys[22] => $this->getIdCreation(),
            $keys[23] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AuthyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdAuthy($value);
                break;
            case 1:
                $this->setIdGroupCreation($value);
                break;
            case 2:
                $this->setValidationKey($value);
                break;
            case 3:
                $this->setUsername($value);
                break;
            case 4:
                $this->setPasswdHash($value);
                break;
            case 5:
                $this->setEmail($value);
                break;
            case 6:
                $valueSet = AuthyPeer::getValueSet(AuthyPeer::IS_ROOT);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setIsRoot($value);
                break;
            case 7:
                $valueSet = AuthyPeer::getValueSet(AuthyPeer::GROUP);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setGroup($value);
                break;
            case 8:
                $this->setExpire($value);
                break;
            case 9:
                $valueSet = AuthyPeer::getValueSet(AuthyPeer::DEACTIVATE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setDeactivate($value);
                break;
            case 10:
                $this->setDateRequested($value);
                break;
            case 11:
                $valueSet = AuthyPeer::getValueSet(AuthyPeer::LANGUAGE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setLanguage($value);
                break;
            case 12:
                $this->setLastPoke($value);
                break;
            case 13:
                $this->setLastPokeIp($value);
                break;
            case 14:
                $this->setRights($value);
                break;
            case 15:
                $this->setWbsPublic($value);
                break;
            case 16:
                $this->setWbsPrivate($value);
                break;
            case 17:
                $this->setOnglet($value);
                break;
            case 18:
                $this->setPasswdHashTemp($value);
                break;
            case 19:
                $this->setDateCreation($value);
                break;
            case 20:
                $this->setDateModification($value);
                break;
            case 21:
                $this->setPasswdDate($value);
                break;
            case 22:
                $this->setIdCreation($value);
                break;
            case 23:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = AuthyPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdAuthy($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdGroupCreation($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setValidationKey($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setUsername($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPasswdHash($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setEmail($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIsRoot($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setGroup($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setExpire($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setDeactivate($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setDateRequested($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setLanguage($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setLastPoke($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setLastPokeIp($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setRights($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setWbsPublic($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setWbsPrivate($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setOnglet($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setPasswdHashTemp($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setDateCreation($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setDateModification($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setPasswdDate($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setIdCreation($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setIdModification($arr[$keys[23]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(AuthyPeer::DATABASE_NAME);

        if ($this->isColumnModified(AuthyPeer::ID_AUTHY)) $criteria->add(AuthyPeer::ID_AUTHY, $this->id_authy);
        if ($this->isColumnModified(AuthyPeer::ID_GROUP_CREATION)) $criteria->add(AuthyPeer::ID_GROUP_CREATION, $this->id_group_creation);
        if ($this->isColumnModified(AuthyPeer::VALIDATION_KEY)) $criteria->add(AuthyPeer::VALIDATION_KEY, $this->validation_key);
        if ($this->isColumnModified(AuthyPeer::USERNAME)) $criteria->add(AuthyPeer::USERNAME, $this->username);
        if ($this->isColumnModified(AuthyPeer::PASSWD_HASH)) $criteria->add(AuthyPeer::PASSWD_HASH, $this->passwd_hash);
        if ($this->isColumnModified(AuthyPeer::EMAIL)) $criteria->add(AuthyPeer::EMAIL, $this->email);
        if ($this->isColumnModified(AuthyPeer::IS_ROOT)) $criteria->add(AuthyPeer::IS_ROOT, $this->is_root);
        if ($this->isColumnModified(AuthyPeer::GROUP)) $criteria->add(AuthyPeer::GROUP, $this->group);
        if ($this->isColumnModified(AuthyPeer::EXPIRE)) $criteria->add(AuthyPeer::EXPIRE, $this->expire);
        if ($this->isColumnModified(AuthyPeer::DEACTIVATE)) $criteria->add(AuthyPeer::DEACTIVATE, $this->deactivate);
        if ($this->isColumnModified(AuthyPeer::DATE_REQUESTED)) $criteria->add(AuthyPeer::DATE_REQUESTED, $this->date_requested);
        if ($this->isColumnModified(AuthyPeer::LANGUAGE)) $criteria->add(AuthyPeer::LANGUAGE, $this->language);
        if ($this->isColumnModified(AuthyPeer::LAST_POKE)) $criteria->add(AuthyPeer::LAST_POKE, $this->last_poke);
        if ($this->isColumnModified(AuthyPeer::LAST_POKE_IP)) $criteria->add(AuthyPeer::LAST_POKE_IP, $this->last_poke_ip);
        if ($this->isColumnModified(AuthyPeer::RIGHTS)) $criteria->add(AuthyPeer::RIGHTS, $this->rights);
        if ($this->isColumnModified(AuthyPeer::WBS_PUBLIC)) $criteria->add(AuthyPeer::WBS_PUBLIC, $this->wbs_public);
        if ($this->isColumnModified(AuthyPeer::WBS_PRIVATE)) $criteria->add(AuthyPeer::WBS_PRIVATE, $this->wbs_private);
        if ($this->isColumnModified(AuthyPeer::ONGLET)) $criteria->add(AuthyPeer::ONGLET, $this->onglet);
        if ($this->isColumnModified(AuthyPeer::PASSWD_HASH_TEMP)) $criteria->add(AuthyPeer::PASSWD_HASH_TEMP, $this->passwd_hash_temp);
        if ($this->isColumnModified(AuthyPeer::DATE_CREATION)) $criteria->add(AuthyPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(AuthyPeer::DATE_MODIFICATION)) $criteria->add(AuthyPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(AuthyPeer::PASSWD_DATE)) $criteria->add(AuthyPeer::PASSWD_DATE, $this->passwd_date);
        if ($this->isColumnModified(AuthyPeer::ID_CREATION)) $criteria->add(AuthyPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(AuthyPeer::ID_MODIFICATION)) $criteria->add(AuthyPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(AuthyPeer::DATABASE_NAME);
        $criteria->add(AuthyPeer::ID_AUTHY, $this->id_authy);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdAuthy();
    }

    /**
     * Generic method to set the primary key (id_authy column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdAuthy($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdAuthy();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Authy (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdGroupCreation($this->getIdGroupCreation());
        $copyObj->setValidationKey($this->getValidationKey());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPasswdHash($this->getPasswdHash());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setIsRoot($this->getIsRoot());
        $copyObj->setGroup($this->getGroup());
        $copyObj->setExpire($this->getExpire());
        $copyObj->setDeactivate($this->getDeactivate());
        $copyObj->setDateRequested($this->getDateRequested());
        $copyObj->setLanguage($this->getLanguage());
        $copyObj->setLastPoke($this->getLastPoke());
        $copyObj->setLastPokeIp($this->getLastPokeIp());
        $copyObj->setRights($this->getRights());
        $copyObj->setWbsPublic($this->getWbsPublic());
        $copyObj->setWbsPrivate($this->getWbsPrivate());
        $copyObj->setOnglet($this->getOnglet());
        $copyObj->setPasswdHashTemp($this->getPasswdHashTemp());
        $copyObj->setDateCreation($this->getDateCreation());
        $copyObj->setDateModification($this->getDateModification());
        $copyObj->setPasswdDate($this->getPasswdDate());
        $copyObj->setIdCreation($this->getIdCreation());
        $copyObj->setIdModification($this->getIdModification());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdAuthy(NULL); // this is a auto-increment column, so set to default value
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
     * @return Authy Clone of current object.
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
     * @return AuthyPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AuthyPeer();
        }

        return self::$peer;
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
    }

    /**
     * Clears out the collAuthyShortcuts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAuthyShortcuts()
     */
    public function clearAuthyShortcuts()
    {
        $this->collAuthyShortcuts = null; // important to set this to null since that means it is uninitialized
        $this->collAuthyShortcutsPartial = null;

        return $this;
    }

    /**
     * reset is the collAuthyShortcuts collection loaded partially
     *
     * @return void
     */
    public function resetPartialAuthyShortcuts($v = true)
    {
        $this->collAuthyShortcutsPartial = $v;
    }

    /**
     * Initializes the collAuthyShortcuts collection.
     *
     * By default this just sets the collAuthyShortcuts collection to an empty array (like clearcollAuthyShortcuts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuthyShortcuts($overrideExisting = true)
    {
        if (null !== $this->collAuthyShortcuts && !$overrideExisting) {
            return;
        }
        $this->collAuthyShortcuts = new PropelObjectCollection();
        $this->collAuthyShortcuts->setModel('AuthyShortcut');
    }

    /**
     * Gets an array of AuthyShortcut objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AuthyShortcut[] List of AuthyShortcut objects
     * @throws PropelException
     */
    public function getAuthyShortcuts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAuthyShortcutsPartial && !$this->isNew();
        if (null === $this->collAuthyShortcuts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuthyShortcuts) {
                // return empty collection
                $this->initAuthyShortcuts();
            } else {
                $collAuthyShortcuts = AuthyShortcutQuery::create(null, $criteria)
                    ->filterByAuthy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAuthyShortcutsPartial && count($collAuthyShortcuts)) {
                      $this->initAuthyShortcuts(false);

                      foreach ($collAuthyShortcuts as $obj) {
                        if (false == $this->collAuthyShortcuts->contains($obj)) {
                          $this->collAuthyShortcuts->append($obj);
                        }
                      }

                      $this->collAuthyShortcutsPartial = true;
                    }

                    $collAuthyShortcuts->getInternalIterator()->rewind();

                    return $collAuthyShortcuts;
                }

                if ($partial && $this->collAuthyShortcuts) {
                    foreach ($this->collAuthyShortcuts as $obj) {
                        if ($obj->isNew()) {
                            $collAuthyShortcuts[] = $obj;
                        }
                    }
                }

                $this->collAuthyShortcuts = $collAuthyShortcuts;
                $this->collAuthyShortcutsPartial = false;
            }
        }

        return $this->collAuthyShortcuts;
    }

    /**
     * Sets a collection of AuthyShortcut objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $authyShortcuts A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAuthyShortcuts(PropelCollection $authyShortcuts, PropelPDO $con = null)
    {
        $authyShortcutsToDelete = $this->getAuthyShortcuts(new Criteria(), $con)->diff($authyShortcuts);


        $this->authyShortcutsScheduledForDeletion = $authyShortcutsToDelete;

        foreach ($authyShortcutsToDelete as $authyShortcutRemoved) {
            $authyShortcutRemoved->setAuthy(null);
        }

        $this->collAuthyShortcuts = null;
        foreach ($authyShortcuts as $authyShortcut) {
            $this->addAuthyShortcut($authyShortcut);
        }

        $this->collAuthyShortcuts = $authyShortcuts;
        $this->collAuthyShortcutsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AuthyShortcut objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AuthyShortcut objects.
     * @throws PropelException
     */
    public function countAuthyShortcuts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAuthyShortcutsPartial && !$this->isNew();
        if (null === $this->collAuthyShortcuts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthyShortcuts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuthyShortcuts());
            }
            $query = AuthyShortcutQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthy($this)
                ->count($con);
        }

        return count($this->collAuthyShortcuts);
    }

    /**
     * Method called to associate a AuthyShortcut object to this object
     * through the AuthyShortcut foreign key attribute.
     *
     * @param    AuthyShortcut $l AuthyShortcut
     * @return Authy The current object (for fluent API support)
     */
    public function addAuthyShortcut(AuthyShortcut $l)
    {
        if ($this->collAuthyShortcuts === null) {
            $this->initAuthyShortcuts();
            $this->collAuthyShortcutsPartial = true;
        }

        if (!in_array($l, $this->collAuthyShortcuts->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAuthyShortcut($l);

            if ($this->authyShortcutsScheduledForDeletion and $this->authyShortcutsScheduledForDeletion->contains($l)) {
                $this->authyShortcutsScheduledForDeletion->remove($this->authyShortcutsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AuthyShortcut $authyShortcut The authyShortcut object to add.
     */
    protected function doAddAuthyShortcut($authyShortcut)
    {
        $this->collAuthyShortcuts[]= $authyShortcut;
        $authyShortcut->setAuthy($this);
    }

    /**
     * @param	AuthyShortcut $authyShortcut The authyShortcut object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAuthyShortcut($authyShortcut)
    {
        if ($this->getAuthyShortcuts()->contains($authyShortcut)) {
            $this->collAuthyShortcuts->remove($this->collAuthyShortcuts->search($authyShortcut));
            if (null === $this->authyShortcutsScheduledForDeletion) {
                $this->authyShortcutsScheduledForDeletion = clone $this->collAuthyShortcuts;
                $this->authyShortcutsScheduledForDeletion->clear();
            }
            $this->authyShortcutsScheduledForDeletion[]= clone $authyShortcut;
            $authyShortcut->setAuthy(null);
        }

        return $this;
    }

    /**
     * Clears out the collMailsRelatedByIdModification collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addMailsRelatedByIdModification()
     */
    public function clearMailsRelatedByIdModification()
    {
        $this->collMailsRelatedByIdModification = null; // important to set this to null since that means it is uninitialized
        $this->collMailsRelatedByIdModificationPartial = null;

        return $this;
    }

    /**
     * reset is the collMailsRelatedByIdModification collection loaded partially
     *
     * @return void
     */
    public function resetPartialMailsRelatedByIdModification($v = true)
    {
        $this->collMailsRelatedByIdModificationPartial = $v;
    }

    /**
     * Initializes the collMailsRelatedByIdModification collection.
     *
     * By default this just sets the collMailsRelatedByIdModification collection to an empty array (like clearcollMailsRelatedByIdModification());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMailsRelatedByIdModification($overrideExisting = true)
    {
        if (null !== $this->collMailsRelatedByIdModification && !$overrideExisting) {
            return;
        }
        $this->collMailsRelatedByIdModification = new PropelObjectCollection();
        $this->collMailsRelatedByIdModification->setModel('Mail');
    }

    /**
     * Gets an array of Mail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Mail[] List of Mail objects
     * @throws PropelException
     */
    public function getMailsRelatedByIdModification($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMailsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collMailsRelatedByIdModification || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMailsRelatedByIdModification) {
                // return empty collection
                $this->initMailsRelatedByIdModification();
            } else {
                $collMailsRelatedByIdModification = MailQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdModification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMailsRelatedByIdModificationPartial && count($collMailsRelatedByIdModification)) {
                      $this->initMailsRelatedByIdModification(false);

                      foreach ($collMailsRelatedByIdModification as $obj) {
                        if (false == $this->collMailsRelatedByIdModification->contains($obj)) {
                          $this->collMailsRelatedByIdModification->append($obj);
                        }
                      }

                      $this->collMailsRelatedByIdModificationPartial = true;
                    }

                    $collMailsRelatedByIdModification->getInternalIterator()->rewind();

                    return $collMailsRelatedByIdModification;
                }

                if ($partial && $this->collMailsRelatedByIdModification) {
                    foreach ($this->collMailsRelatedByIdModification as $obj) {
                        if ($obj->isNew()) {
                            $collMailsRelatedByIdModification[] = $obj;
                        }
                    }
                }

                $this->collMailsRelatedByIdModification = $collMailsRelatedByIdModification;
                $this->collMailsRelatedByIdModificationPartial = false;
            }
        }

        return $this->collMailsRelatedByIdModification;
    }

    /**
     * Sets a collection of MailRelatedByIdModification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $mailsRelatedByIdModification A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setMailsRelatedByIdModification(PropelCollection $mailsRelatedByIdModification, PropelPDO $con = null)
    {
        $mailsRelatedByIdModificationToDelete = $this->getMailsRelatedByIdModification(new Criteria(), $con)->diff($mailsRelatedByIdModification);


        $this->mailsRelatedByIdModificationScheduledForDeletion = $mailsRelatedByIdModificationToDelete;

        foreach ($mailsRelatedByIdModificationToDelete as $mailRelatedByIdModificationRemoved) {
            $mailRelatedByIdModificationRemoved->setAuthyRelatedByIdModification(null);
        }

        $this->collMailsRelatedByIdModification = null;
        foreach ($mailsRelatedByIdModification as $mailRelatedByIdModification) {
            $this->addMailRelatedByIdModification($mailRelatedByIdModification);
        }

        $this->collMailsRelatedByIdModification = $mailsRelatedByIdModification;
        $this->collMailsRelatedByIdModificationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Mail objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Mail objects.
     * @throws PropelException
     */
    public function countMailsRelatedByIdModification(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMailsRelatedByIdModificationPartial && !$this->isNew();
        if (null === $this->collMailsRelatedByIdModification || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMailsRelatedByIdModification) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMailsRelatedByIdModification());
            }
            $query = MailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdModification($this)
                ->count($con);
        }

        return count($this->collMailsRelatedByIdModification);
    }

    /**
     * Method called to associate a Mail object to this object
     * through the Mail foreign key attribute.
     *
     * @param    Mail $l Mail
     * @return Authy The current object (for fluent API support)
     */
    public function addMailRelatedByIdModification(Mail $l)
    {
        if ($this->collMailsRelatedByIdModification === null) {
            $this->initMailsRelatedByIdModification();
            $this->collMailsRelatedByIdModificationPartial = true;
        }

        if (!in_array($l, $this->collMailsRelatedByIdModification->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMailRelatedByIdModification($l);

            if ($this->mailsRelatedByIdModificationScheduledForDeletion and $this->mailsRelatedByIdModificationScheduledForDeletion->contains($l)) {
                $this->mailsRelatedByIdModificationScheduledForDeletion->remove($this->mailsRelatedByIdModificationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	MailRelatedByIdModification $mailRelatedByIdModification The mailRelatedByIdModification object to add.
     */
    protected function doAddMailRelatedByIdModification($mailRelatedByIdModification)
    {
        $this->collMailsRelatedByIdModification[]= $mailRelatedByIdModification;
        $mailRelatedByIdModification->setAuthyRelatedByIdModification($this);
    }

    /**
     * @param	MailRelatedByIdModification $mailRelatedByIdModification The mailRelatedByIdModification object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeMailRelatedByIdModification($mailRelatedByIdModification)
    {
        if ($this->getMailsRelatedByIdModification()->contains($mailRelatedByIdModification)) {
            $this->collMailsRelatedByIdModification->remove($this->collMailsRelatedByIdModification->search($mailRelatedByIdModification));
            if (null === $this->mailsRelatedByIdModificationScheduledForDeletion) {
                $this->mailsRelatedByIdModificationScheduledForDeletion = clone $this->collMailsRelatedByIdModification;
                $this->mailsRelatedByIdModificationScheduledForDeletion->clear();
            }
            $this->mailsRelatedByIdModificationScheduledForDeletion[]= $mailRelatedByIdModification;
            $mailRelatedByIdModification->setAuthyRelatedByIdModification(null);
        }

        return $this;
    }

    /**
     * Clears out the collMailsRelatedByIdCreation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addMailsRelatedByIdCreation()
     */
    public function clearMailsRelatedByIdCreation()
    {
        $this->collMailsRelatedByIdCreation = null; // important to set this to null since that means it is uninitialized
        $this->collMailsRelatedByIdCreationPartial = null;

        return $this;
    }

    /**
     * reset is the collMailsRelatedByIdCreation collection loaded partially
     *
     * @return void
     */
    public function resetPartialMailsRelatedByIdCreation($v = true)
    {
        $this->collMailsRelatedByIdCreationPartial = $v;
    }

    /**
     * Initializes the collMailsRelatedByIdCreation collection.
     *
     * By default this just sets the collMailsRelatedByIdCreation collection to an empty array (like clearcollMailsRelatedByIdCreation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMailsRelatedByIdCreation($overrideExisting = true)
    {
        if (null !== $this->collMailsRelatedByIdCreation && !$overrideExisting) {
            return;
        }
        $this->collMailsRelatedByIdCreation = new PropelObjectCollection();
        $this->collMailsRelatedByIdCreation->setModel('Mail');
    }

    /**
     * Gets an array of Mail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Mail[] List of Mail objects
     * @throws PropelException
     */
    public function getMailsRelatedByIdCreation($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMailsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collMailsRelatedByIdCreation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMailsRelatedByIdCreation) {
                // return empty collection
                $this->initMailsRelatedByIdCreation();
            } else {
                $collMailsRelatedByIdCreation = MailQuery::create(null, $criteria)
                    ->filterByAuthyRelatedByIdCreation($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMailsRelatedByIdCreationPartial && count($collMailsRelatedByIdCreation)) {
                      $this->initMailsRelatedByIdCreation(false);

                      foreach ($collMailsRelatedByIdCreation as $obj) {
                        if (false == $this->collMailsRelatedByIdCreation->contains($obj)) {
                          $this->collMailsRelatedByIdCreation->append($obj);
                        }
                      }

                      $this->collMailsRelatedByIdCreationPartial = true;
                    }

                    $collMailsRelatedByIdCreation->getInternalIterator()->rewind();

                    return $collMailsRelatedByIdCreation;
                }

                if ($partial && $this->collMailsRelatedByIdCreation) {
                    foreach ($this->collMailsRelatedByIdCreation as $obj) {
                        if ($obj->isNew()) {
                            $collMailsRelatedByIdCreation[] = $obj;
                        }
                    }
                }

                $this->collMailsRelatedByIdCreation = $collMailsRelatedByIdCreation;
                $this->collMailsRelatedByIdCreationPartial = false;
            }
        }

        return $this->collMailsRelatedByIdCreation;
    }

    /**
     * Sets a collection of MailRelatedByIdCreation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $mailsRelatedByIdCreation A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setMailsRelatedByIdCreation(PropelCollection $mailsRelatedByIdCreation, PropelPDO $con = null)
    {
        $mailsRelatedByIdCreationToDelete = $this->getMailsRelatedByIdCreation(new Criteria(), $con)->diff($mailsRelatedByIdCreation);


        $this->mailsRelatedByIdCreationScheduledForDeletion = $mailsRelatedByIdCreationToDelete;

        foreach ($mailsRelatedByIdCreationToDelete as $mailRelatedByIdCreationRemoved) {
            $mailRelatedByIdCreationRemoved->setAuthyRelatedByIdCreation(null);
        }

        $this->collMailsRelatedByIdCreation = null;
        foreach ($mailsRelatedByIdCreation as $mailRelatedByIdCreation) {
            $this->addMailRelatedByIdCreation($mailRelatedByIdCreation);
        }

        $this->collMailsRelatedByIdCreation = $mailsRelatedByIdCreation;
        $this->collMailsRelatedByIdCreationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Mail objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Mail objects.
     * @throws PropelException
     */
    public function countMailsRelatedByIdCreation(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMailsRelatedByIdCreationPartial && !$this->isNew();
        if (null === $this->collMailsRelatedByIdCreation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMailsRelatedByIdCreation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMailsRelatedByIdCreation());
            }
            $query = MailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthyRelatedByIdCreation($this)
                ->count($con);
        }

        return count($this->collMailsRelatedByIdCreation);
    }

    /**
     * Method called to associate a Mail object to this object
     * through the Mail foreign key attribute.
     *
     * @param    Mail $l Mail
     * @return Authy The current object (for fluent API support)
     */
    public function addMailRelatedByIdCreation(Mail $l)
    {
        if ($this->collMailsRelatedByIdCreation === null) {
            $this->initMailsRelatedByIdCreation();
            $this->collMailsRelatedByIdCreationPartial = true;
        }

        if (!in_array($l, $this->collMailsRelatedByIdCreation->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMailRelatedByIdCreation($l);

            if ($this->mailsRelatedByIdCreationScheduledForDeletion and $this->mailsRelatedByIdCreationScheduledForDeletion->contains($l)) {
                $this->mailsRelatedByIdCreationScheduledForDeletion->remove($this->mailsRelatedByIdCreationScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	MailRelatedByIdCreation $mailRelatedByIdCreation The mailRelatedByIdCreation object to add.
     */
    protected function doAddMailRelatedByIdCreation($mailRelatedByIdCreation)
    {
        $this->collMailsRelatedByIdCreation[]= $mailRelatedByIdCreation;
        $mailRelatedByIdCreation->setAuthyRelatedByIdCreation($this);
    }

    /**
     * @param	MailRelatedByIdCreation $mailRelatedByIdCreation The mailRelatedByIdCreation object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeMailRelatedByIdCreation($mailRelatedByIdCreation)
    {
        if ($this->getMailsRelatedByIdCreation()->contains($mailRelatedByIdCreation)) {
            $this->collMailsRelatedByIdCreation->remove($this->collMailsRelatedByIdCreation->search($mailRelatedByIdCreation));
            if (null === $this->mailsRelatedByIdCreationScheduledForDeletion) {
                $this->mailsRelatedByIdCreationScheduledForDeletion = clone $this->collMailsRelatedByIdCreation;
                $this->mailsRelatedByIdCreationScheduledForDeletion->clear();
            }
            $this->mailsRelatedByIdCreationScheduledForDeletion[]= clone $mailRelatedByIdCreation;
            $mailRelatedByIdCreation->setAuthyRelatedByIdCreation(null);
        }

        return $this;
    }

    /**
     * Clears out the collAccounts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAccounts()
     */
    public function clearAccounts()
    {
        $this->collAccounts = null; // important to set this to null since that means it is uninitialized
        $this->collAccountsPartial = null;

        return $this;
    }

    /**
     * reset is the collAccounts collection loaded partially
     *
     * @return void
     */
    public function resetPartialAccounts($v = true)
    {
        $this->collAccountsPartial = $v;
    }

    /**
     * Initializes the collAccounts collection.
     *
     * By default this just sets the collAccounts collection to an empty array (like clearcollAccounts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccounts($overrideExisting = true)
    {
        if (null !== $this->collAccounts && !$overrideExisting) {
            return;
        }
        $this->collAccounts = new PropelObjectCollection();
        $this->collAccounts->setModel('Account');
    }

    /**
     * Gets an array of Account objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Account[] List of Account objects
     * @throws PropelException
     */
    public function getAccounts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAccountsPartial && !$this->isNew();
        if (null === $this->collAccounts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccounts) {
                // return empty collection
                $this->initAccounts();
            } else {
                $collAccounts = AccountQuery::create(null, $criteria)
                    ->filterByAuthy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAccountsPartial && count($collAccounts)) {
                      $this->initAccounts(false);

                      foreach ($collAccounts as $obj) {
                        if (false == $this->collAccounts->contains($obj)) {
                          $this->collAccounts->append($obj);
                        }
                      }

                      $this->collAccountsPartial = true;
                    }

                    $collAccounts->getInternalIterator()->rewind();

                    return $collAccounts;
                }

                if ($partial && $this->collAccounts) {
                    foreach ($this->collAccounts as $obj) {
                        if ($obj->isNew()) {
                            $collAccounts[] = $obj;
                        }
                    }
                }

                $this->collAccounts = $collAccounts;
                $this->collAccountsPartial = false;
            }
        }

        return $this->collAccounts;
    }

    /**
     * Sets a collection of Account objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $accounts A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAccounts(PropelCollection $accounts, PropelPDO $con = null)
    {
        $accountsToDelete = $this->getAccounts(new Criteria(), $con)->diff($accounts);


        $this->accountsScheduledForDeletion = $accountsToDelete;

        foreach ($accountsToDelete as $accountRemoved) {
            $accountRemoved->setAuthy(null);
        }

        $this->collAccounts = null;
        foreach ($accounts as $account) {
            $this->addAccount($account);
        }

        $this->collAccounts = $accounts;
        $this->collAccountsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Account objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Account objects.
     * @throws PropelException
     */
    public function countAccounts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAccountsPartial && !$this->isNew();
        if (null === $this->collAccounts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccounts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccounts());
            }
            $query = AccountQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthy($this)
                ->count($con);
        }

        return count($this->collAccounts);
    }

    /**
     * Method called to associate a Account object to this object
     * through the Account foreign key attribute.
     *
     * @param    Account $l Account
     * @return Authy The current object (for fluent API support)
     */
    public function addAccount(Account $l)
    {
        if ($this->collAccounts === null) {
            $this->initAccounts();
            $this->collAccountsPartial = true;
        }

        if (!in_array($l, $this->collAccounts->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAccount($l);

            if ($this->accountsScheduledForDeletion and $this->accountsScheduledForDeletion->contains($l)) {
                $this->accountsScheduledForDeletion->remove($this->accountsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Account $account The account object to add.
     */
    protected function doAddAccount($account)
    {
        $this->collAccounts[]= $account;
        $account->setAuthy($this);
    }

    /**
     * @param	Account $account The account object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAccount($account)
    {
        if ($this->getAccounts()->contains($account)) {
            $this->collAccounts->remove($this->collAccounts->search($account));
            if (null === $this->accountsScheduledForDeletion) {
                $this->accountsScheduledForDeletion = clone $this->collAccounts;
                $this->accountsScheduledForDeletion->clear();
            }
            $this->accountsScheduledForDeletion[]= clone $account;
            $account->setAuthy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Authy is new, it will return
     * an empty collection; or if this Authy has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Authy.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Account[] List of Account objects
     */
    public function getAccountsJoinVille($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AccountQuery::create(null, $criteria);
        $query->joinWith('Ville', $join_behavior);

        return $this->getAccounts($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Authy is new, it will return
     * an empty collection; or if this Authy has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Authy.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Account[] List of Account objects
     */
    public function getAccountsJoinRegion($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AccountQuery::create(null, $criteria);
        $query->joinWith('Region', $join_behavior);

        return $this->getAccounts($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Authy is new, it will return
     * an empty collection; or if this Authy has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Authy.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Account[] List of Account objects
     */
    public function getAccountsJoinProvince($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AccountQuery::create(null, $criteria);
        $query->joinWith('Province', $join_behavior);

        return $this->getAccounts($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Authy is new, it will return
     * an empty collection; or if this Authy has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Authy.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Account[] List of Account objects
     */
    public function getAccountsJoinPays($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AccountQuery::create(null, $criteria);
        $query->joinWith('Pays', $join_behavior);

        return $this->getAccounts($query, $con);
    }

    /**
     * Clears out the collAuthyLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addAuthyLogs()
     */
    public function clearAuthyLogs()
    {
        $this->collAuthyLogs = null; // important to set this to null since that means it is uninitialized
        $this->collAuthyLogsPartial = null;

        return $this;
    }

    /**
     * reset is the collAuthyLogs collection loaded partially
     *
     * @return void
     */
    public function resetPartialAuthyLogs($v = true)
    {
        $this->collAuthyLogsPartial = $v;
    }

    /**
     * Initializes the collAuthyLogs collection.
     *
     * By default this just sets the collAuthyLogs collection to an empty array (like clearcollAuthyLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuthyLogs($overrideExisting = true)
    {
        if (null !== $this->collAuthyLogs && !$overrideExisting) {
            return;
        }
        $this->collAuthyLogs = new PropelObjectCollection();
        $this->collAuthyLogs->setModel('AuthyLog');
    }

    /**
     * Gets an array of AuthyLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AuthyLog[] List of AuthyLog objects
     * @throws PropelException
     */
    public function getAuthyLogs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAuthyLogsPartial && !$this->isNew();
        if (null === $this->collAuthyLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuthyLogs) {
                // return empty collection
                $this->initAuthyLogs();
            } else {
                $collAuthyLogs = AuthyLogQuery::create(null, $criteria)
                    ->filterByAuthy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAuthyLogsPartial && count($collAuthyLogs)) {
                      $this->initAuthyLogs(false);

                      foreach ($collAuthyLogs as $obj) {
                        if (false == $this->collAuthyLogs->contains($obj)) {
                          $this->collAuthyLogs->append($obj);
                        }
                      }

                      $this->collAuthyLogsPartial = true;
                    }

                    $collAuthyLogs->getInternalIterator()->rewind();

                    return $collAuthyLogs;
                }

                if ($partial && $this->collAuthyLogs) {
                    foreach ($this->collAuthyLogs as $obj) {
                        if ($obj->isNew()) {
                            $collAuthyLogs[] = $obj;
                        }
                    }
                }

                $this->collAuthyLogs = $collAuthyLogs;
                $this->collAuthyLogsPartial = false;
            }
        }

        return $this->collAuthyLogs;
    }

    /**
     * Sets a collection of AuthyLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $authyLogs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setAuthyLogs(PropelCollection $authyLogs, PropelPDO $con = null)
    {
        $authyLogsToDelete = $this->getAuthyLogs(new Criteria(), $con)->diff($authyLogs);


        $this->authyLogsScheduledForDeletion = $authyLogsToDelete;

        foreach ($authyLogsToDelete as $authyLogRemoved) {
            $authyLogRemoved->setAuthy(null);
        }

        $this->collAuthyLogs = null;
        foreach ($authyLogs as $authyLog) {
            $this->addAuthyLog($authyLog);
        }

        $this->collAuthyLogs = $authyLogs;
        $this->collAuthyLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AuthyLog objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AuthyLog objects.
     * @throws PropelException
     */
    public function countAuthyLogs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAuthyLogsPartial && !$this->isNew();
        if (null === $this->collAuthyLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthyLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuthyLogs());
            }
            $query = AuthyLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthy($this)
                ->count($con);
        }

        return count($this->collAuthyLogs);
    }

    /**
     * Method called to associate a AuthyLog object to this object
     * through the AuthyLog foreign key attribute.
     *
     * @param    AuthyLog $l AuthyLog
     * @return Authy The current object (for fluent API support)
     */
    public function addAuthyLog(AuthyLog $l)
    {
        if ($this->collAuthyLogs === null) {
            $this->initAuthyLogs();
            $this->collAuthyLogsPartial = true;
        }

        if (!in_array($l, $this->collAuthyLogs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAuthyLog($l);

            if ($this->authyLogsScheduledForDeletion and $this->authyLogsScheduledForDeletion->contains($l)) {
                $this->authyLogsScheduledForDeletion->remove($this->authyLogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AuthyLog $authyLog The authyLog object to add.
     */
    protected function doAddAuthyLog($authyLog)
    {
        $this->collAuthyLogs[]= $authyLog;
        $authyLog->setAuthy($this);
    }

    /**
     * @param	AuthyLog $authyLog The authyLog object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeAuthyLog($authyLog)
    {
        if ($this->getAuthyLogs()->contains($authyLog)) {
            $this->collAuthyLogs->remove($this->collAuthyLogs->search($authyLog));
            if (null === $this->authyLogsScheduledForDeletion) {
                $this->authyLogsScheduledForDeletion = clone $this->collAuthyLogs;
                $this->authyLogsScheduledForDeletion->clear();
            }
            $this->authyLogsScheduledForDeletion[]= $authyLog;
            $authyLog->setAuthy(null);
        }

        return $this;
    }

    /**
     * Clears out the collGroupRightAuthys collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addGroupRightAuthys()
     */
    public function clearGroupRightAuthys()
    {
        $this->collGroupRightAuthys = null; // important to set this to null since that means it is uninitialized
        $this->collGroupRightAuthysPartial = null;

        return $this;
    }

    /**
     * reset is the collGroupRightAuthys collection loaded partially
     *
     * @return void
     */
    public function resetPartialGroupRightAuthys($v = true)
    {
        $this->collGroupRightAuthysPartial = $v;
    }

    /**
     * Initializes the collGroupRightAuthys collection.
     *
     * By default this just sets the collGroupRightAuthys collection to an empty array (like clearcollGroupRightAuthys());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGroupRightAuthys($overrideExisting = true)
    {
        if (null !== $this->collGroupRightAuthys && !$overrideExisting) {
            return;
        }
        $this->collGroupRightAuthys = new PropelObjectCollection();
        $this->collGroupRightAuthys->setModel('GroupRightAuthy');
    }

    /**
     * Gets an array of GroupRightAuthy objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|GroupRightAuthy[] List of GroupRightAuthy objects
     * @throws PropelException
     */
    public function getGroupRightAuthys($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collGroupRightAuthysPartial && !$this->isNew();
        if (null === $this->collGroupRightAuthys || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGroupRightAuthys) {
                // return empty collection
                $this->initGroupRightAuthys();
            } else {
                $collGroupRightAuthys = GroupRightAuthyQuery::create(null, $criteria)
                    ->filterByAuthy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collGroupRightAuthysPartial && count($collGroupRightAuthys)) {
                      $this->initGroupRightAuthys(false);

                      foreach ($collGroupRightAuthys as $obj) {
                        if (false == $this->collGroupRightAuthys->contains($obj)) {
                          $this->collGroupRightAuthys->append($obj);
                        }
                      }

                      $this->collGroupRightAuthysPartial = true;
                    }

                    $collGroupRightAuthys->getInternalIterator()->rewind();

                    return $collGroupRightAuthys;
                }

                if ($partial && $this->collGroupRightAuthys) {
                    foreach ($this->collGroupRightAuthys as $obj) {
                        if ($obj->isNew()) {
                            $collGroupRightAuthys[] = $obj;
                        }
                    }
                }

                $this->collGroupRightAuthys = $collGroupRightAuthys;
                $this->collGroupRightAuthysPartial = false;
            }
        }

        return $this->collGroupRightAuthys;
    }

    /**
     * Sets a collection of GroupRightAuthy objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $groupRightAuthys A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setGroupRightAuthys(PropelCollection $groupRightAuthys, PropelPDO $con = null)
    {
        $groupRightAuthysToDelete = $this->getGroupRightAuthys(new Criteria(), $con)->diff($groupRightAuthys);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->groupRightAuthysScheduledForDeletion = clone $groupRightAuthysToDelete;

        foreach ($groupRightAuthysToDelete as $groupRightAuthyRemoved) {
            $groupRightAuthyRemoved->setAuthy(null);
        }

        $this->collGroupRightAuthys = null;
        foreach ($groupRightAuthys as $groupRightAuthy) {
            $this->addGroupRightAuthy($groupRightAuthy);
        }

        $this->collGroupRightAuthys = $groupRightAuthys;
        $this->collGroupRightAuthysPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GroupRightAuthy objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related GroupRightAuthy objects.
     * @throws PropelException
     */
    public function countGroupRightAuthys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collGroupRightAuthysPartial && !$this->isNew();
        if (null === $this->collGroupRightAuthys || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGroupRightAuthys) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGroupRightAuthys());
            }
            $query = GroupRightAuthyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthy($this)
                ->count($con);
        }

        return count($this->collGroupRightAuthys);
    }

    /**
     * Method called to associate a GroupRightAuthy object to this object
     * through the GroupRightAuthy foreign key attribute.
     *
     * @param    GroupRightAuthy $l GroupRightAuthy
     * @return Authy The current object (for fluent API support)
     */
    public function addGroupRightAuthy(GroupRightAuthy $l)
    {
        if ($this->collGroupRightAuthys === null) {
            $this->initGroupRightAuthys();
            $this->collGroupRightAuthysPartial = true;
        }

        if (!in_array($l, $this->collGroupRightAuthys->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddGroupRightAuthy($l);

            if ($this->groupRightAuthysScheduledForDeletion and $this->groupRightAuthysScheduledForDeletion->contains($l)) {
                $this->groupRightAuthysScheduledForDeletion->remove($this->groupRightAuthysScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	GroupRightAuthy $groupRightAuthy The groupRightAuthy object to add.
     */
    protected function doAddGroupRightAuthy($groupRightAuthy)
    {
        $this->collGroupRightAuthys[]= $groupRightAuthy;
        $groupRightAuthy->setAuthy($this);
    }

    /**
     * @param	GroupRightAuthy $groupRightAuthy The groupRightAuthy object to remove.
     * @return Authy The current object (for fluent API support)
     */
    public function removeGroupRightAuthy($groupRightAuthy)
    {
        if ($this->getGroupRightAuthys()->contains($groupRightAuthy)) {
            $this->collGroupRightAuthys->remove($this->collGroupRightAuthys->search($groupRightAuthy));
            if (null === $this->groupRightAuthysScheduledForDeletion) {
                $this->groupRightAuthysScheduledForDeletion = clone $this->collGroupRightAuthys;
                $this->groupRightAuthysScheduledForDeletion->clear();
            }
            $this->groupRightAuthysScheduledForDeletion[]= clone $groupRightAuthy;
            $groupRightAuthy->setAuthy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Authy is new, it will return
     * an empty collection; or if this Authy has previously
     * been saved, it will retrieve related GroupRightAuthys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Authy.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|GroupRightAuthy[] List of GroupRightAuthy objects
     */
    public function getGroupRightAuthysJoinGroupRight($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = GroupRightAuthyQuery::create(null, $criteria);
        $query->joinWith('GroupRight', $join_behavior);

        return $this->getGroupRightAuthys($query, $con);
    }

    /**
     * Clears out the collGroupRights collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Authy The current object (for fluent API support)
     * @see        addGroupRights()
     */
    public function clearGroupRights()
    {
        $this->collGroupRights = null; // important to set this to null since that means it is uninitialized
        $this->collGroupRightsPartial = null;

        return $this;
    }

    /**
     * Initializes the collGroupRights collection.
     *
     * By default this just sets the collGroupRights collection to an empty collection (like clearGroupRights());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initGroupRights()
    {
        $this->collGroupRights = new PropelObjectCollection();
        $this->collGroupRights->setModel('GroupRight');
    }

    /**
     * Gets a collection of GroupRight objects related by a many-to-many relationship
     * to the current object by way of the group_right_authy cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Authy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|GroupRight[] List of GroupRight objects
     */
    public function getGroupRights($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collGroupRights || null !== $criteria) {
            if ($this->isNew() && null === $this->collGroupRights) {
                // return empty collection
                $this->initGroupRights();
            } else {
                $collGroupRights = GroupRightQuery::create(null, $criteria)
                    ->filterByAuthy($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collGroupRights;
                }
                $this->collGroupRights = $collGroupRights;
            }
        }

        return $this->collGroupRights;
    }

    /**
     * Sets a collection of GroupRight objects related by a many-to-many relationship
     * to the current object by way of the group_right_authy cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $groupRights A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Authy The current object (for fluent API support)
     */
    public function setGroupRights(PropelCollection $groupRights, PropelPDO $con = null)
    {
        $this->clearGroupRights();
        $currentGroupRights = $this->getGroupRights(null, $con);

        $this->groupRightsScheduledForDeletion = $currentGroupRights->diff($groupRights);

        foreach ($groupRights as $groupRight) {
            if (!$currentGroupRights->contains($groupRight)) {
                $this->doAddGroupRight($groupRight);
            }
        }

        $this->collGroupRights = $groupRights;

        return $this;
    }

    /**
     * Gets the number of GroupRight objects related by a many-to-many relationship
     * to the current object by way of the group_right_authy cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related GroupRight objects
     */
    public function countGroupRights($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collGroupRights || null !== $criteria) {
            if ($this->isNew() && null === $this->collGroupRights) {
                return 0;
            } else {
                $query = GroupRightQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByAuthy($this)
                    ->count($con);
            }
        } else {
            return count($this->collGroupRights);
        }
    }

    /**
     * Associate a GroupRight object to this object
     * through the group_right_authy cross reference table.
     *
     * @param  GroupRight $groupRight The GroupRightAuthy object to relate
     * @return Authy The current object (for fluent API support)
     */
    public function addGroupRight(GroupRight $groupRight)
    {
        if ($this->collGroupRights === null) {
            $this->initGroupRights();
        }

        if (!$this->collGroupRights->contains($groupRight)) { // only add it if the **same** object is not already associated
            $this->doAddGroupRight($groupRight);
            $this->collGroupRights[] = $groupRight;

            if ($this->groupRightsScheduledForDeletion and $this->groupRightsScheduledForDeletion->contains($groupRight)) {
                $this->groupRightsScheduledForDeletion->remove($this->groupRightsScheduledForDeletion->search($groupRight));
            }
        }

        return $this;
    }

    /**
     * @param	GroupRight $groupRight The groupRight object to add.
     */
    protected function doAddGroupRight(GroupRight $groupRight)
    {
        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$groupRight->getAuthys()->contains($this)) { $groupRightAuthy = new GroupRightAuthy();
            $groupRightAuthy->setGroupRight($groupRight);
            $this->addGroupRightAuthy($groupRightAuthy);

            $foreignCollection = $groupRight->getAuthys();
            $foreignCollection[] = $this;
        }
    }

    /**
     * Remove a GroupRight object to this object
     * through the group_right_authy cross reference table.
     *
     * @param GroupRight $groupRight The GroupRightAuthy object to relate
     * @return Authy The current object (for fluent API support)
     */
    public function removeGroupRight(GroupRight $groupRight)
    {
        if ($this->getGroupRights()->contains($groupRight)) {
            $this->collGroupRights->remove($this->collGroupRights->search($groupRight));
            if (null === $this->groupRightsScheduledForDeletion) {
                $this->groupRightsScheduledForDeletion = clone $this->collGroupRights;
                $this->groupRightsScheduledForDeletion->clear();
            }
            $this->groupRightsScheduledForDeletion[]= $groupRight;
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_authy = null;
        $this->id_group_creation = null;
        $this->validation_key = null;
        $this->username = null;
        $this->passwd_hash = null;
        $this->email = null;
        $this->is_root = null;
        $this->group = null;
        $this->expire = null;
        $this->deactivate = null;
        $this->date_requested = null;
        $this->language = null;
        $this->last_poke = null;
        $this->last_poke_ip = null;
        $this->rights = null;
        $this->wbs_public = null;
        $this->wbs_private = null;
        $this->onglet = null;
        $this->passwd_hash_temp = null;
        $this->date_creation = null;
        $this->date_creation_isLoaded = false;
        $this->date_modification = null;
        $this->date_modification_isLoaded = false;
        $this->passwd_date = null;
        $this->passwd_date_isLoaded = false;
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

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AuthyPeer::DEFAULT_STRING_FORMAT);
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
     * @return     Authy The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = AuthyPeer::DATE_MODIFICATION;
        return $this;
    }

}
