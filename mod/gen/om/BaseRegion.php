<?php


/**
 * Base class that represents a row from the 'region' table.
 *
 * Région
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseRegion extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'RegionPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        RegionPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

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
     * The value for the title field.
     * @var        string
     */
    protected $title;

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
     * @var        Province
     */
    protected $aProvince;

    /**
     * @var        PropelObjectCollection|Account[] Collection to store aggregation of Account objects.
     */
    protected $collAccounts;
    protected $collAccountsPartial;

    /**
     * @var        PropelObjectCollection|Ville[] Collection to store aggregation of Ville objects.
     */
    protected $collVilles;
    protected $collVillesPartial;

    /**
     * @var        PropelObjectCollection|RegionI18n[] Collection to store aggregation of RegionI18n objects.
     */
    protected $collRegionI18ns;
    protected $collRegionI18nsPartial;

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

    // i18n behavior

    /**
     * Current locale
     * @var        string
     */
    protected $currentLocale = 'en_US';

    /**
     * Current translation objects
     * @var        array[RegionI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $accountsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $villesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $regionI18nsScheduledForDeletion = null;

    /**
     * Get the [id_region] column value.
     *
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
     * Get the [title] column value.
     * Identifiant
     * @return string
     */
    public function getTitle()
    {

        return $this->title;
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
        $c->addSelectColumn(RegionPeer::DATE_CREATION);
        try {
            $stmt = RegionPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(RegionPeer::DATE_MODIFICATION);
        try {
            $stmt = RegionPeer::doSelectStmt($c, $con);
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
     * Set the value of [id_region] column.
     *
     * @param  int $v new value
     * @return Region The current object (for fluent API support)
     */
    public function setIdRegion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_region !== $v) {
            $this->id_region = $v;
            $this->modifiedColumns[] = RegionPeer::ID_REGION;
        }


        return $this;
    } // setIdRegion()

    /**
     * Set the value of [id_province] column.
     * Province
     * @param  int $v new value
     * @return Region The current object (for fluent API support)
     */
    public function setIdProvince($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_province !== $v) {
            $this->id_province = $v;
            $this->modifiedColumns[] = RegionPeer::ID_PROVINCE;
        }

        if ($this->aProvince !== null && $this->aProvince->getIdProvince() !== $v) {
            $this->aProvince = null;
        }


        return $this;
    } // setIdProvince()

    /**
     * Set the value of [title] column.
     * Identifiant
     * @param  string $v new value
     * @return Region The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = RegionPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Region The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = RegionPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = RegionPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Region The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = RegionPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = RegionPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Region The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = RegionPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Region The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = RegionPeer::ID_MODIFICATION;
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

            $this->id_region = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_province = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->title = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->id_creation = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->id_modification = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 5; // 5 = RegionPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Region object", $e);
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

        if ($this->aProvince !== null && $this->id_province !== $this->aProvince->getIdProvince()) {
            $this->aProvince = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(RegionPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = RegionPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->aProvince = null;
            $this->collAccounts = null;
            $this->collVilles = null;
            $this->collRegionI18ns = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Region';}
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
        mem_clean('Region');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(RegionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = RegionQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(RegionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Region');
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

                        mem_clean('Region');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            RegionPeer::addInstanceToPool($this);

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

            if ($this->aProvince !== null) {
                if ($this->aProvince->isModified() || $this->aProvince->isNew()) {
                    $affectedRows += $this->aProvince->save($con);
                }
                $this->setProvince($this->aProvince);
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

            if ($this->accountsScheduledForDeletion !== null) {
                if (!$this->accountsScheduledForDeletion->isEmpty()) {
                    foreach ($this->accountsScheduledForDeletion as $account) {
                        // need to save related object because we set the relation to null
                        $account->save($con);
                    }
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

            if ($this->villesScheduledForDeletion !== null) {
                if (!$this->villesScheduledForDeletion->isEmpty()) {
                    VilleQuery::create()
                        ->filterByPrimaryKeys($this->villesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->villesScheduledForDeletion = null;
                }
            }

            if ($this->collVilles !== null) {
                foreach ($this->collVilles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->regionI18nsScheduledForDeletion !== null) {
                if (!$this->regionI18nsScheduledForDeletion->isEmpty()) {
                    RegionI18nQuery::create()
                        ->filterByPrimaryKeys($this->regionI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->regionI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collRegionI18ns !== null) {
                foreach ($this->collRegionI18ns as $referrerFK) {
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

        $this->modifiedColumns[] = RegionPeer::ID_REGION;
        if (null !== $this->id_region) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RegionPeer::ID_REGION . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RegionPeer::ID_REGION)) {
            $modifiedColumns[':p' . $index++]  = '`id_region`';
        }
        if ($this->isColumnModified(RegionPeer::ID_PROVINCE)) {
            $modifiedColumns[':p' . $index++]  = '`id_province`';
        }
        if ($this->isColumnModified(RegionPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(RegionPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(RegionPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(RegionPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(RegionPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `region` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_region`':
                        $stmt->bindValue($identifier, $this->id_region, PDO::PARAM_INT);
                        break;
                    case '`id_province`':
                        $stmt->bindValue($identifier, $this->id_province, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
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
        $this->setIdRegion($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Region';}
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

            if ($this->aProvince !== null) {
                if (!$this->aProvince->validate($columns)) {$failureMap = array_merge($failureMap, $this->aProvince->getValidationFailures()); }
            }

            if (($retval = RegionPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collAccounts !== null) {
                    foreach ($this->collAccounts as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collVilles !== null) {
                    foreach ($this->collVilles as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collRegionI18ns !== null) {
                    foreach ($this->collRegionI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = RegionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Region'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Region'][$this->getPrimaryKey()] = true;
        $keys = RegionPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdRegion(),
            $keys[1] => $this->getIdProvince(),
            $keys[2] => $this->getTitle(),
            $keys[3] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[4] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[5] => $this->getIdCreation(),
            $keys[6] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProvince) {
                $result['Province'] = $this->aProvince->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAccounts) {
                $result['Accounts'] = $this->collAccounts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collVilles) {
                $result['Villes'] = $this->collVilles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRegionI18ns) {
                $result['RegionI18ns'] = $this->collRegionI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = RegionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdRegion($value);
                break;
            case 1:
                $this->setIdProvince($value);
                break;
            case 2:
                $this->setTitle($value);
                break;
            case 3:
                $this->setDateCreation($value);
                break;
            case 4:
                $this->setDateModification($value);
                break;
            case 5:
                $this->setIdCreation($value);
                break;
            case 6:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = RegionPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdRegion($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdProvince($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDateCreation($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDateModification($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIdCreation($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIdModification($arr[$keys[6]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(RegionPeer::DATABASE_NAME);

        if ($this->isColumnModified(RegionPeer::ID_REGION)) $criteria->add(RegionPeer::ID_REGION, $this->id_region);
        if ($this->isColumnModified(RegionPeer::ID_PROVINCE)) $criteria->add(RegionPeer::ID_PROVINCE, $this->id_province);
        if ($this->isColumnModified(RegionPeer::TITLE)) $criteria->add(RegionPeer::TITLE, $this->title);
        if ($this->isColumnModified(RegionPeer::DATE_CREATION)) $criteria->add(RegionPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(RegionPeer::DATE_MODIFICATION)) $criteria->add(RegionPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(RegionPeer::ID_CREATION)) $criteria->add(RegionPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(RegionPeer::ID_MODIFICATION)) $criteria->add(RegionPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(RegionPeer::DATABASE_NAME);
        $criteria->add(RegionPeer::ID_REGION, $this->id_region);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdRegion();
    }

    /**
     * Generic method to set the primary key (id_region column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdRegion($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdRegion();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Region (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdProvince($this->getIdProvince());
        $copyObj->setTitle($this->getTitle());
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

            foreach ($this->getAccounts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccount($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getVilles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVille($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRegionI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRegionI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdRegion(NULL); // this is a auto-increment column, so set to default value
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
     * @return Region Clone of current object.
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
     * @return RegionPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new RegionPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Province object.
     *
     * @param                  Province $v
     * @return Region The current object (for fluent API support)
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
            $v->addRegion($this);
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
                $this->aProvince->addRegions($this);
             */
        }

        return $this->aProvince;
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
        if ('Account' == $relationName) {
            $this->initAccounts();
        }
        if ('Ville' == $relationName) {
            $this->initVilles();
        }
        if ('RegionI18n' == $relationName) {
            $this->initRegionI18ns();
        }
    }

    /**
     * Clears out the collAccounts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Region The current object (for fluent API support)
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
     * If this Region is new, it will return
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
                    ->filterByRegion($this)
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
     * @return Region The current object (for fluent API support)
     */
    public function setAccounts(PropelCollection $accounts, PropelPDO $con = null)
    {
        $accountsToDelete = $this->getAccounts(new Criteria(), $con)->diff($accounts);


        $this->accountsScheduledForDeletion = $accountsToDelete;

        foreach ($accountsToDelete as $accountRemoved) {
            $accountRemoved->setRegion(null);
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
                ->filterByRegion($this)
                ->count($con);
        }

        return count($this->collAccounts);
    }

    /**
     * Method called to associate a Account object to this object
     * through the Account foreign key attribute.
     *
     * @param    Account $l Account
     * @return Region The current object (for fluent API support)
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
        $account->setRegion($this);
    }

    /**
     * @param	Account $account The account object to remove.
     * @return Region The current object (for fluent API support)
     */
    public function removeAccount($account)
    {
        if ($this->getAccounts()->contains($account)) {
            $this->collAccounts->remove($this->collAccounts->search($account));
            if (null === $this->accountsScheduledForDeletion) {
                $this->accountsScheduledForDeletion = clone $this->collAccounts;
                $this->accountsScheduledForDeletion->clear();
            }
            $this->accountsScheduledForDeletion[]= $account;
            $account->setRegion(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Region is new, it will return
     * an empty collection; or if this Region has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Region.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Account[] List of Account objects
     */
    public function getAccountsJoinAuthy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AccountQuery::create(null, $criteria);
        $query->joinWith('Authy', $join_behavior);

        return $this->getAccounts($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Region is new, it will return
     * an empty collection; or if this Region has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Region.
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
     * Otherwise if this Region is new, it will return
     * an empty collection; or if this Region has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Region.
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
     * Otherwise if this Region is new, it will return
     * an empty collection; or if this Region has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Region.
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
     * Clears out the collVilles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Region The current object (for fluent API support)
     * @see        addVilles()
     */
    public function clearVilles()
    {
        $this->collVilles = null; // important to set this to null since that means it is uninitialized
        $this->collVillesPartial = null;

        return $this;
    }

    /**
     * reset is the collVilles collection loaded partially
     *
     * @return void
     */
    public function resetPartialVilles($v = true)
    {
        $this->collVillesPartial = $v;
    }

    /**
     * Initializes the collVilles collection.
     *
     * By default this just sets the collVilles collection to an empty array (like clearcollVilles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVilles($overrideExisting = true)
    {
        if (null !== $this->collVilles && !$overrideExisting) {
            return;
        }
        $this->collVilles = new PropelObjectCollection();
        $this->collVilles->setModel('Ville');
    }

    /**
     * Gets an array of Ville objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Region is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Ville[] List of Ville objects
     * @throws PropelException
     */
    public function getVilles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collVillesPartial && !$this->isNew();
        if (null === $this->collVilles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVilles) {
                // return empty collection
                $this->initVilles();
            } else {
                $collVilles = VilleQuery::create(null, $criteria)
                    ->filterByRegion($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collVillesPartial && count($collVilles)) {
                      $this->initVilles(false);

                      foreach ($collVilles as $obj) {
                        if (false == $this->collVilles->contains($obj)) {
                          $this->collVilles->append($obj);
                        }
                      }

                      $this->collVillesPartial = true;
                    }

                    $collVilles->getInternalIterator()->rewind();

                    return $collVilles;
                }

                if ($partial && $this->collVilles) {
                    foreach ($this->collVilles as $obj) {
                        if ($obj->isNew()) {
                            $collVilles[] = $obj;
                        }
                    }
                }

                $this->collVilles = $collVilles;
                $this->collVillesPartial = false;
            }
        }

        return $this->collVilles;
    }

    /**
     * Sets a collection of Ville objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $villes A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Region The current object (for fluent API support)
     */
    public function setVilles(PropelCollection $villes, PropelPDO $con = null)
    {
        $villesToDelete = $this->getVilles(new Criteria(), $con)->diff($villes);


        $this->villesScheduledForDeletion = $villesToDelete;

        foreach ($villesToDelete as $villeRemoved) {
            $villeRemoved->setRegion(null);
        }

        $this->collVilles = null;
        foreach ($villes as $ville) {
            $this->addVille($ville);
        }

        $this->collVilles = $villes;
        $this->collVillesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Ville objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Ville objects.
     * @throws PropelException
     */
    public function countVilles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collVillesPartial && !$this->isNew();
        if (null === $this->collVilles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVilles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVilles());
            }
            $query = VilleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRegion($this)
                ->count($con);
        }

        return count($this->collVilles);
    }

    /**
     * Method called to associate a Ville object to this object
     * through the Ville foreign key attribute.
     *
     * @param    Ville $l Ville
     * @return Region The current object (for fluent API support)
     */
    public function addVille(Ville $l)
    {
        if ($this->collVilles === null) {
            $this->initVilles();
            $this->collVillesPartial = true;
        }

        if (!in_array($l, $this->collVilles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddVille($l);

            if ($this->villesScheduledForDeletion and $this->villesScheduledForDeletion->contains($l)) {
                $this->villesScheduledForDeletion->remove($this->villesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Ville $ville The ville object to add.
     */
    protected function doAddVille($ville)
    {
        $this->collVilles[]= $ville;
        $ville->setRegion($this);
    }

    /**
     * @param	Ville $ville The ville object to remove.
     * @return Region The current object (for fluent API support)
     */
    public function removeVille($ville)
    {
        if ($this->getVilles()->contains($ville)) {
            $this->collVilles->remove($this->collVilles->search($ville));
            if (null === $this->villesScheduledForDeletion) {
                $this->villesScheduledForDeletion = clone $this->collVilles;
                $this->villesScheduledForDeletion->clear();
            }
            $this->villesScheduledForDeletion[]= $ville;
            $ville->setRegion(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Region is new, it will return
     * an empty collection; or if this Region has previously
     * been saved, it will retrieve related Villes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Region.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Ville[] List of Ville objects
     */
    public function getVillesJoinProvince($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = VilleQuery::create(null, $criteria);
        $query->joinWith('Province', $join_behavior);

        return $this->getVilles($query, $con);
    }

    /**
     * Clears out the collRegionI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Region The current object (for fluent API support)
     * @see        addRegionI18ns()
     */
    public function clearRegionI18ns()
    {
        $this->collRegionI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collRegionI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collRegionI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialRegionI18ns($v = true)
    {
        $this->collRegionI18nsPartial = $v;
    }

    /**
     * Initializes the collRegionI18ns collection.
     *
     * By default this just sets the collRegionI18ns collection to an empty array (like clearcollRegionI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRegionI18ns($overrideExisting = true)
    {
        if (null !== $this->collRegionI18ns && !$overrideExisting) {
            return;
        }
        $this->collRegionI18ns = new PropelObjectCollection();
        $this->collRegionI18ns->setModel('RegionI18n');
    }

    /**
     * Gets an array of RegionI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Region is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|RegionI18n[] List of RegionI18n objects
     * @throws PropelException
     */
    public function getRegionI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collRegionI18nsPartial && !$this->isNew();
        if (null === $this->collRegionI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRegionI18ns) {
                // return empty collection
                $this->initRegionI18ns();
            } else {
                $collRegionI18ns = RegionI18nQuery::create(null, $criteria)
                    ->filterByRegion($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collRegionI18nsPartial && count($collRegionI18ns)) {
                      $this->initRegionI18ns(false);

                      foreach ($collRegionI18ns as $obj) {
                        if (false == $this->collRegionI18ns->contains($obj)) {
                          $this->collRegionI18ns->append($obj);
                        }
                      }

                      $this->collRegionI18nsPartial = true;
                    }

                    $collRegionI18ns->getInternalIterator()->rewind();

                    return $collRegionI18ns;
                }

                if ($partial && $this->collRegionI18ns) {
                    foreach ($this->collRegionI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collRegionI18ns[] = $obj;
                        }
                    }
                }

                $this->collRegionI18ns = $collRegionI18ns;
                $this->collRegionI18nsPartial = false;
            }
        }

        return $this->collRegionI18ns;
    }

    /**
     * Sets a collection of RegionI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $regionI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Region The current object (for fluent API support)
     */
    public function setRegionI18ns(PropelCollection $regionI18ns, PropelPDO $con = null)
    {
        $regionI18nsToDelete = $this->getRegionI18ns(new Criteria(), $con)->diff($regionI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->regionI18nsScheduledForDeletion = clone $regionI18nsToDelete;

        foreach ($regionI18nsToDelete as $regionI18nRemoved) {
            $regionI18nRemoved->setRegion(null);
        }

        $this->collRegionI18ns = null;
        foreach ($regionI18ns as $regionI18n) {
            $this->addRegionI18n($regionI18n);
        }

        $this->collRegionI18ns = $regionI18ns;
        $this->collRegionI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RegionI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related RegionI18n objects.
     * @throws PropelException
     */
    public function countRegionI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collRegionI18nsPartial && !$this->isNew();
        if (null === $this->collRegionI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRegionI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRegionI18ns());
            }
            $query = RegionI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRegion($this)
                ->count($con);
        }

        return count($this->collRegionI18ns);
    }

    /**
     * Method called to associate a RegionI18n object to this object
     * through the RegionI18n foreign key attribute.
     *
     * @param    RegionI18n $l RegionI18n
     * @return Region The current object (for fluent API support)
     */
    public function addRegionI18n(RegionI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collRegionI18ns === null) {
            $this->initRegionI18ns();
            $this->collRegionI18nsPartial = true;
        }

        if (!in_array($l, $this->collRegionI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddRegionI18n($l);

            if ($this->regionI18nsScheduledForDeletion and $this->regionI18nsScheduledForDeletion->contains($l)) {
                $this->regionI18nsScheduledForDeletion->remove($this->regionI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	RegionI18n $regionI18n The regionI18n object to add.
     */
    protected function doAddRegionI18n($regionI18n)
    {
        $this->collRegionI18ns[]= $regionI18n;
        $regionI18n->setRegion($this);
    }

    /**
     * @param	RegionI18n $regionI18n The regionI18n object to remove.
     * @return Region The current object (for fluent API support)
     */
    public function removeRegionI18n($regionI18n)
    {
        if ($this->getRegionI18ns()->contains($regionI18n)) {
            $this->collRegionI18ns->remove($this->collRegionI18ns->search($regionI18n));
            if (null === $this->regionI18nsScheduledForDeletion) {
                $this->regionI18nsScheduledForDeletion = clone $this->collRegionI18ns;
                $this->regionI18nsScheduledForDeletion->clear();
            }
            $this->regionI18nsScheduledForDeletion[]= clone $regionI18n;
            $regionI18n->setRegion(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_region = null;
        $this->id_province = null;
        $this->title = null;
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
            if ($this->collAccounts) {
                foreach ($this->collAccounts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVilles) {
                foreach ($this->collVilles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRegionI18ns) {
                foreach ($this->collRegionI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aProvince instanceof Persistent) {
              $this->aProvince->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collAccounts instanceof PropelCollection) {
            $this->collAccounts->clearIterator();
        }
        $this->collAccounts = null;
        if ($this->collVilles instanceof PropelCollection) {
            $this->collVilles->clearIterator();
        }
        $this->collVilles = null;
        if ($this->collRegionI18ns instanceof PropelCollection) {
            $this->collRegionI18ns->clearIterator();
        }
        $this->collRegionI18ns = null;
        $this->aProvince = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RegionPeer::DEFAULT_STRING_FORMAT);
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

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    Region The current object (for fluent API support)
     */
    public function setLocale($locale = 'en_US')
    {
        $this->currentLocale = $locale;

        return $this;
    }

    /**
     * Gets the locale for translations
     *
     * @return    string $locale Locale to use for the translation, e.g. 'fr_FR'
     */
    public function getLocale()
    {
        return $this->currentLocale;
    }

    /**
     * Returns the current translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return RegionI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collRegionI18ns) {
                foreach ($this->collRegionI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new RegionI18n();
                $translation->setLocale($locale);
            } else {
                $translation = RegionI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addRegionI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    Region The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            RegionI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collRegionI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collRegionI18ns[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Returns the current translation
     *
     * @param     PropelPDO $con an optional connection object
     *
     * @return RegionI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [name] column value.
         * Région
         * @return string
         */
        public function getName()
        {
        return $this->getCurrentTranslation()->getName();
    }


        /**
         * Set the value of [name] column.
         * Région
         * @param  string $v new value
         * @return RegionI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
    }

    // TableStampBehavior behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     * @return     Region The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = RegionPeer::DATE_MODIFICATION;
        return $this;
    }

}
