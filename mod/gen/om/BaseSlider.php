<?php


/**
 * Base class that represents a row from the 'slider' table.
 *
 * Slider
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseSlider extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'SliderPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        SliderPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_slider field.
     * @var        int
     */
    protected $id_slider;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the online field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $online;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

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
     * @var        PropelObjectCollection|SliderFile[] Collection to store aggregation of SliderFile objects.
     */
    protected $collSliderFiles;
    protected $collSliderFilesPartial;

    /**
     * @var        PropelObjectCollection|SliderI18n[] Collection to store aggregation of SliderI18n objects.
     */
    protected $collSliderI18ns;
    protected $collSliderI18nsPartial;

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
     * @var        array[SliderI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $sliderFilesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $sliderI18nsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->online = 0;
    }

    /**
     * Initializes internal state of BaseSlider object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id_slider] column value.
     *
     * @return int
     */
    public function getIdSlider()
    {

        return $this->id_slider;
    }

    /**
     * Get the [title] column value.
     * Titre
     * @return string
     */
    public function getTitle()
    {

        return $this->title;
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
        $valueSet = SliderPeer::getValueSet(SliderPeer::ONLINE);
        if (!isset($valueSet[$this->online])) {
            throw new PropelException('Unknown stored enum key: ' . $this->online);
        }

        return $valueSet[$this->online];
    }

    /**
     * Get the [url] column value.
     *
     * @return string
     */
    public function getUrl()
    {

        return $this->url;
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
        $c->addSelectColumn(SliderPeer::DATE_CREATION);
        try {
            $stmt = SliderPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(SliderPeer::DATE_MODIFICATION);
        try {
            $stmt = SliderPeer::doSelectStmt($c, $con);
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
     * Set the value of [id_slider] column.
     *
     * @param  int $v new value
     * @return Slider The current object (for fluent API support)
     */
    public function setIdSlider($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_slider !== $v) {
            $this->id_slider = $v;
            $this->modifiedColumns[] = SliderPeer::ID_SLIDER;
        }


        return $this;
    } // setIdSlider()

    /**
     * Set the value of [title] column.
     * Titre
     * @param  string $v new value
     * @return Slider The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = SliderPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [online] column.
     * En ligne
     * @param  int $v new value
     * @return Slider The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setOnline($v)
    {
        if ($v !== null) {
            $valueSet = SliderPeer::getValueSet(SliderPeer::ONLINE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->online !== $v) {
            $this->online = $v;
            $this->modifiedColumns[] = SliderPeer::ONLINE;
        }


        return $this;
    } // setOnline()

    /**
     * Set the value of [url] column.
     *
     * @param  string $v new value
     * @return Slider The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[] = SliderPeer::URL;
        }


        return $this;
    } // setUrl()

    /**
     * Set the value of [order] column.
     * Ordre d'affichage
     * @param  int $v new value
     * @return Slider The current object (for fluent API support)
     */
    public function setOrder($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->order !== $v) {
            $this->order = $v;
            $this->modifiedColumns[] = SliderPeer::ORDER;
        }


        return $this;
    } // setOrder()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Slider The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = SliderPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = SliderPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Slider The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = SliderPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = SliderPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Slider The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = SliderPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Slider The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = SliderPeer::ID_MODIFICATION;
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
            if ($this->online !== 0) {
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

            $this->id_slider = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->title = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->online = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->url = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->order = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->id_creation = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->id_modification = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 7; // 7 = SliderPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Slider object", $e);
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
        if ($con === null) { $con = Propel::getConnection(SliderPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = SliderPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->collSliderFiles = null;
            $this->collSliderI18ns = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Slider';}
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
        mem_clean('Slider');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(SliderPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = SliderQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(SliderPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Slider');
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

                        mem_clean('Slider');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            SliderPeer::addInstanceToPool($this);

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

            if ($this->sliderFilesScheduledForDeletion !== null) {
                if (!$this->sliderFilesScheduledForDeletion->isEmpty()) {
                    SliderFileQuery::create()
                        ->filterByPrimaryKeys($this->sliderFilesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sliderFilesScheduledForDeletion = null;
                }
            }

            if ($this->collSliderFiles !== null) {
                foreach ($this->collSliderFiles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sliderI18nsScheduledForDeletion !== null) {
                if (!$this->sliderI18nsScheduledForDeletion->isEmpty()) {
                    SliderI18nQuery::create()
                        ->filterByPrimaryKeys($this->sliderI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sliderI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSliderI18ns !== null) {
                foreach ($this->collSliderI18ns as $referrerFK) {
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

        $this->modifiedColumns[] = SliderPeer::ID_SLIDER;
        if (null !== $this->id_slider) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SliderPeer::ID_SLIDER . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SliderPeer::ID_SLIDER)) {
            $modifiedColumns[':p' . $index++]  = '`id_slider`';
        }
        if ($this->isColumnModified(SliderPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(SliderPeer::ONLINE)) {
            $modifiedColumns[':p' . $index++]  = '`online`';
        }
        if ($this->isColumnModified(SliderPeer::URL)) {
            $modifiedColumns[':p' . $index++]  = '`url`';
        }
        if ($this->isColumnModified(SliderPeer::ORDER)) {
            $modifiedColumns[':p' . $index++]  = '`order`';
        }
        if ($this->isColumnModified(SliderPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(SliderPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(SliderPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(SliderPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `slider` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_slider`':
                        $stmt->bindValue($identifier, $this->id_slider, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`online`':
                        $stmt->bindValue($identifier, $this->online, PDO::PARAM_INT);
                        break;
                    case '`url`':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
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
        $this->setIdSlider($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Slider';}
        $needeRight='a';
        if($this->getPrimaryKey()){$needeRight='w';}
        if(!$_SESSION[_AUTH_VAR]->hasRights($_SESSION['CurrentRights'],$needeRight,$this)){
            if(is_array($_SESSION['CurrentRights'])){
                foreach($_SESSION['CurrentRights'] as $Rigths){if($Rigths){$Entite = _($Rigths);}}
            }else{ $Entite = _($_SESSION['CurrentRights']);
            }$failureMap['Rights'] = new ValidationFailed('Rights', _('Droit insuffisant').'<br>'.$Entite.'-'.$needeRight, NULL);
        }

            if (($retval = SliderPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collSliderFiles !== null) {
                    foreach ($this->collSliderFiles as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collSliderI18ns !== null) {
                    foreach ($this->collSliderI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = SliderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Slider'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Slider'][$this->getPrimaryKey()] = true;
        $keys = SliderPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdSlider(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getOnline(),
            $keys[3] => $this->getUrl(),
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
            if (null !== $this->collSliderFiles) {
                $result['SliderFiles'] = $this->collSliderFiles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSliderI18ns) {
                $result['SliderI18ns'] = $this->collSliderI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = SliderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdSlider($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $valueSet = SliderPeer::getValueSet(SliderPeer::ONLINE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setOnline($value);
                break;
            case 3:
                $this->setUrl($value);
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
        $keys = SliderPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdSlider($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setOnline($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setUrl($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setOrder($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDateCreation($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDateModification($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setIdCreation($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setIdModification($arr[$keys[8]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(SliderPeer::DATABASE_NAME);

        if ($this->isColumnModified(SliderPeer::ID_SLIDER)) $criteria->add(SliderPeer::ID_SLIDER, $this->id_slider);
        if ($this->isColumnModified(SliderPeer::TITLE)) $criteria->add(SliderPeer::TITLE, $this->title);
        if ($this->isColumnModified(SliderPeer::ONLINE)) $criteria->add(SliderPeer::ONLINE, $this->online);
        if ($this->isColumnModified(SliderPeer::URL)) $criteria->add(SliderPeer::URL, $this->url);
        if ($this->isColumnModified(SliderPeer::ORDER)) $criteria->add(SliderPeer::ORDER, $this->order);
        if ($this->isColumnModified(SliderPeer::DATE_CREATION)) $criteria->add(SliderPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(SliderPeer::DATE_MODIFICATION)) $criteria->add(SliderPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(SliderPeer::ID_CREATION)) $criteria->add(SliderPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(SliderPeer::ID_MODIFICATION)) $criteria->add(SliderPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(SliderPeer::DATABASE_NAME);
        $criteria->add(SliderPeer::ID_SLIDER, $this->id_slider);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdSlider();
    }

    /**
     * Generic method to set the primary key (id_slider column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdSlider($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdSlider();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Slider (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setTitle($this->getTitle());
        $copyObj->setOnline($this->getOnline());
        $copyObj->setUrl($this->getUrl());
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

            foreach ($this->getSliderFiles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSliderFile($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSliderI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSliderI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdSlider(NULL); // this is a auto-increment column, so set to default value
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
     * @return Slider Clone of current object.
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
     * @return SliderPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new SliderPeer();
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
        if ('SliderFile' == $relationName) {
            $this->initSliderFiles();
        }
        if ('SliderI18n' == $relationName) {
            $this->initSliderI18ns();
        }
    }

    /**
     * Clears out the collSliderFiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Slider The current object (for fluent API support)
     * @see        addSliderFiles()
     */
    public function clearSliderFiles()
    {
        $this->collSliderFiles = null; // important to set this to null since that means it is uninitialized
        $this->collSliderFilesPartial = null;

        return $this;
    }

    /**
     * reset is the collSliderFiles collection loaded partially
     *
     * @return void
     */
    public function resetPartialSliderFiles($v = true)
    {
        $this->collSliderFilesPartial = $v;
    }

    /**
     * Initializes the collSliderFiles collection.
     *
     * By default this just sets the collSliderFiles collection to an empty array (like clearcollSliderFiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSliderFiles($overrideExisting = true)
    {
        if (null !== $this->collSliderFiles && !$overrideExisting) {
            return;
        }
        $this->collSliderFiles = new PropelObjectCollection();
        $this->collSliderFiles->setModel('SliderFile');
    }

    /**
     * Gets an array of SliderFile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Slider is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|SliderFile[] List of SliderFile objects
     * @throws PropelException
     */
    public function getSliderFiles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSliderFilesPartial && !$this->isNew();
        if (null === $this->collSliderFiles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSliderFiles) {
                // return empty collection
                $this->initSliderFiles();
            } else {
                $collSliderFiles = SliderFileQuery::create(null, $criteria)
                    ->filterBySlider($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSliderFilesPartial && count($collSliderFiles)) {
                      $this->initSliderFiles(false);

                      foreach ($collSliderFiles as $obj) {
                        if (false == $this->collSliderFiles->contains($obj)) {
                          $this->collSliderFiles->append($obj);
                        }
                      }

                      $this->collSliderFilesPartial = true;
                    }

                    $collSliderFiles->getInternalIterator()->rewind();

                    return $collSliderFiles;
                }

                if ($partial && $this->collSliderFiles) {
                    foreach ($this->collSliderFiles as $obj) {
                        if ($obj->isNew()) {
                            $collSliderFiles[] = $obj;
                        }
                    }
                }

                $this->collSliderFiles = $collSliderFiles;
                $this->collSliderFilesPartial = false;
            }
        }

        return $this->collSliderFiles;
    }

    /**
     * Sets a collection of SliderFile objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $sliderFiles A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Slider The current object (for fluent API support)
     */
    public function setSliderFiles(PropelCollection $sliderFiles, PropelPDO $con = null)
    {
        $sliderFilesToDelete = $this->getSliderFiles(new Criteria(), $con)->diff($sliderFiles);


        $this->sliderFilesScheduledForDeletion = $sliderFilesToDelete;

        foreach ($sliderFilesToDelete as $sliderFileRemoved) {
            $sliderFileRemoved->setSlider(null);
        }

        $this->collSliderFiles = null;
        foreach ($sliderFiles as $sliderFile) {
            $this->addSliderFile($sliderFile);
        }

        $this->collSliderFiles = $sliderFiles;
        $this->collSliderFilesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SliderFile objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related SliderFile objects.
     * @throws PropelException
     */
    public function countSliderFiles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSliderFilesPartial && !$this->isNew();
        if (null === $this->collSliderFiles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSliderFiles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSliderFiles());
            }
            $query = SliderFileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySlider($this)
                ->count($con);
        }

        return count($this->collSliderFiles);
    }

    /**
     * Method called to associate a SliderFile object to this object
     * through the SliderFile foreign key attribute.
     *
     * @param    SliderFile $l SliderFile
     * @return Slider The current object (for fluent API support)
     */
    public function addSliderFile(SliderFile $l)
    {
        if ($this->collSliderFiles === null) {
            $this->initSliderFiles();
            $this->collSliderFilesPartial = true;
        }

        if (!in_array($l, $this->collSliderFiles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSliderFile($l);

            if ($this->sliderFilesScheduledForDeletion and $this->sliderFilesScheduledForDeletion->contains($l)) {
                $this->sliderFilesScheduledForDeletion->remove($this->sliderFilesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	SliderFile $sliderFile The sliderFile object to add.
     */
    protected function doAddSliderFile($sliderFile)
    {
        $this->collSliderFiles[]= $sliderFile;
        $sliderFile->setSlider($this);
    }

    /**
     * @param	SliderFile $sliderFile The sliderFile object to remove.
     * @return Slider The current object (for fluent API support)
     */
    public function removeSliderFile($sliderFile)
    {
        if ($this->getSliderFiles()->contains($sliderFile)) {
            $this->collSliderFiles->remove($this->collSliderFiles->search($sliderFile));
            if (null === $this->sliderFilesScheduledForDeletion) {
                $this->sliderFilesScheduledForDeletion = clone $this->collSliderFiles;
                $this->sliderFilesScheduledForDeletion->clear();
            }
            $this->sliderFilesScheduledForDeletion[]= clone $sliderFile;
            $sliderFile->setSlider(null);
        }

        return $this;
    }

    /**
     * Clears out the collSliderI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Slider The current object (for fluent API support)
     * @see        addSliderI18ns()
     */
    public function clearSliderI18ns()
    {
        $this->collSliderI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collSliderI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collSliderI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialSliderI18ns($v = true)
    {
        $this->collSliderI18nsPartial = $v;
    }

    /**
     * Initializes the collSliderI18ns collection.
     *
     * By default this just sets the collSliderI18ns collection to an empty array (like clearcollSliderI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSliderI18ns($overrideExisting = true)
    {
        if (null !== $this->collSliderI18ns && !$overrideExisting) {
            return;
        }
        $this->collSliderI18ns = new PropelObjectCollection();
        $this->collSliderI18ns->setModel('SliderI18n');
    }

    /**
     * Gets an array of SliderI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Slider is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|SliderI18n[] List of SliderI18n objects
     * @throws PropelException
     */
    public function getSliderI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSliderI18nsPartial && !$this->isNew();
        if (null === $this->collSliderI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSliderI18ns) {
                // return empty collection
                $this->initSliderI18ns();
            } else {
                $collSliderI18ns = SliderI18nQuery::create(null, $criteria)
                    ->filterBySlider($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSliderI18nsPartial && count($collSliderI18ns)) {
                      $this->initSliderI18ns(false);

                      foreach ($collSliderI18ns as $obj) {
                        if (false == $this->collSliderI18ns->contains($obj)) {
                          $this->collSliderI18ns->append($obj);
                        }
                      }

                      $this->collSliderI18nsPartial = true;
                    }

                    $collSliderI18ns->getInternalIterator()->rewind();

                    return $collSliderI18ns;
                }

                if ($partial && $this->collSliderI18ns) {
                    foreach ($this->collSliderI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSliderI18ns[] = $obj;
                        }
                    }
                }

                $this->collSliderI18ns = $collSliderI18ns;
                $this->collSliderI18nsPartial = false;
            }
        }

        return $this->collSliderI18ns;
    }

    /**
     * Sets a collection of SliderI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $sliderI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Slider The current object (for fluent API support)
     */
    public function setSliderI18ns(PropelCollection $sliderI18ns, PropelPDO $con = null)
    {
        $sliderI18nsToDelete = $this->getSliderI18ns(new Criteria(), $con)->diff($sliderI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sliderI18nsScheduledForDeletion = clone $sliderI18nsToDelete;

        foreach ($sliderI18nsToDelete as $sliderI18nRemoved) {
            $sliderI18nRemoved->setSlider(null);
        }

        $this->collSliderI18ns = null;
        foreach ($sliderI18ns as $sliderI18n) {
            $this->addSliderI18n($sliderI18n);
        }

        $this->collSliderI18ns = $sliderI18ns;
        $this->collSliderI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SliderI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related SliderI18n objects.
     * @throws PropelException
     */
    public function countSliderI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSliderI18nsPartial && !$this->isNew();
        if (null === $this->collSliderI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSliderI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSliderI18ns());
            }
            $query = SliderI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySlider($this)
                ->count($con);
        }

        return count($this->collSliderI18ns);
    }

    /**
     * Method called to associate a SliderI18n object to this object
     * through the SliderI18n foreign key attribute.
     *
     * @param    SliderI18n $l SliderI18n
     * @return Slider The current object (for fluent API support)
     */
    public function addSliderI18n(SliderI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSliderI18ns === null) {
            $this->initSliderI18ns();
            $this->collSliderI18nsPartial = true;
        }

        if (!in_array($l, $this->collSliderI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSliderI18n($l);

            if ($this->sliderI18nsScheduledForDeletion and $this->sliderI18nsScheduledForDeletion->contains($l)) {
                $this->sliderI18nsScheduledForDeletion->remove($this->sliderI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	SliderI18n $sliderI18n The sliderI18n object to add.
     */
    protected function doAddSliderI18n($sliderI18n)
    {
        $this->collSliderI18ns[]= $sliderI18n;
        $sliderI18n->setSlider($this);
    }

    /**
     * @param	SliderI18n $sliderI18n The sliderI18n object to remove.
     * @return Slider The current object (for fluent API support)
     */
    public function removeSliderI18n($sliderI18n)
    {
        if ($this->getSliderI18ns()->contains($sliderI18n)) {
            $this->collSliderI18ns->remove($this->collSliderI18ns->search($sliderI18n));
            if (null === $this->sliderI18nsScheduledForDeletion) {
                $this->sliderI18nsScheduledForDeletion = clone $this->collSliderI18ns;
                $this->sliderI18nsScheduledForDeletion->clear();
            }
            $this->sliderI18nsScheduledForDeletion[]= clone $sliderI18n;
            $sliderI18n->setSlider(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_slider = null;
        $this->title = null;
        $this->online = null;
        $this->url = null;
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
            if ($this->collSliderFiles) {
                foreach ($this->collSliderFiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSliderI18ns) {
                foreach ($this->collSliderI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collSliderFiles instanceof PropelCollection) {
            $this->collSliderFiles->clearIterator();
        }
        $this->collSliderFiles = null;
        if ($this->collSliderI18ns instanceof PropelCollection) {
            $this->collSliderI18ns->clearIterator();
        }
        $this->collSliderI18ns = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SliderPeer::DEFAULT_STRING_FORMAT);
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
     * @return    Slider The current object (for fluent API support)
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
     * @return SliderI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSliderI18ns) {
                foreach ($this->collSliderI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new SliderI18n();
                $translation->setLocale($locale);
            } else {
                $translation = SliderI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSliderI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    Slider The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            SliderI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSliderI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSliderI18ns[$key]);
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
     * @return SliderI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [text] column value.
         * Texte
         * @return string
         */
        public function getText()
        {
        return $this->getCurrentTranslation()->getText();
    }


        /**
         * Set the value of [text] column.
         * Texte
         * @param  string $v new value
         * @return SliderI18n The current object (for fluent API support)
         */
        public function setText($v)
        {    $this->getCurrentTranslation()->setText($v);

        return $this;
    }

    // TableStampBehavior behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     * @return     Slider The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = SliderPeer::DATE_MODIFICATION;
        return $this;
    }

}
