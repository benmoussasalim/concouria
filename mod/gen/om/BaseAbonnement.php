<?php


/**
 * Base class that represents a row from the 'abonnement' table.
 *
 * Renouvellement
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseAbonnement extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'AbonnementPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AbonnementPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_abonnement field.
     * @var        int
     */
    protected $id_abonnement;

    /**
     * The value for the id_sale field.
     * @var        int
     */
    protected $id_sale;

    /**
     * The value for the date_paiement field.
     * @var        string
     */
    protected $date_paiement;

    /**
     * The value for the sub_amount field.
     * @var        string
     */
    protected $sub_amount;

    /**
     * The value for the amount field.
     * @var        string
     */
    protected $amount;

    /**
     * The value for the abonnement_price field.
     * @var        string
     */
    protected $abonnement_price;

    /**
     * The value for the stripe_response field.
     * @var        string
     */
    protected $stripe_response;

    /**
     * The value for the type field.
     * Note: this column has a database default value of: 0
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
     * @var        Sale
     */
    protected $aSale;

    /**
     * @var        PropelObjectCollection|SaleTaxe[] Collection to store aggregation of SaleTaxe objects.
     */
    protected $collSaleTaxes;
    protected $collSaleTaxesPartial;

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
    protected $saleTaxesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->type = 0;
    }

    /**
     * Initializes internal state of BaseAbonnement object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id_abonnement] column value.
     *
     * @return int
     */
    public function getIdAbonnement()
    {

        return $this->id_abonnement;
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
     * Get the [optionally formatted] temporal [date_paiement] column value.
     * Date de paiement
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatePaiement($format = 'Y-m-d H:i:s')
    {
        if ($this->date_paiement === null) {
            return null;
        }

        if ($this->date_paiement === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date_paiement);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_paiement, true), $x);
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
     * Get the [sub_amount] column value.
     * Sous-total
     * @return string
     */
    public function getSubAmount()
    {

        return $this->sub_amount;
    }

    /**
     * Get the [amount] column value.
     * Total
     * @return string
     */
    public function getAmount()
    {

        return $this->amount;
    }

    /**
     * Get the [abonnement_price] column value.
     *
     * @return string
     */
    public function getAbonnementPrice()
    {

        return $this->abonnement_price;
    }

    /**
     * Get the [stripe_response] column value.
     * Réponse Stripe
     * @return string
     */
    public function getStripeResponse()
    {

        return $this->stripe_response;
    }

    /**
     * Get the [type] column value.
     * Type d'abonnement
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getType()
    {
        if (null === $this->type) {
            return null;
        }
        $valueSet = AbonnementPeer::getValueSet(AbonnementPeer::TYPE);
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
        $c->addSelectColumn(AbonnementPeer::DATE_CREATION);
        try {
            $stmt = AbonnementPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(AbonnementPeer::DATE_MODIFICATION);
        try {
            $stmt = AbonnementPeer::doSelectStmt($c, $con);
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
     * Set the value of [id_abonnement] column.
     *
     * @param  int $v new value
     * @return Abonnement The current object (for fluent API support)
     */
    public function setIdAbonnement($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_abonnement !== $v) {
            $this->id_abonnement = $v;
            $this->modifiedColumns[] = AbonnementPeer::ID_ABONNEMENT;
        }


        return $this;
    } // setIdAbonnement()

    /**
     * Set the value of [id_sale] column.
     *
     * @param  int $v new value
     * @return Abonnement The current object (for fluent API support)
     */
    public function setIdSale($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_sale !== $v) {
            $this->id_sale = $v;
            $this->modifiedColumns[] = AbonnementPeer::ID_SALE;
        }

        if ($this->aSale !== null && $this->aSale->getIdSale() !== $v) {
            $this->aSale = null;
        }


        return $this;
    } // setIdSale()

    /**
     * Sets the value of [date_paiement] column to a normalized version of the date/time value specified.
     * Date de paiement
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Abonnement The current object (for fluent API support)
     */
    public function setDatePaiement($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_paiement !== null || $dt !== null) {
            $currentDateAsString = ($this->date_paiement !== null && $tmpDt = new DateTime($this->date_paiement)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_paiement = $newDateAsString;
                $this->modifiedColumns[] = AbonnementPeer::DATE_PAIEMENT;
            }
        } // if either are not null


        return $this;
    } // setDatePaiement()

    /**
     * Set the value of [sub_amount] column.
     * Sous-total
     * @param  string $v new value
     * @return Abonnement The current object (for fluent API support)
     */
    public function setSubAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sub_amount !== $v) {
            $this->sub_amount = $v;
            $this->modifiedColumns[] = AbonnementPeer::SUB_AMOUNT;
        }


        return $this;
    } // setSubAmount()

    /**
     * Set the value of [amount] column.
     * Total
     * @param  string $v new value
     * @return Abonnement The current object (for fluent API support)
     */
    public function setAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->amount !== $v) {
            $this->amount = $v;
            $this->modifiedColumns[] = AbonnementPeer::AMOUNT;
        }


        return $this;
    } // setAmount()

    /**
     * Set the value of [abonnement_price] column.
     *
     * @param  string $v new value
     * @return Abonnement The current object (for fluent API support)
     */
    public function setAbonnementPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->abonnement_price !== $v) {
            $this->abonnement_price = $v;
            $this->modifiedColumns[] = AbonnementPeer::ABONNEMENT_PRICE;
        }


        return $this;
    } // setAbonnementPrice()

    /**
     * Set the value of [stripe_response] column.
     * Réponse Stripe
     * @param  string $v new value
     * @return Abonnement The current object (for fluent API support)
     */
    public function setStripeResponse($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->stripe_response !== $v) {
            $this->stripe_response = $v;
            $this->modifiedColumns[] = AbonnementPeer::STRIPE_RESPONSE;
        }


        return $this;
    } // setStripeResponse()

    /**
     * Set the value of [type] column.
     * Type d'abonnement
     * @param  int $v new value
     * @return Abonnement The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setType($v)
    {
        if ($v !== null) {
            $valueSet = AbonnementPeer::getValueSet(AbonnementPeer::TYPE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = AbonnementPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Abonnement The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = AbonnementPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = AbonnementPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Abonnement The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = AbonnementPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = AbonnementPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Abonnement The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = AbonnementPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Abonnement The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = AbonnementPeer::ID_MODIFICATION;
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
            if ($this->type !== 0) {
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

            $this->id_abonnement = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_sale = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->date_paiement = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->sub_amount = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->amount = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->abonnement_price = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->stripe_response = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->type = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->id_creation = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->id_modification = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 10; // 10 = AbonnementPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Abonnement object", $e);
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

        if ($this->aSale !== null && $this->id_sale !== $this->aSale->getIdSale()) {
            $this->aSale = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(AbonnementPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = AbonnementPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->aSale = null;
            $this->collSaleTaxes = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Abonnement';}
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
        mem_clean('Abonnement');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(AbonnementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = AbonnementQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(AbonnementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Abonnement');
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

                        mem_clean('Abonnement');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            AbonnementPeer::addInstanceToPool($this);

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

            if ($this->aSale !== null) {
                if ($this->aSale->isModified() || $this->aSale->isNew()) {
                    $affectedRows += $this->aSale->save($con);
                }
                $this->setSale($this->aSale);
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
                    SaleTaxeQuery::create()
                        ->filterByPrimaryKeys($this->saleTaxesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

        $this->modifiedColumns[] = AbonnementPeer::ID_ABONNEMENT;
        if (null !== $this->id_abonnement) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AbonnementPeer::ID_ABONNEMENT . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AbonnementPeer::ID_ABONNEMENT)) {
            $modifiedColumns[':p' . $index++]  = '`id_abonnement`';
        }
        if ($this->isColumnModified(AbonnementPeer::ID_SALE)) {
            $modifiedColumns[':p' . $index++]  = '`id_sale`';
        }
        if ($this->isColumnModified(AbonnementPeer::DATE_PAIEMENT)) {
            $modifiedColumns[':p' . $index++]  = '`date_paiement`';
        }
        if ($this->isColumnModified(AbonnementPeer::SUB_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = '`sub_amount`';
        }
        if ($this->isColumnModified(AbonnementPeer::AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = '`amount`';
        }
        if ($this->isColumnModified(AbonnementPeer::ABONNEMENT_PRICE)) {
            $modifiedColumns[':p' . $index++]  = '`abonnement_price`';
        }
        if ($this->isColumnModified(AbonnementPeer::STRIPE_RESPONSE)) {
            $modifiedColumns[':p' . $index++]  = '`stripe_response`';
        }
        if ($this->isColumnModified(AbonnementPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(AbonnementPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(AbonnementPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(AbonnementPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(AbonnementPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `abonnement` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_abonnement`':
                        $stmt->bindValue($identifier, $this->id_abonnement, PDO::PARAM_INT);
                        break;
                    case '`id_sale`':
                        $stmt->bindValue($identifier, $this->id_sale, PDO::PARAM_INT);
                        break;
                    case '`date_paiement`':
                        $stmt->bindValue($identifier, $this->date_paiement, PDO::PARAM_STR);
                        break;
                    case '`sub_amount`':
                        $stmt->bindValue($identifier, $this->sub_amount, PDO::PARAM_STR);
                        break;
                    case '`amount`':
                        $stmt->bindValue($identifier, $this->amount, PDO::PARAM_STR);
                        break;
                    case '`abonnement_price`':
                        $stmt->bindValue($identifier, $this->abonnement_price, PDO::PARAM_STR);
                        break;
                    case '`stripe_response`':
                        $stmt->bindValue($identifier, $this->stripe_response, PDO::PARAM_STR);
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
        $this->setIdAbonnement($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Abonnement';}
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

            if ($this->aSale !== null) {
                if (!$this->aSale->validate($columns)) {$failureMap = array_merge($failureMap, $this->aSale->getValidationFailures()); }
            }

            if (($retval = AbonnementPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collSaleTaxes !== null) {
                    foreach ($this->collSaleTaxes as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AbonnementPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Abonnement'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Abonnement'][$this->getPrimaryKey()] = true;
        $keys = AbonnementPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdAbonnement(),
            $keys[1] => $this->getIdSale(),
            $keys[2] => $this->getDatePaiement(),
            $keys[3] => $this->getSubAmount(),
            $keys[4] => $this->getAmount(),
            $keys[5] => $this->getAbonnementPrice(),
            $keys[6] => $this->getStripeResponse(),
            $keys[7] => $this->getType(),
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
            if (null !== $this->aSale) {
                $result['Sale'] = $this->aSale->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSaleTaxes) {
                $result['SaleTaxes'] = $this->collSaleTaxes->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AbonnementPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdAbonnement($value);
                break;
            case 1:
                $this->setIdSale($value);
                break;
            case 2:
                $this->setDatePaiement($value);
                break;
            case 3:
                $this->setSubAmount($value);
                break;
            case 4:
                $this->setAmount($value);
                break;
            case 5:
                $this->setAbonnementPrice($value);
                break;
            case 6:
                $this->setStripeResponse($value);
                break;
            case 7:
                $valueSet = AbonnementPeer::getValueSet(AbonnementPeer::TYPE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setType($value);
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
        $keys = AbonnementPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdAbonnement($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdSale($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDatePaiement($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setSubAmount($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAmount($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setAbonnementPrice($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setStripeResponse($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setType($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDateCreation($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setDateModification($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setIdCreation($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setIdModification($arr[$keys[11]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(AbonnementPeer::DATABASE_NAME);

        if ($this->isColumnModified(AbonnementPeer::ID_ABONNEMENT)) $criteria->add(AbonnementPeer::ID_ABONNEMENT, $this->id_abonnement);
        if ($this->isColumnModified(AbonnementPeer::ID_SALE)) $criteria->add(AbonnementPeer::ID_SALE, $this->id_sale);
        if ($this->isColumnModified(AbonnementPeer::DATE_PAIEMENT)) $criteria->add(AbonnementPeer::DATE_PAIEMENT, $this->date_paiement);
        if ($this->isColumnModified(AbonnementPeer::SUB_AMOUNT)) $criteria->add(AbonnementPeer::SUB_AMOUNT, $this->sub_amount);
        if ($this->isColumnModified(AbonnementPeer::AMOUNT)) $criteria->add(AbonnementPeer::AMOUNT, $this->amount);
        if ($this->isColumnModified(AbonnementPeer::ABONNEMENT_PRICE)) $criteria->add(AbonnementPeer::ABONNEMENT_PRICE, $this->abonnement_price);
        if ($this->isColumnModified(AbonnementPeer::STRIPE_RESPONSE)) $criteria->add(AbonnementPeer::STRIPE_RESPONSE, $this->stripe_response);
        if ($this->isColumnModified(AbonnementPeer::TYPE)) $criteria->add(AbonnementPeer::TYPE, $this->type);
        if ($this->isColumnModified(AbonnementPeer::DATE_CREATION)) $criteria->add(AbonnementPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(AbonnementPeer::DATE_MODIFICATION)) $criteria->add(AbonnementPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(AbonnementPeer::ID_CREATION)) $criteria->add(AbonnementPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(AbonnementPeer::ID_MODIFICATION)) $criteria->add(AbonnementPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(AbonnementPeer::DATABASE_NAME);
        $criteria->add(AbonnementPeer::ID_ABONNEMENT, $this->id_abonnement);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdAbonnement();
    }

    /**
     * Generic method to set the primary key (id_abonnement column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdAbonnement($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdAbonnement();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Abonnement (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdSale($this->getIdSale());
        $copyObj->setDatePaiement($this->getDatePaiement());
        $copyObj->setSubAmount($this->getSubAmount());
        $copyObj->setAmount($this->getAmount());
        $copyObj->setAbonnementPrice($this->getAbonnementPrice());
        $copyObj->setStripeResponse($this->getStripeResponse());
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

            foreach ($this->getSaleTaxes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSaleTaxe($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdAbonnement(NULL); // this is a auto-increment column, so set to default value
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
     * @return Abonnement Clone of current object.
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
     * @return AbonnementPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AbonnementPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Sale object.
     *
     * @param                  Sale $v
     * @return Abonnement The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSale(Sale $v = null)
    {
        if ($v === null) {
            $this->setIdSale(NULL);
        } else {
            $this->setIdSale($v->getIdSale());
        }

        $this->aSale = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Sale object, it will not be re-added.
        if ($v !== null) {
            $v->addAbonnement($this);
        }


        return $this;
    }


    /**
     * Get the associated Sale object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Sale The associated Sale object.
     * @throws PropelException
     */
    public function getSale(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aSale === null && ($this->id_sale !== null) && $doQuery) {
            $this->aSale = SaleQuery::create()->findPk($this->id_sale, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSale->addAbonnements($this);
             */
        }

        return $this->aSale;
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
    }

    /**
     * Clears out the collSaleTaxes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Abonnement The current object (for fluent API support)
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
     * If this Abonnement is new, it will return
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
                    ->filterByAbonnement($this)
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
     * @return Abonnement The current object (for fluent API support)
     */
    public function setSaleTaxes(PropelCollection $saleTaxes, PropelPDO $con = null)
    {
        $saleTaxesToDelete = $this->getSaleTaxes(new Criteria(), $con)->diff($saleTaxes);


        $this->saleTaxesScheduledForDeletion = $saleTaxesToDelete;

        foreach ($saleTaxesToDelete as $saleTaxeRemoved) {
            $saleTaxeRemoved->setAbonnement(null);
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
                ->filterByAbonnement($this)
                ->count($con);
        }

        return count($this->collSaleTaxes);
    }

    /**
     * Method called to associate a SaleTaxe object to this object
     * through the SaleTaxe foreign key attribute.
     *
     * @param    SaleTaxe $l SaleTaxe
     * @return Abonnement The current object (for fluent API support)
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
        $saleTaxe->setAbonnement($this);
    }

    /**
     * @param	SaleTaxe $saleTaxe The saleTaxe object to remove.
     * @return Abonnement The current object (for fluent API support)
     */
    public function removeSaleTaxe($saleTaxe)
    {
        if ($this->getSaleTaxes()->contains($saleTaxe)) {
            $this->collSaleTaxes->remove($this->collSaleTaxes->search($saleTaxe));
            if (null === $this->saleTaxesScheduledForDeletion) {
                $this->saleTaxesScheduledForDeletion = clone $this->collSaleTaxes;
                $this->saleTaxesScheduledForDeletion->clear();
            }
            $this->saleTaxesScheduledForDeletion[]= clone $saleTaxe;
            $saleTaxe->setAbonnement(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Abonnement is new, it will return
     * an empty collection; or if this Abonnement has previously
     * been saved, it will retrieve related SaleTaxes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Abonnement.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|SaleTaxe[] List of SaleTaxe objects
     */
    public function getSaleTaxesJoinTaxe($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SaleTaxeQuery::create(null, $criteria);
        $query->joinWith('Taxe', $join_behavior);

        return $this->getSaleTaxes($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_abonnement = null;
        $this->id_sale = null;
        $this->date_paiement = null;
        $this->sub_amount = null;
        $this->amount = null;
        $this->abonnement_price = null;
        $this->stripe_response = null;
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
            if ($this->collSaleTaxes) {
                foreach ($this->collSaleTaxes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aSale instanceof Persistent) {
              $this->aSale->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collSaleTaxes instanceof PropelCollection) {
            $this->collSaleTaxes->clearIterator();
        }
        $this->collSaleTaxes = null;
        $this->aSale = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AbonnementPeer::DEFAULT_STRING_FORMAT);
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
     * @return     Abonnement The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = AbonnementPeer::DATE_MODIFICATION;
        return $this;
    }

}
