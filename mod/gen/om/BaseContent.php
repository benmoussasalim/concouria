<?php


/**
 * Base class that represents a row from the 'content' table.
 *
 * Contenu
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseContent extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ContentPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ContentPeer
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
     * The value for the status field.
     * @var        int
     */
    protected $status;

    /**
     * The value for the menu_visible field.
     * @var        int
     */
    protected $menu_visible;

    /**
     * The value for the slug field.
     * @var        string
     */
    protected $slug;

    /**
     * The value for the home field.
     * @var        int
     */
    protected $home;

    /**
     * The value for the order field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $order;

    /**
     * The value for the id_menu field.
     * @var        int
     */
    protected $id_menu;

    /**
     * The value for the name_menu field.
     * @var        string
     */
    protected $name_menu;

    /**
     * The value for the type field.
     * @var        int
     */
    protected $type;

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
     * @var        Menu
     */
    protected $aMenu;

    /**
     * @var        PropelObjectCollection|Block[] Collection to store aggregation of Block objects.
     */
    protected $collBlocks;
    protected $collBlocksPartial;

    /**
     * @var        PropelObjectCollection|ContentFile[] Collection to store aggregation of ContentFile objects.
     */
    protected $collContentFiles;
    protected $collContentFilesPartial;

    /**
     * @var        PropelObjectCollection|ContentI18nVersion[] Collection to store aggregation of ContentI18nVersion objects.
     */
    protected $collContentI18nVersions;
    protected $collContentI18nVersionsPartial;

    /**
     * @var        PropelObjectCollection|ContentI18n[] Collection to store aggregation of ContentI18n objects.
     */
    protected $collContentI18ns;
    protected $collContentI18nsPartial;

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
     * @var        array[ContentI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $blocksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentFilesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentI18nVersionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentI18nsScheduledForDeletion = null;

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
     * Initializes internal state of BaseContent object.
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
        $valueSet = ContentPeer::getValueSet(ContentPeer::STATUS);
        if (!isset($valueSet[$this->status])) {
            throw new PropelException('Unknown stored enum key: ' . $this->status);
        }

        return $valueSet[$this->status];
    }

    /**
     * Get the [menu_visible] column value.
     * menu Visible
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getMenuVisible()
    {
        if (null === $this->menu_visible) {
            return null;
        }
        $valueSet = ContentPeer::getValueSet(ContentPeer::MENU_VISIBLE);
        if (!isset($valueSet[$this->menu_visible])) {
            throw new PropelException('Unknown stored enum key: ' . $this->menu_visible);
        }

        return $valueSet[$this->menu_visible];
    }

    /**
     * Get the [slug] column value.
     * Lien de la page
     * @return string
     */
    public function getSlug()
    {

        return $this->slug;
    }

    /**
     * Get the [home] column value.
     * Accueil
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getHome()
    {
        if (null === $this->home) {
            return null;
        }
        $valueSet = ContentPeer::getValueSet(ContentPeer::HOME);
        if (!isset($valueSet[$this->home])) {
            throw new PropelException('Unknown stored enum key: ' . $this->home);
        }

        return $valueSet[$this->home];
    }

    /**
     * Get the [order] column value.
     * Ordre du menu
     * @return int
     */
    public function getOrder()
    {

        return $this->order;
    }

    /**
     * Get the [id_menu] column value.
     * Hiérarchie
     * @return int
     */
    public function getIdMenu()
    {

        return $this->id_menu;
    }

    /**
     * Get the [name_menu] column value.
     * Nom menu
     * @return string
     */
    public function getNameMenu()
    {

        return $this->name_menu;
    }

    /**
     * Get the [type] column value.
     * Type de contenu
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getType()
    {
        if (null === $this->type) {
            return null;
        }
        $valueSet = ContentPeer::getValueSet(ContentPeer::TYPE);
        if (!isset($valueSet[$this->type])) {
            throw new PropelException('Unknown stored enum key: ' . $this->type);
        }

        return $valueSet[$this->type];
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
        $c->addSelectColumn(ContentPeer::DATE_CREATION);
        try {
            $stmt = ContentPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(ContentPeer::DATE_MODIFICATION);
        try {
            $stmt = ContentPeer::doSelectStmt($c, $con);
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
     * @return Content The current object (for fluent API support)
     */
    public function setIdContent($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_content !== $v) {
            $this->id_content = $v;
            $this->modifiedColumns[] = ContentPeer::ID_CONTENT;
        }


        return $this;
    } // setIdContent()

    /**
     * Set the value of [status] column.
     * Status
     * @param  int $v new value
     * @return Content The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $valueSet = ContentPeer::getValueSet(ContentPeer::STATUS);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[] = ContentPeer::STATUS;
        }


        return $this;
    } // setStatus()

    /**
     * Set the value of [menu_visible] column.
     * menu Visible
     * @param  int $v new value
     * @return Content The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setMenuVisible($v)
    {
        if ($v !== null) {
            $valueSet = ContentPeer::getValueSet(ContentPeer::MENU_VISIBLE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->menu_visible !== $v) {
            $this->menu_visible = $v;
            $this->modifiedColumns[] = ContentPeer::MENU_VISIBLE;
        }


        return $this;
    } // setMenuVisible()

    /**
     * Set the value of [slug] column.
     * Lien de la page
     * @param  string $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setSlug($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->slug !== $v) {
            $this->slug = $v;
            $this->modifiedColumns[] = ContentPeer::SLUG;
        }


        return $this;
    } // setSlug()

    /**
     * Set the value of [home] column.
     * Accueil
     * @param  int $v new value
     * @return Content The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setHome($v)
    {
        if ($v !== null) {
            $valueSet = ContentPeer::getValueSet(ContentPeer::HOME);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->home !== $v) {
            $this->home = $v;
            $this->modifiedColumns[] = ContentPeer::HOME;
        }


        return $this;
    } // setHome()

    /**
     * Set the value of [order] column.
     * Ordre du menu
     * @param  int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setOrder($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->order !== $v) {
            $this->order = $v;
            $this->modifiedColumns[] = ContentPeer::ORDER;
        }


        return $this;
    } // setOrder()

    /**
     * Set the value of [id_menu] column.
     * Hiérarchie
     * @param  int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setIdMenu($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_menu !== $v) {
            $this->id_menu = $v;
            $this->modifiedColumns[] = ContentPeer::ID_MENU;
        }

        if ($this->aMenu !== null && $this->aMenu->getIdMenu() !== $v) {
            $this->aMenu = null;
        }


        return $this;
    } // setIdMenu()

    /**
     * Set the value of [name_menu] column.
     * Nom menu
     * @param  string $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setNameMenu($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name_menu !== $v) {
            $this->name_menu = $v;
            $this->modifiedColumns[] = ContentPeer::NAME_MENU;
        }


        return $this;
    } // setNameMenu()

    /**
     * Set the value of [type] column.
     * Type de contenu
     * @param  int $v new value
     * @return Content The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setType($v)
    {
        if ($v !== null) {
            $valueSet = ContentPeer::getValueSet(ContentPeer::TYPE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = ContentPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Content The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = ContentPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = ContentPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Content The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = ContentPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = ContentPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = ContentPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = ContentPeer::ID_MODIFICATION;
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

            $this->id_content = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->status = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->menu_visible = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->slug = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->home = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->order = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->id_menu = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->name_menu = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->type = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->id_creation = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->id_modification = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 11; // 11 = ContentPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Content object", $e);
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

        if ($this->aMenu !== null && $this->id_menu !== $this->aMenu->getIdMenu()) {
            $this->aMenu = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = ContentPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->aMenu = null;
            $this->collBlocks = null;
            $this->collContentFiles = null;
            $this->collContentI18nVersions = null;
            $this->collContentI18ns = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Content';}
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
        mem_clean('Content');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = ContentQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Content');
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

                        mem_clean('Content');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            ContentPeer::addInstanceToPool($this);

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

            if ($this->aMenu !== null) {
                if ($this->aMenu->isModified() || $this->aMenu->isNew()) {
                    $affectedRows += $this->aMenu->save($con);
                }
                $this->setMenu($this->aMenu);
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

            if ($this->blocksScheduledForDeletion !== null) {
                if (!$this->blocksScheduledForDeletion->isEmpty()) {
                    BlockQuery::create()
                        ->filterByPrimaryKeys($this->blocksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->blocksScheduledForDeletion = null;
                }
            }

            if ($this->collBlocks !== null) {
                foreach ($this->collBlocks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentFilesScheduledForDeletion !== null) {
                if (!$this->contentFilesScheduledForDeletion->isEmpty()) {
                    ContentFileQuery::create()
                        ->filterByPrimaryKeys($this->contentFilesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentFilesScheduledForDeletion = null;
                }
            }

            if ($this->collContentFiles !== null) {
                foreach ($this->collContentFiles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentI18nVersionsScheduledForDeletion !== null) {
                if (!$this->contentI18nVersionsScheduledForDeletion->isEmpty()) {
                    ContentI18nVersionQuery::create()
                        ->filterByPrimaryKeys($this->contentI18nVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentI18nVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collContentI18nVersions !== null) {
                foreach ($this->collContentI18nVersions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentI18nsScheduledForDeletion !== null) {
                if (!$this->contentI18nsScheduledForDeletion->isEmpty()) {
                    ContentI18nQuery::create()
                        ->filterByPrimaryKeys($this->contentI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collContentI18ns !== null) {
                foreach ($this->collContentI18ns as $referrerFK) {
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

        $this->modifiedColumns[] = ContentPeer::ID_CONTENT;
        if (null !== $this->id_content) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ContentPeer::ID_CONTENT . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ContentPeer::ID_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = '`id_content`';
        }
        if ($this->isColumnModified(ContentPeer::STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`status`';
        }
        if ($this->isColumnModified(ContentPeer::MENU_VISIBLE)) {
            $modifiedColumns[':p' . $index++]  = '`menu_visible`';
        }
        if ($this->isColumnModified(ContentPeer::SLUG)) {
            $modifiedColumns[':p' . $index++]  = '`slug`';
        }
        if ($this->isColumnModified(ContentPeer::HOME)) {
            $modifiedColumns[':p' . $index++]  = '`home`';
        }
        if ($this->isColumnModified(ContentPeer::ORDER)) {
            $modifiedColumns[':p' . $index++]  = '`order`';
        }
        if ($this->isColumnModified(ContentPeer::ID_MENU)) {
            $modifiedColumns[':p' . $index++]  = '`id_menu`';
        }
        if ($this->isColumnModified(ContentPeer::NAME_MENU)) {
            $modifiedColumns[':p' . $index++]  = '`name_menu`';
        }
        if ($this->isColumnModified(ContentPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(ContentPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(ContentPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(ContentPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(ContentPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `content` (%s) VALUES (%s)',
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
                    case '`status`':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case '`menu_visible`':
                        $stmt->bindValue($identifier, $this->menu_visible, PDO::PARAM_INT);
                        break;
                    case '`slug`':
                        $stmt->bindValue($identifier, $this->slug, PDO::PARAM_STR);
                        break;
                    case '`home`':
                        $stmt->bindValue($identifier, $this->home, PDO::PARAM_INT);
                        break;
                    case '`order`':
                        $stmt->bindValue($identifier, $this->order, PDO::PARAM_INT);
                        break;
                    case '`id_menu`':
                        $stmt->bindValue($identifier, $this->id_menu, PDO::PARAM_INT);
                        break;
                    case '`name_menu`':
                        $stmt->bindValue($identifier, $this->name_menu, PDO::PARAM_STR);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
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
        $this->setIdContent($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Content';}
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

            if ($this->aMenu !== null) {
                if (!$this->aMenu->validate($columns)) {$failureMap = array_merge($failureMap, $this->aMenu->getValidationFailures()); }
            }

            if (($retval = ContentPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collBlocks !== null) {
                    foreach ($this->collBlocks as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collContentFiles !== null) {
                    foreach ($this->collContentFiles as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collContentI18nVersions !== null) {
                    foreach ($this->collContentI18nVersions as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collContentI18ns !== null) {
                    foreach ($this->collContentI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ContentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Content'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Content'][$this->getPrimaryKey()] = true;
        $keys = ContentPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdContent(),
            $keys[1] => $this->getStatus(),
            $keys[2] => $this->getMenuVisible(),
            $keys[3] => $this->getSlug(),
            $keys[4] => $this->getHome(),
            $keys[5] => $this->getOrder(),
            $keys[6] => $this->getIdMenu(),
            $keys[7] => $this->getNameMenu(),
            $keys[8] => $this->getType(),
            $keys[9] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[10] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[11] => $this->getIdCreation(),
            $keys[12] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aMenu) {
                $result['Menu'] = $this->aMenu->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collBlocks) {
                $result['Blocks'] = $this->collBlocks->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentFiles) {
                $result['ContentFiles'] = $this->collContentFiles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentI18nVersions) {
                $result['ContentI18nVersions'] = $this->collContentI18nVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentI18ns) {
                $result['ContentI18ns'] = $this->collContentI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ContentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdContent($value);
                break;
            case 1:
                $valueSet = ContentPeer::getValueSet(ContentPeer::STATUS);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setStatus($value);
                break;
            case 2:
                $valueSet = ContentPeer::getValueSet(ContentPeer::MENU_VISIBLE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setMenuVisible($value);
                break;
            case 3:
                $this->setSlug($value);
                break;
            case 4:
                $valueSet = ContentPeer::getValueSet(ContentPeer::HOME);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setHome($value);
                break;
            case 5:
                $this->setOrder($value);
                break;
            case 6:
                $this->setIdMenu($value);
                break;
            case 7:
                $this->setNameMenu($value);
                break;
            case 8:
                $valueSet = ContentPeer::getValueSet(ContentPeer::TYPE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setType($value);
                break;
            case 9:
                $this->setDateCreation($value);
                break;
            case 10:
                $this->setDateModification($value);
                break;
            case 11:
                $this->setIdCreation($value);
                break;
            case 12:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ContentPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdContent($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setStatus($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setMenuVisible($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setSlug($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setHome($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setOrder($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIdMenu($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setNameMenu($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setType($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setDateCreation($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setDateModification($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setIdCreation($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setIdModification($arr[$keys[12]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(ContentPeer::DATABASE_NAME);

        if ($this->isColumnModified(ContentPeer::ID_CONTENT)) $criteria->add(ContentPeer::ID_CONTENT, $this->id_content);
        if ($this->isColumnModified(ContentPeer::STATUS)) $criteria->add(ContentPeer::STATUS, $this->status);
        if ($this->isColumnModified(ContentPeer::MENU_VISIBLE)) $criteria->add(ContentPeer::MENU_VISIBLE, $this->menu_visible);
        if ($this->isColumnModified(ContentPeer::SLUG)) $criteria->add(ContentPeer::SLUG, $this->slug);
        if ($this->isColumnModified(ContentPeer::HOME)) $criteria->add(ContentPeer::HOME, $this->home);
        if ($this->isColumnModified(ContentPeer::ORDER)) $criteria->add(ContentPeer::ORDER, $this->order);
        if ($this->isColumnModified(ContentPeer::ID_MENU)) $criteria->add(ContentPeer::ID_MENU, $this->id_menu);
        if ($this->isColumnModified(ContentPeer::NAME_MENU)) $criteria->add(ContentPeer::NAME_MENU, $this->name_menu);
        if ($this->isColumnModified(ContentPeer::TYPE)) $criteria->add(ContentPeer::TYPE, $this->type);
        if ($this->isColumnModified(ContentPeer::DATE_CREATION)) $criteria->add(ContentPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(ContentPeer::DATE_MODIFICATION)) $criteria->add(ContentPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(ContentPeer::ID_CREATION)) $criteria->add(ContentPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(ContentPeer::ID_MODIFICATION)) $criteria->add(ContentPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(ContentPeer::DATABASE_NAME);
        $criteria->add(ContentPeer::ID_CONTENT, $this->id_content);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdContent();
    }

    /**
     * Generic method to set the primary key (id_content column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdContent($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdContent();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Content (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setStatus($this->getStatus());
        $copyObj->setMenuVisible($this->getMenuVisible());
        $copyObj->setSlug($this->getSlug());
        $copyObj->setHome($this->getHome());
        $copyObj->setOrder($this->getOrder());
        $copyObj->setIdMenu($this->getIdMenu());
        $copyObj->setNameMenu($this->getNameMenu());
        $copyObj->setType($this->getType());
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

            foreach ($this->getBlocks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBlock($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentFiles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentFile($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentI18nVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentI18nVersion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdContent(NULL); // this is a auto-increment column, so set to default value
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
     * @return Content Clone of current object.
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
     * @return ContentPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ContentPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Menu object.
     *
     * @param                  Menu $v
     * @return Content The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMenu(Menu $v = null)
    {
        if ($v === null) {
            $this->setIdMenu(NULL);
        } else {
            $this->setIdMenu($v->getIdMenu());
        }

        $this->aMenu = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Menu object, it will not be re-added.
        if ($v !== null) {
            $v->addContent($this);
        }


        return $this;
    }


    /**
     * Get the associated Menu object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Menu The associated Menu object.
     * @throws PropelException
     */
    public function getMenu(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aMenu === null && ($this->id_menu !== null) && $doQuery) {
            $this->aMenu = MenuQuery::create()->findPk($this->id_menu, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMenu->addContents($this);
             */
        }

        return $this->aMenu;
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
        if ('Block' == $relationName) {
            $this->initBlocks();
        }
        if ('ContentFile' == $relationName) {
            $this->initContentFiles();
        }
        if ('ContentI18nVersion' == $relationName) {
            $this->initContentI18nVersions();
        }
        if ('ContentI18n' == $relationName) {
            $this->initContentI18ns();
        }
    }

    /**
     * Clears out the collBlocks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Content The current object (for fluent API support)
     * @see        addBlocks()
     */
    public function clearBlocks()
    {
        $this->collBlocks = null; // important to set this to null since that means it is uninitialized
        $this->collBlocksPartial = null;

        return $this;
    }

    /**
     * reset is the collBlocks collection loaded partially
     *
     * @return void
     */
    public function resetPartialBlocks($v = true)
    {
        $this->collBlocksPartial = $v;
    }

    /**
     * Initializes the collBlocks collection.
     *
     * By default this just sets the collBlocks collection to an empty array (like clearcollBlocks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBlocks($overrideExisting = true)
    {
        if (null !== $this->collBlocks && !$overrideExisting) {
            return;
        }
        $this->collBlocks = new PropelObjectCollection();
        $this->collBlocks->setModel('Block');
    }

    /**
     * Gets an array of Block objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Block[] List of Block objects
     * @throws PropelException
     */
    public function getBlocks($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBlocksPartial && !$this->isNew();
        if (null === $this->collBlocks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBlocks) {
                // return empty collection
                $this->initBlocks();
            } else {
                $collBlocks = BlockQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBlocksPartial && count($collBlocks)) {
                      $this->initBlocks(false);

                      foreach ($collBlocks as $obj) {
                        if (false == $this->collBlocks->contains($obj)) {
                          $this->collBlocks->append($obj);
                        }
                      }

                      $this->collBlocksPartial = true;
                    }

                    $collBlocks->getInternalIterator()->rewind();

                    return $collBlocks;
                }

                if ($partial && $this->collBlocks) {
                    foreach ($this->collBlocks as $obj) {
                        if ($obj->isNew()) {
                            $collBlocks[] = $obj;
                        }
                    }
                }

                $this->collBlocks = $collBlocks;
                $this->collBlocksPartial = false;
            }
        }

        return $this->collBlocks;
    }

    /**
     * Sets a collection of Block objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $blocks A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Content The current object (for fluent API support)
     */
    public function setBlocks(PropelCollection $blocks, PropelPDO $con = null)
    {
        $blocksToDelete = $this->getBlocks(new Criteria(), $con)->diff($blocks);


        $this->blocksScheduledForDeletion = $blocksToDelete;

        foreach ($blocksToDelete as $blockRemoved) {
            $blockRemoved->setContent(null);
        }

        $this->collBlocks = null;
        foreach ($blocks as $block) {
            $this->addBlock($block);
        }

        $this->collBlocks = $blocks;
        $this->collBlocksPartial = false;

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
    public function countBlocks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBlocksPartial && !$this->isNew();
        if (null === $this->collBlocks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBlocks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBlocks());
            }
            $query = BlockQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContent($this)
                ->count($con);
        }

        return count($this->collBlocks);
    }

    /**
     * Method called to associate a Block object to this object
     * through the Block foreign key attribute.
     *
     * @param    Block $l Block
     * @return Content The current object (for fluent API support)
     */
    public function addBlock(Block $l)
    {
        if ($this->collBlocks === null) {
            $this->initBlocks();
            $this->collBlocksPartial = true;
        }

        if (!in_array($l, $this->collBlocks->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBlock($l);

            if ($this->blocksScheduledForDeletion and $this->blocksScheduledForDeletion->contains($l)) {
                $this->blocksScheduledForDeletion->remove($this->blocksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Block $block The block object to add.
     */
    protected function doAddBlock($block)
    {
        $this->collBlocks[]= $block;
        $block->setContent($this);
    }

    /**
     * @param	Block $block The block object to remove.
     * @return Content The current object (for fluent API support)
     */
    public function removeBlock($block)
    {
        if ($this->getBlocks()->contains($block)) {
            $this->collBlocks->remove($this->collBlocks->search($block));
            if (null === $this->blocksScheduledForDeletion) {
                $this->blocksScheduledForDeletion = clone $this->collBlocks;
                $this->blocksScheduledForDeletion->clear();
            }
            $this->blocksScheduledForDeletion[]= $block;
            $block->setContent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Content is new, it will return
     * an empty collection; or if this Content has previously
     * been saved, it will retrieve related Blocks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Content.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Block[] List of Block objects
     */
    public function getBlocksJoinBlockRelatedByIdParent($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BlockQuery::create(null, $criteria);
        $query->joinWith('BlockRelatedByIdParent', $join_behavior);

        return $this->getBlocks($query, $con);
    }

    /**
     * Clears out the collContentFiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Content The current object (for fluent API support)
     * @see        addContentFiles()
     */
    public function clearContentFiles()
    {
        $this->collContentFiles = null; // important to set this to null since that means it is uninitialized
        $this->collContentFilesPartial = null;

        return $this;
    }

    /**
     * reset is the collContentFiles collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentFiles($v = true)
    {
        $this->collContentFilesPartial = $v;
    }

    /**
     * Initializes the collContentFiles collection.
     *
     * By default this just sets the collContentFiles collection to an empty array (like clearcollContentFiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentFiles($overrideExisting = true)
    {
        if (null !== $this->collContentFiles && !$overrideExisting) {
            return;
        }
        $this->collContentFiles = new PropelObjectCollection();
        $this->collContentFiles->setModel('ContentFile');
    }

    /**
     * Gets an array of ContentFile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentFile[] List of ContentFile objects
     * @throws PropelException
     */
    public function getContentFiles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentFilesPartial && !$this->isNew();
        if (null === $this->collContentFiles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentFiles) {
                // return empty collection
                $this->initContentFiles();
            } else {
                $collContentFiles = ContentFileQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentFilesPartial && count($collContentFiles)) {
                      $this->initContentFiles(false);

                      foreach ($collContentFiles as $obj) {
                        if (false == $this->collContentFiles->contains($obj)) {
                          $this->collContentFiles->append($obj);
                        }
                      }

                      $this->collContentFilesPartial = true;
                    }

                    $collContentFiles->getInternalIterator()->rewind();

                    return $collContentFiles;
                }

                if ($partial && $this->collContentFiles) {
                    foreach ($this->collContentFiles as $obj) {
                        if ($obj->isNew()) {
                            $collContentFiles[] = $obj;
                        }
                    }
                }

                $this->collContentFiles = $collContentFiles;
                $this->collContentFilesPartial = false;
            }
        }

        return $this->collContentFiles;
    }

    /**
     * Sets a collection of ContentFile objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentFiles A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Content The current object (for fluent API support)
     */
    public function setContentFiles(PropelCollection $contentFiles, PropelPDO $con = null)
    {
        $contentFilesToDelete = $this->getContentFiles(new Criteria(), $con)->diff($contentFiles);


        $this->contentFilesScheduledForDeletion = $contentFilesToDelete;

        foreach ($contentFilesToDelete as $contentFileRemoved) {
            $contentFileRemoved->setContent(null);
        }

        $this->collContentFiles = null;
        foreach ($contentFiles as $contentFile) {
            $this->addContentFile($contentFile);
        }

        $this->collContentFiles = $contentFiles;
        $this->collContentFilesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentFile objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentFile objects.
     * @throws PropelException
     */
    public function countContentFiles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentFilesPartial && !$this->isNew();
        if (null === $this->collContentFiles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentFiles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContentFiles());
            }
            $query = ContentFileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContent($this)
                ->count($con);
        }

        return count($this->collContentFiles);
    }

    /**
     * Method called to associate a ContentFile object to this object
     * through the ContentFile foreign key attribute.
     *
     * @param    ContentFile $l ContentFile
     * @return Content The current object (for fluent API support)
     */
    public function addContentFile(ContentFile $l)
    {
        if ($this->collContentFiles === null) {
            $this->initContentFiles();
            $this->collContentFilesPartial = true;
        }

        if (!in_array($l, $this->collContentFiles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentFile($l);

            if ($this->contentFilesScheduledForDeletion and $this->contentFilesScheduledForDeletion->contains($l)) {
                $this->contentFilesScheduledForDeletion->remove($this->contentFilesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ContentFile $contentFile The contentFile object to add.
     */
    protected function doAddContentFile($contentFile)
    {
        $this->collContentFiles[]= $contentFile;
        $contentFile->setContent($this);
    }

    /**
     * @param	ContentFile $contentFile The contentFile object to remove.
     * @return Content The current object (for fluent API support)
     */
    public function removeContentFile($contentFile)
    {
        if ($this->getContentFiles()->contains($contentFile)) {
            $this->collContentFiles->remove($this->collContentFiles->search($contentFile));
            if (null === $this->contentFilesScheduledForDeletion) {
                $this->contentFilesScheduledForDeletion = clone $this->collContentFiles;
                $this->contentFilesScheduledForDeletion->clear();
            }
            $this->contentFilesScheduledForDeletion[]= clone $contentFile;
            $contentFile->setContent(null);
        }

        return $this;
    }

    /**
     * Clears out the collContentI18nVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Content The current object (for fluent API support)
     * @see        addContentI18nVersions()
     */
    public function clearContentI18nVersions()
    {
        $this->collContentI18nVersions = null; // important to set this to null since that means it is uninitialized
        $this->collContentI18nVersionsPartial = null;

        return $this;
    }

    /**
     * reset is the collContentI18nVersions collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentI18nVersions($v = true)
    {
        $this->collContentI18nVersionsPartial = $v;
    }

    /**
     * Initializes the collContentI18nVersions collection.
     *
     * By default this just sets the collContentI18nVersions collection to an empty array (like clearcollContentI18nVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentI18nVersions($overrideExisting = true)
    {
        if (null !== $this->collContentI18nVersions && !$overrideExisting) {
            return;
        }
        $this->collContentI18nVersions = new PropelObjectCollection();
        $this->collContentI18nVersions->setModel('ContentI18nVersion');
    }

    /**
     * Gets an array of ContentI18nVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentI18nVersion[] List of ContentI18nVersion objects
     * @throws PropelException
     */
    public function getContentI18nVersions($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentI18nVersionsPartial && !$this->isNew();
        if (null === $this->collContentI18nVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentI18nVersions) {
                // return empty collection
                $this->initContentI18nVersions();
            } else {
                $collContentI18nVersions = ContentI18nVersionQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentI18nVersionsPartial && count($collContentI18nVersions)) {
                      $this->initContentI18nVersions(false);

                      foreach ($collContentI18nVersions as $obj) {
                        if (false == $this->collContentI18nVersions->contains($obj)) {
                          $this->collContentI18nVersions->append($obj);
                        }
                      }

                      $this->collContentI18nVersionsPartial = true;
                    }

                    $collContentI18nVersions->getInternalIterator()->rewind();

                    return $collContentI18nVersions;
                }

                if ($partial && $this->collContentI18nVersions) {
                    foreach ($this->collContentI18nVersions as $obj) {
                        if ($obj->isNew()) {
                            $collContentI18nVersions[] = $obj;
                        }
                    }
                }

                $this->collContentI18nVersions = $collContentI18nVersions;
                $this->collContentI18nVersionsPartial = false;
            }
        }

        return $this->collContentI18nVersions;
    }

    /**
     * Sets a collection of ContentI18nVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentI18nVersions A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Content The current object (for fluent API support)
     */
    public function setContentI18nVersions(PropelCollection $contentI18nVersions, PropelPDO $con = null)
    {
        $contentI18nVersionsToDelete = $this->getContentI18nVersions(new Criteria(), $con)->diff($contentI18nVersions);


        $this->contentI18nVersionsScheduledForDeletion = $contentI18nVersionsToDelete;

        foreach ($contentI18nVersionsToDelete as $contentI18nVersionRemoved) {
            $contentI18nVersionRemoved->setContent(null);
        }

        $this->collContentI18nVersions = null;
        foreach ($contentI18nVersions as $contentI18nVersion) {
            $this->addContentI18nVersion($contentI18nVersion);
        }

        $this->collContentI18nVersions = $contentI18nVersions;
        $this->collContentI18nVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentI18nVersion objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentI18nVersion objects.
     * @throws PropelException
     */
    public function countContentI18nVersions(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentI18nVersionsPartial && !$this->isNew();
        if (null === $this->collContentI18nVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentI18nVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContentI18nVersions());
            }
            $query = ContentI18nVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContent($this)
                ->count($con);
        }

        return count($this->collContentI18nVersions);
    }

    /**
     * Method called to associate a ContentI18nVersion object to this object
     * through the ContentI18nVersion foreign key attribute.
     *
     * @param    ContentI18nVersion $l ContentI18nVersion
     * @return Content The current object (for fluent API support)
     */
    public function addContentI18nVersion(ContentI18nVersion $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collContentI18nVersions === null) {
            $this->initContentI18nVersions();
            $this->collContentI18nVersionsPartial = true;
        }

        if (!in_array($l, $this->collContentI18nVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentI18nVersion($l);

            if ($this->contentI18nVersionsScheduledForDeletion and $this->contentI18nVersionsScheduledForDeletion->contains($l)) {
                $this->contentI18nVersionsScheduledForDeletion->remove($this->contentI18nVersionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ContentI18nVersion $contentI18nVersion The contentI18nVersion object to add.
     */
    protected function doAddContentI18nVersion($contentI18nVersion)
    {
        $this->collContentI18nVersions[]= $contentI18nVersion;
        $contentI18nVersion->setContent($this);
    }

    /**
     * @param	ContentI18nVersion $contentI18nVersion The contentI18nVersion object to remove.
     * @return Content The current object (for fluent API support)
     */
    public function removeContentI18nVersion($contentI18nVersion)
    {
        if ($this->getContentI18nVersions()->contains($contentI18nVersion)) {
            $this->collContentI18nVersions->remove($this->collContentI18nVersions->search($contentI18nVersion));
            if (null === $this->contentI18nVersionsScheduledForDeletion) {
                $this->contentI18nVersionsScheduledForDeletion = clone $this->collContentI18nVersions;
                $this->contentI18nVersionsScheduledForDeletion->clear();
            }
            $this->contentI18nVersionsScheduledForDeletion[]= clone $contentI18nVersion;
            $contentI18nVersion->setContent(null);
        }

        return $this;
    }

    /**
     * Clears out the collContentI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Content The current object (for fluent API support)
     * @see        addContentI18ns()
     */
    public function clearContentI18ns()
    {
        $this->collContentI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collContentI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collContentI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentI18ns($v = true)
    {
        $this->collContentI18nsPartial = $v;
    }

    /**
     * Initializes the collContentI18ns collection.
     *
     * By default this just sets the collContentI18ns collection to an empty array (like clearcollContentI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentI18ns($overrideExisting = true)
    {
        if (null !== $this->collContentI18ns && !$overrideExisting) {
            return;
        }
        $this->collContentI18ns = new PropelObjectCollection();
        $this->collContentI18ns->setModel('ContentI18n');
    }

    /**
     * Gets an array of ContentI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentI18n[] List of ContentI18n objects
     * @throws PropelException
     */
    public function getContentI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentI18nsPartial && !$this->isNew();
        if (null === $this->collContentI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentI18ns) {
                // return empty collection
                $this->initContentI18ns();
            } else {
                $collContentI18ns = ContentI18nQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentI18nsPartial && count($collContentI18ns)) {
                      $this->initContentI18ns(false);

                      foreach ($collContentI18ns as $obj) {
                        if (false == $this->collContentI18ns->contains($obj)) {
                          $this->collContentI18ns->append($obj);
                        }
                      }

                      $this->collContentI18nsPartial = true;
                    }

                    $collContentI18ns->getInternalIterator()->rewind();

                    return $collContentI18ns;
                }

                if ($partial && $this->collContentI18ns) {
                    foreach ($this->collContentI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collContentI18ns[] = $obj;
                        }
                    }
                }

                $this->collContentI18ns = $collContentI18ns;
                $this->collContentI18nsPartial = false;
            }
        }

        return $this->collContentI18ns;
    }

    /**
     * Sets a collection of ContentI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Content The current object (for fluent API support)
     */
    public function setContentI18ns(PropelCollection $contentI18ns, PropelPDO $con = null)
    {
        $contentI18nsToDelete = $this->getContentI18ns(new Criteria(), $con)->diff($contentI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->contentI18nsScheduledForDeletion = clone $contentI18nsToDelete;

        foreach ($contentI18nsToDelete as $contentI18nRemoved) {
            $contentI18nRemoved->setContent(null);
        }

        $this->collContentI18ns = null;
        foreach ($contentI18ns as $contentI18n) {
            $this->addContentI18n($contentI18n);
        }

        $this->collContentI18ns = $contentI18ns;
        $this->collContentI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentI18n objects.
     * @throws PropelException
     */
    public function countContentI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentI18nsPartial && !$this->isNew();
        if (null === $this->collContentI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContentI18ns());
            }
            $query = ContentI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContent($this)
                ->count($con);
        }

        return count($this->collContentI18ns);
    }

    /**
     * Method called to associate a ContentI18n object to this object
     * through the ContentI18n foreign key attribute.
     *
     * @param    ContentI18n $l ContentI18n
     * @return Content The current object (for fluent API support)
     */
    public function addContentI18n(ContentI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collContentI18ns === null) {
            $this->initContentI18ns();
            $this->collContentI18nsPartial = true;
        }

        if (!in_array($l, $this->collContentI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentI18n($l);

            if ($this->contentI18nsScheduledForDeletion and $this->contentI18nsScheduledForDeletion->contains($l)) {
                $this->contentI18nsScheduledForDeletion->remove($this->contentI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ContentI18n $contentI18n The contentI18n object to add.
     */
    protected function doAddContentI18n($contentI18n)
    {
        $this->collContentI18ns[]= $contentI18n;
        $contentI18n->setContent($this);
    }

    /**
     * @param	ContentI18n $contentI18n The contentI18n object to remove.
     * @return Content The current object (for fluent API support)
     */
    public function removeContentI18n($contentI18n)
    {
        if ($this->getContentI18ns()->contains($contentI18n)) {
            $this->collContentI18ns->remove($this->collContentI18ns->search($contentI18n));
            if (null === $this->contentI18nsScheduledForDeletion) {
                $this->contentI18nsScheduledForDeletion = clone $this->collContentI18ns;
                $this->contentI18nsScheduledForDeletion->clear();
            }
            $this->contentI18nsScheduledForDeletion[]= clone $contentI18n;
            $contentI18n->setContent(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_content = null;
        $this->status = null;
        $this->menu_visible = null;
        $this->slug = null;
        $this->home = null;
        $this->order = null;
        $this->id_menu = null;
        $this->name_menu = null;
        $this->type = null;
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
            if ($this->collBlocks) {
                foreach ($this->collBlocks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentFiles) {
                foreach ($this->collContentFiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentI18nVersions) {
                foreach ($this->collContentI18nVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentI18ns) {
                foreach ($this->collContentI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aMenu instanceof Persistent) {
              $this->aMenu->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collBlocks instanceof PropelCollection) {
            $this->collBlocks->clearIterator();
        }
        $this->collBlocks = null;
        if ($this->collContentFiles instanceof PropelCollection) {
            $this->collContentFiles->clearIterator();
        }
        $this->collContentFiles = null;
        if ($this->collContentI18nVersions instanceof PropelCollection) {
            $this->collContentI18nVersions->clearIterator();
        }
        $this->collContentI18nVersions = null;
        if ($this->collContentI18ns instanceof PropelCollection) {
            $this->collContentI18ns->clearIterator();
        }
        $this->collContentI18ns = null;
        $this->aMenu = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ContentPeer::DEFAULT_STRING_FORMAT);
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
     * @return    Content The current object (for fluent API support)
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
     * @return ContentI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collContentI18ns) {
                foreach ($this->collContentI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ContentI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ContentI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addContentI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    Content The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            ContentI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collContentI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collContentI18ns[$key]);
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
     * @return ContentI18n */
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
         * @return ContentI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
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
         * @return ContentI18n The current object (for fluent API support)
         */
        public function setText($v)
        {    $this->getCurrentTranslation()->setText($v);

        return $this;
    }


        /**
         * Get the [meta_keyword] column value.
         * Meta Keyword
         * @return string
         */
        public function getMetaKeyword()
        {
        return $this->getCurrentTranslation()->getMetaKeyword();
    }


        /**
         * Set the value of [meta_keyword] column.
         * Meta Keyword
         * @param  string $v new value
         * @return ContentI18n The current object (for fluent API support)
         */
        public function setMetaKeyword($v)
        {    $this->getCurrentTranslation()->setMetaKeyword($v);

        return $this;
    }


        /**
         * Get the [meta_description] column value.
         * Meta Description
         * @return string
         */
        public function getMetaDescription()
        {
        return $this->getCurrentTranslation()->getMetaDescription();
    }


        /**
         * Set the value of [meta_description] column.
         * Meta Description
         * @param  string $v new value
         * @return ContentI18n The current object (for fluent API support)
         */
        public function setMetaDescription($v)
        {    $this->getCurrentTranslation()->setMetaDescription($v);

        return $this;
    }


        /**
         * Get the [meta_title] column value.
         * Meta Title
         * @return string
         */
        public function getMetaTitle()
        {
        return $this->getCurrentTranslation()->getMetaTitle();
    }


        /**
         * Set the value of [meta_title] column.
         * Meta Title
         * @param  string $v new value
         * @return ContentI18n The current object (for fluent API support)
         */
        public function setMetaTitle($v)
        {    $this->getCurrentTranslation()->setMetaTitle($v);

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
         * @return ContentI18n The current object (for fluent API support)
         */
        public function setVersion($v)
        {    $this->getCurrentTranslation()->setVersion($v);

        return $this;
    }

    // TableStampBehavior behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     * @return     Content The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = ContentPeer::DATE_MODIFICATION;
        return $this;
    }

}
