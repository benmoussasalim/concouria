<?php


/**
 * Base class that represents a row from the 'taxe' table.
 *
 * Taxe
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseTaxe extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'TaxePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        TaxePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_taxe field.
     * @var        int
     */
    protected $id_taxe;

    /**
     * The value for the id_group_taxe_sup field.
     * @var        int
     */
    protected $id_group_taxe_sup;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the code field.
     * @var        string
     */
    protected $code;

    /**
     * The value for the pourcent field.
     * @var        string
     */
    protected $pourcent;

    /**
     * The value for the taxable field.
     * @var        int
     */
    protected $taxable;

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
     * @var        GrpTaxe
     */
    protected $aGrpTaxe;

    /**
     * @var        PropelObjectCollection|SaleTaxe[] Collection to store aggregation of SaleTaxe objects.
     */
    protected $collSaleTaxes;
    protected $collSaleTaxesPartial;

    /**
     * @var        PropelObjectCollection|TaxeI18n[] Collection to store aggregation of TaxeI18n objects.
     */
    protected $collTaxeI18ns;
    protected $collTaxeI18nsPartial;

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
     * @var        array[TaxeI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $saleTaxesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $taxeI18nsScheduledForDeletion = null;

    /**
     * Get the [id_taxe] column value.
     *
     * @return int
     */
    public function getIdTaxe()
    {

        return $this->id_taxe;
    }

    /**
     * Get the [id_group_taxe_sup] column value.
     *
     * @return int
     */
    public function getIdGroupTaxeSup()
    {

        return $this->id_group_taxe_sup;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [code] column value.
     * Code de taxe
     * @return string
     */
    public function getCode()
    {

        return $this->code;
    }

    /**
     * Get the [pourcent] column value.
     * Pourcentage
     * @return string
     */
    public function getPourcent()
    {

        return $this->pourcent;
    }

    /**
     * Get the [taxable] column value.
     *
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getTaxable()
    {
        if (null === $this->taxable) {
            return null;
        }
        $valueSet = TaxePeer::getValueSet(TaxePeer::TAXABLE);
        if (!isset($valueSet[$this->taxable])) {
            throw new PropelException('Unknown stored enum key: ' . $this->taxable);
        }

        return $valueSet[$this->taxable];
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
        $c->addSelectColumn(TaxePeer::DATE_CREATION);
        try {
            $stmt = TaxePeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(TaxePeer::DATE_MODIFICATION);
        try {
            $stmt = TaxePeer::doSelectStmt($c, $con);
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
     * Set the value of [id_taxe] column.
     *
     * @param  int $v new value
     * @return Taxe The current object (for fluent API support)
     */
    public function setIdTaxe($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_taxe !== $v) {
            $this->id_taxe = $v;
            $this->modifiedColumns[] = TaxePeer::ID_TAXE;
        }


        return $this;
    } // setIdTaxe()

    /**
     * Set the value of [id_group_taxe_sup] column.
     *
     * @param  int $v new value
     * @return Taxe The current object (for fluent API support)
     */
    public function setIdGroupTaxeSup($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_group_taxe_sup !== $v) {
            $this->id_group_taxe_sup = $v;
            $this->modifiedColumns[] = TaxePeer::ID_GROUP_TAXE_SUP;
        }

        if ($this->aGrpTaxe !== null && $this->aGrpTaxe->getIdGroupTaxeSup() !== $v) {
            $this->aGrpTaxe = null;
        }


        return $this;
    } // setIdGroupTaxeSup()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Taxe The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = TaxePeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [code] column.
     * Code de taxe
     * @param  string $v new value
     * @return Taxe The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[] = TaxePeer::CODE;
        }


        return $this;
    } // setCode()

    /**
     * Set the value of [pourcent] column.
     * Pourcentage
     * @param  string $v new value
     * @return Taxe The current object (for fluent API support)
     */
    public function setPourcent($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->pourcent !== $v) {
            $this->pourcent = $v;
            $this->modifiedColumns[] = TaxePeer::POURCENT;
        }


        return $this;
    } // setPourcent()

    /**
     * Set the value of [taxable] column.
     *
     * @param  int $v new value
     * @return Taxe The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setTaxable($v)
    {
        if ($v !== null) {
            $valueSet = TaxePeer::getValueSet(TaxePeer::TAXABLE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->taxable !== $v) {
            $this->taxable = $v;
            $this->modifiedColumns[] = TaxePeer::TAXABLE;
        }


        return $this;
    } // setTaxable()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Taxe The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = TaxePeer::DATE_CREATION;
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
                $this->modifiedColumns[] = TaxePeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Taxe The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = TaxePeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = TaxePeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Taxe The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = TaxePeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Taxe The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = TaxePeer::ID_MODIFICATION;
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

            $this->id_taxe = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_group_taxe_sup = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->code = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->pourcent = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->taxable = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->id_creation = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->id_modification = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = TaxePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Taxe object", $e);
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

        if ($this->aGrpTaxe !== null && $this->id_group_taxe_sup !== $this->aGrpTaxe->getIdGroupTaxeSup()) {
            $this->aGrpTaxe = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(TaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = TaxePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->aGrpTaxe = null;
            $this->collSaleTaxes = null;
            $this->collTaxeI18ns = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Taxe';}
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
        mem_clean('Taxe');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(TaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = TaxeQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(TaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Taxe');
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

                        mem_clean('Taxe');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            TaxePeer::addInstanceToPool($this);

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

            if ($this->aGrpTaxe !== null) {
                if ($this->aGrpTaxe->isModified() || $this->aGrpTaxe->isNew()) {
                    $affectedRows += $this->aGrpTaxe->save($con);
                }
                $this->setGrpTaxe($this->aGrpTaxe);
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

            if ($this->saleTaxesScheduledForDeletion !== null) {
                if (!$this->saleTaxesScheduledForDeletion->isEmpty()) {
                    foreach ($this->saleTaxesScheduledForDeletion as $saleTaxe) {
                        // need to save related object because we set the relation to null
                        $saleTaxe->save($con);
                    }
                    $this->saleTaxesScheduledForDeletion = null;
                }
            }

            if ($this->collSaleTaxes !== null) {
                foreach ($this->collSaleTaxes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->taxeI18nsScheduledForDeletion !== null) {
                if (!$this->taxeI18nsScheduledForDeletion->isEmpty()) {
                    TaxeI18nQuery::create()
                        ->filterByPrimaryKeys($this->taxeI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->taxeI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collTaxeI18ns !== null) {
                foreach ($this->collTaxeI18ns as $referrerFK) {
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

        $this->modifiedColumns[] = TaxePeer::ID_TAXE;
        if (null !== $this->id_taxe) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TaxePeer::ID_TAXE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TaxePeer::ID_TAXE)) {
            $modifiedColumns[':p' . $index++]  = '`id_taxe`';
        }
        if ($this->isColumnModified(TaxePeer::ID_GROUP_TAXE_SUP)) {
            $modifiedColumns[':p' . $index++]  = '`id_group_taxe_sup`';
        }
        if ($this->isColumnModified(TaxePeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(TaxePeer::CODE)) {
            $modifiedColumns[':p' . $index++]  = '`code`';
        }
        if ($this->isColumnModified(TaxePeer::POURCENT)) {
            $modifiedColumns[':p' . $index++]  = '`pourcent`';
        }
        if ($this->isColumnModified(TaxePeer::TAXABLE)) {
            $modifiedColumns[':p' . $index++]  = '`taxable`';
        }
        if ($this->isColumnModified(TaxePeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(TaxePeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(TaxePeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(TaxePeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `taxe` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_taxe`':
                        $stmt->bindValue($identifier, $this->id_taxe, PDO::PARAM_INT);
                        break;
                    case '`id_group_taxe_sup`':
                        $stmt->bindValue($identifier, $this->id_group_taxe_sup, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`code`':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case '`pourcent`':
                        $stmt->bindValue($identifier, $this->pourcent, PDO::PARAM_STR);
                        break;
                    case '`taxable`':
                        $stmt->bindValue($identifier, $this->taxable, PDO::PARAM_INT);
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
        $this->setIdTaxe($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Taxe';}
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

            if ($this->aGrpTaxe !== null) {
                if (!$this->aGrpTaxe->validate($columns)) {$failureMap = array_merge($failureMap, $this->aGrpTaxe->getValidationFailures()); }
            }

            if (($retval = TaxePeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collSaleTaxes !== null) {
                    foreach ($this->collSaleTaxes as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

                if ($this->collTaxeI18ns !== null) {
                    foreach ($this->collTaxeI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = TaxePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Taxe'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Taxe'][$this->getPrimaryKey()] = true;
        $keys = TaxePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdTaxe(),
            $keys[1] => $this->getIdGroupTaxeSup(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getCode(),
            $keys[4] => $this->getPourcent(),
            $keys[5] => $this->getTaxable(),
            $keys[6] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[7] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[8] => $this->getIdCreation(),
            $keys[9] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aGrpTaxe) {
                $result['GrpTaxe'] = $this->aGrpTaxe->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSaleTaxes) {
                $result['SaleTaxes'] = $this->collSaleTaxes->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTaxeI18ns) {
                $result['TaxeI18ns'] = $this->collTaxeI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = TaxePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdTaxe($value);
                break;
            case 1:
                $this->setIdGroupTaxeSup($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setCode($value);
                break;
            case 4:
                $this->setPourcent($value);
                break;
            case 5:
                $valueSet = TaxePeer::getValueSet(TaxePeer::TAXABLE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setTaxable($value);
                break;
            case 6:
                $this->setDateCreation($value);
                break;
            case 7:
                $this->setDateModification($value);
                break;
            case 8:
                $this->setIdCreation($value);
                break;
            case 9:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = TaxePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdTaxe($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdGroupTaxeSup($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCode($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPourcent($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setTaxable($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDateCreation($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDateModification($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setIdCreation($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setIdModification($arr[$keys[9]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(TaxePeer::DATABASE_NAME);

        if ($this->isColumnModified(TaxePeer::ID_TAXE)) $criteria->add(TaxePeer::ID_TAXE, $this->id_taxe);
        if ($this->isColumnModified(TaxePeer::ID_GROUP_TAXE_SUP)) $criteria->add(TaxePeer::ID_GROUP_TAXE_SUP, $this->id_group_taxe_sup);
        if ($this->isColumnModified(TaxePeer::NAME)) $criteria->add(TaxePeer::NAME, $this->name);
        if ($this->isColumnModified(TaxePeer::CODE)) $criteria->add(TaxePeer::CODE, $this->code);
        if ($this->isColumnModified(TaxePeer::POURCENT)) $criteria->add(TaxePeer::POURCENT, $this->pourcent);
        if ($this->isColumnModified(TaxePeer::TAXABLE)) $criteria->add(TaxePeer::TAXABLE, $this->taxable);
        if ($this->isColumnModified(TaxePeer::DATE_CREATION)) $criteria->add(TaxePeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(TaxePeer::DATE_MODIFICATION)) $criteria->add(TaxePeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(TaxePeer::ID_CREATION)) $criteria->add(TaxePeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(TaxePeer::ID_MODIFICATION)) $criteria->add(TaxePeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(TaxePeer::DATABASE_NAME);
        $criteria->add(TaxePeer::ID_TAXE, $this->id_taxe);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdTaxe();
    }

    /**
     * Generic method to set the primary key (id_taxe column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdTaxe($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdTaxe();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Taxe (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdGroupTaxeSup($this->getIdGroupTaxeSup());
        $copyObj->setName($this->getName());
        $copyObj->setCode($this->getCode());
        $copyObj->setPourcent($this->getPourcent());
        $copyObj->setTaxable($this->getTaxable());
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

            foreach ($this->getSaleTaxes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSaleTaxe($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTaxeI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTaxeI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdTaxe(NULL); // this is a auto-increment column, so set to default value
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
     * @return Taxe Clone of current object.
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
     * @return TaxePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new TaxePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a GrpTaxe object.
     *
     * @param                  GrpTaxe $v
     * @return Taxe The current object (for fluent API support)
     * @throws PropelException
     */
    public function setGrpTaxe(GrpTaxe $v = null)
    {
        if ($v === null) {
            $this->setIdGroupTaxeSup(NULL);
        } else {
            $this->setIdGroupTaxeSup($v->getIdGroupTaxeSup());
        }

        $this->aGrpTaxe = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the GrpTaxe object, it will not be re-added.
        if ($v !== null) {
            $v->addTaxe($this);
        }


        return $this;
    }


    /**
     * Get the associated GrpTaxe object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return GrpTaxe The associated GrpTaxe object.
     * @throws PropelException
     */
    public function getGrpTaxe(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aGrpTaxe === null && ($this->id_group_taxe_sup !== null) && $doQuery) {
            $this->aGrpTaxe = GrpTaxeQuery::create()->findPk($this->id_group_taxe_sup, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGrpTaxe->addTaxes($this);
             */
        }

        return $this->aGrpTaxe;
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
        if ('SaleTaxe' == $relationName) {
            $this->initSaleTaxes();
        }
        if ('TaxeI18n' == $relationName) {
            $this->initTaxeI18ns();
        }
    }

    /**
     * Clears out the collSaleTaxes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Taxe The current object (for fluent API support)
     * @see        addSaleTaxes()
     */
    public function clearSaleTaxes()
    {
        $this->collSaleTaxes = null; // important to set this to null since that means it is uninitialized
        $this->collSaleTaxesPartial = null;

        return $this;
    }

    /**
     * reset is the collSaleTaxes collection loaded partially
     *
     * @return void
     */
    public function resetPartialSaleTaxes($v = true)
    {
        $this->collSaleTaxesPartial = $v;
    }

    /**
     * Initializes the collSaleTaxes collection.
     *
     * By default this just sets the collSaleTaxes collection to an empty array (like clearcollSaleTaxes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSaleTaxes($overrideExisting = true)
    {
        if (null !== $this->collSaleTaxes && !$overrideExisting) {
            return;
        }
        $this->collSaleTaxes = new PropelObjectCollection();
        $this->collSaleTaxes->setModel('SaleTaxe');
    }

    /**
     * Gets an array of SaleTaxe objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Taxe is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|SaleTaxe[] List of SaleTaxe objects
     * @throws PropelException
     */
    public function getSaleTaxes($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSaleTaxesPartial && !$this->isNew();
        if (null === $this->collSaleTaxes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSaleTaxes) {
                // return empty collection
                $this->initSaleTaxes();
            } else {
                $collSaleTaxes = SaleTaxeQuery::create(null, $criteria)
                    ->filterByTaxe($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSaleTaxesPartial && count($collSaleTaxes)) {
                      $this->initSaleTaxes(false);

                      foreach ($collSaleTaxes as $obj) {
                        if (false == $this->collSaleTaxes->contains($obj)) {
                          $this->collSaleTaxes->append($obj);
                        }
                      }

                      $this->collSaleTaxesPartial = true;
                    }

                    $collSaleTaxes->getInternalIterator()->rewind();

                    return $collSaleTaxes;
                }

                if ($partial && $this->collSaleTaxes) {
                    foreach ($this->collSaleTaxes as $obj) {
                        if ($obj->isNew()) {
                            $collSaleTaxes[] = $obj;
                        }
                    }
                }

                $this->collSaleTaxes = $collSaleTaxes;
                $this->collSaleTaxesPartial = false;
            }
        }

        return $this->collSaleTaxes;
    }

    /**
     * Sets a collection of SaleTaxe objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $saleTaxes A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Taxe The current object (for fluent API support)
     */
    public function setSaleTaxes(PropelCollection $saleTaxes, PropelPDO $con = null)
    {
        $saleTaxesToDelete = $this->getSaleTaxes(new Criteria(), $con)->diff($saleTaxes);


        $this->saleTaxesScheduledForDeletion = $saleTaxesToDelete;

        foreach ($saleTaxesToDelete as $saleTaxeRemoved) {
            $saleTaxeRemoved->setTaxe(null);
        }

        $this->collSaleTaxes = null;
        foreach ($saleTaxes as $saleTaxe) {
            $this->addSaleTaxe($saleTaxe);
        }

        $this->collSaleTaxes = $saleTaxes;
        $this->collSaleTaxesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SaleTaxe objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related SaleTaxe objects.
     * @throws PropelException
     */
    public function countSaleTaxes(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSaleTaxesPartial && !$this->isNew();
        if (null === $this->collSaleTaxes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSaleTaxes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSaleTaxes());
            }
            $query = SaleTaxeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTaxe($this)
                ->count($con);
        }

        return count($this->collSaleTaxes);
    }

    /**
     * Method called to associate a SaleTaxe object to this object
     * through the SaleTaxe foreign key attribute.
     *
     * @param    SaleTaxe $l SaleTaxe
     * @return Taxe The current object (for fluent API support)
     */
    public function addSaleTaxe(SaleTaxe $l)
    {
        if ($this->collSaleTaxes === null) {
            $this->initSaleTaxes();
            $this->collSaleTaxesPartial = true;
        }

        if (!in_array($l, $this->collSaleTaxes->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSaleTaxe($l);

            if ($this->saleTaxesScheduledForDeletion and $this->saleTaxesScheduledForDeletion->contains($l)) {
                $this->saleTaxesScheduledForDeletion->remove($this->saleTaxesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	SaleTaxe $saleTaxe The saleTaxe object to add.
     */
    protected function doAddSaleTaxe($saleTaxe)
    {
        $this->collSaleTaxes[]= $saleTaxe;
        $saleTaxe->setTaxe($this);
    }

    /**
     * @param	SaleTaxe $saleTaxe The saleTaxe object to remove.
     * @return Taxe The current object (for fluent API support)
     */
    public function removeSaleTaxe($saleTaxe)
    {
        if ($this->getSaleTaxes()->contains($saleTaxe)) {
            $this->collSaleTaxes->remove($this->collSaleTaxes->search($saleTaxe));
            if (null === $this->saleTaxesScheduledForDeletion) {
                $this->saleTaxesScheduledForDeletion = clone $this->collSaleTaxes;
                $this->saleTaxesScheduledForDeletion->clear();
            }
            $this->saleTaxesScheduledForDeletion[]= $saleTaxe;
            $saleTaxe->setTaxe(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Taxe is new, it will return
     * an empty collection; or if this Taxe has previously
     * been saved, it will retrieve related SaleTaxes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Taxe.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|SaleTaxe[] List of SaleTaxe objects
     */
    public function getSaleTaxesJoinAbonnement($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SaleTaxeQuery::create(null, $criteria);
        $query->joinWith('Abonnement', $join_behavior);

        return $this->getSaleTaxes($query, $con);
    }

    /**
     * Clears out the collTaxeI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Taxe The current object (for fluent API support)
     * @see        addTaxeI18ns()
     */
    public function clearTaxeI18ns()
    {
        $this->collTaxeI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collTaxeI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collTaxeI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialTaxeI18ns($v = true)
    {
        $this->collTaxeI18nsPartial = $v;
    }

    /**
     * Initializes the collTaxeI18ns collection.
     *
     * By default this just sets the collTaxeI18ns collection to an empty array (like clearcollTaxeI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTaxeI18ns($overrideExisting = true)
    {
        if (null !== $this->collTaxeI18ns && !$overrideExisting) {
            return;
        }
        $this->collTaxeI18ns = new PropelObjectCollection();
        $this->collTaxeI18ns->setModel('TaxeI18n');
    }

    /**
     * Gets an array of TaxeI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Taxe is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|TaxeI18n[] List of TaxeI18n objects
     * @throws PropelException
     */
    public function getTaxeI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTaxeI18nsPartial && !$this->isNew();
        if (null === $this->collTaxeI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTaxeI18ns) {
                // return empty collection
                $this->initTaxeI18ns();
            } else {
                $collTaxeI18ns = TaxeI18nQuery::create(null, $criteria)
                    ->filterByTaxe($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTaxeI18nsPartial && count($collTaxeI18ns)) {
                      $this->initTaxeI18ns(false);

                      foreach ($collTaxeI18ns as $obj) {
                        if (false == $this->collTaxeI18ns->contains($obj)) {
                          $this->collTaxeI18ns->append($obj);
                        }
                      }

                      $this->collTaxeI18nsPartial = true;
                    }

                    $collTaxeI18ns->getInternalIterator()->rewind();

                    return $collTaxeI18ns;
                }

                if ($partial && $this->collTaxeI18ns) {
                    foreach ($this->collTaxeI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collTaxeI18ns[] = $obj;
                        }
                    }
                }

                $this->collTaxeI18ns = $collTaxeI18ns;
                $this->collTaxeI18nsPartial = false;
            }
        }

        return $this->collTaxeI18ns;
    }

    /**
     * Sets a collection of TaxeI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $taxeI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Taxe The current object (for fluent API support)
     */
    public function setTaxeI18ns(PropelCollection $taxeI18ns, PropelPDO $con = null)
    {
        $taxeI18nsToDelete = $this->getTaxeI18ns(new Criteria(), $con)->diff($taxeI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->taxeI18nsScheduledForDeletion = clone $taxeI18nsToDelete;

        foreach ($taxeI18nsToDelete as $taxeI18nRemoved) {
            $taxeI18nRemoved->setTaxe(null);
        }

        $this->collTaxeI18ns = null;
        foreach ($taxeI18ns as $taxeI18n) {
            $this->addTaxeI18n($taxeI18n);
        }

        $this->collTaxeI18ns = $taxeI18ns;
        $this->collTaxeI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TaxeI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related TaxeI18n objects.
     * @throws PropelException
     */
    public function countTaxeI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTaxeI18nsPartial && !$this->isNew();
        if (null === $this->collTaxeI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTaxeI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTaxeI18ns());
            }
            $query = TaxeI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTaxe($this)
                ->count($con);
        }

        return count($this->collTaxeI18ns);
    }

    /**
     * Method called to associate a TaxeI18n object to this object
     * through the TaxeI18n foreign key attribute.
     *
     * @param    TaxeI18n $l TaxeI18n
     * @return Taxe The current object (for fluent API support)
     */
    public function addTaxeI18n(TaxeI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collTaxeI18ns === null) {
            $this->initTaxeI18ns();
            $this->collTaxeI18nsPartial = true;
        }

        if (!in_array($l, $this->collTaxeI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTaxeI18n($l);

            if ($this->taxeI18nsScheduledForDeletion and $this->taxeI18nsScheduledForDeletion->contains($l)) {
                $this->taxeI18nsScheduledForDeletion->remove($this->taxeI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	TaxeI18n $taxeI18n The taxeI18n object to add.
     */
    protected function doAddTaxeI18n($taxeI18n)
    {
        $this->collTaxeI18ns[]= $taxeI18n;
        $taxeI18n->setTaxe($this);
    }

    /**
     * @param	TaxeI18n $taxeI18n The taxeI18n object to remove.
     * @return Taxe The current object (for fluent API support)
     */
    public function removeTaxeI18n($taxeI18n)
    {
        if ($this->getTaxeI18ns()->contains($taxeI18n)) {
            $this->collTaxeI18ns->remove($this->collTaxeI18ns->search($taxeI18n));
            if (null === $this->taxeI18nsScheduledForDeletion) {
                $this->taxeI18nsScheduledForDeletion = clone $this->collTaxeI18ns;
                $this->taxeI18nsScheduledForDeletion->clear();
            }
            $this->taxeI18nsScheduledForDeletion[]= clone $taxeI18n;
            $taxeI18n->setTaxe(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_taxe = null;
        $this->id_group_taxe_sup = null;
        $this->name = null;
        $this->code = null;
        $this->pourcent = null;
        $this->taxable = null;
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
            if ($this->collSaleTaxes) {
                foreach ($this->collSaleTaxes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTaxeI18ns) {
                foreach ($this->collTaxeI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aGrpTaxe instanceof Persistent) {
              $this->aGrpTaxe->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collSaleTaxes instanceof PropelCollection) {
            $this->collSaleTaxes->clearIterator();
        }
        $this->collSaleTaxes = null;
        if ($this->collTaxeI18ns instanceof PropelCollection) {
            $this->collTaxeI18ns->clearIterator();
        }
        $this->collTaxeI18ns = null;
        $this->aGrpTaxe = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TaxePeer::DEFAULT_STRING_FORMAT);
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
     * @return    Taxe The current object (for fluent API support)
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
     * @return TaxeI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collTaxeI18ns) {
                foreach ($this->collTaxeI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new TaxeI18n();
                $translation->setLocale($locale);
            } else {
                $translation = TaxeI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addTaxeI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    Taxe The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            TaxeI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collTaxeI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collTaxeI18ns[$key]);
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
     * @return TaxeI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [title] column value.
         * Nom
         * @return string
         */
        public function getTitle()
        {
        return $this->getCurrentTranslation()->getTitle();
    }


        /**
         * Set the value of [title] column.
         * Nom
         * @param  string $v new value
         * @return TaxeI18n The current object (for fluent API support)
         */
        public function setTitle($v)
        {    $this->getCurrentTranslation()->setTitle($v);

        return $this;
    }

    // TableStampBehavior behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     * @return     Taxe The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = TaxePeer::DATE_MODIFICATION;
        return $this;
    }

}
