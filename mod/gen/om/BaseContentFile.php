<?php


/**
 * Base class that represents a row from the 'content_file' table.
 *
 * Upload d'images
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseContentFile extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ContentFilePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ContentFilePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_content_file field.
     * @var        int
     */
    protected $id_content_file;

    /**
     * The value for the id_content field.
     * @var        int
     */
    protected $id_content;

    /**
     * The value for the ext field.
     * @var        string
     */
    protected $ext;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the desc field.
     * @var        string
     */
    protected $desc;

    /**
     * The value for the index field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $index;

    /**
     * The value for the current field.
     * @var        int
     */
    protected $current;

    /**
     * The value for the size field.
     * @var        int
     */
    protected $size;

    /**
     * The value for the fichier field.
     * @var        string
     */
    protected $fichier;

    /**
     * The value for the blob field.
     * @var        resource
     */
    protected $blob;

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
        $this->index = 0;
    }

    /**
     * Initializes internal state of BaseContentFile object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id_content_file] column value.
     *
     * @return int
     */
    public function getIdContentFile()
    {

        return $this->id_content_file;
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
     * Get the [ext] column value.
     *
     * @return string
     */
    public function getExt()
    {

        return $this->ext;
    }

    /**
     * Get the [name] column value.
     * Name
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [desc] column value.
     * Description
     * @return string
     */
    public function getDesc()
    {

        return $this->desc;
    }

    /**
     * Get the [index] column value.
     * Ordre
     * @return int
     */
    public function getIndex()
    {

        return $this->index;
    }

    /**
     * Get the [current] column value.
     * Visible
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getCurrent()
    {
        if (null === $this->current) {
            return null;
        }
        $valueSet = ContentFilePeer::getValueSet(ContentFilePeer::CURRENT);
        if (!isset($valueSet[$this->current])) {
            throw new PropelException('Unknown stored enum key: ' . $this->current);
        }

        return $valueSet[$this->current];
    }

    /**
     * Get the [size] column value.
     * Poids
     * @return int
     */
    public function getSize()
    {

        return $this->size;
    }

    /**
     * Get the [fichier] column value.
     *
     * @return string
     */
    public function getFichier()
    {

        return $this->fichier;
    }

    /**
     * Get the [blob] column value.
     *
     * @return resource
     */
    public function getBlob()
    {

        return $this->blob;
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
        $c->addSelectColumn(ContentFilePeer::DATE_CREATION);
        try {
            $stmt = ContentFilePeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(ContentFilePeer::DATE_MODIFICATION);
        try {
            $stmt = ContentFilePeer::doSelectStmt($c, $con);
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
     * Set the value of [id_content_file] column.
     *
     * @param  int $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setIdContentFile($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_content_file !== $v) {
            $this->id_content_file = $v;
            $this->modifiedColumns[] = ContentFilePeer::ID_CONTENT_FILE;
        }


        return $this;
    } // setIdContentFile()

    /**
     * Set the value of [id_content] column.
     *
     * @param  int $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setIdContent($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_content !== $v) {
            $this->id_content = $v;
            $this->modifiedColumns[] = ContentFilePeer::ID_CONTENT;
        }

        if ($this->aContent !== null && $this->aContent->getIdContent() !== $v) {
            $this->aContent = null;
        }


        return $this;
    } // setIdContent()

    /**
     * Set the value of [ext] column.
     *
     * @param  string $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setExt($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ext !== $v) {
            $this->ext = $v;
            $this->modifiedColumns[] = ContentFilePeer::EXT;
        }


        return $this;
    } // setExt()

    /**
     * Set the value of [name] column.
     * Name
     * @param  string $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ContentFilePeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [desc] column.
     * Description
     * @param  string $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setDesc($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->desc !== $v) {
            $this->desc = $v;
            $this->modifiedColumns[] = ContentFilePeer::DESC;
        }


        return $this;
    } // setDesc()

    /**
     * Set the value of [index] column.
     * Ordre
     * @param  int $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setIndex($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->index !== $v) {
            $this->index = $v;
            $this->modifiedColumns[] = ContentFilePeer::INDEX;
        }


        return $this;
    } // setIndex()

    /**
     * Set the value of [current] column.
     * Visible
     * @param  int $v new value
     * @return ContentFile The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setCurrent($v)
    {
        if ($v !== null) {
            $valueSet = ContentFilePeer::getValueSet(ContentFilePeer::CURRENT);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->current !== $v) {
            $this->current = $v;
            $this->modifiedColumns[] = ContentFilePeer::CURRENT;
        }


        return $this;
    } // setCurrent()

    /**
     * Set the value of [size] column.
     * Poids
     * @param  int $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setSize($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->size !== $v) {
            $this->size = $v;
            $this->modifiedColumns[] = ContentFilePeer::SIZE;
        }


        return $this;
    } // setSize()

    /**
     * Set the value of [fichier] column.
     *
     * @param  string $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setFichier($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fichier !== $v) {
            $this->fichier = $v;
            $this->modifiedColumns[] = ContentFilePeer::FICHIER;
        }


        return $this;
    } // setFichier()

    /**
     * Set the value of [blob] column.
     *
     * @param  resource $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setBlob($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->blob = fopen('php://memory', 'r+');
            fwrite($this->blob, $v);
            rewind($this->blob);
        } else { // it's already a stream
            $this->blob = $v;
        }
        $this->modifiedColumns[] = ContentFilePeer::BLOB;


        return $this;
    } // setBlob()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return ContentFile The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = ContentFilePeer::DATE_CREATION;
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
                $this->modifiedColumns[] = ContentFilePeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return ContentFile The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = ContentFilePeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = ContentFilePeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = ContentFilePeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return ContentFile The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = ContentFilePeer::ID_MODIFICATION;
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
            if ($this->index !== 0) {
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

            $this->id_content_file = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_content = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->ext = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->desc = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->index = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->current = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->size = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->fichier = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            if ($row[$startcol + 9] !== null) {
                $this->blob = fopen('php://memory', 'r+');
                fwrite($this->blob, $row[$startcol + 9]);
                rewind($this->blob);
            } else {
                $this->blob = null;
            }
            $this->id_creation = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->id_modification = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 12; // 12 = ContentFilePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating ContentFile object", $e);
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
        if ($con === null) { $con = Propel::getConnection(ContentFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = ContentFilePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='ContentFile';}
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
        mem_clean('ContentFile');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(ContentFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = ContentFileQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(ContentFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('ContentFile');
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

                        mem_clean('ContentFile');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            ContentFilePeer::addInstanceToPool($this);

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

                if ($this->blob !== null && is_resource($this->blob)) {
                    rewind($this->blob);
                }

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

        $this->modifiedColumns[] = ContentFilePeer::ID_CONTENT_FILE;
        if (null !== $this->id_content_file) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ContentFilePeer::ID_CONTENT_FILE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ContentFilePeer::ID_CONTENT_FILE)) {
            $modifiedColumns[':p' . $index++]  = '`id_content_file`';
        }
        if ($this->isColumnModified(ContentFilePeer::ID_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = '`id_content`';
        }
        if ($this->isColumnModified(ContentFilePeer::EXT)) {
            $modifiedColumns[':p' . $index++]  = '`ext`';
        }
        if ($this->isColumnModified(ContentFilePeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(ContentFilePeer::DESC)) {
            $modifiedColumns[':p' . $index++]  = '`desc`';
        }
        if ($this->isColumnModified(ContentFilePeer::INDEX)) {
            $modifiedColumns[':p' . $index++]  = '`index`';
        }
        if ($this->isColumnModified(ContentFilePeer::CURRENT)) {
            $modifiedColumns[':p' . $index++]  = '`current`';
        }
        if ($this->isColumnModified(ContentFilePeer::SIZE)) {
            $modifiedColumns[':p' . $index++]  = '`size`';
        }
        if ($this->isColumnModified(ContentFilePeer::FICHIER)) {
            $modifiedColumns[':p' . $index++]  = '`fichier`';
        }
        if ($this->isColumnModified(ContentFilePeer::BLOB)) {
            $modifiedColumns[':p' . $index++]  = '`blob`';
        }
        if ($this->isColumnModified(ContentFilePeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(ContentFilePeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(ContentFilePeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(ContentFilePeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `content_file` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_content_file`':
                        $stmt->bindValue($identifier, $this->id_content_file, PDO::PARAM_INT);
                        break;
                    case '`id_content`':
                        $stmt->bindValue($identifier, $this->id_content, PDO::PARAM_INT);
                        break;
                    case '`ext`':
                        $stmt->bindValue($identifier, $this->ext, PDO::PARAM_STR);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`desc`':
                        $stmt->bindValue($identifier, $this->desc, PDO::PARAM_STR);
                        break;
                    case '`index`':
                        $stmt->bindValue($identifier, $this->index, PDO::PARAM_INT);
                        break;
                    case '`current`':
                        $stmt->bindValue($identifier, $this->current, PDO::PARAM_INT);
                        break;
                    case '`size`':
                        $stmt->bindValue($identifier, $this->size, PDO::PARAM_INT);
                        break;
                    case '`fichier`':
                        $stmt->bindValue($identifier, $this->fichier, PDO::PARAM_STR);
                        break;
                    case '`blob`':
                        if (is_resource($this->blob)) {
                            rewind($this->blob);
                        }
                        $stmt->bindValue($identifier, $this->blob, PDO::PARAM_LOB);
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
        $this->setIdContentFile($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='ContentFile';}
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

            if (($retval = ContentFilePeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ContentFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['ContentFile'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ContentFile'][$this->getPrimaryKey()] = true;
        $keys = ContentFilePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdContentFile(),
            $keys[1] => $this->getIdContent(),
            $keys[2] => $this->getExt(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getDesc(),
            $keys[5] => $this->getIndex(),
            $keys[6] => $this->getCurrent(),
            $keys[7] => $this->getSize(),
            $keys[8] => $this->getFichier(),
            $keys[9] => $this->getBlob(),
            $keys[10] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[11] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[12] => $this->getIdCreation(),
            $keys[13] => $this->getIdModification(),
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
        $pos = ContentFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdContentFile($value);
                break;
            case 1:
                $this->setIdContent($value);
                break;
            case 2:
                $this->setExt($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setDesc($value);
                break;
            case 5:
                $this->setIndex($value);
                break;
            case 6:
                $valueSet = ContentFilePeer::getValueSet(ContentFilePeer::CURRENT);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setCurrent($value);
                break;
            case 7:
                $this->setSize($value);
                break;
            case 8:
                $this->setFichier($value);
                break;
            case 9:
                $this->setBlob($value);
                break;
            case 10:
                $this->setDateCreation($value);
                break;
            case 11:
                $this->setDateModification($value);
                break;
            case 12:
                $this->setIdCreation($value);
                break;
            case 13:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ContentFilePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdContentFile($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdContent($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setExt($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDesc($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIndex($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCurrent($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setSize($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setFichier($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setBlob($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setDateCreation($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setDateModification($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setIdCreation($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setIdModification($arr[$keys[13]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(ContentFilePeer::DATABASE_NAME);

        if ($this->isColumnModified(ContentFilePeer::ID_CONTENT_FILE)) $criteria->add(ContentFilePeer::ID_CONTENT_FILE, $this->id_content_file);
        if ($this->isColumnModified(ContentFilePeer::ID_CONTENT)) $criteria->add(ContentFilePeer::ID_CONTENT, $this->id_content);
        if ($this->isColumnModified(ContentFilePeer::EXT)) $criteria->add(ContentFilePeer::EXT, $this->ext);
        if ($this->isColumnModified(ContentFilePeer::NAME)) $criteria->add(ContentFilePeer::NAME, $this->name);
        if ($this->isColumnModified(ContentFilePeer::DESC)) $criteria->add(ContentFilePeer::DESC, $this->desc);
        if ($this->isColumnModified(ContentFilePeer::INDEX)) $criteria->add(ContentFilePeer::INDEX, $this->index);
        if ($this->isColumnModified(ContentFilePeer::CURRENT)) $criteria->add(ContentFilePeer::CURRENT, $this->current);
        if ($this->isColumnModified(ContentFilePeer::SIZE)) $criteria->add(ContentFilePeer::SIZE, $this->size);
        if ($this->isColumnModified(ContentFilePeer::FICHIER)) $criteria->add(ContentFilePeer::FICHIER, $this->fichier);
        if ($this->isColumnModified(ContentFilePeer::BLOB)) $criteria->add(ContentFilePeer::BLOB, $this->blob);
        if ($this->isColumnModified(ContentFilePeer::DATE_CREATION)) $criteria->add(ContentFilePeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(ContentFilePeer::DATE_MODIFICATION)) $criteria->add(ContentFilePeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(ContentFilePeer::ID_CREATION)) $criteria->add(ContentFilePeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(ContentFilePeer::ID_MODIFICATION)) $criteria->add(ContentFilePeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(ContentFilePeer::DATABASE_NAME);
        $criteria->add(ContentFilePeer::ID_CONTENT_FILE, $this->id_content_file);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdContentFile();
    }

    /**
     * Generic method to set the primary key (id_content_file column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdContentFile($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdContentFile();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of ContentFile (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdContent($this->getIdContent());
        $copyObj->setExt($this->getExt());
        $copyObj->setName($this->getName());
        $copyObj->setDesc($this->getDesc());
        $copyObj->setIndex($this->getIndex());
        $copyObj->setCurrent($this->getCurrent());
        $copyObj->setSize($this->getSize());
        $copyObj->setFichier($this->getFichier());
        $copyObj->setBlob($this->getBlob());
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
            $copyObj->setIdContentFile(NULL); // this is a auto-increment column, so set to default value
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
     * @return ContentFile Clone of current object.
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
     * @return ContentFilePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ContentFilePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Content object.
     *
     * @param                  Content $v
     * @return ContentFile The current object (for fluent API support)
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
            $v->addContentFile($this);
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
                $this->aContent->addContentFiles($this);
             */
        }

        return $this->aContent;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_content_file = null;
        $this->id_content = null;
        $this->ext = null;
        $this->name = null;
        $this->desc = null;
        $this->index = null;
        $this->current = null;
        $this->size = null;
        $this->fichier = null;
        $this->blob = null;
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
        return (string) $this->exportTo(ContentFilePeer::DEFAULT_STRING_FORMAT);
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
     * @return     ContentFile The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = ContentFilePeer::DATE_MODIFICATION;
        return $this;
    }

}
