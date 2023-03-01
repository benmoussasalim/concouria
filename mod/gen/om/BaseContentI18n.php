<?php


/**
 * Base class that represents a row from the 'content_i18n' table.
 *
 *
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseContentI18n extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ContentI18nPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ContentI18nPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_content field.
     * @var        int
     */
    protected $id_content;

    /**
     * The value for the locale field.
     * Note: this column has a database default value of: 'en_US'
     * @var        string
     */
    protected $locale;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the text field.
     * @var        string
     */
    protected $text;

    /**
     * The value for the meta_keyword field.
     * @var        string
     */
    protected $meta_keyword;

    /**
     * The value for the meta_description field.
     * @var        string
     */
    protected $meta_description;

    /**
     * The value for the meta_title field.
     * @var        string
     */
    protected $meta_title;

    /**
     * The value for the version field.
     * @var        int
     */
    protected $version;

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
     * @var        Content
     */
    protected $aContent;

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
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->locale = 'en_US';
    }

    /**
     * Initializes internal state of BaseContentI18n object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id_content] column value.
     *
     * @return int
     */
    public function getIdContent()
    {

        return $this->id_content;
    }

    /**
     * Get the [locale] column value.
     *
     * @return string
     */
    public function getLocale()
    {

        return $this->locale;
    }

    /**
     * Get the [name] column value.
     * Titre
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [text] column value.
     * Contenu
     * @return string
     */
    public function getText()
    {

        return $this->text;
    }

    /**
     * Get the [meta_keyword] column value.
     * Meta Keyword
     * @return string
     */
    public function getMetaKeyword()
    {

        return $this->meta_keyword;
    }

    /**
     * Get the [meta_description] column value.
     * Meta Description
     * @return string
     */
    public function getMetaDescription()
    {

        return $this->meta_description;
    }

    /**
     * Get the [meta_title] column value.
     * Meta Title
     * @return string
     */
    public function getMetaTitle()
    {

        return $this->meta_title;
    }

    /**
     * Get the [version] column value.
     *
     * @return int
     */
    public function getVersion()
    {

        return $this->version;
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
        $c->addSelectColumn(ContentI18nPeer::DATE_CREATION);
        try {
            $stmt = ContentI18nPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(ContentI18nPeer::DATE_MODIFICATION);
        try {
            $stmt = ContentI18nPeer::doSelectStmt($c, $con);
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
     * Set the value of [id_content] column.
     *
     * @param  int $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setIdContent($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_content !== $v) {
            $this->id_content = $v;
            $this->modifiedColumns[] = ContentI18nPeer::ID_CONTENT;
        }

        if ($this->aContent !== null && $this->aContent->getIdContent() !== $v) {
            $this->aContent = null;
        }


        return $this;
    } // setIdContent()

    /**
     * Set the value of [locale] column.
     *
     * @param  string $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setLocale($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->locale !== $v) {
            $this->locale = $v;
            $this->modifiedColumns[] = ContentI18nPeer::LOCALE;
        }


        return $this;
    } // setLocale()

    /**
     * Set the value of [name] column.
     * Titre
     * @param  string $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ContentI18nPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [text] column.
     * Contenu
     * @param  string $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text !== $v) {
            $this->text = $v;
            $this->modifiedColumns[] = ContentI18nPeer::TEXT;
        }


        return $this;
    } // setText()

    /**
     * Set the value of [meta_keyword] column.
     * Meta Keyword
     * @param  string $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setMetaKeyword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_keyword !== $v) {
            $this->meta_keyword = $v;
            $this->modifiedColumns[] = ContentI18nPeer::META_KEYWORD;
        }


        return $this;
    } // setMetaKeyword()

    /**
     * Set the value of [meta_description] column.
     * Meta Description
     * @param  string $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setMetaDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_description !== $v) {
            $this->meta_description = $v;
            $this->modifiedColumns[] = ContentI18nPeer::META_DESCRIPTION;
        }


        return $this;
    } // setMetaDescription()

    /**
     * Set the value of [meta_title] column.
     * Meta Title
     * @param  string $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setMetaTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_title !== $v) {
            $this->meta_title = $v;
            $this->modifiedColumns[] = ContentI18nPeer::META_TITLE;
        }


        return $this;
    } // setMetaTitle()

    /**
     * Set the value of [version] column.
     *
     * @param  int $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[] = ContentI18nPeer::VERSION;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = ContentI18nPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = ContentI18nPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = ContentI18nPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = ContentI18nPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = ContentI18nPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return ContentI18n The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = ContentI18nPeer::ID_MODIFICATION;
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
            if ($this->locale !== 'en_US') {
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

            $this->id_content = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->locale = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->text = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->meta_keyword = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->meta_description = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->meta_title = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->version = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->id_creation = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->id_modification = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 10; // 10 = ContentI18nPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating ContentI18n object", $e);
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

        if ($this->aContent !== null && $this->id_content !== $this->aContent->getIdContent()) {
            $this->aContent = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = ContentI18nPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->aContent = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='ContentI18n';}
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
        mem_clean('ContentI18n');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = ContentI18nQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('ContentI18n');
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

                        mem_clean('ContentI18n');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            ContentI18nPeer::addInstanceToPool($this);

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

            if ($this->aContent !== null) {
                if ($this->aContent->isModified() || $this->aContent->isNew()) {
                    $affectedRows += $this->aContent->save($con);
                }
                $this->setContent($this->aContent);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ContentI18nPeer::ID_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = '`id_content`';
        }
        if ($this->isColumnModified(ContentI18nPeer::LOCALE)) {
            $modifiedColumns[':p' . $index++]  = '`locale`';
        }
        if ($this->isColumnModified(ContentI18nPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(ContentI18nPeer::TEXT)) {
            $modifiedColumns[':p' . $index++]  = '`text`';
        }
        if ($this->isColumnModified(ContentI18nPeer::META_KEYWORD)) {
            $modifiedColumns[':p' . $index++]  = '`meta_keyword`';
        }
        if ($this->isColumnModified(ContentI18nPeer::META_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`meta_description`';
        }
        if ($this->isColumnModified(ContentI18nPeer::META_TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`meta_title`';
        }
        if ($this->isColumnModified(ContentI18nPeer::VERSION)) {
            $modifiedColumns[':p' . $index++]  = '`version`';
        }
        if ($this->isColumnModified(ContentI18nPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(ContentI18nPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(ContentI18nPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(ContentI18nPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `content_i18n` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_content`':
                        $stmt->bindValue($identifier, $this->id_content, PDO::PARAM_INT);
                        break;
                    case '`locale`':
                        $stmt->bindValue($identifier, $this->locale, PDO::PARAM_STR);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`text`':
                        $stmt->bindValue($identifier, $this->text, PDO::PARAM_STR);
                        break;
                    case '`meta_keyword`':
                        $stmt->bindValue($identifier, $this->meta_keyword, PDO::PARAM_STR);
                        break;
                    case '`meta_description`':
                        $stmt->bindValue($identifier, $this->meta_description, PDO::PARAM_STR);
                        break;
                    case '`meta_title`':
                        $stmt->bindValue($identifier, $this->meta_title, PDO::PARAM_STR);
                        break;
                    case '`version`':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='ContentI18n';}
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

            if ($this->aContent !== null) {
                if (!$this->aContent->validate($columns)) {$failureMap = array_merge($failureMap, $this->aContent->getValidationFailures()); }
            }

            if (($retval = ContentI18nPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ContentI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['ContentI18n'][serialize($this->getPrimaryKey())])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ContentI18n'][serialize($this->getPrimaryKey())] = true;
        $keys = ContentI18nPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdContent(),
            $keys[1] => $this->getLocale(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getText(),
            $keys[4] => $this->getMetaKeyword(),
            $keys[5] => $this->getMetaDescription(),
            $keys[6] => $this->getMetaTitle(),
            $keys[7] => $this->getVersion(),
            $keys[8] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[9] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[10] => $this->getIdCreation(),
            $keys[11] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aContent) {
                $result['Content'] = $this->aContent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ContentI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdContent($value);
                break;
            case 1:
                $this->setLocale($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setText($value);
                break;
            case 4:
                $this->setMetaKeyword($value);
                break;
            case 5:
                $this->setMetaDescription($value);
                break;
            case 6:
                $this->setMetaTitle($value);
                break;
            case 7:
                $this->setVersion($value);
                break;
            case 8:
                $this->setDateCreation($value);
                break;
            case 9:
                $this->setDateModification($value);
                break;
            case 10:
                $this->setIdCreation($value);
                break;
            case 11:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ContentI18nPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdContent($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setLocale($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setText($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setMetaKeyword($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setMetaDescription($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setMetaTitle($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setVersion($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDateCreation($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setDateModification($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setIdCreation($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setIdModification($arr[$keys[11]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(ContentI18nPeer::DATABASE_NAME);

        if ($this->isColumnModified(ContentI18nPeer::ID_CONTENT)) $criteria->add(ContentI18nPeer::ID_CONTENT, $this->id_content);
        if ($this->isColumnModified(ContentI18nPeer::LOCALE)) $criteria->add(ContentI18nPeer::LOCALE, $this->locale);
        if ($this->isColumnModified(ContentI18nPeer::NAME)) $criteria->add(ContentI18nPeer::NAME, $this->name);
        if ($this->isColumnModified(ContentI18nPeer::TEXT)) $criteria->add(ContentI18nPeer::TEXT, $this->text);
        if ($this->isColumnModified(ContentI18nPeer::META_KEYWORD)) $criteria->add(ContentI18nPeer::META_KEYWORD, $this->meta_keyword);
        if ($this->isColumnModified(ContentI18nPeer::META_DESCRIPTION)) $criteria->add(ContentI18nPeer::META_DESCRIPTION, $this->meta_description);
        if ($this->isColumnModified(ContentI18nPeer::META_TITLE)) $criteria->add(ContentI18nPeer::META_TITLE, $this->meta_title);
        if ($this->isColumnModified(ContentI18nPeer::VERSION)) $criteria->add(ContentI18nPeer::VERSION, $this->version);
        if ($this->isColumnModified(ContentI18nPeer::DATE_CREATION)) $criteria->add(ContentI18nPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(ContentI18nPeer::DATE_MODIFICATION)) $criteria->add(ContentI18nPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(ContentI18nPeer::ID_CREATION)) $criteria->add(ContentI18nPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(ContentI18nPeer::ID_MODIFICATION)) $criteria->add(ContentI18nPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(ContentI18nPeer::DATABASE_NAME);
        $criteria->add(ContentI18nPeer::ID_CONTENT, $this->id_content);
        $criteria->add(ContentI18nPeer::LOCALE, $this->locale);

        return $criteria;
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getIdContent();
        $pks[1] = $this->getLocale();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setIdContent($keys[0]);
        $this->setLocale($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return (null === $this->getIdContent()) && (null === $this->getLocale());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of ContentI18n (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdContent($this->getIdContent());
        $copyObj->setLocale($this->getLocale());
        $copyObj->setName($this->getName());
        $copyObj->setText($this->getText());
        $copyObj->setMetaKeyword($this->getMetaKeyword());
        $copyObj->setMetaDescription($this->getMetaDescription());
        $copyObj->setMetaTitle($this->getMetaTitle());
        $copyObj->setVersion($this->getVersion());
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

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return ContentI18n Clone of current object.
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
     * @return ContentI18nPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ContentI18nPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Content object.
     *
     * @param                  Content $v
     * @return ContentI18n The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContent(Content $v = null)
    {
        if ($v === null) {
            $this->setIdContent(NULL);
        } else {
            $this->setIdContent($v->getIdContent());
        }

        $this->aContent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Content object, it will not be re-added.
        if ($v !== null) {
            $v->addContentI18n($this);
        }


        return $this;
    }


    /**
     * Get the associated Content object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Content The associated Content object.
     * @throws PropelException
     */
    public function getContent(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aContent === null && ($this->id_content !== null) && $doQuery) {
            $this->aContent = ContentQuery::create()->findPk($this->id_content, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContent->addContentI18ns($this);
             */
        }

        return $this->aContent;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_content = null;
        $this->locale = null;
        $this->name = null;
        $this->text = null;
        $this->meta_keyword = null;
        $this->meta_description = null;
        $this->meta_title = null;
        $this->version = null;
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
            if ($this->aContent instanceof Persistent) {
              $this->aContent->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aContent = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ContentI18nPeer::DEFAULT_STRING_FORMAT);
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
     * @return     ContentI18n The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = ContentI18nPeer::DATE_MODIFICATION;
        return $this;
    }

}
