<?php


/**
 * Base class that represents a row from the 'concours' table.
 *
 * Concours
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseConcours extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ConcoursPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ConcoursPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_concours field.
     * @var        int
     */
    protected $id_concours;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

    /**
     * The value for the price field.
     * @var        string
     */
    protected $price;

    /**
     * The value for the date field.
     * @var        string
     */
    protected $date;

    /**
     * The value for the online field.
     * @var        int
     */
    protected $online;

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
     * @var        PropelObjectCollection|ConcoursFile[] Collection to store aggregation of ConcoursFile objects.
     */
    protected $collConcoursFiles;
    protected $collConcoursFilesPartial;

    /**
     * @var        PropelObjectCollection|ConcoursI18n[] Collection to store aggregation of ConcoursI18n objects.
     */
    protected $collConcoursI18ns;
    protected $collConcoursI18nsPartial;

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
     * @var        array[ConcoursI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $concoursFilesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $concoursI18nsScheduledForDeletion = null;

    /**
     * Get the [id_concours] column value.
     *
     * @return int
     */
    public function getIdConcours()
    {

        return $this->id_concours;
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
     * Get the [url] column value.
     * Lien du concours
     * @return string
     */
    public function getUrl()
    {

        return $this->url;
    }

    /**
     * Get the [price] column value.
     * Valeur
     * @return string
     */
    public function getPrice()
    {

        return $this->price;
    }

    /**
     * Get the [optionally formatted] temporal [date] column value.
     * Date du tirage
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDate($format = 'Y-m-d')
    {
        if ($this->date === null) {
            return null;
        }

        if ($this->date === '0000-00-00') {
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
     * Get the [online] column value.
     * En ligne
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getOnline()
    {
        if (null === $this->online) {
            return null;
        }
        $valueSet = ConcoursPeer::getValueSet(ConcoursPeer::ONLINE);
        if (!isset($valueSet[$this->online])) {
            throw new PropelException('Unknown stored enum key: ' . $this->online);
        }

        return $valueSet[$this->online];
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
        $c->addSelectColumn(ConcoursPeer::DATE_CREATION);
        try {
            $stmt = ConcoursPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(ConcoursPeer::DATE_MODIFICATION);
        try {
            $stmt = ConcoursPeer::doSelectStmt($c, $con);
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
     * Set the value of [id_concours] column.
     *
     * @param  int $v new value
     * @return Concours The current object (for fluent API support)
     */
    public function setIdConcours($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_concours !== $v) {
            $this->id_concours = $v;
            $this->modifiedColumns[] = ConcoursPeer::ID_CONCOURS;
        }


        return $this;
    } // setIdConcours()

    /**
     * Set the value of [title] column.
     * Identifiant
     * @param  string $v new value
     * @return Concours The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = ConcoursPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [url] column.
     * Lien du concours
     * @param  string $v new value
     * @return Concours The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[] = ConcoursPeer::URL;
        }


        return $this;
    } // setUrl()

    /**
     * Set the value of [price] column.
     * Valeur
     * @param  string $v new value
     * @return Concours The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[] = ConcoursPeer::PRICE;
        }


        return $this;
    } // setPrice()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     * Date du tirage
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Concours The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date !== null || $dt !== null) {
            $currentDateAsString = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date = $newDateAsString;
                $this->modifiedColumns[] = ConcoursPeer::DATE;
            }
        } // if either are not null


        return $this;
    } // setDate()

    /**
     * Set the value of [online] column.
     * En ligne
     * @param  int $v new value
     * @return Concours The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setOnline($v)
    {
        if ($v !== null) {
            $valueSet = ConcoursPeer::getValueSet(ConcoursPeer::ONLINE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->online !== $v) {
            $this->online = $v;
            $this->modifiedColumns[] = ConcoursPeer::ONLINE;
        }


        return $this;
    } // setOnline()

    /**
     * Set the value of [order] column.
     * Ordre d'affichage
     * @param  int $v new value
     * @return Concours The current object (for fluent API support)
     */
    public function setOrder($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->order !== $v) {
            $this->order = $v;
            $this->modifiedColumns[] = ConcoursPeer::ORDER;
        }


        return $this;
    } // setOrder()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Concours The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = ConcoursPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = ConcoursPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Concours The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = ConcoursPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = ConcoursPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Concours The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = ConcoursPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Concours The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = ConcoursPeer::ID_MODIFICATION;
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

            $this->id_concours = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->title = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->url = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->price = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->date = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->online = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->order = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->id_creation = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->id_modification = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 9; // 9 = ConcoursPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Concours object", $e);
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
        if ($con === null) { $con = Propel::getConnection(ConcoursPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = ConcoursPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->collConcoursFiles = null;
            $this->collConcoursI18ns = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Concours';}
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
        mem_clean('Concours');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(ConcoursPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = ConcoursQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(ConcoursPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Concours');
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

                        mem_clean('Concours');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            ConcoursPeer::addInstanceToPool($this);

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

            if ($this->concoursFilesScheduledForDeletion !== null) {
                if (!$this->concoursFilesScheduledForDeletion->isEmpty()) {
                    ConcoursFileQuery::create()
                        ->filterByPrimaryKeys($this->concoursFilesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->concoursFilesScheduledForDeletion = null;
                }
            }

            if ($this->collConcoursFiles !== null) {
                foreach ($this->collConcoursFiles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->concoursI18nsScheduledForDeletion !== null) {
                if (!$this->concoursI18nsScheduledForDeletion->isEmpty()) {
                    ConcoursI18nQuery::create()
                        ->filterByPrimaryKeys($this->concoursI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->concoursI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collConcoursI18ns !== null) {
                foreach ($this->collConcoursI18ns as $referrerFK) {
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

        $this->modifiedColumns[] = ConcoursPeer::ID_CONCOURS;
        if (null !== $this->id_concours) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ConcoursPeer::ID_CONCOURS . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ConcoursPeer::ID_CONCOURS)) {
            $modifiedColumns[':p' . $index++]  = '`id_concours`';
        }
        if ($this->isColumnModified(ConcoursPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(ConcoursPeer::URL)) {
            $modifiedColumns[':p' . $index++]  = '`url`';
        }
        if ($this->isColumnModified(ConcoursPeer::PRICE)) {
            $modifiedColumns[':p' . $index++]  = '`price`';
        }
        if ($this->isColumnModified(ConcoursPeer::DATE)) {
            $modifiedColumns[':p' . $index++]  = '`date`';
        }
        if ($this->isColumnModified(ConcoursPeer::ONLINE)) {
            $modifiedColumns[':p' . $index++]  = '`online`';
        }
        if ($this->isColumnModified(ConcoursPeer::ORDER)) {
            $modifiedColumns[':p' . $index++]  = '`order`';
        }
        if ($this->isColumnModified(ConcoursPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(ConcoursPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(ConcoursPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(ConcoursPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `concours` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_concours`':
                        $stmt->bindValue($identifier, $this->id_concours, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`url`':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                    case '`price`':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_STR);
                        break;
                    case '`date`':
                        $stmt->bindValue($identifier, $this->date, PDO::PARAM_STR);
                        break;
                    case '`online`':
                        $stmt->bindValue($identifier, $this->online, PDO::PARAM_INT);
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
        $this->setIdConcours($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Concours';}
        $needeRight='a';
        if($this->getPrimaryKey()){$needeRight='w';}
        if(!$_SESSION[_AUTH_VAR]->hasRights($_SESSION['CurrentRights'],$needeRight,$this)){
            if(is_array($_SESSION['CurrentRights'])){
                foreach($_SESSION['CurrentRights'] as $Rigths){if($Rigths){$Entite = _($Rigths);}}
            }else{ $Entite = _($_SESSION['CurrentRights']);
            }$failureMap['Rights'] = new ValidationFailed('Rights', _('Droit insuffisant').'<br>'.$Entite.'-'.$needeRight, NULL);
        }

            if (($retval = ConcoursPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collConcoursFiles !== null) {
                    foreach ($this->collConcoursFiles as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collConcoursI18ns !== null) {
                    foreach ($this->collConcoursI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ConcoursPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Concours'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Concours'][$this->getPrimaryKey()] = true;
        $keys = ConcoursPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdConcours(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getUrl(),
            $keys[3] => $this->getPrice(),
            $keys[4] => $this->getDate(),
            $keys[5] => $this->getOnline(),
            $keys[6] => $this->getOrder(),
            $keys[7] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[8] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[9] => $this->getIdCreation(),
            $keys[10] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collConcoursFiles) {
                $result['ConcoursFiles'] = $this->collConcoursFiles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collConcoursI18ns) {
                $result['ConcoursI18ns'] = $this->collConcoursI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ConcoursPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdConcours($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setUrl($value);
                break;
            case 3:
                $this->setPrice($value);
                break;
            case 4:
                $this->setDate($value);
                break;
            case 5:
                $valueSet = ConcoursPeer::getValueSet(ConcoursPeer::ONLINE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setOnline($value);
                break;
            case 6:
                $this->setOrder($value);
                break;
            case 7:
                $this->setDateCreation($value);
                break;
            case 8:
                $this->setDateModification($value);
                break;
            case 9:
                $this->setIdCreation($value);
                break;
            case 10:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ConcoursPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdConcours($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUrl($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPrice($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDate($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setOnline($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setOrder($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDateCreation($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDateModification($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setIdCreation($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setIdModification($arr[$keys[10]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(ConcoursPeer::DATABASE_NAME);

        if ($this->isColumnModified(ConcoursPeer::ID_CONCOURS)) $criteria->add(ConcoursPeer::ID_CONCOURS, $this->id_concours);
        if ($this->isColumnModified(ConcoursPeer::TITLE)) $criteria->add(ConcoursPeer::TITLE, $this->title);
        if ($this->isColumnModified(ConcoursPeer::URL)) $criteria->add(ConcoursPeer::URL, $this->url);
        if ($this->isColumnModified(ConcoursPeer::PRICE)) $criteria->add(ConcoursPeer::PRICE, $this->price);
        if ($this->isColumnModified(ConcoursPeer::DATE)) $criteria->add(ConcoursPeer::DATE, $this->date);
        if ($this->isColumnModified(ConcoursPeer::ONLINE)) $criteria->add(ConcoursPeer::ONLINE, $this->online);
        if ($this->isColumnModified(ConcoursPeer::ORDER)) $criteria->add(ConcoursPeer::ORDER, $this->order);
        if ($this->isColumnModified(ConcoursPeer::DATE_CREATION)) $criteria->add(ConcoursPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(ConcoursPeer::DATE_MODIFICATION)) $criteria->add(ConcoursPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(ConcoursPeer::ID_CREATION)) $criteria->add(ConcoursPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(ConcoursPeer::ID_MODIFICATION)) $criteria->add(ConcoursPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(ConcoursPeer::DATABASE_NAME);
        $criteria->add(ConcoursPeer::ID_CONCOURS, $this->id_concours);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdConcours();
    }

    /**
     * Generic method to set the primary key (id_concours column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdConcours($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdConcours();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Concours (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setTitle($this->getTitle());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setPrice($this->getPrice());
        $copyObj->setDate($this->getDate());
        $copyObj->setOnline($this->getOnline());
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

            foreach ($this->getConcoursFiles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConcoursFile($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getConcoursI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConcoursI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdConcours(NULL); // this is a auto-increment column, so set to default value
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
     * @return Concours Clone of current object.
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
     * @return ConcoursPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ConcoursPeer();
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
        if ('ConcoursFile' == $relationName) {
            $this->initConcoursFiles();
        }
        if ('ConcoursI18n' == $relationName) {
            $this->initConcoursI18ns();
        }
    }

    /**
     * Clears out the collConcoursFiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Concours The current object (for fluent API support)
     * @see        addConcoursFiles()
     */
    public function clearConcoursFiles()
    {
        $this->collConcoursFiles = null; // important to set this to null since that means it is uninitialized
        $this->collConcoursFilesPartial = null;

        return $this;
    }

    /**
     * reset is the collConcoursFiles collection loaded partially
     *
     * @return void
     */
    public function resetPartialConcoursFiles($v = true)
    {
        $this->collConcoursFilesPartial = $v;
    }

    /**
     * Initializes the collConcoursFiles collection.
     *
     * By default this just sets the collConcoursFiles collection to an empty array (like clearcollConcoursFiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConcoursFiles($overrideExisting = true)
    {
        if (null !== $this->collConcoursFiles && !$overrideExisting) {
            return;
        }
        $this->collConcoursFiles = new PropelObjectCollection();
        $this->collConcoursFiles->setModel('ConcoursFile');
    }

    /**
     * Gets an array of ConcoursFile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Concours is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ConcoursFile[] List of ConcoursFile objects
     * @throws PropelException
     */
    public function getConcoursFiles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collConcoursFilesPartial && !$this->isNew();
        if (null === $this->collConcoursFiles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConcoursFiles) {
                // return empty collection
                $this->initConcoursFiles();
            } else {
                $collConcoursFiles = ConcoursFileQuery::create(null, $criteria)
                    ->filterByConcours($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collConcoursFilesPartial && count($collConcoursFiles)) {
                      $this->initConcoursFiles(false);

                      foreach ($collConcoursFiles as $obj) {
                        if (false == $this->collConcoursFiles->contains($obj)) {
                          $this->collConcoursFiles->append($obj);
                        }
                      }

                      $this->collConcoursFilesPartial = true;
                    }

                    $collConcoursFiles->getInternalIterator()->rewind();

                    return $collConcoursFiles;
                }

                if ($partial && $this->collConcoursFiles) {
                    foreach ($this->collConcoursFiles as $obj) {
                        if ($obj->isNew()) {
                            $collConcoursFiles[] = $obj;
                        }
                    }
                }

                $this->collConcoursFiles = $collConcoursFiles;
                $this->collConcoursFilesPartial = false;
            }
        }

        return $this->collConcoursFiles;
    }

    /**
     * Sets a collection of ConcoursFile objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $concoursFiles A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Concours The current object (for fluent API support)
     */
    public function setConcoursFiles(PropelCollection $concoursFiles, PropelPDO $con = null)
    {
        $concoursFilesToDelete = $this->getConcoursFiles(new Criteria(), $con)->diff($concoursFiles);


        $this->concoursFilesScheduledForDeletion = $concoursFilesToDelete;

        foreach ($concoursFilesToDelete as $concoursFileRemoved) {
            $concoursFileRemoved->setConcours(null);
        }

        $this->collConcoursFiles = null;
        foreach ($concoursFiles as $concoursFile) {
            $this->addConcoursFile($concoursFile);
        }

        $this->collConcoursFiles = $concoursFiles;
        $this->collConcoursFilesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ConcoursFile objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ConcoursFile objects.
     * @throws PropelException
     */
    public function countConcoursFiles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collConcoursFilesPartial && !$this->isNew();
        if (null === $this->collConcoursFiles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConcoursFiles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConcoursFiles());
            }
            $query = ConcoursFileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByConcours($this)
                ->count($con);
        }

        return count($this->collConcoursFiles);
    }

    /**
     * Method called to associate a ConcoursFile object to this object
     * through the ConcoursFile foreign key attribute.
     *
     * @param    ConcoursFile $l ConcoursFile
     * @return Concours The current object (for fluent API support)
     */
    public function addConcoursFile(ConcoursFile $l)
    {
        if ($this->collConcoursFiles === null) {
            $this->initConcoursFiles();
            $this->collConcoursFilesPartial = true;
        }

        if (!in_array($l, $this->collConcoursFiles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddConcoursFile($l);

            if ($this->concoursFilesScheduledForDeletion and $this->concoursFilesScheduledForDeletion->contains($l)) {
                $this->concoursFilesScheduledForDeletion->remove($this->concoursFilesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ConcoursFile $concoursFile The concoursFile object to add.
     */
    protected function doAddConcoursFile($concoursFile)
    {
        $this->collConcoursFiles[]= $concoursFile;
        $concoursFile->setConcours($this);
    }

    /**
     * @param	ConcoursFile $concoursFile The concoursFile object to remove.
     * @return Concours The current object (for fluent API support)
     */
    public function removeConcoursFile($concoursFile)
    {
        if ($this->getConcoursFiles()->contains($concoursFile)) {
            $this->collConcoursFiles->remove($this->collConcoursFiles->search($concoursFile));
            if (null === $this->concoursFilesScheduledForDeletion) {
                $this->concoursFilesScheduledForDeletion = clone $this->collConcoursFiles;
                $this->concoursFilesScheduledForDeletion->clear();
            }
            $this->concoursFilesScheduledForDeletion[]= clone $concoursFile;
            $concoursFile->setConcours(null);
        }

        return $this;
    }

    /**
     * Clears out the collConcoursI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Concours The current object (for fluent API support)
     * @see        addConcoursI18ns()
     */
    public function clearConcoursI18ns()
    {
        $this->collConcoursI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collConcoursI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collConcoursI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialConcoursI18ns($v = true)
    {
        $this->collConcoursI18nsPartial = $v;
    }

    /**
     * Initializes the collConcoursI18ns collection.
     *
     * By default this just sets the collConcoursI18ns collection to an empty array (like clearcollConcoursI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConcoursI18ns($overrideExisting = true)
    {
        if (null !== $this->collConcoursI18ns && !$overrideExisting) {
            return;
        }
        $this->collConcoursI18ns = new PropelObjectCollection();
        $this->collConcoursI18ns->setModel('ConcoursI18n');
    }

    /**
     * Gets an array of ConcoursI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Concours is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ConcoursI18n[] List of ConcoursI18n objects
     * @throws PropelException
     */
    public function getConcoursI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collConcoursI18nsPartial && !$this->isNew();
        if (null === $this->collConcoursI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConcoursI18ns) {
                // return empty collection
                $this->initConcoursI18ns();
            } else {
                $collConcoursI18ns = ConcoursI18nQuery::create(null, $criteria)
                    ->filterByConcours($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collConcoursI18nsPartial && count($collConcoursI18ns)) {
                      $this->initConcoursI18ns(false);

                      foreach ($collConcoursI18ns as $obj) {
                        if (false == $this->collConcoursI18ns->contains($obj)) {
                          $this->collConcoursI18ns->append($obj);
                        }
                      }

                      $this->collConcoursI18nsPartial = true;
                    }

                    $collConcoursI18ns->getInternalIterator()->rewind();

                    return $collConcoursI18ns;
                }

                if ($partial && $this->collConcoursI18ns) {
                    foreach ($this->collConcoursI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collConcoursI18ns[] = $obj;
                        }
                    }
                }

                $this->collConcoursI18ns = $collConcoursI18ns;
                $this->collConcoursI18nsPartial = false;
            }
        }

        return $this->collConcoursI18ns;
    }

    /**
     * Sets a collection of ConcoursI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $concoursI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Concours The current object (for fluent API support)
     */
    public function setConcoursI18ns(PropelCollection $concoursI18ns, PropelPDO $con = null)
    {
        $concoursI18nsToDelete = $this->getConcoursI18ns(new Criteria(), $con)->diff($concoursI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->concoursI18nsScheduledForDeletion = clone $concoursI18nsToDelete;

        foreach ($concoursI18nsToDelete as $concoursI18nRemoved) {
            $concoursI18nRemoved->setConcours(null);
        }

        $this->collConcoursI18ns = null;
        foreach ($concoursI18ns as $concoursI18n) {
            $this->addConcoursI18n($concoursI18n);
        }

        $this->collConcoursI18ns = $concoursI18ns;
        $this->collConcoursI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ConcoursI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ConcoursI18n objects.
     * @throws PropelException
     */
    public function countConcoursI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collConcoursI18nsPartial && !$this->isNew();
        if (null === $this->collConcoursI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConcoursI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConcoursI18ns());
            }
            $query = ConcoursI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByConcours($this)
                ->count($con);
        }

        return count($this->collConcoursI18ns);
    }

    /**
     * Method called to associate a ConcoursI18n object to this object
     * through the ConcoursI18n foreign key attribute.
     *
     * @param    ConcoursI18n $l ConcoursI18n
     * @return Concours The current object (for fluent API support)
     */
    public function addConcoursI18n(ConcoursI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collConcoursI18ns === null) {
            $this->initConcoursI18ns();
            $this->collConcoursI18nsPartial = true;
        }

        if (!in_array($l, $this->collConcoursI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddConcoursI18n($l);

            if ($this->concoursI18nsScheduledForDeletion and $this->concoursI18nsScheduledForDeletion->contains($l)) {
                $this->concoursI18nsScheduledForDeletion->remove($this->concoursI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ConcoursI18n $concoursI18n The concoursI18n object to add.
     */
    protected function doAddConcoursI18n($concoursI18n)
    {
        $this->collConcoursI18ns[]= $concoursI18n;
        $concoursI18n->setConcours($this);
    }

    /**
     * @param	ConcoursI18n $concoursI18n The concoursI18n object to remove.
     * @return Concours The current object (for fluent API support)
     */
    public function removeConcoursI18n($concoursI18n)
    {
        if ($this->getConcoursI18ns()->contains($concoursI18n)) {
            $this->collConcoursI18ns->remove($this->collConcoursI18ns->search($concoursI18n));
            if (null === $this->concoursI18nsScheduledForDeletion) {
                $this->concoursI18nsScheduledForDeletion = clone $this->collConcoursI18ns;
                $this->concoursI18nsScheduledForDeletion->clear();
            }
            $this->concoursI18nsScheduledForDeletion[]= clone $concoursI18n;
            $concoursI18n->setConcours(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_concours = null;
        $this->title = null;
        $this->url = null;
        $this->price = null;
        $this->date = null;
        $this->online = null;
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
            if ($this->collConcoursFiles) {
                foreach ($this->collConcoursFiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collConcoursI18ns) {
                foreach ($this->collConcoursI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collConcoursFiles instanceof PropelCollection) {
            $this->collConcoursFiles->clearIterator();
        }
        $this->collConcoursFiles = null;
        if ($this->collConcoursI18ns instanceof PropelCollection) {
            $this->collConcoursI18ns->clearIterator();
        }
        $this->collConcoursI18ns = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ConcoursPeer::DEFAULT_STRING_FORMAT);
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
     * @return    Concours The current object (for fluent API support)
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
     * @return ConcoursI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collConcoursI18ns) {
                foreach ($this->collConcoursI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ConcoursI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ConcoursI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addConcoursI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    Concours The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            ConcoursI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collConcoursI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collConcoursI18ns[$key]);
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
     * @return ConcoursI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [name] column value.
         * Nom du concours
         * @return string
         */
        public function getName()
        {
        return $this->getCurrentTranslation()->getName();
    }


        /**
         * Set the value of [name] column.
         * Nom du concours
         * @param  string $v new value
         * @return ConcoursI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
    }


        /**
         * Get the [text] column value.
         * Description
         * @return string
         */
        public function getText()
        {
        return $this->getCurrentTranslation()->getText();
    }


        /**
         * Set the value of [text] column.
         * Description
         * @param  string $v new value
         * @return ConcoursI18n The current object (for fluent API support)
         */
        public function setText($v)
        {    $this->getCurrentTranslation()->setText($v);

        return $this;
    }

    // TableStampBehavior behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     * @return     Concours The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = ConcoursPeer::DATE_MODIFICATION;
        return $this;
    }

}
