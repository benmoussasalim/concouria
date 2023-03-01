<?php


/**
 * Base class that represents a row from the 'group_right' table.
 *
 * Groupe
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseGroupRight extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'GroupRightPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        GroupRightPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_group_right field.
     * @var        int
     */
    protected $id_group_right;

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
     * The value for the rights_admin field.
     * @var        string
     */
    protected $rights_admin;

    /**
     * The value for the rights_owner field.
     * @var        string
     */
    protected $rights_owner;

    /**
     * The value for the rights_group field.
     * @var        string
     */
    protected $rights_group;

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
     * @var        PropelObjectCollection|GroupRightAuthy[] Collection to store aggregation of GroupRightAuthy objects.
     */
    protected $collGroupRightAuthys;
    protected $collGroupRightAuthysPartial;

    /**
     * @var        PropelObjectCollection|Authy[] Collection to store aggregation Xrel of Authy objects.
     */
    protected $collAuthys;

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
    protected $authysScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $groupRightAuthysScheduledForDeletion = null;

    /**
     * Get the [id_group_right] column value.
     *
     * @return int
     */
    public function getIdGroupRight()
    {

        return $this->id_group_right;
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
     * Get the [name] column value.
     * Nom
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
     * Get the [rights_admin] column value.
     * Droits admin
     * @return string
     */
    public function getRightsAdmin()
    {

        return $this->rights_admin;
    }

    /**
     * Get the [rights_owner] column value.
     * Droits propriétaire
     * @return string
     */
    public function getRightsOwner()
    {

        return $this->rights_owner;
    }

    /**
     * Get the [rights_group] column value.
     * Droits groupe
     * @return string
     */
    public function getRightsGroup()
    {

        return $this->rights_group;
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
        $c->addSelectColumn(GroupRightPeer::DATE_CREATION);
        try {
            $stmt = GroupRightPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(GroupRightPeer::DATE_MODIFICATION);
        try {
            $stmt = GroupRightPeer::doSelectStmt($c, $con);
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $stmt->closeCursor();
            $this->date_modification = ($row[0] !== null) ? (string) $row[0] : null;
            $this->date_modification_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [date_modification] column on demand.", $e);
        }
    }
    /**
     * Set the value of [id_group_right] column.
     *
     * @param  int $v new value
     * @return GroupRight The current object (for fluent API support)
     */
    public function setIdGroupRight($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_group_right !== $v) {
            $this->id_group_right = $v;
            $this->modifiedColumns[] = GroupRightPeer::ID_GROUP_RIGHT;
        }


        return $this;
    } // setIdGroupRight()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return GroupRight The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = GroupRightPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return GroupRight The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = GroupRightPeer::ID_MODIFICATION;
        }


        return $this;
    } // setIdModification()

    /**
     * Set the value of [name] column.
     * Nom
     * @param  string $v new value
     * @return GroupRight The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = GroupRightPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [desc] column.
     * Description
     * @param  string $v new value
     * @return GroupRight The current object (for fluent API support)
     */
    public function setDesc($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->desc !== $v) {
            $this->desc = $v;
            $this->modifiedColumns[] = GroupRightPeer::DESC;
        }


        return $this;
    } // setDesc()

    /**
     * Set the value of [rights_admin] column.
     * Droits admin
     * @param  string $v new value
     * @return GroupRight The current object (for fluent API support)
     */
    public function setRightsAdmin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rights_admin !== $v) {
            $this->rights_admin = $v;
            $this->modifiedColumns[] = GroupRightPeer::RIGHTS_ADMIN;
        }


        return $this;
    } // setRightsAdmin()

    /**
     * Set the value of [rights_owner] column.
     * Droits propriétaire
     * @param  string $v new value
     * @return GroupRight The current object (for fluent API support)
     */
    public function setRightsOwner($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rights_owner !== $v) {
            $this->rights_owner = $v;
            $this->modifiedColumns[] = GroupRightPeer::RIGHTS_OWNER;
        }


        return $this;
    } // setRightsOwner()

    /**
     * Set the value of [rights_group] column.
     * Droits groupe
     * @param  string $v new value
     * @return GroupRight The current object (for fluent API support)
     */
    public function setRightsGroup($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rights_group !== $v) {
            $this->rights_group = $v;
            $this->modifiedColumns[] = GroupRightPeer::RIGHTS_GROUP;
        }


        return $this;
    } // setRightsGroup()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return GroupRight The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = GroupRightPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = GroupRightPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return GroupRight The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = GroupRightPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = GroupRightPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

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

            $this->id_group_right = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_creation = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->id_modification = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->desc = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->rights_admin = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->rights_owner = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->rights_group = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = GroupRightPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating GroupRight object", $e);
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
        if ($con === null) { $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = GroupRightPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->collGroupRightAuthys = null;
            $this->collAuthys = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='GroupRight';}
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
        mem_clean('GroupRight');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = GroupRightQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('GroupRight');
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

                        mem_clean('GroupRight');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            GroupRightPeer::addInstanceToPool($this);

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

            if ($this->authysScheduledForDeletion !== null) {
                if (!$this->authysScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->authysScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($pk, $remotePk);
                    }
                    GroupRightAuthyQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->authysScheduledForDeletion = null;
                }

                foreach ($this->getAuthys() as $authy) {
                    if ($authy->isModified()) {
                        $authy->save($con);
                    }
                }
            } elseif ($this->collAuthys) {
                foreach ($this->collAuthys as $authy) {
                    if ($authy->isModified()) {
                        $authy->save($con);
                    }
                }
            }

            if ($this->groupRightAuthysScheduledForDeletion !== null) {
                if (!$this->groupRightAuthysScheduledForDeletion->isEmpty()) {
                    GroupRightAuthyQuery::create()
                        ->filterByPrimaryKeys($this->groupRightAuthysScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->groupRightAuthysScheduledForDeletion = null;
                }
            }

            if ($this->collGroupRightAuthys !== null) {
                foreach ($this->collGroupRightAuthys as $referrerFK) {
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

        $this->modifiedColumns[] = GroupRightPeer::ID_GROUP_RIGHT;
        if (null !== $this->id_group_right) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GroupRightPeer::ID_GROUP_RIGHT . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GroupRightPeer::ID_GROUP_RIGHT)) {
            $modifiedColumns[':p' . $index++]  = '`id_group_right`';
        }
        if ($this->isColumnModified(GroupRightPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(GroupRightPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }
        if ($this->isColumnModified(GroupRightPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(GroupRightPeer::DESC)) {
            $modifiedColumns[':p' . $index++]  = '`desc`';
        }
        if ($this->isColumnModified(GroupRightPeer::RIGHTS_ADMIN)) {
            $modifiedColumns[':p' . $index++]  = '`rights_admin`';
        }
        if ($this->isColumnModified(GroupRightPeer::RIGHTS_OWNER)) {
            $modifiedColumns[':p' . $index++]  = '`rights_owner`';
        }
        if ($this->isColumnModified(GroupRightPeer::RIGHTS_GROUP)) {
            $modifiedColumns[':p' . $index++]  = '`rights_group`';
        }
        if ($this->isColumnModified(GroupRightPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(GroupRightPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `group_right` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_group_right`':
                        $stmt->bindValue($identifier, $this->id_group_right, PDO::PARAM_INT);
                        break;
                    case '`id_creation`':
                        $stmt->bindValue($identifier, $this->id_creation, PDO::PARAM_INT);
                        break;
                    case '`id_modification`':
                        $stmt->bindValue($identifier, $this->id_modification, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`desc`':
                        $stmt->bindValue($identifier, $this->desc, PDO::PARAM_STR);
                        break;
                    case '`rights_admin`':
                        $stmt->bindValue($identifier, $this->rights_admin, PDO::PARAM_STR);
                        break;
                    case '`rights_owner`':
                        $stmt->bindValue($identifier, $this->rights_owner, PDO::PARAM_STR);
                        break;
                    case '`rights_group`':
                        $stmt->bindValue($identifier, $this->rights_group, PDO::PARAM_STR);
                        break;
                    case '`date_creation`':
                        $stmt->bindValue($identifier, $this->date_creation, PDO::PARAM_STR);
                        break;
                    case '`date_modification`':
                        $stmt->bindValue($identifier, $this->date_modification, PDO::PARAM_STR);
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
        $this->setIdGroupRight($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='GroupRight';}
        $needeRight='a';
        if($this->getPrimaryKey()){$needeRight='w';}
        if(!$_SESSION[_AUTH_VAR]->hasRights($_SESSION['CurrentRights'],$needeRight,$this)){
            if(is_array($_SESSION['CurrentRights'])){
                foreach($_SESSION['CurrentRights'] as $Rigths){if($Rigths){$Entite = _($Rigths);}}
            }else{ $Entite = _($_SESSION['CurrentRights']);
            }$failureMap['Rights'] = new ValidationFailed('Rights', _('Droit insuffisant').'<br>'.$Entite.'-'.$needeRight, NULL);
        }

            if (($retval = GroupRightPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collGroupRightAuthys !== null) {
                    foreach ($this->collGroupRightAuthys as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = GroupRightPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['GroupRight'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['GroupRight'][$this->getPrimaryKey()] = true;
        $keys = GroupRightPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdGroupRight(),
            $keys[1] => $this->getIdCreation(),
            $keys[2] => $this->getIdModification(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getDesc(),
            $keys[5] => $this->getRightsAdmin(),
            $keys[6] => $this->getRightsOwner(),
            $keys[7] => $this->getRightsGroup(),
            $keys[8] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[9] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collGroupRightAuthys) {
                $result['GroupRightAuthys'] = $this->collGroupRightAuthys->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = GroupRightPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdGroupRight($value);
                break;
            case 1:
                $this->setIdCreation($value);
                break;
            case 2:
                $this->setIdModification($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setDesc($value);
                break;
            case 5:
                $this->setRightsAdmin($value);
                break;
            case 6:
                $this->setRightsOwner($value);
                break;
            case 7:
                $this->setRightsGroup($value);
                break;
            case 8:
                $this->setDateCreation($value);
                break;
            case 9:
                $this->setDateModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = GroupRightPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdGroupRight($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdCreation($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setIdModification($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDesc($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setRightsAdmin($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setRightsOwner($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setRightsGroup($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDateCreation($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setDateModification($arr[$keys[9]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(GroupRightPeer::DATABASE_NAME);

        if ($this->isColumnModified(GroupRightPeer::ID_GROUP_RIGHT)) $criteria->add(GroupRightPeer::ID_GROUP_RIGHT, $this->id_group_right);
        if ($this->isColumnModified(GroupRightPeer::ID_CREATION)) $criteria->add(GroupRightPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(GroupRightPeer::ID_MODIFICATION)) $criteria->add(GroupRightPeer::ID_MODIFICATION, $this->id_modification);
        if ($this->isColumnModified(GroupRightPeer::NAME)) $criteria->add(GroupRightPeer::NAME, $this->name);
        if ($this->isColumnModified(GroupRightPeer::DESC)) $criteria->add(GroupRightPeer::DESC, $this->desc);
        if ($this->isColumnModified(GroupRightPeer::RIGHTS_ADMIN)) $criteria->add(GroupRightPeer::RIGHTS_ADMIN, $this->rights_admin);
        if ($this->isColumnModified(GroupRightPeer::RIGHTS_OWNER)) $criteria->add(GroupRightPeer::RIGHTS_OWNER, $this->rights_owner);
        if ($this->isColumnModified(GroupRightPeer::RIGHTS_GROUP)) $criteria->add(GroupRightPeer::RIGHTS_GROUP, $this->rights_group);
        if ($this->isColumnModified(GroupRightPeer::DATE_CREATION)) $criteria->add(GroupRightPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(GroupRightPeer::DATE_MODIFICATION)) $criteria->add(GroupRightPeer::DATE_MODIFICATION, $this->date_modification);

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
        $criteria = new Criteria(GroupRightPeer::DATABASE_NAME);
        $criteria->add(GroupRightPeer::ID_GROUP_RIGHT, $this->id_group_right);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdGroupRight();
    }

    /**
     * Generic method to set the primary key (id_group_right column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdGroupRight($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdGroupRight();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of GroupRight (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdCreation($this->getIdCreation());
        $copyObj->setIdModification($this->getIdModification());
        $copyObj->setName($this->getName());
        $copyObj->setDesc($this->getDesc());
        $copyObj->setRightsAdmin($this->getRightsAdmin());
        $copyObj->setRightsOwner($this->getRightsOwner());
        $copyObj->setRightsGroup($this->getRightsGroup());
        $copyObj->setDateCreation($this->getDateCreation());
        $copyObj->setDateModification($this->getDateModification());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getGroupRightAuthys() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGroupRightAuthy($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdGroupRight(NULL); // this is a auto-increment column, so set to default value
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
     * @return GroupRight Clone of current object.
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
     * @return GroupRightPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new GroupRightPeer();
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
        if ('GroupRightAuthy' == $relationName) {
            $this->initGroupRightAuthys();
        }
    }

    /**
     * Clears out the collGroupRightAuthys collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return GroupRight The current object (for fluent API support)
     * @see        addGroupRightAuthys()
     */
    public function clearGroupRightAuthys()
    {
        $this->collGroupRightAuthys = null; // important to set this to null since that means it is uninitialized
        $this->collGroupRightAuthysPartial = null;

        return $this;
    }

    /**
     * reset is the collGroupRightAuthys collection loaded partially
     *
     * @return void
     */
    public function resetPartialGroupRightAuthys($v = true)
    {
        $this->collGroupRightAuthysPartial = $v;
    }

    /**
     * Initializes the collGroupRightAuthys collection.
     *
     * By default this just sets the collGroupRightAuthys collection to an empty array (like clearcollGroupRightAuthys());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGroupRightAuthys($overrideExisting = true)
    {
        if (null !== $this->collGroupRightAuthys && !$overrideExisting) {
            return;
        }
        $this->collGroupRightAuthys = new PropelObjectCollection();
        $this->collGroupRightAuthys->setModel('GroupRightAuthy');
    }

    /**
     * Gets an array of GroupRightAuthy objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this GroupRight is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|GroupRightAuthy[] List of GroupRightAuthy objects
     * @throws PropelException
     */
    public function getGroupRightAuthys($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collGroupRightAuthysPartial && !$this->isNew();
        if (null === $this->collGroupRightAuthys || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGroupRightAuthys) {
                // return empty collection
                $this->initGroupRightAuthys();
            } else {
                $collGroupRightAuthys = GroupRightAuthyQuery::create(null, $criteria)
                    ->filterByGroupRight($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collGroupRightAuthysPartial && count($collGroupRightAuthys)) {
                      $this->initGroupRightAuthys(false);

                      foreach ($collGroupRightAuthys as $obj) {
                        if (false == $this->collGroupRightAuthys->contains($obj)) {
                          $this->collGroupRightAuthys->append($obj);
                        }
                      }

                      $this->collGroupRightAuthysPartial = true;
                    }

                    $collGroupRightAuthys->getInternalIterator()->rewind();

                    return $collGroupRightAuthys;
                }

                if ($partial && $this->collGroupRightAuthys) {
                    foreach ($this->collGroupRightAuthys as $obj) {
                        if ($obj->isNew()) {
                            $collGroupRightAuthys[] = $obj;
                        }
                    }
                }

                $this->collGroupRightAuthys = $collGroupRightAuthys;
                $this->collGroupRightAuthysPartial = false;
            }
        }

        return $this->collGroupRightAuthys;
    }

    /**
     * Sets a collection of GroupRightAuthy objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $groupRightAuthys A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return GroupRight The current object (for fluent API support)
     */
    public function setGroupRightAuthys(PropelCollection $groupRightAuthys, PropelPDO $con = null)
    {
        $groupRightAuthysToDelete = $this->getGroupRightAuthys(new Criteria(), $con)->diff($groupRightAuthys);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->groupRightAuthysScheduledForDeletion = clone $groupRightAuthysToDelete;

        foreach ($groupRightAuthysToDelete as $groupRightAuthyRemoved) {
            $groupRightAuthyRemoved->setGroupRight(null);
        }

        $this->collGroupRightAuthys = null;
        foreach ($groupRightAuthys as $groupRightAuthy) {
            $this->addGroupRightAuthy($groupRightAuthy);
        }

        $this->collGroupRightAuthys = $groupRightAuthys;
        $this->collGroupRightAuthysPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GroupRightAuthy objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related GroupRightAuthy objects.
     * @throws PropelException
     */
    public function countGroupRightAuthys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collGroupRightAuthysPartial && !$this->isNew();
        if (null === $this->collGroupRightAuthys || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGroupRightAuthys) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGroupRightAuthys());
            }
            $query = GroupRightAuthyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroupRight($this)
                ->count($con);
        }

        return count($this->collGroupRightAuthys);
    }

    /**
     * Method called to associate a GroupRightAuthy object to this object
     * through the GroupRightAuthy foreign key attribute.
     *
     * @param    GroupRightAuthy $l GroupRightAuthy
     * @return GroupRight The current object (for fluent API support)
     */
    public function addGroupRightAuthy(GroupRightAuthy $l)
    {
        if ($this->collGroupRightAuthys === null) {
            $this->initGroupRightAuthys();
            $this->collGroupRightAuthysPartial = true;
        }

        if (!in_array($l, $this->collGroupRightAuthys->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddGroupRightAuthy($l);

            if ($this->groupRightAuthysScheduledForDeletion and $this->groupRightAuthysScheduledForDeletion->contains($l)) {
                $this->groupRightAuthysScheduledForDeletion->remove($this->groupRightAuthysScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	GroupRightAuthy $groupRightAuthy The groupRightAuthy object to add.
     */
    protected function doAddGroupRightAuthy($groupRightAuthy)
    {
        $this->collGroupRightAuthys[]= $groupRightAuthy;
        $groupRightAuthy->setGroupRight($this);
    }

    /**
     * @param	GroupRightAuthy $groupRightAuthy The groupRightAuthy object to remove.
     * @return GroupRight The current object (for fluent API support)
     */
    public function removeGroupRightAuthy($groupRightAuthy)
    {
        if ($this->getGroupRightAuthys()->contains($groupRightAuthy)) {
            $this->collGroupRightAuthys->remove($this->collGroupRightAuthys->search($groupRightAuthy));
            if (null === $this->groupRightAuthysScheduledForDeletion) {
                $this->groupRightAuthysScheduledForDeletion = clone $this->collGroupRightAuthys;
                $this->groupRightAuthysScheduledForDeletion->clear();
            }
            $this->groupRightAuthysScheduledForDeletion[]= clone $groupRightAuthy;
            $groupRightAuthy->setGroupRight(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this GroupRight is new, it will return
     * an empty collection; or if this GroupRight has previously
     * been saved, it will retrieve related GroupRightAuthys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in GroupRight.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|GroupRightAuthy[] List of GroupRightAuthy objects
     */
    public function getGroupRightAuthysJoinAuthy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = GroupRightAuthyQuery::create(null, $criteria);
        $query->joinWith('Authy', $join_behavior);

        return $this->getGroupRightAuthys($query, $con);
    }

    /**
     * Clears out the collAuthys collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return GroupRight The current object (for fluent API support)
     * @see        addAuthys()
     */
    public function clearAuthys()
    {
        $this->collAuthys = null; // important to set this to null since that means it is uninitialized
        $this->collAuthysPartial = null;

        return $this;
    }

    /**
     * Initializes the collAuthys collection.
     *
     * By default this just sets the collAuthys collection to an empty collection (like clearAuthys());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initAuthys()
    {
        $this->collAuthys = new PropelObjectCollection();
        $this->collAuthys->setModel('Authy');
    }

    /**
     * Gets a collection of Authy objects related by a many-to-many relationship
     * to the current object by way of the group_right_authy cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this GroupRight is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|Authy[] List of Authy objects
     */
    public function getAuthys($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collAuthys || null !== $criteria) {
            if ($this->isNew() && null === $this->collAuthys) {
                // return empty collection
                $this->initAuthys();
            } else {
                $collAuthys = AuthyQuery::create(null, $criteria)
                    ->filterByGroupRight($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collAuthys;
                }
                $this->collAuthys = $collAuthys;
            }
        }

        return $this->collAuthys;
    }

    /**
     * Sets a collection of Authy objects related by a many-to-many relationship
     * to the current object by way of the group_right_authy cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $authys A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return GroupRight The current object (for fluent API support)
     */
    public function setAuthys(PropelCollection $authys, PropelPDO $con = null)
    {
        $this->clearAuthys();
        $currentAuthys = $this->getAuthys(null, $con);

        $this->authysScheduledForDeletion = $currentAuthys->diff($authys);

        foreach ($authys as $authy) {
            if (!$currentAuthys->contains($authy)) {
                $this->doAddAuthy($authy);
            }
        }

        $this->collAuthys = $authys;

        return $this;
    }

    /**
     * Gets the number of Authy objects related by a many-to-many relationship
     * to the current object by way of the group_right_authy cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related Authy objects
     */
    public function countAuthys($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collAuthys || null !== $criteria) {
            if ($this->isNew() && null === $this->collAuthys) {
                return 0;
            } else {
                $query = AuthyQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByGroupRight($this)
                    ->count($con);
            }
        } else {
            return count($this->collAuthys);
        }
    }

    /**
     * Associate a Authy object to this object
     * through the group_right_authy cross reference table.
     *
     * @param  Authy $authy The GroupRightAuthy object to relate
     * @return GroupRight The current object (for fluent API support)
     */
    public function addAuthy(Authy $authy)
    {
        if ($this->collAuthys === null) {
            $this->initAuthys();
        }

        if (!$this->collAuthys->contains($authy)) { // only add it if the **same** object is not already associated
            $this->doAddAuthy($authy);
            $this->collAuthys[] = $authy;

            if ($this->authysScheduledForDeletion and $this->authysScheduledForDeletion->contains($authy)) {
                $this->authysScheduledForDeletion->remove($this->authysScheduledForDeletion->search($authy));
            }
        }

        return $this;
    }

    /**
     * @param	Authy $authy The authy object to add.
     */
    protected function doAddAuthy(Authy $authy)
    {
        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$authy->getGroupRights()->contains($this)) { $groupRightAuthy = new GroupRightAuthy();
            $groupRightAuthy->setAuthy($authy);
            $this->addGroupRightAuthy($groupRightAuthy);

            $foreignCollection = $authy->getGroupRights();
            $foreignCollection[] = $this;
        }
    }

    /**
     * Remove a Authy object to this object
     * through the group_right_authy cross reference table.
     *
     * @param Authy $authy The GroupRightAuthy object to relate
     * @return GroupRight The current object (for fluent API support)
     */
    public function removeAuthy(Authy $authy)
    {
        if ($this->getAuthys()->contains($authy)) {
            $this->collAuthys->remove($this->collAuthys->search($authy));
            if (null === $this->authysScheduledForDeletion) {
                $this->authysScheduledForDeletion = clone $this->collAuthys;
                $this->authysScheduledForDeletion->clear();
            }
            $this->authysScheduledForDeletion[]= $authy;
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_group_right = null;
        $this->id_creation = null;
        $this->id_modification = null;
        $this->name = null;
        $this->desc = null;
        $this->rights_admin = null;
        $this->rights_owner = null;
        $this->rights_group = null;
        $this->date_creation = null;
        $this->date_creation_isLoaded = false;
        $this->date_modification = null;
        $this->date_modification_isLoaded = false;
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
            if ($this->collGroupRightAuthys) {
                foreach ($this->collGroupRightAuthys as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuthys) {
                foreach ($this->collAuthys as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collGroupRightAuthys instanceof PropelCollection) {
            $this->collGroupRightAuthys->clearIterator();
        }
        $this->collGroupRightAuthys = null;
        if ($this->collAuthys instanceof PropelCollection) {
            $this->collAuthys->clearIterator();
        }
        $this->collAuthys = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GroupRightPeer::DEFAULT_STRING_FORMAT);
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
     * @return     GroupRight The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = GroupRightPeer::DATE_MODIFICATION;
        return $this;
    }

}
