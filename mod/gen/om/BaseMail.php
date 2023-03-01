<?php


/**
 * Base class that represents a row from the 'mail' table.
 *
 * Courriel
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseMail extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'MailPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MailPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_mail field.
     * @var        int
     */
    protected $id_mail;

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
     * The value for the date_creation field.
     * @var        string
     */
    protected $date_creation;

    /**
     * The value for the date_modification field.
     * @var        string
     */
    protected $date_modification;

    /**
     * The value for the calc_id field.
     * @var        string
     */
    protected $calc_id;

    /**
     * The value for the status field.
     * @var        int
     */
    protected $status;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * @var        Authy
     */
    protected $aAuthyRelatedByIdModification;

    /**
     * @var        Authy
     */
    protected $aAuthyRelatedByIdCreation;

    /**
     * @var        PropelObjectCollection|MailI18n[] Collection to store aggregation of MailI18n objects.
     */
    protected $collMailI18ns;
    protected $collMailI18nsPartial;

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
     * @var        array[MailI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $mailI18nsScheduledForDeletion = null;

    /**
     * Get the [id_mail] column value.
     *
     * @return int
     */
    public function getIdMail()
    {

        return $this->id_mail;
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
     * Get the [optionally formatted] temporal [date_creation] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateCreation($format = 'Y-m-d H:i:s')
    {
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
     * Get the [optionally formatted] temporal [date_modification] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateModification($format = 'Y-m-d H:i:s')
    {
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
     * Get the [calc_id] column value.
     * Mail #
     * @return string
     */
    public function getCalcId()
    {

        return $this->calc_id;
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
        $valueSet = MailPeer::getValueSet(MailPeer::STATUS);
        if (!isset($valueSet[$this->status])) {
            throw new PropelException('Unknown stored enum key: ' . $this->status);
        }

        return $valueSet[$this->status];
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
     * Set the value of [id_mail] column.
     *
     * @param  int $v new value
     * @return Mail The current object (for fluent API support)
     */
    public function setIdMail($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_mail !== $v) {
            $this->id_mail = $v;
            $this->modifiedColumns[] = MailPeer::ID_MAIL;
        }


        return $this;
    } // setIdMail()

    /**
     * Set the value of [id_creation] column.
     *
     * @param  int $v new value
     * @return Mail The current object (for fluent API support)
     */
    public function setIdCreation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_creation !== $v) {
            $this->id_creation = $v;
            $this->modifiedColumns[] = MailPeer::ID_CREATION;
        }

        if ($this->aAuthyRelatedByIdCreation !== null && $this->aAuthyRelatedByIdCreation->getIdAuthy() !== $v) {
            $this->aAuthyRelatedByIdCreation = null;
        }


        return $this;
    } // setIdCreation()

    /**
     * Set the value of [id_modification] column.
     *
     * @param  int $v new value
     * @return Mail The current object (for fluent API support)
     */
    public function setIdModification($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_modification !== $v) {
            $this->id_modification = $v;
            $this->modifiedColumns[] = MailPeer::ID_MODIFICATION;
        }

        if ($this->aAuthyRelatedByIdModification !== null && $this->aAuthyRelatedByIdModification->getIdAuthy() !== $v) {
            $this->aAuthyRelatedByIdModification = null;
        }


        return $this;
    } // setIdModification()

    /**
     * Sets the value of [date_creation] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Mail The current object (for fluent API support)
     */
    public function setDateCreation($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_creation !== null || $dt !== null) {
            $currentDateAsString = ($this->date_creation !== null && $tmpDt = new DateTime($this->date_creation)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_creation = $newDateAsString;
                $this->modifiedColumns[] = MailPeer::DATE_CREATION;
            }
        } // if either are not null


        return $this;
    } // setDateCreation()

    /**
     * Sets the value of [date_modification] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Mail The current object (for fluent API support)
     */
    public function setDateModification($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_modification !== null || $dt !== null) {
            $currentDateAsString = ($this->date_modification !== null && $tmpDt = new DateTime($this->date_modification)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date_modification = $newDateAsString;
                $this->modifiedColumns[] = MailPeer::DATE_MODIFICATION;
            }
        } // if either are not null


        return $this;
    } // setDateModification()

    /**
     * Set the value of [calc_id] column.
     * Mail #
     * @param  string $v new value
     * @return Mail The current object (for fluent API support)
     */
    public function setCalcId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->calc_id !== $v) {
            $this->calc_id = $v;
            $this->modifiedColumns[] = MailPeer::CALC_ID;
        }


        return $this;
    } // setCalcId()

    /**
     * Set the value of [status] column.
     * Status
     * @param  int $v new value
     * @return Mail The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $valueSet = MailPeer::getValueSet(MailPeer::STATUS);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[] = MailPeer::STATUS;
        }


        return $this;
    } // setStatus()

    /**
     * Set the value of [name] column.
     * Nom
     * @param  string $v new value
     * @return Mail The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = MailPeer::NAME;
        }


        return $this;
    } // setName()

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

            $this->id_mail = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_creation = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->id_modification = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->date_creation = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->date_modification = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->calc_id = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->status = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->name = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = MailPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Mail object", $e);
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

        if ($this->aAuthyRelatedByIdCreation !== null && $this->id_creation !== $this->aAuthyRelatedByIdCreation->getIdAuthy()) {
            $this->aAuthyRelatedByIdCreation = null;
        }
        if ($this->aAuthyRelatedByIdModification !== null && $this->id_modification !== $this->aAuthyRelatedByIdModification->getIdAuthy()) {
            $this->aAuthyRelatedByIdModification = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(MailPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = MailPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) { throw new PropelException('Cannot find matching row in the database to reload object values.');}
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAuthyRelatedByIdModification = null;
            $this->aAuthyRelatedByIdCreation = null;
            $this->collMailI18ns = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Mail';}
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
        mem_clean('Mail');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(MailPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = MailQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(MailPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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

                        mem_clean('Mail');
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

                        mem_clean('Mail');

            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            MailPeer::addInstanceToPool($this);

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

            if ($this->aAuthyRelatedByIdModification !== null) {
                if ($this->aAuthyRelatedByIdModification->isModified() || $this->aAuthyRelatedByIdModification->isNew()) {
                    $affectedRows += $this->aAuthyRelatedByIdModification->save($con);
                }
                $this->setAuthyRelatedByIdModification($this->aAuthyRelatedByIdModification);
            }

            if ($this->aAuthyRelatedByIdCreation !== null) {
                if ($this->aAuthyRelatedByIdCreation->isModified() || $this->aAuthyRelatedByIdCreation->isNew()) {
                    $affectedRows += $this->aAuthyRelatedByIdCreation->save($con);
                }
                $this->setAuthyRelatedByIdCreation($this->aAuthyRelatedByIdCreation);
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

            if ($this->mailI18nsScheduledForDeletion !== null) {
                if (!$this->mailI18nsScheduledForDeletion->isEmpty()) {
                    MailI18nQuery::create()
                        ->filterByPrimaryKeys($this->mailI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mailI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collMailI18ns !== null) {
                foreach ($this->collMailI18ns as $referrerFK) {
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

        $this->modifiedColumns[] = MailPeer::ID_MAIL;
        if (null !== $this->id_mail) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MailPeer::ID_MAIL . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MailPeer::ID_MAIL)) {
            $modifiedColumns[':p' . $index++]  = '`id_mail`';
        }
        if ($this->isColumnModified(MailPeer::ID_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_creation`';
        }
        if ($this->isColumnModified(MailPeer::ID_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`id_modification`';
        }
        if ($this->isColumnModified(MailPeer::DATE_CREATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_creation`';
        }
        if ($this->isColumnModified(MailPeer::DATE_MODIFICATION)) {
            $modifiedColumns[':p' . $index++]  = '`date_modification`';
        }
        if ($this->isColumnModified(MailPeer::CALC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`calc_id`';
        }
        if ($this->isColumnModified(MailPeer::STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`status`';
        }
        if ($this->isColumnModified(MailPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }

        $sql = sprintf(
            'INSERT INTO `mail` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_mail`':
                        $stmt->bindValue($identifier, $this->id_mail, PDO::PARAM_INT);
                        break;
                    case '`id_creation`':
                        $stmt->bindValue($identifier, $this->id_creation, PDO::PARAM_INT);
                        break;
                    case '`id_modification`':
                        $stmt->bindValue($identifier, $this->id_modification, PDO::PARAM_INT);
                        break;
                    case '`date_creation`':
                        $stmt->bindValue($identifier, $this->date_creation, PDO::PARAM_STR);
                        break;
                    case '`date_modification`':
                        $stmt->bindValue($identifier, $this->date_modification, PDO::PARAM_STR);
                        break;
                    case '`calc_id`':
                        $stmt->bindValue($identifier, $this->calc_id, PDO::PARAM_STR);
                        break;
                    case '`status`':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
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
        $this->setIdMail($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='Mail';}
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

            if ($this->aAuthyRelatedByIdModification !== null) {
                if (!$this->aAuthyRelatedByIdModification->validate($columns)) {$failureMap = array_merge($failureMap, $this->aAuthyRelatedByIdModification->getValidationFailures()); }
            }

            if ($this->aAuthyRelatedByIdCreation !== null) {
                if (!$this->aAuthyRelatedByIdCreation->validate($columns)) {$failureMap = array_merge($failureMap, $this->aAuthyRelatedByIdCreation->getValidationFailures()); }
            }

            if (($retval = MailPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

                if ($this->collMailI18ns !== null) {
                    foreach ($this->collMailI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) { $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());}
                    }
                }

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = MailPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Mail'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Mail'][$this->getPrimaryKey()] = true;
        $keys = MailPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdMail(),
            $keys[1] => $this->getIdCreation(),
            $keys[2] => $this->getIdModification(),
            $keys[3] => $this->getDateCreation(),
            $keys[4] => $this->getDateModification(),
            $keys[5] => $this->getCalcId(),
            $keys[6] => $this->getStatus(),
            $keys[7] => $this->getName(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAuthyRelatedByIdModification) {
                $result['AuthyRelatedByIdModification'] = $this->aAuthyRelatedByIdModification->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAuthyRelatedByIdCreation) {
                $result['AuthyRelatedByIdCreation'] = $this->aAuthyRelatedByIdCreation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collMailI18ns) {
                $result['MailI18ns'] = $this->collMailI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = MailPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdMail($value);
                break;
            case 1:
                $this->setIdCreation($value);
                break;
            case 2:
                $this->setIdModification($value);
                break;
            case 3:
                $this->setDateCreation($value);
                break;
            case 4:
                $this->setDateModification($value);
                break;
            case 5:
                $this->setCalcId($value);
                break;
            case 6:
                $valueSet = MailPeer::getValueSet(MailPeer::STATUS);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setStatus($value);
                break;
            case 7:
                $this->setName($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = MailPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdMail($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdCreation($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setIdModification($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDateCreation($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDateModification($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCalcId($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setStatus($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setName($arr[$keys[7]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(MailPeer::DATABASE_NAME);

        if ($this->isColumnModified(MailPeer::ID_MAIL)) $criteria->add(MailPeer::ID_MAIL, $this->id_mail);
        if ($this->isColumnModified(MailPeer::ID_CREATION)) $criteria->add(MailPeer::ID_CREATION, $this->id_creation);
        if ($this->isColumnModified(MailPeer::ID_MODIFICATION)) $criteria->add(MailPeer::ID_MODIFICATION, $this->id_modification);
        if ($this->isColumnModified(MailPeer::DATE_CREATION)) $criteria->add(MailPeer::DATE_CREATION, $this->date_creation);
        if ($this->isColumnModified(MailPeer::DATE_MODIFICATION)) $criteria->add(MailPeer::DATE_MODIFICATION, $this->date_modification);
        if ($this->isColumnModified(MailPeer::CALC_ID)) $criteria->add(MailPeer::CALC_ID, $this->calc_id);
        if ($this->isColumnModified(MailPeer::STATUS)) $criteria->add(MailPeer::STATUS, $this->status);
        if ($this->isColumnModified(MailPeer::NAME)) $criteria->add(MailPeer::NAME, $this->name);

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
        $criteria = new Criteria(MailPeer::DATABASE_NAME);
        $criteria->add(MailPeer::ID_MAIL, $this->id_mail);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdMail();
    }

    /**
     * Generic method to set the primary key (id_mail column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdMail($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdMail();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Mail (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdCreation($this->getIdCreation());
        $copyObj->setIdModification($this->getIdModification());
        $copyObj->setDateCreation($this->getDateCreation());
        $copyObj->setDateModification($this->getDateModification());
        $copyObj->setCalcId($this->getCalcId());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setName($this->getName());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getMailI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMailI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdMail(NULL); // this is a auto-increment column, so set to default value
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
     * @return Mail Clone of current object.
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
     * @return MailPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MailPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return Mail The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthyRelatedByIdModification(Authy $v = null)
    {
        if ($v === null) {
            $this->setIdModification(NULL);
        } else {
            $this->setIdModification($v->getIdAuthy());
        }

        $this->aAuthyRelatedByIdModification = $v;


        return $this;
    }


    /**
     * Get the associated Authy object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Authy The associated Authy object.
     * @throws PropelException
     */
    public function getAuthyRelatedByIdModification(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthyRelatedByIdModification === null && ($this->id_modification !== null) && $doQuery) {
            $this->aAuthyRelatedByIdModification = AuthyQuery::create()->findPk($this->id_modification, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthyRelatedByIdModification->addMailsRelatedByIdModification($this);
             */
        }

        return $this->aAuthyRelatedByIdModification;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return Mail The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthyRelatedByIdCreation(Authy $v = null)
    {
        if ($v === null) {
            $this->setIdCreation(NULL);
        } else {
            $this->setIdCreation($v->getIdAuthy());
        }

        $this->aAuthyRelatedByIdCreation = $v;


        return $this;
    }


    /**
     * Get the associated Authy object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Authy The associated Authy object.
     * @throws PropelException
     */
    public function getAuthyRelatedByIdCreation(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthyRelatedByIdCreation === null && ($this->id_creation !== null) && $doQuery) {
            $this->aAuthyRelatedByIdCreation = AuthyQuery::create()->findPk($this->id_creation, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthyRelatedByIdCreation->addMailsRelatedByIdCreation($this);
             */
        }

        return $this->aAuthyRelatedByIdCreation;
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
        if ('MailI18n' == $relationName) {
            $this->initMailI18ns();
        }
    }

    /**
     * Clears out the collMailI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Mail The current object (for fluent API support)
     * @see        addMailI18ns()
     */
    public function clearMailI18ns()
    {
        $this->collMailI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collMailI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collMailI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialMailI18ns($v = true)
    {
        $this->collMailI18nsPartial = $v;
    }

    /**
     * Initializes the collMailI18ns collection.
     *
     * By default this just sets the collMailI18ns collection to an empty array (like clearcollMailI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMailI18ns($overrideExisting = true)
    {
        if (null !== $this->collMailI18ns && !$overrideExisting) {
            return;
        }
        $this->collMailI18ns = new PropelObjectCollection();
        $this->collMailI18ns->setModel('MailI18n');
    }

    /**
     * Gets an array of MailI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Mail is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MailI18n[] List of MailI18n objects
     * @throws PropelException
     */
    public function getMailI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMailI18nsPartial && !$this->isNew();
        if (null === $this->collMailI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMailI18ns) {
                // return empty collection
                $this->initMailI18ns();
            } else {
                $collMailI18ns = MailI18nQuery::create(null, $criteria)
                    ->filterByMail($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMailI18nsPartial && count($collMailI18ns)) {
                      $this->initMailI18ns(false);

                      foreach ($collMailI18ns as $obj) {
                        if (false == $this->collMailI18ns->contains($obj)) {
                          $this->collMailI18ns->append($obj);
                        }
                      }

                      $this->collMailI18nsPartial = true;
                    }

                    $collMailI18ns->getInternalIterator()->rewind();

                    return $collMailI18ns;
                }

                if ($partial && $this->collMailI18ns) {
                    foreach ($this->collMailI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collMailI18ns[] = $obj;
                        }
                    }
                }

                $this->collMailI18ns = $collMailI18ns;
                $this->collMailI18nsPartial = false;
            }
        }

        return $this->collMailI18ns;
    }

    /**
     * Sets a collection of MailI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $mailI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Mail The current object (for fluent API support)
     */
    public function setMailI18ns(PropelCollection $mailI18ns, PropelPDO $con = null)
    {
        $mailI18nsToDelete = $this->getMailI18ns(new Criteria(), $con)->diff($mailI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->mailI18nsScheduledForDeletion = clone $mailI18nsToDelete;

        foreach ($mailI18nsToDelete as $mailI18nRemoved) {
            $mailI18nRemoved->setMail(null);
        }

        $this->collMailI18ns = null;
        foreach ($mailI18ns as $mailI18n) {
            $this->addMailI18n($mailI18n);
        }

        $this->collMailI18ns = $mailI18ns;
        $this->collMailI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MailI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MailI18n objects.
     * @throws PropelException
     */
    public function countMailI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMailI18nsPartial && !$this->isNew();
        if (null === $this->collMailI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMailI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMailI18ns());
            }
            $query = MailI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMail($this)
                ->count($con);
        }

        return count($this->collMailI18ns);
    }

    /**
     * Method called to associate a MailI18n object to this object
     * through the MailI18n foreign key attribute.
     *
     * @param    MailI18n $l MailI18n
     * @return Mail The current object (for fluent API support)
     */
    public function addMailI18n(MailI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collMailI18ns === null) {
            $this->initMailI18ns();
            $this->collMailI18nsPartial = true;
        }

        if (!in_array($l, $this->collMailI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMailI18n($l);

            if ($this->mailI18nsScheduledForDeletion and $this->mailI18nsScheduledForDeletion->contains($l)) {
                $this->mailI18nsScheduledForDeletion->remove($this->mailI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	MailI18n $mailI18n The mailI18n object to add.
     */
    protected function doAddMailI18n($mailI18n)
    {
        $this->collMailI18ns[]= $mailI18n;
        $mailI18n->setMail($this);
    }

    /**
     * @param	MailI18n $mailI18n The mailI18n object to remove.
     * @return Mail The current object (for fluent API support)
     */
    public function removeMailI18n($mailI18n)
    {
        if ($this->getMailI18ns()->contains($mailI18n)) {
            $this->collMailI18ns->remove($this->collMailI18ns->search($mailI18n));
            if (null === $this->mailI18nsScheduledForDeletion) {
                $this->mailI18nsScheduledForDeletion = clone $this->collMailI18ns;
                $this->mailI18nsScheduledForDeletion->clear();
            }
            $this->mailI18nsScheduledForDeletion[]= clone $mailI18n;
            $mailI18n->setMail(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_mail = null;
        $this->id_creation = null;
        $this->id_modification = null;
        $this->date_creation = null;
        $this->date_modification = null;
        $this->calc_id = null;
        $this->status = null;
        $this->name = null;
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
            if ($this->collMailI18ns) {
                foreach ($this->collMailI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAuthyRelatedByIdModification instanceof Persistent) {
              $this->aAuthyRelatedByIdModification->clearAllReferences($deep);
            }
            if ($this->aAuthyRelatedByIdCreation instanceof Persistent) {
              $this->aAuthyRelatedByIdCreation->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        if ($this->collMailI18ns instanceof PropelCollection) {
            $this->collMailI18ns->clearIterator();
        }
        $this->collMailI18ns = null;
        $this->aAuthyRelatedByIdModification = null;
        $this->aAuthyRelatedByIdCreation = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MailPeer::DEFAULT_STRING_FORMAT);
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
     * @return    Mail The current object (for fluent API support)
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
     * @return MailI18n */
    public function getTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collMailI18ns) {
                foreach ($this->collMailI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new MailI18n();
                $translation->setLocale($locale);
            } else {
                $translation = MailI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addMailI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    Mail The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            MailI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collMailI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collMailI18ns[$key]);
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
     * @return MailI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [title] column value.
         * Title
         * @return string
         */
        public function getTitle()
        {
        return $this->getCurrentTranslation()->getTitle();
    }


        /**
         * Set the value of [title] column.
         * Title
         * @param  string $v new value
         * @return MailI18n The current object (for fluent API support)
         */
        public function setTitle($v)
        {    $this->getCurrentTranslation()->setTitle($v);

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
         * @return MailI18n The current object (for fluent API support)
         */
        public function setText($v)
        {    $this->getCurrentTranslation()->setText($v);

        return $this;
    }

    // TableStampBehavior behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     * @return     Mail The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged(){
        $this->modifiedColumns[] = MailPeer::DATE_MODIFICATION;
        return $this;
    }

}
