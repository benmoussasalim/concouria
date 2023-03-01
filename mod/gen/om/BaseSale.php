<?php


/**
 * Base class that represents a row from the 'sale' table.
 *
 * Abonnement
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseSale extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'SalePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        SalePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_sale field.
     * @var        int
     */
    protected $id_sale;

    /**
     * The value for the id_account field.
     * @var        int
     */
    protected $id_account;

    /**
     * The value for the date field.
     * @var        string
     */
    protected $date;

    /**
     * The value for the statut field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $statut;

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
     * @var        Account
     */
    protected $aAccount;

    /**
     * @var        PropelObjectCollection|Abonnement[] Collection to store aggregation of Abonnement objects.
     */
    protected $collAbonnements;
    protected $collAbonnementsPartial;

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
    protected $abonnementsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->statut = 0;
    }

    /**
     * Initializes internal state of BaseSale object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id_sale] column value.
     *
     * @return int
     */
    public function getIdSale()
    {

        return $this->id_sale;
    }

    /**
     * Get the [id_account] column value.
     * Compte
     * @return int
     */
    public function getIdAccount()
    {

        return $this->id_account;
    }

    /**
     * Get the [optionally formatted] temporal [date] column value.
     * Date de création
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDate($format = 'Y-m-d H:i:s')
    {
        if ($this->date === null) {
            return null;
        }

        if ($this->date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date, true), $x);
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
     * Get the [statut] column value.
     * Statut
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getStatut()
    {
        if (null === $this->statut) {
            return null;
        }
        $valueSet = SalePeer::getValueSet(SalePeer::STATUT);
        if (!isset($valueSet[$this->statut])) {
            throw new PropelException('Unknown stored enum key: ' . $this->statut);
        }

        return $valueSet[$this->statut];
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
        $c->addSelectColumn(SalePeer::DATE_CREATION);
        try {
            $stmt = SalePeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(SalePeer::DATE_MODIFICATION);
        try {
            $stmt = SalePeer::doSelectStmt($c, $con);
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
     * Set the value of [id_sale] column.
     *
     * @param  int $v new value
     * @return Sale The current object (for fluent API support)
     */
    public function setIdSale($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_sale !== $v) {
            $this->id_sale = $v;
            $this->modifiedColumns[] = SalePeer::ID_SALE;
        }


        return $this;
    } // setIdSale()

    /**
     * Set the value of [id_account] column.
     * Compte
     * @param  int $v new value
     * @return Sale The current object (for fluent API support)
     */
    public function setIdAccount($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_account !== $v) {
            $this->id_account = $v;
            $this->modifiedColumns[] = SalePeer::ID_ACCOUNT;
        }

        if ($this->aAccount !== null && $this->aAccount->getIdAccount() !== $v) {
            $this->aAccount = null;
        }


        return $this;
    } // setIdAccount()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     * Date de création
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Sale The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date !== null || $dt !== null) {
            $currentDateAsString = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date = $newDateAsString;
                $this->modifiedColumns[] = SalePeer::DATE;
            }
        } // if either are not null


        return $this;
    } // setDate()

    /**
     * Set the value of [statut] column.
     * Statut
     * @param  int $v new value
     * @return Sale The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setStatut($v)
    {
        if ($v !== null) {
            $valueSet = SalePeer::getValueSet(SalePeer::STATUT);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->statut !== $v) {
            $this->statut = $v;
            $this->modifiedColumns[] = SalePeer::STATUT;
        }


        return $this;
    } // setStatut()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Sale The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = SalePeer::DATE_CREATION;
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
                $this->modifiedColumns[] = SalePeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Sale The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = SalePeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = SalePeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Sale The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = SalePeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Sale The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = SalePeer::ID_MODIFICATION;
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
            if ($this->statut !== 0) {
                return false;
            }

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

            $this->id_sale = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_account = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->date = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->statut = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->id_creation = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->id_modification = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 6; // 6 = SalePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Sale object", $e);
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

        if ($this->aAccount !== null && $this->id_account !== $this->aAccount->getIdAccount()) {
            $this->aAccount = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(SalePeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = SalePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->aAccount = null;
            $this->collAbonnements = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Sale';}
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
        mem_clean('Sale');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(SalePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = SaleQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(SalePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Sale');
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

                        mem_clean('Sale');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            SalePeer::addInstanceToPool($this);

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

            if ($this->aAccount !== null) {
                if ($this->aAccount->isModified() || $this->aAccount->isNew()) {
                    $affectedRows += $this->aAccount->save($con);
                }
                $this->setAccount($this->aAccount);
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

            if ($this->abonnementsScheduledForDeletion !== null) {
                if (!$this->abonnementsScheduledForDeletion->isEmpty()) {
                    AbonnementQuery::create()
                        ->filterByPrimaryKeys($this->abonnementsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->abonnementsScheduledForDeletion = null;
                }
            }

            if ($this->collAbonnements !== null) {
                foreach ($this->collAbonnements as $referrerFK) {
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

        $this->modifiedColumns[] = SalePeer::ID_SALE;
        if (null !== $this->id_sale) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SalePeer::ID_SALE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SalePeer::ID_SALE)) {
            $modifiedColumns[':p' . $index++]  = '`id_sale`';
        }
        if ($this->isColumnModified(SalePeer::ID_ACCOUNT)) {
            $modifiedColumns[':p' . $index++]  = '`id_account`';
        }
        if ($this->isColumnModified(SalePeer::DATE)) {
            $modifiedColumns[':p' . $index++]  = '`date`';
        }
        if ($this->isColumnModified(SalePeer::STATUT)) {
            $modifiedColumns[':p' . $index++]  = '`statut`';
        }
        if ($this->isColumnModified(SalePeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(SalePeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(SalePeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(SalePeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `sale` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_sale`':
                        $stmt->bindValue($identifier, $this->id_sale, PDO::PARAM_INT);
                        break;
                    case '`id_account`':
                        $stmt->bindValue($identifier, $this->id_account, PDO::PARAM_INT);
                        break;
                    case '`date`':
                        $stmt->bindValue($identifier, $this->date, PDO::PARAM_STR);
                        break;
                    case '`statut`':
                        $stmt->bindValue($identifier, $this->statut, PDO::PARAM_INT);
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
        $this->setIdSale($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Sale';}
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

            if ($this->aAccount !== null) {
                if (!$this->aAccount->validate($columns)) {$failureMap = array_merge($failureMap, $this->aAccount->getValidationFailures()); }
            }

            if (($retval = SalePeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collAbonnements !== null) {
                    foreach ($this->collAbonnements as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = SalePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Sale'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Sale'][$this->getPrimaryKey()] = true;
        $keys = SalePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdSale(),
            $keys[1] => $this->getIdAccount(),
            $keys[2] => $this->getDate(),
            $keys[3] => $this->getStatut(),
            $keys[4] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[5] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[6] => $this->getIdCreation(),
            $keys[7] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAccount) {
                $result['Account'] = $this->aAccount->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAbonnements) {
                $result['Abonnements'] = $this->collAbonnements->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = SalePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdSale($value);
                break;
            case 1:
                $this->setIdAccount($value);
                break;
            case 2:
                $this->setDate($value);
                break;
            case 3:
                $valueSet = SalePeer::getValueSet(SalePeer::STATUT);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setStatut($value);
                break;
            case 4:
                $this->setDateCreation($value);
                break;
            case 5:
                $this->setDateModification($value);
                break;
            case 6:
                $this->setIdCreation($value);
                break;
            case 7:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = SalePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdSale($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdAccount($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDate($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setStatut($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDateCreation($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDateModification($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIdCreation($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setIdModification($arr[$keys[7]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(SalePeer::DATABASE_NAME);

        if ($this->isColumnModified(SalePeer::ID_SALE)) $criteria->add(SalePeer::ID_SALE, $this->id_sale);
        if ($this->isColumnModified(SalePeer::ID_ACCOUNT)) $criteria->add(SalePeer::ID_ACCOUNT, $this->id_account);
        if ($this->isColumnModified(SalePeer::DATE)) $criteria->add(SalePeer::DATE, $this->date);
        if ($this->isColumnModified(SalePeer::STATUT)) $criteria->add(SalePeer::STATUT, $this->statut);
        if ($this->isColumnModified(SalePeer::DATE_CREATION)) $criteria->add(SalePeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(SalePeer::DATE_MODIFICATION)) $criteria->add(SalePeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(SalePeer::ID_CREATION)) $criteria->add(SalePeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(SalePeer::ID_MODIFICATION)) $criteria->add(SalePeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(SalePeer::DATABASE_NAME);
        $criteria->add(SalePeer::ID_SALE, $this->id_sale);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdSale();
    }

    /**
     * Generic method to set the primary key (id_sale column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdSale($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdSale();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Sale (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdAccount($this->getIdAccount());
        $copyObj->setDate($this->getDate());
        $copyObj->setStatut($this->getStatut());
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

            foreach ($this->getAbonnements() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAbonnement($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdSale(NULL); // this is a auto-increment column, so set to default value
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
     * @return Sale Clone of current object.
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
     * @return SalePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new SalePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Account object.
     *
     * @param                  Account $v
     * @return Sale The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAccount(Account $v = null)
    {
        if ($v === null) {
            $this->setIdAccount(NULL);
        } else {
            $this->setIdAccount($v->getIdAccount());
        }

        $this->aAccount = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Account object, it will not be re-added.
        if ($v !== null) {
            $v->addSale($this);
        }


        return $this;
    }


    /**
     * Get the associated Account object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Account The associated Account object.
     * @throws PropelException
     */
    public function getAccount(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAccount === null && ($this->id_account !== null) && $doQuery) {
            $this->aAccount = AccountQuery::create()->findPk($this->id_account, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAccount->addSales($this);
             */
        }

        return $this->aAccount;
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
        if ('Abonnement' == $relationName) {
            $this->initAbonnements();
        }
    }

    /**
     * Clears out the collAbonnements collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Sale The current object (for fluent API support)
     * @see        addAbonnements()
     */
    public function clearAbonnements()
    {
        $this->collAbonnements = null; // important to set this to null since that means it is uninitialized
        $this->collAbonnementsPartial = null;

        return $this;
    }

    /**
     * reset is the collAbonnements collection loaded partially
     *
     * @return void
     */
    public function resetPartialAbonnements($v = true)
    {
        $this->collAbonnementsPartial = $v;
    }

    /**
     * Initializes the collAbonnements collection.
     *
     * By default this just sets the collAbonnements collection to an empty array (like clearcollAbonnements());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAbonnements($overrideExisting = true)
    {
        if (null !== $this->collAbonnements && !$overrideExisting) {
            return;
        }
        $this->collAbonnements = new PropelObjectCollection();
        $this->collAbonnements->setModel('Abonnement');
    }

    /**
     * Gets an array of Abonnement objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Sale is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Abonnement[] List of Abonnement objects
     * @throws PropelException
     */
    public function getAbonnements($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAbonnementsPartial && !$this->isNew();
        if (null === $this->collAbonnements || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAbonnements) {
                // return empty collection
                $this->initAbonnements();
            } else {
                $collAbonnements = AbonnementQuery::create(null, $criteria)
                    ->filterBySale($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAbonnementsPartial && count($collAbonnements)) {
                      $this->initAbonnements(false);

                      foreach ($collAbonnements as $obj) {
                        if (false == $this->collAbonnements->contains($obj)) {
                          $this->collAbonnements->append($obj);
                        }
                      }

                      $this->collAbonnementsPartial = true;
                    }

                    $collAbonnements->getInternalIterator()->rewind();

                    return $collAbonnements;
                }

                if ($partial && $this->collAbonnements) {
                    foreach ($this->collAbonnements as $obj) {
                        if ($obj->isNew()) {
                            $collAbonnements[] = $obj;
                        }
                    }
                }

                $this->collAbonnements = $collAbonnements;
                $this->collAbonnementsPartial = false;
            }
        }

        return $this->collAbonnements;
    }

    /**
     * Sets a collection of Abonnement objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $abonnements A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Sale The current object (for fluent API support)
     */
    public function setAbonnements(PropelCollection $abonnements, PropelPDO $con = null)
    {
        $abonnementsToDelete = $this->getAbonnements(new Criteria(), $con)->diff($abonnements);


        $this->abonnementsScheduledForDeletion = $abonnementsToDelete;

        foreach ($abonnementsToDelete as $abonnementRemoved) {
            $abonnementRemoved->setSale(null);
        }

        $this->collAbonnements = null;
        foreach ($abonnements as $abonnement) {
            $this->addAbonnement($abonnement);
        }

        $this->collAbonnements = $abonnements;
        $this->collAbonnementsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Abonnement objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Abonnement objects.
     * @throws PropelException
     */
    public function countAbonnements(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAbonnementsPartial && !$this->isNew();
        if (null === $this->collAbonnements || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAbonnements) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAbonnements());
            }
            $query = AbonnementQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySale($this)
                ->count($con);
        }

        return count($this->collAbonnements);
    }

    /**
     * Method called to associate a Abonnement object to this object
     * through the Abonnement foreign key attribute.
     *
     * @param    Abonnement $l Abonnement
     * @return Sale The current object (for fluent API support)
     */
    public function addAbonnement(Abonnement $l)
    {
        if ($this->collAbonnements === null) {
            $this->initAbonnements();
            $this->collAbonnementsPartial = true;
        }

        if (!in_array($l, $this->collAbonnements->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAbonnement($l);

            if ($this->abonnementsScheduledForDeletion and $this->abonnementsScheduledForDeletion->contains($l)) {
                $this->abonnementsScheduledForDeletion->remove($this->abonnementsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Abonnement $abonnement The abonnement object to add.
     */
    protected function doAddAbonnement($abonnement)
    {
        $this->collAbonnements[]= $abonnement;
        $abonnement->setSale($this);
    }

    /**
     * @param	Abonnement $abonnement The abonnement object to remove.
     * @return Sale The current object (for fluent API support)
     */
    public function removeAbonnement($abonnement)
    {
        if ($this->getAbonnements()->contains($abonnement)) {
            $this->collAbonnements->remove($this->collAbonnements->search($abonnement));
            if (null === $this->abonnementsScheduledForDeletion) {
                $this->abonnementsScheduledForDeletion = clone $this->collAbonnements;
                $this->abonnementsScheduledForDeletion->clear();
            }
            $this->abonnementsScheduledForDeletion[]= clone $abonnement;
            $abonnement->setSale(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_sale = null;
        $this->id_account = null;
        $this->date = null;
        $this->statut = null;
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
        $this->applyDefaultValues();
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
            if ($this->collAbonnements) {
                foreach ($this->collAbonnements as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAccount instanceof Persistent) {
              $this->aAccount->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAbonnements instanceof PropelCollection) {
            $this->collAbonnements->clearIterator();
        }
        $this->collAbonnements = null;
        $this->aAccount = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SalePeer::DEFAULT_STRING_FORMAT);
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
     * @return     Sale The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = SalePeer::DATE_MODIFICATION;
        return $this;
    }

}
