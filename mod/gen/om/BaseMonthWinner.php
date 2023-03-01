<?php


/**
 * Base class that represents a row from the 'month_winner' table.
 *
 * Mois
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseMonthWinner extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'MonthWinnerPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MonthWinnerPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_month_winner field.
     * @var        int
     */
    protected $id_month_winner;

    /**
     * The value for the id_winner field.
     * @var        int
     */
    protected $id_winner;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the onlune field.
     * @var        int
     */
    protected $onlune;

    /**
     * The value for the order field.
     * @var        int
     */
    protected $order;

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
     * @var        Winner
     */
    protected $aWinner;

    /**
     * @var        PropelObjectCollection|MonthWinnerI18n[] Collection to store aggregation of MonthWinnerI18n objects.
     */
    protected $collMonthWinnerI18ns;
    protected $collMonthWinnerI18nsPartial;

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
     * @var        array[MonthWinnerI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $monthWinnerI18nsScheduledForDeletion = null;

    /**
     * Get the [id_month_winner] column value.
     *
     * @return int
     */
    public function getIdMonthWinner()
    {

        return $this->id_month_winner;
    }

    /**
     * Get the [id_winner] column value.
     *
     * @return int
     */
    public function getIdWinner()
    {

        return $this->id_winner;
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
     * Get the [onlune] column value.
     * En ligne
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getOnlune()
    {
        if (null === $this->onlune) {
            return null;
        }
        $valueSet = MonthWinnerPeer::getValueSet(MonthWinnerPeer::ONLUNE);
        if (!isset($valueSet[$this->onlune])) {
            throw new PropelException('Unknown stored enum key: ' . $this->onlune);
        }

        return $valueSet[$this->onlune];
    }

    /**
     * Get the [order] column value.
     * Ordre d'affichage
     * @return int
     */
    public function getOrder()
    {

        return $this->order;
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
        $c->addSelectColumn(MonthWinnerPeer::DATE_CREATION);
        try {
            $stmt = MonthWinnerPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(MonthWinnerPeer::DATE_MODIFICATION);
        try {
            $stmt = MonthWinnerPeer::doSelectStmt($c, $con);
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
     * Set the value of [id_month_winner] column.
     *
     * @param  int $v new value
     * @return MonthWinner The current object (for fluent API support)
     */
    public function setIdMonthWinner($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_month_winner !== $v) {
            $this->id_month_winner = $v;
            $this->modifiedColumns[] = MonthWinnerPeer::ID_MONTH_WINNER;
        }


        return $this;
    } // setIdMonthWinner()

    /**
     * Set the value of [id_winner] column.
     *
     * @param  int $v new value
     * @return MonthWinner The current object (for fluent API support)
     */
    public function setIdWinner($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_winner !== $v) {
            $this->id_winner = $v;
            $this->modifiedColumns[] = MonthWinnerPeer::ID_WINNER;
        }

        if ($this->aWinner !== null && $this->aWinner->getIdWinner() !== $v) {
            $this->aWinner = null;
        }


        return $this;
    } // setIdWinner()

    /**
     * Set the value of [title] column.
     * Identifiant
     * @param  string $v new value
     * @return MonthWinner The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = MonthWinnerPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [onlune] column.
     * En ligne
     * @param  int $v new value
     * @return MonthWinner The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setOnlune($v)
    {
        if ($v !== null) {
            $valueSet = MonthWinnerPeer::getValueSet(MonthWinnerPeer::ONLUNE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->onlune !== $v) {
            $this->onlune = $v;
            $this->modifiedColumns[] = MonthWinnerPeer::ONLUNE;
        }


        return $this;
    } // setOnlune()

    /**
     * Set the value of [order] column.
     * Ordre d'affichage
     * @param  int $v new value
     * @return MonthWinner The current object (for fluent API support)
     */
    public function setOrder($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->order !== $v) {
            $this->order = $v;
            $this->modifiedColumns[] = MonthWinnerPeer::ORDER;
        }


        return $this;
    } // setOrder()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MonthWinner The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = MonthWinnerPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = MonthWinnerPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MonthWinner The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = MonthWinnerPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = MonthWinnerPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return MonthWinner The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = MonthWinnerPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return MonthWinner The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = MonthWinnerPeer::ID_MODIFICATION;
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

            $this->id_month_winner = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_winner = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->title = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->onlune = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->order = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->id_creation = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->id_modification = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 7; // 7 = MonthWinnerPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating MonthWinner object", $e);
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

        if ($this->aWinner !== null && $this->id_winner !== $this->aWinner->getIdWinner()) {
            $this->aWinner = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(MonthWinnerPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = MonthWinnerPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->aWinner = null;
            $this->collMonthWinnerI18ns = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='MonthWinner';}
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
        mem_clean('MonthWinner');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(MonthWinnerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = MonthWinnerQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(MonthWinnerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('MonthWinner');
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

                        mem_clean('MonthWinner');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            MonthWinnerPeer::addInstanceToPool($this);

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

            if ($this->aWinner !== null) {
                if ($this->aWinner->isModified() || $this->aWinner->isNew()) {
                    $affectedRows += $this->aWinner->save($con);
                }
                $this->setWinner($this->aWinner);
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

            if ($this->monthWinnerI18nsScheduledForDeletion !== null) {
                if (!$this->monthWinnerI18nsScheduledForDeletion->isEmpty()) {
                    MonthWinnerI18nQuery::create()
                        ->filterByPrimaryKeys($this->monthWinnerI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->monthWinnerI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collMonthWinnerI18ns !== null) {
                foreach ($this->collMonthWinnerI18ns as $referrerFK) {
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

        $this->modifiedColumns[] = MonthWinnerPeer::ID_MONTH_WINNER;
        if (null !== $this->id_month_winner) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MonthWinnerPeer::ID_MONTH_WINNER . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MonthWinnerPeer::ID_MONTH_WINNER)) {
            $modifiedColumns[':p' . $index++]  = '`id_month_winner`';
        }
        if ($this->isColumnModified(MonthWinnerPeer::ID_WINNER)) {
            $modifiedColumns[':p' . $index++]  = '`id_winner`';
        }
        if ($this->isColumnModified(MonthWinnerPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(MonthWinnerPeer::ONLUNE)) {
            $modifiedColumns[':p' . $index++]  = '`onlune`';
        }
        if ($this->isColumnModified(MonthWinnerPeer::ORDER)) {
            $modifiedColumns[':p' . $index++]  = '`order`';
        }
        if ($this->isColumnModified(MonthWinnerPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(MonthWinnerPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(MonthWinnerPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(MonthWinnerPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `month_winner` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_month_winner`':
                        $stmt->bindValue($identifier, $this->id_month_winner, PDO::PARAM_INT);
                        break;
                    case '`id_winner`':
                        $stmt->bindValue($identifier, $this->id_winner, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`onlune`':
                        $stmt->bindValue($identifier, $this->onlune, PDO::PARAM_INT);
                        break;
                    case '`order`':
                        $stmt->bindValue($identifier, $this->order, PDO::PARAM_INT);
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
        $this->setIdMonthWinner($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='MonthWinner';}
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

            if ($this->aWinner !== null) {
                if (!$this->aWinner->validate($columns)) {$failureMap = array_merge($failureMap, $this->aWinner->getValidationFailures()); }
            }

            if (($retval = MonthWinnerPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collMonthWinnerI18ns !== null) {
                    foreach ($this->collMonthWinnerI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = MonthWinnerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['MonthWinner'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['MonthWinner'][$this->getPrimaryKey()] = true;
        $keys = MonthWinnerPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdMonthWinner(),
            $keys[1] => $this->getIdWinner(),
            $keys[2] => $this->getTitle(),
            $keys[3] => $this->getOnlune(),
            $keys[4] => $this->getOrder(),
            $keys[5] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[6] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[7] => $this->getIdCreation(),
            $keys[8] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aWinner) {
                $result['Winner'] = $this->aWinner->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collMonthWinnerI18ns) {
                $result['MonthWinnerI18ns'] = $this->collMonthWinnerI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = MonthWinnerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdMonthWinner($value);
                break;
            case 1:
                $this->setIdWinner($value);
                break;
            case 2:
                $this->setTitle($value);
                break;
            case 3:
                $valueSet = MonthWinnerPeer::getValueSet(MonthWinnerPeer::ONLUNE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setOnlune($value);
                break;
            case 4:
                $this->setOrder($value);
                break;
            case 5:
                $this->setDateCreation($value);
                break;
            case 6:
                $this->setDateModification($value);
                break;
            case 7:
                $this->setIdCreation($value);
                break;
            case 8:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = MonthWinnerPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdMonthWinner($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdWinner($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setOnlune($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setOrder($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDateCreation($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDateModification($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setIdCreation($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setIdModification($arr[$keys[8]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(MonthWinnerPeer::DATABASE_NAME);

        if ($this->isColumnModified(MonthWinnerPeer::ID_MONTH_WINNER)) $criteria->add(MonthWinnerPeer::ID_MONTH_WINNER, $this->id_month_winner);
        if ($this->isColumnModified(MonthWinnerPeer::ID_WINNER)) $criteria->add(MonthWinnerPeer::ID_WINNER, $this->id_winner);
        if ($this->isColumnModified(MonthWinnerPeer::TITLE)) $criteria->add(MonthWinnerPeer::TITLE, $this->title);
        if ($this->isColumnModified(MonthWinnerPeer::ONLUNE)) $criteria->add(MonthWinnerPeer::ONLUNE, $this->onlune);
        if ($this->isColumnModified(MonthWinnerPeer::ORDER)) $criteria->add(MonthWinnerPeer::ORDER, $this->order);
        if ($this->isColumnModified(MonthWinnerPeer::DATE_CREATION)) $criteria->add(MonthWinnerPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(MonthWinnerPeer::DATE_MODIFICATION)) $criteria->add(MonthWinnerPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(MonthWinnerPeer::ID_CREATION)) $criteria->add(MonthWinnerPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(MonthWinnerPeer::ID_MODIFICATION)) $criteria->add(MonthWinnerPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(MonthWinnerPeer::DATABASE_NAME);
        $criteria->add(MonthWinnerPeer::ID_MONTH_WINNER, $this->id_month_winner);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdMonthWinner();
    }

    /**
     * Generic method to set the primary key (id_month_winner column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdMonthWinner($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdMonthWinner();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of MonthWinner (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdWinner($this->getIdWinner());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setOnlune($this->getOnlune());
        $copyObj->setOrder($this->getOrder());
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

            foreach ($this->getMonthWinnerI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMonthWinnerI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdMonthWinner(NULL); // this is a auto-increment column, so set to default value
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
     * @return MonthWinner Clone of current object.
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
     * @return MonthWinnerPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MonthWinnerPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Winner object.
     *
     * @param                  Winner $v
     * @return MonthWinner The current object (for fluent API support)
     * @throws PropelException
     */
    public function setWinner(Winner $v = null)
    {
        if ($v === null) {
            $this->setIdWinner(NULL);
        } else {
            $this->setIdWinner($v->getIdWinner());
        }

        $this->aWinner = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Winner object, it will not be re-added.
        if ($v !== null) {
            $v->addMonthWinner($this);
        }


        return $this;
    }


    /**
     * Get the associated Winner object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Winner The associated Winner object.
     * @throws PropelException
     */
    public function getWinner(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aWinner === null && ($this->id_winner !== null) && $doQuery) {
            $this->aWinner = WinnerQuery::create()->findPk($this->id_winner, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aWinner->addMonthWinners($this);
             */
        }

        return $this->aWinner;
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
        if ('MonthWinnerI18n' == $relationName) {
            $this->initMonthWinnerI18ns();
        }
    }

    /**
     * Clears out the collMonthWinnerI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return MonthWinner The current object (for fluent API support)
     * @see        addMonthWinnerI18ns()
     */
    public function clearMonthWinnerI18ns()
    {
        $this->collMonthWinnerI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collMonthWinnerI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collMonthWinnerI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialMonthWinnerI18ns($v = true)
    {
        $this->collMonthWinnerI18nsPartial = $v;
    }

    /**
     * Initializes the collMonthWinnerI18ns collection.
     *
     * By default this just sets the collMonthWinnerI18ns collection to an empty array (like clearcollMonthWinnerI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMonthWinnerI18ns($overrideExisting = true)
    {
        if (null !== $this->collMonthWinnerI18ns && !$overrideExisting) {
            return;
        }
        $this->collMonthWinnerI18ns = new PropelObjectCollection();
        $this->collMonthWinnerI18ns->setModel('MonthWinnerI18n');
    }

    /**
     * Gets an array of MonthWinnerI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this MonthWinner is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MonthWinnerI18n[] List of MonthWinnerI18n objects
     * @throws PropelException
     */
    public function getMonthWinnerI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMonthWinnerI18nsPartial && !$this->isNew();
        if (null === $this->collMonthWinnerI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMonthWinnerI18ns) {
                // return empty collection
                $this->initMonthWinnerI18ns();
            } else {
                $collMonthWinnerI18ns = MonthWinnerI18nQuery::create(null, $criteria)
                    ->filterByMonthWinner($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMonthWinnerI18nsPartial && count($collMonthWinnerI18ns)) {
                      $this->initMonthWinnerI18ns(false);

                      foreach ($collMonthWinnerI18ns as $obj) {
                        if (false == $this->collMonthWinnerI18ns->contains($obj)) {
                          $this->collMonthWinnerI18ns->append($obj);
                        }
                      }

                      $this->collMonthWinnerI18nsPartial = true;
                    }

                    $collMonthWinnerI18ns->getInternalIterator()->rewind();

                    return $collMonthWinnerI18ns;
                }

                if ($partial && $this->collMonthWinnerI18ns) {
                    foreach ($this->collMonthWinnerI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collMonthWinnerI18ns[] = $obj;
                        }
                    }
                }

                $this->collMonthWinnerI18ns = $collMonthWinnerI18ns;
                $this->collMonthWinnerI18nsPartial = false;
            }
        }

        return $this->collMonthWinnerI18ns;
    }

    /**
     * Sets a collection of MonthWinnerI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $monthWinnerI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return MonthWinner The current object (for fluent API support)
     */
    public function setMonthWinnerI18ns(PropelCollection $monthWinnerI18ns, PropelPDO $con = null)
    {
        $monthWinnerI18nsToDelete = $this->getMonthWinnerI18ns(new Criteria(), $con)->diff($monthWinnerI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->monthWinnerI18nsScheduledForDeletion = clone $monthWinnerI18nsToDelete;

        foreach ($monthWinnerI18nsToDelete as $monthWinnerI18nRemoved) {
            $monthWinnerI18nRemoved->setMonthWinner(null);
        }

        $this->collMonthWinnerI18ns = null;
        foreach ($monthWinnerI18ns as $monthWinnerI18n) {
            $this->addMonthWinnerI18n($monthWinnerI18n);
        }

        $this->collMonthWinnerI18ns = $monthWinnerI18ns;
        $this->collMonthWinnerI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MonthWinnerI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MonthWinnerI18n objects.
     * @throws PropelException
     */
    public function countMonthWinnerI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMonthWinnerI18nsPartial && !$this->isNew();
        if (null === $this->collMonthWinnerI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMonthWinnerI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMonthWinnerI18ns());
            }
            $query = MonthWinnerI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMonthWinner($this)
                ->count($con);
        }

        return count($this->collMonthWinnerI18ns);
    }

    /**
     * Method called to associate a MonthWinnerI18n object to this object
     * through the MonthWinnerI18n foreign key attribute.
     *
     * @param    MonthWinnerI18n $l MonthWinnerI18n
     * @return MonthWinner The current object (for fluent API support)
     */
    public function addMonthWinnerI18n(MonthWinnerI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collMonthWinnerI18ns === null) {
            $this->initMonthWinnerI18ns();
            $this->collMonthWinnerI18nsPartial = true;
        }

        if (!in_array($l, $this->collMonthWinnerI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMonthWinnerI18n($l);

            if ($this->monthWinnerI18nsScheduledForDeletion and $this->monthWinnerI18nsScheduledForDeletion->contains($l)) {
                $this->monthWinnerI18nsScheduledForDeletion->remove($this->monthWinnerI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	MonthWinnerI18n $monthWinnerI18n The monthWinnerI18n object to add.
     */
    protected function doAddMonthWinnerI18n($monthWinnerI18n)
    {
        $this->collMonthWinnerI18ns[]= $monthWinnerI18n;
        $monthWinnerI18n->setMonthWinner($this);
    }

    /**
     * @param	MonthWinnerI18n $monthWinnerI18n The monthWinnerI18n object to remove.
     * @return MonthWinner The current object (for fluent API support)
     */
    public function removeMonthWinnerI18n($monthWinnerI18n)
    {
        if ($this->getMonthWinnerI18ns()->contains($monthWinnerI18n)) {
            $this->collMonthWinnerI18ns->remove($this->collMonthWinnerI18ns->search($monthWinnerI18n));
            if (null === $this->monthWinnerI18nsScheduledForDeletion) {
                $this->monthWinnerI18nsScheduledForDeletion = clone $this->collMonthWinnerI18ns;
                $this->monthWinnerI18nsScheduledForDeletion->clear();
            }
            $this->monthWinnerI18nsScheduledForDeletion[]= clone $monthWinnerI18n;
            $monthWinnerI18n->setMonthWinner(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_month_winner = null;
        $this->id_winner = null;
        $this->title = null;
        $this->onlune = null;
        $this->order = null;
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
            if ($this->collMonthWinnerI18ns) {
                foreach ($this->collMonthWinnerI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aWinner instanceof Persistent) {
              $this->aWinner->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collMonthWinnerI18ns instanceof PropelCollection) {
            $this->collMonthWinnerI18ns->clearIterator();
        }
        $this->collMonthWinnerI18ns = null;
        $this->aWinner = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MonthWinnerPeer::DEFAULT_STRING_FORMAT);
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
     * @return    MonthWinner The current object (for fluent API support)
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
     * @return MonthWinnerI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collMonthWinnerI18ns) {
                foreach ($this->collMonthWinnerI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new MonthWinnerI18n();
                $translation->setLocale($locale);
            } else {
                $translation = MonthWinnerI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addMonthWinnerI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    MonthWinner The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            MonthWinnerI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collMonthWinnerI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collMonthWinnerI18ns[$key]);
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
     * @return MonthWinnerI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [name] column value.
         * Titre
         * @return string
         */
        public function getName()
        {
        return $this->getCurrentTranslation()->getName();
    }


        /**
         * Set the value of [name] column.
         * Titre
         * @param  string $v new value
         * @return MonthWinnerI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
    }


        /**
         * Get the [text] column value.
         * Liste de gagnants
         * @return string
         */
        public function getText()
        {
        return $this->getCurrentTranslation()->getText();
    }


        /**
         * Set the value of [text] column.
         * Liste de gagnants
         * @param  string $v new value
         * @return MonthWinnerI18n The current object (for fluent API support)
         */
        public function setText($v)
        {    $this->getCurrentTranslation()->setText($v);

        return $this;
    }

    // TableStampBehavior behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     * @return     MonthWinner The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = MonthWinnerPeer::DATE_MODIFICATION;
        return $this;
    }

}
