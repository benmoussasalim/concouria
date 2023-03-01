<?php


/**
 * Base class that represents a row from the 'block' table.
 *
 * Block
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseBlock extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'BlockPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        BlockPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_block field.
     * @var        int
     */
    protected $id_block;

    /**
     * The value for the id_content field.
     * @var        int
     */
    protected $id_content;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the status field.
     * @var        int
     */
    protected $status;

    /**
     * The value for the type field.
     * @var        int
     */
    protected $type;

    /**
     * The value for the id_parent field.
     * @var        int
     */
    protected $id_parent;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * The value for the order field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $order;

    /**
     * The value for the display field.
     * @var        int
     */
    protected $display;

    /**
     * The value for the slug field.
     * @var        string
     */
    protected $slug;

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
     * @var        Block
     */
    protected $aBlockRelatedByIdParent;

    /**
     * @var        Content
     */
    protected $aContent;

    /**
     * @var        PropelObjectCollection|Block[] Collection to store aggregation of Block objects.
     */
    protected $collBlocksRelatedByIdBlock;
    protected $collBlocksRelatedByIdBlockPartial;

    /**
     * @var        PropelObjectCollection|BlockFile[] Collection to store aggregation of BlockFile objects.
     */
    protected $collBlockFiles;
    protected $collBlockFilesPartial;

    /**
     * @var        PropelObjectCollection|BlockI18nVersion[] Collection to store aggregation of BlockI18nVersion objects.
     */
    protected $collBlockI18nVersions;
    protected $collBlockI18nVersionsPartial;

    /**
     * @var        PropelObjectCollection|BlockI18n[] Collection to store aggregation of BlockI18n objects.
     */
    protected $collBlockI18ns;
    protected $collBlockI18nsPartial;

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
     * @var        array[BlockI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $blocksRelatedByIdBlockScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $blockFilesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $blockI18nVersionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $blockI18nsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->order = 0;
    }

    /**
     * Initializes internal state of BaseBlock object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id_block] column value.
     *
     * @return int
     */
    public function getIdBlock()
    {

        return $this->id_block;
    }

    /**
     * Get the [id_content] column value.
     * Contenu associé
     * @return int
     */
    public function getIdContent()
    {

        return $this->id_content;
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
        $valueSet = BlockPeer::getValueSet(BlockPeer::STATUS);
        if (!isset($valueSet[$this->status])) {
            throw new PropelException('Unknown stored enum key: ' . $this->status);
        }

        return $valueSet[$this->status];
    }

    /**
     * Get the [type] column value.
     * Type de block
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getType()
    {
        if (null === $this->type) {
            return null;
        }
        $valueSet = BlockPeer::getValueSet(BlockPeer::TYPE);
        if (!isset($valueSet[$this->type])) {
            throw new PropelException('Unknown stored enum key: ' . $this->type);
        }

        return $valueSet[$this->type];
    }

    /**
     * Get the [id_parent] column value.
     * Block parent
     * @return int
     */
    public function getIdParent()
    {

        return $this->id_parent;
    }

    /**
     * Get the [position] column value.
     * Positionnement
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getPosition()
    {
        if (null === $this->position) {
            return null;
        }
        $valueSet = BlockPeer::getValueSet(BlockPeer::POSITION);
        if (!isset($valueSet[$this->position])) {
            throw new PropelException('Unknown stored enum key: ' . $this->position);
        }

        return $valueSet[$this->position];
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
     * Get the [display] column value.
     * Affichage
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getDisplay()
    {
        if (null === $this->display) {
            return null;
        }
        $valueSet = BlockPeer::getValueSet(BlockPeer::DISPLAY);
        if (!isset($valueSet[$this->display])) {
            throw new PropelException('Unknown stored enum key: ' . $this->display);
        }

        return $valueSet[$this->display];
    }

    /**
     * Get the [slug] column value.
     * Class du block
     * @return string
     */
    public function getSlug()
    {

        return $this->slug;
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
        $c->addSelectColumn(BlockPeer::DATE_CREATION);
        try {
            $stmt = BlockPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(BlockPeer::DATE_MODIFICATION);
        try {
            $stmt = BlockPeer::doSelectStmt($c, $con);
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
     * Set the value of [id_block] column.
     *
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     */
    public function setIdBlock($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_block !== $v) {
            $this->id_block = $v;
            $this->modifiedColumns[] = BlockPeer::ID_BLOCK;
        }


        return $this;
    } // setIdBlock()

    /**
     * Set the value of [id_content] column.
     * Contenu associé
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     */
    public function setIdContent($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_content !== $v) {
            $this->id_content = $v;
            $this->modifiedColumns[] = BlockPeer::ID_CONTENT;
        }

        if ($this->aContent !== null && $this->aContent->getIdContent() !== $v) {
            $this->aContent = null;
        }


        return $this;
    } // setIdContent()

    /**
     * Set the value of [title] column.
     * Titre
     * @param  string $v new value
     * @return Block The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = BlockPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [status] column.
     * Status
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $valueSet = BlockPeer::getValueSet(BlockPeer::STATUS);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[] = BlockPeer::STATUS;
        }


        return $this;
    } // setStatus()

    /**
     * Set the value of [type] column.
     * Type de block
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setType($v)
    {
        if ($v !== null) {
            $valueSet = BlockPeer::getValueSet(BlockPeer::TYPE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = BlockPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [id_parent] column.
     * Block parent
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     */
    public function setIdParent($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_parent !== $v) {
            $this->id_parent = $v;
            $this->modifiedColumns[] = BlockPeer::ID_PARENT;
        }

        if ($this->aBlockRelatedByIdParent !== null && $this->aBlockRelatedByIdParent->getIdBlock() !== $v) {
            $this->aBlockRelatedByIdParent = null;
        }


        return $this;
    } // setIdParent()

    /**
     * Set the value of [position] column.
     * Positionnement
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $valueSet = BlockPeer::getValueSet(BlockPeer::POSITION);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[] = BlockPeer::POSITION;
        }


        return $this;
    } // setPosition()

    /**
     * Set the value of [order] column.
     * Ordre d'affichage
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     */
    public function setOrder($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->order !== $v) {
            $this->order = $v;
            $this->modifiedColumns[] = BlockPeer::ORDER;
        }


        return $this;
    } // setOrder()

    /**
     * Set the value of [display] column.
     * Affichage
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setDisplay($v)
    {
        if ($v !== null) {
            $valueSet = BlockPeer::getValueSet(BlockPeer::DISPLAY);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->display !== $v) {
            $this->display = $v;
            $this->modifiedColumns[] = BlockPeer::DISPLAY;
        }


        return $this;
    } // setDisplay()

    /**
     * Set the value of [slug] column.
     * Class du block
     * @param  string $v new value
     * @return Block The current object (for fluent API support)
     */
    public function setSlug($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->slug !== $v) {
            $this->slug = $v;
            $this->modifiedColumns[] = BlockPeer::SLUG;
        }


        return $this;
    } // setSlug()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Block The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = BlockPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = BlockPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Block The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = BlockPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = BlockPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = BlockPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Block The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = BlockPeer::ID_MODIFICATION;
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
            if ($this->order !== 0) {
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

            $this->id_block = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_content = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->title = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->status = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->type = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->id_parent = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->position = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->order = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->display = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->slug = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->id_creation = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->id_modification = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 12; // 12 = BlockPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Block object", $e);
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
        if ($this->aBlockRelatedByIdParent !== null && $this->id_parent !== $this->aBlockRelatedByIdParent->getIdBlock()) {
            $this->aBlockRelatedByIdParent = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = BlockPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->aBlockRelatedByIdParent = null;
            $this->aContent = null;
            $this->collBlocksRelatedByIdBlock = null;
            $this->collBlockFiles = null;
            $this->collBlockI18nVersions = null;
            $this->collBlockI18ns = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Block';}
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
        mem_clean('Block');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = BlockQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Block');
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

                        mem_clean('Block');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            BlockPeer::addInstanceToPool($this);

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

            if ($this->aBlockRelatedByIdParent !== null) {
                if ($this->aBlockRelatedByIdParent->isModified() || $this->aBlockRelatedByIdParent->isNew()) {
                    $affectedRows += $this->aBlockRelatedByIdParent->save($con);
                }
                $this->setBlockRelatedByIdParent($this->aBlockRelatedByIdParent);
            }

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

            if ($this->blocksRelatedByIdBlockScheduledForDeletion !== null) {
                if (!$this->blocksRelatedByIdBlockScheduledForDeletion->isEmpty()) {
                    BlockQuery::create()
                        ->filterByPrimaryKeys($this->blocksRelatedByIdBlockScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->blocksRelatedByIdBlockScheduledForDeletion = null;
                }
            }

            if ($this->collBlocksRelatedByIdBlock !== null) {
                foreach ($this->collBlocksRelatedByIdBlock as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->blockFilesScheduledForDeletion !== null) {
                if (!$this->blockFilesScheduledForDeletion->isEmpty()) {
                    BlockFileQuery::create()
                        ->filterByPrimaryKeys($this->blockFilesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->blockFilesScheduledForDeletion = null;
                }
            }

            if ($this->collBlockFiles !== null) {
                foreach ($this->collBlockFiles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->blockI18nVersionsScheduledForDeletion !== null) {
                if (!$this->blockI18nVersionsScheduledForDeletion->isEmpty()) {
                    BlockI18nVersionQuery::create()
                        ->filterByPrimaryKeys($this->blockI18nVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->blockI18nVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collBlockI18nVersions !== null) {
                foreach ($this->collBlockI18nVersions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->blockI18nsScheduledForDeletion !== null) {
                if (!$this->blockI18nsScheduledForDeletion->isEmpty()) {
                    BlockI18nQuery::create()
                        ->filterByPrimaryKeys($this->blockI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->blockI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collBlockI18ns !== null) {
                foreach ($this->collBlockI18ns as $referrerFK) {
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

        $this->modifiedColumns[] = BlockPeer::ID_BLOCK;
        if (null !== $this->id_block) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BlockPeer::ID_BLOCK . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BlockPeer::ID_BLOCK)) {
            $modifiedColumns[':p' . $index++]  = '`id_block`';
        }
        if ($this->isColumnModified(BlockPeer::ID_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = '`id_content`';
        }
        if ($this->isColumnModified(BlockPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(BlockPeer::STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`status`';
        }
        if ($this->isColumnModified(BlockPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(BlockPeer::ID_PARENT)) {
            $modifiedColumns[':p' . $index++]  = '`id_parent`';
        }
        if ($this->isColumnModified(BlockPeer::POSITION)) {
            $modifiedColumns[':p' . $index++]  = '`position`';
        }
        if ($this->isColumnModified(BlockPeer::ORDER)) {
            $modifiedColumns[':p' . $index++]  = '`order`';
        }
        if ($this->isColumnModified(BlockPeer::DISPLAY)) {
            $modifiedColumns[':p' . $index++]  = '`display`';
        }
        if ($this->isColumnModified(BlockPeer::SLUG)) {
            $modifiedColumns[':p' . $index++]  = '`slug`';
        }
        if ($this->isColumnModified(BlockPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(BlockPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(BlockPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(BlockPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `block` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_block`':
                        $stmt->bindValue($identifier, $this->id_block, PDO::PARAM_INT);
                        break;
                    case '`id_content`':
                        $stmt->bindValue($identifier, $this->id_content, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`status`':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case '`id_parent`':
                        $stmt->bindValue($identifier, $this->id_parent, PDO::PARAM_INT);
                        break;
                    case '`position`':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case '`order`':
                        $stmt->bindValue($identifier, $this->order, PDO::PARAM_INT);
                        break;
                    case '`display`':
                        $stmt->bindValue($identifier, $this->display, PDO::PARAM_INT);
                        break;
                    case '`slug`':
                        $stmt->bindValue($identifier, $this->slug, PDO::PARAM_STR);
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
        $this->setIdBlock($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Block';}
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

            if ($this->aBlockRelatedByIdParent !== null) {
                if (!$this->aBlockRelatedByIdParent->validate($columns)) {$failureMap = array_merge($failureMap, $this->aBlockRelatedByIdParent->getValidationFailures()); }
            }

            if ($this->aContent !== null) {
                if (!$this->aContent->validate($columns)) {$failureMap = array_merge($failureMap, $this->aContent->getValidationFailures()); }
            }

            if (($retval = BlockPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collBlocksRelatedByIdBlock !== null) {
                    foreach ($this->collBlocksRelatedByIdBlock as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collBlockFiles !== null) {
                    foreach ($this->collBlockFiles as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collBlockI18nVersions !== null) {
                    foreach ($this->collBlockI18nVersions as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collBlockI18ns !== null) {
                    foreach ($this->collBlockI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = BlockPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Block'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Block'][$this->getPrimaryKey()] = true;
        $keys = BlockPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdBlock(),
            $keys[1] => $this->getIdContent(),
            $keys[2] => $this->getTitle(),
            $keys[3] => $this->getStatus(),
            $keys[4] => $this->getType(),
            $keys[5] => $this->getIdParent(),
            $keys[6] => $this->getPosition(),
            $keys[7] => $this->getOrder(),
            $keys[8] => $this->getDisplay(),
            $keys[9] => $this->getSlug(),
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
            if (null !== $this->aBlockRelatedByIdParent) {
                $result['BlockRelatedByIdParent'] = $this->aBlockRelatedByIdParent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aContent) {
                $result['Content'] = $this->aContent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collBlocksRelatedByIdBlock) {
                $result['BlocksRelatedByIdBlock'] = $this->collBlocksRelatedByIdBlock->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBlockFiles) {
                $result['BlockFiles'] = $this->collBlockFiles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBlockI18nVersions) {
                $result['BlockI18nVersions'] = $this->collBlockI18nVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBlockI18ns) {
                $result['BlockI18ns'] = $this->collBlockI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = BlockPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdBlock($value);
                break;
            case 1:
                $this->setIdContent($value);
                break;
            case 2:
                $this->setTitle($value);
                break;
            case 3:
                $valueSet = BlockPeer::getValueSet(BlockPeer::STATUS);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setStatus($value);
                break;
            case 4:
                $valueSet = BlockPeer::getValueSet(BlockPeer::TYPE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setType($value);
                break;
            case 5:
                $this->setIdParent($value);
                break;
            case 6:
                $valueSet = BlockPeer::getValueSet(BlockPeer::POSITION);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setPosition($value);
                break;
            case 7:
                $this->setOrder($value);
                break;
            case 8:
                $valueSet = BlockPeer::getValueSet(BlockPeer::DISPLAY);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setDisplay($value);
                break;
            case 9:
                $this->setSlug($value);
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
        $keys = BlockPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdBlock($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdContent($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setStatus($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setType($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIdParent($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setPosition($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setOrder($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDisplay($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setSlug($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setDateCreation($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setDateModification($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setIdCreation($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setIdModification($arr[$keys[13]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(BlockPeer::DATABASE_NAME);

        if ($this->isColumnModified(BlockPeer::ID_BLOCK)) $criteria->add(BlockPeer::ID_BLOCK, $this->id_block);
        if ($this->isColumnModified(BlockPeer::ID_CONTENT)) $criteria->add(BlockPeer::ID_CONTENT, $this->id_content);
        if ($this->isColumnModified(BlockPeer::TITLE)) $criteria->add(BlockPeer::TITLE, $this->title);
        if ($this->isColumnModified(BlockPeer::STATUS)) $criteria->add(BlockPeer::STATUS, $this->status);
        if ($this->isColumnModified(BlockPeer::TYPE)) $criteria->add(BlockPeer::TYPE, $this->type);
        if ($this->isColumnModified(BlockPeer::ID_PARENT)) $criteria->add(BlockPeer::ID_PARENT, $this->id_parent);
        if ($this->isColumnModified(BlockPeer::POSITION)) $criteria->add(BlockPeer::POSITION, $this->position);
        if ($this->isColumnModified(BlockPeer::ORDER)) $criteria->add(BlockPeer::ORDER, $this->order);
        if ($this->isColumnModified(BlockPeer::DISPLAY)) $criteria->add(BlockPeer::DISPLAY, $this->display);
        if ($this->isColumnModified(BlockPeer::SLUG)) $criteria->add(BlockPeer::SLUG, $this->slug);
        if ($this->isColumnModified(BlockPeer::DATE_CREATION)) $criteria->add(BlockPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(BlockPeer::DATE_MODIFICATION)) $criteria->add(BlockPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(BlockPeer::ID_CREATION)) $criteria->add(BlockPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(BlockPeer::ID_MODIFICATION)) $criteria->add(BlockPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(BlockPeer::DATABASE_NAME);
        $criteria->add(BlockPeer::ID_BLOCK, $this->id_block);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdBlock();
    }

    /**
     * Generic method to set the primary key (id_block column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdBlock($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdBlock();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Block (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdContent($this->getIdContent());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setType($this->getType());
        $copyObj->setIdParent($this->getIdParent());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setOrder($this->getOrder());
        $copyObj->setDisplay($this->getDisplay());
        $copyObj->setSlug($this->getSlug());
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

            foreach ($this->getBlocksRelatedByIdBlock() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBlockRelatedByIdBlock($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBlockFiles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBlockFile($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBlockI18nVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBlockI18nVersion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBlockI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBlockI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdBlock(NULL); // this is a auto-increment column, so set to default value
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
     * @return Block Clone of current object.
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
     * @return BlockPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new BlockPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Block object.
     *
     * @param                  Block $v
     * @return Block The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBlockRelatedByIdParent(Block $v = null)
    {
        if ($v === null) {
            $this->setIdParent(NULL);
        } else {
            $this->setIdParent($v->getIdBlock());
        }

        $this->aBlockRelatedByIdParent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Block object, it will not be re-added.
        if ($v !== null) {
            $v->addBlockRelatedByIdBlock($this);
        }


        return $this;
    }


    /**
     * Get the associated Block object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Block The associated Block object.
     * @throws PropelException
     */
    public function getBlockRelatedByIdParent(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aBlockRelatedByIdParent === null && ($this->id_parent !== null) && $doQuery) {
            $this->aBlockRelatedByIdParent = BlockQuery::create()->findPk($this->id_parent, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBlockRelatedByIdParent->addBlocksRelatedByIdBlock($this);
             */
        }

        return $this->aBlockRelatedByIdParent;
    }

    /**
     * Declares an association between this object and a Content object.
     *
     * @param                  Content $v
     * @return Block The current object (for fluent API support)
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
            $v->addBlock($this);
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
                $this->aContent->addBlocks($this);
             */
        }

        return $this->aContent;
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
        if ('BlockRelatedByIdBlock' == $relationName) {
            $this->initBlocksRelatedByIdBlock();
        }
        if ('BlockFile' == $relationName) {
            $this->initBlockFiles();
        }
        if ('BlockI18nVersion' == $relationName) {
            $this->initBlockI18nVersions();
        }
        if ('BlockI18n' == $relationName) {
            $this->initBlockI18ns();
        }
    }

    /**
     * Clears out the collBlocksRelatedByIdBlock collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Block The current object (for fluent API support)
     * @see        addBlocksRelatedByIdBlock()
     */
    public function clearBlocksRelatedByIdBlock()
    {
        $this->collBlocksRelatedByIdBlock = null; // important to set this to null since that means it is uninitialized
        $this->collBlocksRelatedByIdBlockPartial = null;

        return $this;
    }

    /**
     * reset is the collBlocksRelatedByIdBlock collection loaded partially
     *
     * @return void
     */
    public function resetPartialBlocksRelatedByIdBlock($v = true)
    {
        $this->collBlocksRelatedByIdBlockPartial = $v;
    }

    /**
     * Initializes the collBlocksRelatedByIdBlock collection.
     *
     * By default this just sets the collBlocksRelatedByIdBlock collection to an empty array (like clearcollBlocksRelatedByIdBlock());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBlocksRelatedByIdBlock($overrideExisting = true)
    {
        if (null !== $this->collBlocksRelatedByIdBlock && !$overrideExisting) {
            return;
        }
        $this->collBlocksRelatedByIdBlock = new PropelObjectCollection();
        $this->collBlocksRelatedByIdBlock->setModel('Block');
    }

    /**
     * Gets an array of Block objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Block is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Block[] List of Block objects
     * @throws PropelException
     */
    public function getBlocksRelatedByIdBlock($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBlocksRelatedByIdBlockPartial && !$this->isNew();
        if (null === $this->collBlocksRelatedByIdBlock || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBlocksRelatedByIdBlock) {
                // return empty collection
                $this->initBlocksRelatedByIdBlock();
            } else {
                $collBlocksRelatedByIdBlock = BlockQuery::create(null, $criteria)
                    ->filterByBlockRelatedByIdParent($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBlocksRelatedByIdBlockPartial && count($collBlocksRelatedByIdBlock)) {
                      $this->initBlocksRelatedByIdBlock(false);

                      foreach ($collBlocksRelatedByIdBlock as $obj) {
                        if (false == $this->collBlocksRelatedByIdBlock->contains($obj)) {
                          $this->collBlocksRelatedByIdBlock->append($obj);
                        }
                      }

                      $this->collBlocksRelatedByIdBlockPartial = true;
                    }

                    $collBlocksRelatedByIdBlock->getInternalIterator()->rewind();

                    return $collBlocksRelatedByIdBlock;
                }

                if ($partial && $this->collBlocksRelatedByIdBlock) {
                    foreach ($this->collBlocksRelatedByIdBlock as $obj) {
                        if ($obj->isNew()) {
                            $collBlocksRelatedByIdBlock[] = $obj;
                        }
                    }
                }

                $this->collBlocksRelatedByIdBlock = $collBlocksRelatedByIdBlock;
                $this->collBlocksRelatedByIdBlockPartial = false;
            }
        }

        return $this->collBlocksRelatedByIdBlock;
    }

    /**
     * Sets a collection of BlockRelatedByIdBlock objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $blocksRelatedByIdBlock A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Block The current object (for fluent API support)
     */
    public function setBlocksRelatedByIdBlock(PropelCollection $blocksRelatedByIdBlock, PropelPDO $con = null)
    {
        $blocksRelatedByIdBlockToDelete = $this->getBlocksRelatedByIdBlock(new Criteria(), $con)->diff($blocksRelatedByIdBlock);


        $this->blocksRelatedByIdBlockScheduledForDeletion = $blocksRelatedByIdBlockToDelete;

        foreach ($blocksRelatedByIdBlockToDelete as $blockRelatedByIdBlockRemoved) {
            $blockRelatedByIdBlockRemoved->setBlockRelatedByIdParent(null);
        }

        $this->collBlocksRelatedByIdBlock = null;
        foreach ($blocksRelatedByIdBlock as $blockRelatedByIdBlock) {
            $this->addBlockRelatedByIdBlock($blockRelatedByIdBlock);
        }

        $this->collBlocksRelatedByIdBlock = $blocksRelatedByIdBlock;
        $this->collBlocksRelatedByIdBlockPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Block objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Block objects.
     * @throws PropelException
     */
    public function countBlocksRelatedByIdBlock(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBlocksRelatedByIdBlockPartial && !$this->isNew();
        if (null === $this->collBlocksRelatedByIdBlock || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBlocksRelatedByIdBlock) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBlocksRelatedByIdBlock());
            }
            $query = BlockQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBlockRelatedByIdParent($this)
                ->count($con);
        }

        return count($this->collBlocksRelatedByIdBlock);
    }

    /**
     * Method called to associate a Block object to this object
     * through the Block foreign key attribute.
     *
     * @param    Block $l Block
     * @return Block The current object (for fluent API support)
     */
    public function addBlockRelatedByIdBlock(Block $l)
    {
        if ($this->collBlocksRelatedByIdBlock === null) {
            $this->initBlocksRelatedByIdBlock();
            $this->collBlocksRelatedByIdBlockPartial = true;
        }

        if (!in_array($l, $this->collBlocksRelatedByIdBlock->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBlockRelatedByIdBlock($l);

            if ($this->blocksRelatedByIdBlockScheduledForDeletion and $this->blocksRelatedByIdBlockScheduledForDeletion->contains($l)) {
                $this->blocksRelatedByIdBlockScheduledForDeletion->remove($this->blocksRelatedByIdBlockScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	BlockRelatedByIdBlock $blockRelatedByIdBlock The blockRelatedByIdBlock object to add.
     */
    protected function doAddBlockRelatedByIdBlock($blockRelatedByIdBlock)
    {
        $this->collBlocksRelatedByIdBlock[]= $blockRelatedByIdBlock;
        $blockRelatedByIdBlock->setBlockRelatedByIdParent($this);
    }

    /**
     * @param	BlockRelatedByIdBlock $blockRelatedByIdBlock The blockRelatedByIdBlock object to remove.
     * @return Block The current object (for fluent API support)
     */
    public function removeBlockRelatedByIdBlock($blockRelatedByIdBlock)
    {
        if ($this->getBlocksRelatedByIdBlock()->contains($blockRelatedByIdBlock)) {
            $this->collBlocksRelatedByIdBlock->remove($this->collBlocksRelatedByIdBlock->search($blockRelatedByIdBlock));
            if (null === $this->blocksRelatedByIdBlockScheduledForDeletion) {
                $this->blocksRelatedByIdBlockScheduledForDeletion = clone $this->collBlocksRelatedByIdBlock;
                $this->blocksRelatedByIdBlockScheduledForDeletion->clear();
            }
            $this->blocksRelatedByIdBlockScheduledForDeletion[]= $blockRelatedByIdBlock;
            $blockRelatedByIdBlock->setBlockRelatedByIdParent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Block is new, it will return
     * an empty collection; or if this Block has previously
     * been saved, it will retrieve related BlocksRelatedByIdBlock from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Block.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Block[] List of Block objects
     */
    public function getBlocksRelatedByIdBlockJoinContent($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BlockQuery::create(null, $criteria);
        $query->joinWith('Content', $join_behavior);

        return $this->getBlocksRelatedByIdBlock($query, $con);
    }

    /**
     * Clears out the collBlockFiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Block The current object (for fluent API support)
     * @see        addBlockFiles()
     */
    public function clearBlockFiles()
    {
        $this->collBlockFiles = null; // important to set this to null since that means it is uninitialized
        $this->collBlockFilesPartial = null;

        return $this;
    }

    /**
     * reset is the collBlockFiles collection loaded partially
     *
     * @return void
     */
    public function resetPartialBlockFiles($v = true)
    {
        $this->collBlockFilesPartial = $v;
    }

    /**
     * Initializes the collBlockFiles collection.
     *
     * By default this just sets the collBlockFiles collection to an empty array (like clearcollBlockFiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBlockFiles($overrideExisting = true)
    {
        if (null !== $this->collBlockFiles && !$overrideExisting) {
            return;
        }
        $this->collBlockFiles = new PropelObjectCollection();
        $this->collBlockFiles->setModel('BlockFile');
    }

    /**
     * Gets an array of BlockFile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Block is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BlockFile[] List of BlockFile objects
     * @throws PropelException
     */
    public function getBlockFiles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBlockFilesPartial && !$this->isNew();
        if (null === $this->collBlockFiles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBlockFiles) {
                // return empty collection
                $this->initBlockFiles();
            } else {
                $collBlockFiles = BlockFileQuery::create(null, $criteria)
                    ->filterByBlock($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBlockFilesPartial && count($collBlockFiles)) {
                      $this->initBlockFiles(false);

                      foreach ($collBlockFiles as $obj) {
                        if (false == $this->collBlockFiles->contains($obj)) {
                          $this->collBlockFiles->append($obj);
                        }
                      }

                      $this->collBlockFilesPartial = true;
                    }

                    $collBlockFiles->getInternalIterator()->rewind();

                    return $collBlockFiles;
                }

                if ($partial && $this->collBlockFiles) {
                    foreach ($this->collBlockFiles as $obj) {
                        if ($obj->isNew()) {
                            $collBlockFiles[] = $obj;
                        }
                    }
                }

                $this->collBlockFiles = $collBlockFiles;
                $this->collBlockFilesPartial = false;
            }
        }

        return $this->collBlockFiles;
    }

    /**
     * Sets a collection of BlockFile objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $blockFiles A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Block The current object (for fluent API support)
     */
    public function setBlockFiles(PropelCollection $blockFiles, PropelPDO $con = null)
    {
        $blockFilesToDelete = $this->getBlockFiles(new Criteria(), $con)->diff($blockFiles);


        $this->blockFilesScheduledForDeletion = $blockFilesToDelete;

        foreach ($blockFilesToDelete as $blockFileRemoved) {
            $blockFileRemoved->setBlock(null);
        }

        $this->collBlockFiles = null;
        foreach ($blockFiles as $blockFile) {
            $this->addBlockFile($blockFile);
        }

        $this->collBlockFiles = $blockFiles;
        $this->collBlockFilesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BlockFile objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BlockFile objects.
     * @throws PropelException
     */
    public function countBlockFiles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBlockFilesPartial && !$this->isNew();
        if (null === $this->collBlockFiles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBlockFiles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBlockFiles());
            }
            $query = BlockFileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBlock($this)
                ->count($con);
        }

        return count($this->collBlockFiles);
    }

    /**
     * Method called to associate a BlockFile object to this object
     * through the BlockFile foreign key attribute.
     *
     * @param    BlockFile $l BlockFile
     * @return Block The current object (for fluent API support)
     */
    public function addBlockFile(BlockFile $l)
    {
        if ($this->collBlockFiles === null) {
            $this->initBlockFiles();
            $this->collBlockFilesPartial = true;
        }

        if (!in_array($l, $this->collBlockFiles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBlockFile($l);

            if ($this->blockFilesScheduledForDeletion and $this->blockFilesScheduledForDeletion->contains($l)) {
                $this->blockFilesScheduledForDeletion->remove($this->blockFilesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	BlockFile $blockFile The blockFile object to add.
     */
    protected function doAddBlockFile($blockFile)
    {
        $this->collBlockFiles[]= $blockFile;
        $blockFile->setBlock($this);
    }

    /**
     * @param	BlockFile $blockFile The blockFile object to remove.
     * @return Block The current object (for fluent API support)
     */
    public function removeBlockFile($blockFile)
    {
        if ($this->getBlockFiles()->contains($blockFile)) {
            $this->collBlockFiles->remove($this->collBlockFiles->search($blockFile));
            if (null === $this->blockFilesScheduledForDeletion) {
                $this->blockFilesScheduledForDeletion = clone $this->collBlockFiles;
                $this->blockFilesScheduledForDeletion->clear();
            }
            $this->blockFilesScheduledForDeletion[]= clone $blockFile;
            $blockFile->setBlock(null);
        }

        return $this;
    }

    /**
     * Clears out the collBlockI18nVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Block The current object (for fluent API support)
     * @see        addBlockI18nVersions()
     */
    public function clearBlockI18nVersions()
    {
        $this->collBlockI18nVersions = null; // important to set this to null since that means it is uninitialized
        $this->collBlockI18nVersionsPartial = null;

        return $this;
    }

    /**
     * reset is the collBlockI18nVersions collection loaded partially
     *
     * @return void
     */
    public function resetPartialBlockI18nVersions($v = true)
    {
        $this->collBlockI18nVersionsPartial = $v;
    }

    /**
     * Initializes the collBlockI18nVersions collection.
     *
     * By default this just sets the collBlockI18nVersions collection to an empty array (like clearcollBlockI18nVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBlockI18nVersions($overrideExisting = true)
    {
        if (null !== $this->collBlockI18nVersions && !$overrideExisting) {
            return;
        }
        $this->collBlockI18nVersions = new PropelObjectCollection();
        $this->collBlockI18nVersions->setModel('BlockI18nVersion');
    }

    /**
     * Gets an array of BlockI18nVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Block is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BlockI18nVersion[] List of BlockI18nVersion objects
     * @throws PropelException
     */
    public function getBlockI18nVersions($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBlockI18nVersionsPartial && !$this->isNew();
        if (null === $this->collBlockI18nVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBlockI18nVersions) {
                // return empty collection
                $this->initBlockI18nVersions();
            } else {
                $collBlockI18nVersions = BlockI18nVersionQuery::create(null, $criteria)
                    ->filterByBlock($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBlockI18nVersionsPartial && count($collBlockI18nVersions)) {
                      $this->initBlockI18nVersions(false);

                      foreach ($collBlockI18nVersions as $obj) {
                        if (false == $this->collBlockI18nVersions->contains($obj)) {
                          $this->collBlockI18nVersions->append($obj);
                        }
                      }

                      $this->collBlockI18nVersionsPartial = true;
                    }

                    $collBlockI18nVersions->getInternalIterator()->rewind();

                    return $collBlockI18nVersions;
                }

                if ($partial && $this->collBlockI18nVersions) {
                    foreach ($this->collBlockI18nVersions as $obj) {
                        if ($obj->isNew()) {
                            $collBlockI18nVersions[] = $obj;
                        }
                    }
                }

                $this->collBlockI18nVersions = $collBlockI18nVersions;
                $this->collBlockI18nVersionsPartial = false;
            }
        }

        return $this->collBlockI18nVersions;
    }

    /**
     * Sets a collection of BlockI18nVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $blockI18nVersions A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Block The current object (for fluent API support)
     */
    public function setBlockI18nVersions(PropelCollection $blockI18nVersions, PropelPDO $con = null)
    {
        $blockI18nVersionsToDelete = $this->getBlockI18nVersions(new Criteria(), $con)->diff($blockI18nVersions);


        $this->blockI18nVersionsScheduledForDeletion = $blockI18nVersionsToDelete;

        foreach ($blockI18nVersionsToDelete as $blockI18nVersionRemoved) {
            $blockI18nVersionRemoved->setBlock(null);
        }

        $this->collBlockI18nVersions = null;
        foreach ($blockI18nVersions as $blockI18nVersion) {
            $this->addBlockI18nVersion($blockI18nVersion);
        }

        $this->collBlockI18nVersions = $blockI18nVersions;
        $this->collBlockI18nVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BlockI18nVersion objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BlockI18nVersion objects.
     * @throws PropelException
     */
    public function countBlockI18nVersions(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBlockI18nVersionsPartial && !$this->isNew();
        if (null === $this->collBlockI18nVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBlockI18nVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBlockI18nVersions());
            }
            $query = BlockI18nVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBlock($this)
                ->count($con);
        }

        return count($this->collBlockI18nVersions);
    }

    /**
     * Method called to associate a BlockI18nVersion object to this object
     * through the BlockI18nVersion foreign key attribute.
     *
     * @param    BlockI18nVersion $l BlockI18nVersion
     * @return Block The current object (for fluent API support)
     */
    public function addBlockI18nVersion(BlockI18nVersion $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collBlockI18nVersions === null) {
            $this->initBlockI18nVersions();
            $this->collBlockI18nVersionsPartial = true;
        }

        if (!in_array($l, $this->collBlockI18nVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBlockI18nVersion($l);

            if ($this->blockI18nVersionsScheduledForDeletion and $this->blockI18nVersionsScheduledForDeletion->contains($l)) {
                $this->blockI18nVersionsScheduledForDeletion->remove($this->blockI18nVersionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	BlockI18nVersion $blockI18nVersion The blockI18nVersion object to add.
     */
    protected function doAddBlockI18nVersion($blockI18nVersion)
    {
        $this->collBlockI18nVersions[]= $blockI18nVersion;
        $blockI18nVersion->setBlock($this);
    }

    /**
     * @param	BlockI18nVersion $blockI18nVersion The blockI18nVersion object to remove.
     * @return Block The current object (for fluent API support)
     */
    public function removeBlockI18nVersion($blockI18nVersion)
    {
        if ($this->getBlockI18nVersions()->contains($blockI18nVersion)) {
            $this->collBlockI18nVersions->remove($this->collBlockI18nVersions->search($blockI18nVersion));
            if (null === $this->blockI18nVersionsScheduledForDeletion) {
                $this->blockI18nVersionsScheduledForDeletion = clone $this->collBlockI18nVersions;
                $this->blockI18nVersionsScheduledForDeletion->clear();
            }
            $this->blockI18nVersionsScheduledForDeletion[]= clone $blockI18nVersion;
            $blockI18nVersion->setBlock(null);
        }

        return $this;
    }

    /**
     * Clears out the collBlockI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Block The current object (for fluent API support)
     * @see        addBlockI18ns()
     */
    public function clearBlockI18ns()
    {
        $this->collBlockI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collBlockI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collBlockI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialBlockI18ns($v = true)
    {
        $this->collBlockI18nsPartial = $v;
    }

    /**
     * Initializes the collBlockI18ns collection.
     *
     * By default this just sets the collBlockI18ns collection to an empty array (like clearcollBlockI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBlockI18ns($overrideExisting = true)
    {
        if (null !== $this->collBlockI18ns && !$overrideExisting) {
            return;
        }
        $this->collBlockI18ns = new PropelObjectCollection();
        $this->collBlockI18ns->setModel('BlockI18n');
    }

    /**
     * Gets an array of BlockI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Block is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BlockI18n[] List of BlockI18n objects
     * @throws PropelException
     */
    public function getBlockI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBlockI18nsPartial && !$this->isNew();
        if (null === $this->collBlockI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBlockI18ns) {
                // return empty collection
                $this->initBlockI18ns();
            } else {
                $collBlockI18ns = BlockI18nQuery::create(null, $criteria)
                    ->filterByBlock($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBlockI18nsPartial && count($collBlockI18ns)) {
                      $this->initBlockI18ns(false);

                      foreach ($collBlockI18ns as $obj) {
                        if (false == $this->collBlockI18ns->contains($obj)) {
                          $this->collBlockI18ns->append($obj);
                        }
                      }

                      $this->collBlockI18nsPartial = true;
                    }

                    $collBlockI18ns->getInternalIterator()->rewind();

                    return $collBlockI18ns;
                }

                if ($partial && $this->collBlockI18ns) {
                    foreach ($this->collBlockI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collBlockI18ns[] = $obj;
                        }
                    }
                }

                $this->collBlockI18ns = $collBlockI18ns;
                $this->collBlockI18nsPartial = false;
            }
        }

        return $this->collBlockI18ns;
    }

    /**
     * Sets a collection of BlockI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $blockI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Block The current object (for fluent API support)
     */
    public function setBlockI18ns(PropelCollection $blockI18ns, PropelPDO $con = null)
    {
        $blockI18nsToDelete = $this->getBlockI18ns(new Criteria(), $con)->diff($blockI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->blockI18nsScheduledForDeletion = clone $blockI18nsToDelete;

        foreach ($blockI18nsToDelete as $blockI18nRemoved) {
            $blockI18nRemoved->setBlock(null);
        }

        $this->collBlockI18ns = null;
        foreach ($blockI18ns as $blockI18n) {
            $this->addBlockI18n($blockI18n);
        }

        $this->collBlockI18ns = $blockI18ns;
        $this->collBlockI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BlockI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BlockI18n objects.
     * @throws PropelException
     */
    public function countBlockI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBlockI18nsPartial && !$this->isNew();
        if (null === $this->collBlockI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBlockI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBlockI18ns());
            }
            $query = BlockI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBlock($this)
                ->count($con);
        }

        return count($this->collBlockI18ns);
    }

    /**
     * Method called to associate a BlockI18n object to this object
     * through the BlockI18n foreign key attribute.
     *
     * @param    BlockI18n $l BlockI18n
     * @return Block The current object (for fluent API support)
     */
    public function addBlockI18n(BlockI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collBlockI18ns === null) {
            $this->initBlockI18ns();
            $this->collBlockI18nsPartial = true;
        }

        if (!in_array($l, $this->collBlockI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBlockI18n($l);

            if ($this->blockI18nsScheduledForDeletion and $this->blockI18nsScheduledForDeletion->contains($l)) {
                $this->blockI18nsScheduledForDeletion->remove($this->blockI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	BlockI18n $blockI18n The blockI18n object to add.
     */
    protected function doAddBlockI18n($blockI18n)
    {
        $this->collBlockI18ns[]= $blockI18n;
        $blockI18n->setBlock($this);
    }

    /**
     * @param	BlockI18n $blockI18n The blockI18n object to remove.
     * @return Block The current object (for fluent API support)
     */
    public function removeBlockI18n($blockI18n)
    {
        if ($this->getBlockI18ns()->contains($blockI18n)) {
            $this->collBlockI18ns->remove($this->collBlockI18ns->search($blockI18n));
            if (null === $this->blockI18nsScheduledForDeletion) {
                $this->blockI18nsScheduledForDeletion = clone $this->collBlockI18ns;
                $this->blockI18nsScheduledForDeletion->clear();
            }
            $this->blockI18nsScheduledForDeletion[]= clone $blockI18n;
            $blockI18n->setBlock(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_block = null;
        $this->id_content = null;
        $this->title = null;
        $this->status = null;
        $this->type = null;
        $this->id_parent = null;
        $this->position = null;
        $this->order = null;
        $this->display = null;
        $this->slug = null;
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
            if ($this->collBlocksRelatedByIdBlock) {
                foreach ($this->collBlocksRelatedByIdBlock as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBlockFiles) {
                foreach ($this->collBlockFiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBlockI18nVersions) {
                foreach ($this->collBlockI18nVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBlockI18ns) {
                foreach ($this->collBlockI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aBlockRelatedByIdParent instanceof Persistent) {
              $this->aBlockRelatedByIdParent->clearAllReferences($deep);
            }
            if ($this->aContent instanceof Persistent) {
              $this->aContent->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collBlocksRelatedByIdBlock instanceof PropelCollection) {
            $this->collBlocksRelatedByIdBlock->clearIterator();
        }
        $this->collBlocksRelatedByIdBlock = null;
        if ($this->collBlockFiles instanceof PropelCollection) {
            $this->collBlockFiles->clearIterator();
        }
        $this->collBlockFiles = null;
        if ($this->collBlockI18nVersions instanceof PropelCollection) {
            $this->collBlockI18nVersions->clearIterator();
        }
        $this->collBlockI18nVersions = null;
        if ($this->collBlockI18ns instanceof PropelCollection) {
            $this->collBlockI18ns->clearIterator();
        }
        $this->collBlockI18ns = null;
        $this->aBlockRelatedByIdParent = null;
        $this->aContent = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BlockPeer::DEFAULT_STRING_FORMAT);
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
     * @return    Block The current object (for fluent API support)
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
     * @return BlockI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collBlockI18ns) {
                foreach ($this->collBlockI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new BlockI18n();
                $translation->setLocale($locale);
            } else {
                $translation = BlockI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addBlockI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    Block The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            BlockI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collBlockI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collBlockI18ns[$key]);
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
     * @return BlockI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [text] column value.
         * Contenu
         * @return string
         */
        public function getText()
        {
        return $this->getCurrentTranslation()->getText();
    }


        /**
         * Set the value of [text] column.
         * Contenu
         * @param  string $v new value
         * @return BlockI18n The current object (for fluent API support)
         */
        public function setText($v)
        {    $this->getCurrentTranslation()->setText($v);

        return $this;
    }


        /**
         * Get the [version] column value.
         *
         * @return int
         */
        public function getVersion()
        {
        return $this->getCurrentTranslation()->getVersion();
    }


        /**
         * Set the value of [version] column.
         *
         * @param  int $v new value
         * @return BlockI18n The current object (for fluent API support)
         */
        public function setVersion($v)
        {    $this->getCurrentTranslation()->setVersion($v);

        return $this;
    }

    // TableStampBehavior behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     * @return     Block The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = BlockPeer::DATE_MODIFICATION;
        return $this;
    }

}
