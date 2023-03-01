<?php


/**
 * Base class that represents a row from the 'menu' table.
 *
 * Hiérarchie
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseMenu extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'MenuPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MenuPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_menu field.
     * @var        int
     */
    protected $id_menu;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

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
     * @var        PropelObjectCollection|Content[] Collection to store aggregation of Content objects.
     */
    protected $collContents;
    protected $collContentsPartial;

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
    protected $contentsScheduledForDeletion = null;

    /**
     * Get the [id_menu] column value.
     *
     * @return int
     */
    public function getIdMenu()
    {

        return $this->id_menu;
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
     * Get the [order] column value.
     * Ordre du menu
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
        $c->addSelectColumn(MenuPeer::DATE_CREATION);
        try {
            $stmt = MenuPeer::doSelectStmt($c, $con);
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
        $c->addSelectColumn(MenuPeer::DATE_MODIFICATION);
        try {
            $stmt = MenuPeer::doSelectStmt($c, $con);
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
     * Set the value of [id_menu] column.
     *
     * @param  int $v new value
     * @return Menu The current object (for fluent API support)
     */
    public function setIdMenu($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_menu !== $v) {
            $this->id_menu = $v;
            $this->modifiedColumns[] = MenuPeer::ID_MENU;
        }


        return $this;
    } // setIdMenu()

    /**
     * Set the value of [title] column.
     * Titre
     * @param  string $v new value
     * @return Menu The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = MenuPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [order] column.
     * Ordre du menu
     * @param  int $v new value
     * @return Menu The current object (for fluent API support)
     */
    public function setOrder($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->order !== $v) {
            $this->order = $v;
            $this->modifiedColumns[] = MenuPeer::ORDER;
        }


        return $this;
    } // setOrder()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Menu The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_creation_isLoaded && $v === null) {
            $this->modifiedColumns[] = MenuPeer::DATE_CREATION;
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
                $this->modifiedColumns[] = MenuPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Menu The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        // Allow unsetting the lazy loaded column even when its not loaded.
        if (!$this->date_modification_isLoaded && $v === null) {
            $this->modifiedColumns[] = MenuPeer::DATE_MODIFICATION;
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
                $this->modifiedColumns[] = MenuPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Menu The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = MenuPeer::ID_CREATION;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Menu The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = MenuPeer::ID_MODIFICATION;
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

            $this->id_menu = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->title = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->order = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->id_creation = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->id_modification = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 5; // 5 = MenuPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Menu object", $e);
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
        if ($con === null) { $con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = MenuPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

            $this->collContents = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Menu';}
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
        mem_clean('Menu');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = MenuQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Menu');
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

                        mem_clean('Menu');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            MenuPeer::addInstanceToPool($this);

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

            if ($this->contentsScheduledForDeletion !== null) {
                if (!$this->contentsScheduledForDeletion->isEmpty()) {
                    foreach ($this->contentsScheduledForDeletion as $content) {
                        // need to save related object because we set the relation to null
                        $content->save($con);
                    }
                    $this->contentsScheduledForDeletion = null;
                }
            }

            if ($this->collContents !== null) {
                foreach ($this->collContents as $referrerFK) {
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

        $this->modifiedColumns[] = MenuPeer::ID_MENU;
        if (null !== $this->id_menu) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MenuPeer::ID_MENU . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MenuPeer::ID_MENU)) {
            $modifiedColumns[':p' . $index++]  = '`id_menu`';
        }
        if ($this->isColumnModified(MenuPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(MenuPeer::ORDER)) {
            $modifiedColumns[':p' . $index++]  = '`order`';
        }
        if ($this->isColumnModified(MenuPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(MenuPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(MenuPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(MenuPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }

        $sql = sprintf(
            'INSERT INTO `menu` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_menu`':
                        $stmt->bindValue($identifier, $this->id_menu, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
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
        $this->setIdMenu($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Menu';}
        $needeRight='a';
        if($this->getPrimaryKey()){$needeRight='w';}
        if(!$_SESSION[_AUTH_VAR]->hasRights($_SESSION['CurrentRights'],$needeRight,$this)){
            if(is_array($_SESSION['CurrentRights'])){
                foreach($_SESSION['CurrentRights'] as $Rigths){if($Rigths){$Entite = _($Rigths);}}
            }else{ $Entite = _($_SESSION['CurrentRights']);
            }$failureMap['Rights'] = new ValidationFailed('Rights', _('Droit insuffisant').'<br>'.$Entite.'-'.$needeRight, NULL);
        }

            if (($retval = MenuPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collContents !== null) {
                    foreach ($this->collContents as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = MenuPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Menu'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Menu'][$this->getPrimaryKey()] = true;
        $keys = MenuPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdMenu(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getOrder(),
            $keys[3] => ($includeLazyLoadColumns) ? $this->getDateCreation() : null,
            $keys[4] => ($includeLazyLoadColumns) ? $this->getDateModification() : null,
            $keys[5] => $this->getIdCreation(),
            $keys[6] => $this->getIdModification(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collContents) {
                $result['Contents'] = $this->collContents->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = MenuPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdMenu($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setOrder($value);
                break;
            case 3:
                $this->setDateCreation($value);
                break;
            case 4:
                $this->setDateModification($value);
                break;
            case 5:
                $this->setIdCreation($value);
                break;
            case 6:
                $this->setIdModification($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = MenuPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdMenu($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setOrder($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDateCreation($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDateModification($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIdCreation($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIdModification($arr[$keys[6]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(MenuPeer::DATABASE_NAME);

        if ($this->isColumnModified(MenuPeer::ID_MENU)) $criteria->add(MenuPeer::ID_MENU, $this->id_menu);
        if ($this->isColumnModified(MenuPeer::TITLE)) $criteria->add(MenuPeer::TITLE, $this->title);
        if ($this->isColumnModified(MenuPeer::ORDER)) $criteria->add(MenuPeer::ORDER, $this->order);
        if ($this->isColumnModified(MenuPeer::DATE_CREATION)) $criteria->add(MenuPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(MenuPeer::DATE_MODIFICATION)) $criteria->add(MenuPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(MenuPeer::ID_CREATION)) $criteria->add(MenuPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(MenuPeer::ID_MODIFICATION)) $criteria->add(MenuPeer::ID_MODIFICATION, $this->id_modification);

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
        $criteria = new Criteria(MenuPeer::DATABASE_NAME);
        $criteria->add(MenuPeer::ID_MENU, $this->id_menu);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdMenu();
    }

    /**
     * Generic method to set the primary key (id_menu column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdMenu($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdMenu();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Menu (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setTitle($this->getTitle());
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

            foreach ($this->getContents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContent($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdMenu(NULL); // this is a auto-increment column, so set to default value
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
     * @return Menu Clone of current object.
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
     * @return MenuPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MenuPeer();
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
        if ('Content' == $relationName) {
            $this->initContents();
        }
    }

    /**
     * Clears out the collContents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Menu The current object (for fluent API support)
     * @see        addContents()
     */
    public function clearContents()
    {
        $this->collContents = null; // important to set this to null since that means it is uninitialized
        $this->collContentsPartial = null;

        return $this;
    }

    /**
     * reset is the collContents collection loaded partially
     *
     * @return void
     */
    public function resetPartialContents($v = true)
    {
        $this->collContentsPartial = $v;
    }

    /**
     * Initializes the collContents collection.
     *
     * By default this just sets the collContents collection to an empty array (like clearcollContents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContents($overrideExisting = true)
    {
        if (null !== $this->collContents && !$overrideExisting) {
            return;
        }
        $this->collContents = new PropelObjectCollection();
        $this->collContents->setModel('Content');
    }

    /**
     * Gets an array of Content objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Menu is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Content[] List of Content objects
     * @throws PropelException
     */
    public function getContents($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentsPartial && !$this->isNew();
        if (null === $this->collContents || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContents) {
                // return empty collection
                $this->initContents();
            } else {
                $collContents = ContentQuery::create(null, $criteria)
                    ->filterByMenu($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentsPartial && count($collContents)) {
                      $this->initContents(false);

                      foreach ($collContents as $obj) {
                        if (false == $this->collContents->contains($obj)) {
                          $this->collContents->append($obj);
                        }
                      }

                      $this->collContentsPartial = true;
                    }

                    $collContents->getInternalIterator()->rewind();

                    return $collContents;
                }

                if ($partial && $this->collContents) {
                    foreach ($this->collContents as $obj) {
                        if ($obj->isNew()) {
                            $collContents[] = $obj;
                        }
                    }
                }

                $this->collContents = $collContents;
                $this->collContentsPartial = false;
            }
        }

        return $this->collContents;
    }

    /**
     * Sets a collection of Content objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contents A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Menu The current object (for fluent API support)
     */
    public function setContents(PropelCollection $contents, PropelPDO $con = null)
    {
        $contentsToDelete = $this->getContents(new Criteria(), $con)->diff($contents);


        $this->contentsScheduledForDeletion = $contentsToDelete;

        foreach ($contentsToDelete as $contentRemoved) {
            $contentRemoved->setMenu(null);
        }

        $this->collContents = null;
        foreach ($contents as $content) {
            $this->addContent($content);
        }

        $this->collContents = $contents;
        $this->collContentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Content objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Content objects.
     * @throws PropelException
     */
    public function countContents(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentsPartial && !$this->isNew();
        if (null === $this->collContents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContents) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContents());
            }
            $query = ContentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMenu($this)
                ->count($con);
        }

        return count($this->collContents);
    }

    /**
     * Method called to associate a Content object to this object
     * through the Content foreign key attribute.
     *
     * @param    Content $l Content
     * @return Menu The current object (for fluent API support)
     */
    public function addContent(Content $l)
    {
        if ($this->collContents === null) {
            $this->initContents();
            $this->collContentsPartial = true;
        }

        if (!in_array($l, $this->collContents->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContent($l);

            if ($this->contentsScheduledForDeletion and $this->contentsScheduledForDeletion->contains($l)) {
                $this->contentsScheduledForDeletion->remove($this->contentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Content $content The content object to add.
     */
    protected function doAddContent($content)
    {
        $this->collContents[]= $content;
        $content->setMenu($this);
    }

    /**
     * @param	Content $content The content object to remove.
     * @return Menu The current object (for fluent API support)
     */
    public function removeContent($content)
    {
        if ($this->getContents()->contains($content)) {
            $this->collContents->remove($this->collContents->search($content));
            if (null === $this->contentsScheduledForDeletion) {
                $this->contentsScheduledForDeletion = clone $this->collContents;
                $this->contentsScheduledForDeletion->clear();
            }
            $this->contentsScheduledForDeletion[]= $content;
            $content->setMenu(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_menu = null;
        $this->title = null;
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
            if ($this->collContents) {
                foreach ($this->collContents as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collContents instanceof PropelCollection) {
            $this->collContents->clearIterator();
        }
        $this->collContents = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MenuPeer::DEFAULT_STRING_FORMAT);
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
     * @return     Menu The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = MenuPeer::DATE_MODIFICATION;
        return $this;
    }

}
