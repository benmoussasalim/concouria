<?php


/**
 * Base class that represents a row from the 'authy_log' table.
 *
 * Usagers Log
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseAuthyLog extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'AuthyLogPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AuthyLogPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id_authy_log field.
     * @var        int
     */
    protected $id_authy_log;

    /**
     * The value for the id_authy field.
     * @var        int
     */
    protected $id_authy;

    /**
     * The value for the timestamp field.
     * @var        int
     */
    protected $timestamp;

    /**
     * The value for the login field.
     * @var        string
     */
    protected $login;

    /**
     * The value for the userid field.
     * @var        int
     */
    protected $userid;

    /**
     * The value for the result field.
     * @var        string
     */
    protected $result;

    /**
     * The value for the ip field.
     * @var        string
     */
    protected $ip;

    /**
     * The value for the count field.
     * @var        int
     */
    protected $count;

    /**
     * @var        Authy
     */
    protected $aAuthy;

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
     * Get the [id_authy_log] column value.
     *
     * @return int
     */
    public function getIdAuthyLog()
    {

        return $this->id_authy_log;
    }

    /**
     * Get the [id_authy] column value.
     *
     * @return int
     */
    public function getIdAuthy()
    {

        return $this->id_authy;
    }

    /**
     * Get the [timestamp] column value.
     * Date
     * @return int
     */
    public function getTimestamp()
    {

        return $this->timestamp;
    }

    /**
     * Get the [login] column value.
     * Nom d'usager
     * @return string
     */
    public function getLogin()
    {

        return $this->login;
    }

    /**
     * Get the [userid] column value.
     *
     * @return int
     */
    public function getUserid()
    {

        return $this->userid;
    }

    /**
     * Get the [result] column value.
     *
     * @return string
     */
    public function getResult()
    {

        return $this->result;
    }

    /**
     * Get the [ip] column value.
     * Ip
     * @return string
     */
    public function getIp()
    {

        return $this->ip;
    }

    /**
     * Get the [count] column value.
     * Compte
     * @return int
     */
    public function getCount()
    {

        return $this->count;
    }

    /**
     * Set the value of [id_authy_log] column.
     *
     * @param  int $v new value
     * @return AuthyLog The current object (for fluent API support)
     */
    public function setIdAuthyLog($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_authy_log !== $v) {
            $this->id_authy_log = $v;
            $this->modifiedColumns[] = AuthyLogPeer::ID_AUTHY_LOG;
        }


        return $this;
    } // setIdAuthyLog()

    /**
     * Set the value of [id_authy] column.
     *
     * @param  int $v new value
     * @return AuthyLog The current object (for fluent API support)
     */
    public function setIdAuthy($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id_authy !== $v) {
            $this->id_authy = $v;
            $this->modifiedColumns[] = AuthyLogPeer::ID_AUTHY;
        }

        if ($this->aAuthy !== null && $this->aAuthy->getIdAuthy() !== $v) {
            $this->aAuthy = null;
        }


        return $this;
    } // setIdAuthy()

    /**
     * Set the value of [timestamp] column.
     * Date
     * @param  int $v new value
     * @return AuthyLog The current object (for fluent API support)
     */
    public function setTimestamp($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->timestamp !== $v) {
            $this->timestamp = $v;
            $this->modifiedColumns[] = AuthyLogPeer::TIMESTAMP;
        }


        return $this;
    } // setTimestamp()

    /**
     * Set the value of [login] column.
     * Nom d'usager
     * @param  string $v new value
     * @return AuthyLog The current object (for fluent API support)
     */
    public function setLogin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->login !== $v) {
            $this->login = $v;
            $this->modifiedColumns[] = AuthyLogPeer::LOGIN;
        }


        return $this;
    } // setLogin()

    /**
     * Set the value of [userid] column.
     *
     * @param  int $v new value
     * @return AuthyLog The current object (for fluent API support)
     */
    public function setUserid($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->userid !== $v) {
            $this->userid = $v;
            $this->modifiedColumns[] = AuthyLogPeer::USERID;
        }


        return $this;
    } // setUserid()

    /**
     * Set the value of [result] column.
     *
     * @param  string $v new value
     * @return AuthyLog The current object (for fluent API support)
     */
    public function setResult($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->result !== $v) {
            $this->result = $v;
            $this->modifiedColumns[] = AuthyLogPeer::RESULT;
        }


        return $this;
    } // setResult()

    /**
     * Set the value of [ip] column.
     * Ip
     * @param  string $v new value
     * @return AuthyLog The current object (for fluent API support)
     */
    public function setIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ip !== $v) {
            $this->ip = $v;
            $this->modifiedColumns[] = AuthyLogPeer::IP;
        }


        return $this;
    } // setIp()

    /**
     * Set the value of [count] column.
     * Compte
     * @param  int $v new value
     * @return AuthyLog The current object (for fluent API support)
     */
    public function setCount($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->count !== $v) {
            $this->count = $v;
            $this->modifiedColumns[] = AuthyLogPeer::COUNT;
        }


        return $this;
    } // setCount()

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

            $this->id_authy_log = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->id_authy = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->timestamp = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->login = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->userid = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->result = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->ip = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->count = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = AuthyLogPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating AuthyLog object", $e);
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

        if ($this->aAuthy !== null && $this->id_authy !== $this->aAuthy->getIdAuthy()) {
            $this->aAuthy = null;
        }
    } // ensureConsistency


    public function reload($deep = false, PropelPDO $con = null){
        if ($this->isDeleted()) { throw new PropelException("Cannot reload a deleted object."); }
        if ($this->isNew()) { throw new PropelException("Cannot reload an unsaved object.");}
        if ($con === null) { $con = Propel::getConnection(AuthyLogPeer::DATABASE_NAME, Propel::CONNECTION_READ);}
        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.
        $stmt = AuthyLogPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) { throw new PropelException('Cannot find matching row in the database to reload object values.');}
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAuthy = null;
        } // if (deep)
    }


    public function delete(PropelPDO $con = null){
// TableStampBehavior behavior

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='AuthyLog';}
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
        mem_clean('AuthyLog');

        if ($this->isDeleted()) { throw new PropelException("This object has already been deleted.");}
        if ($con === null) { $con = Propel::getConnection(AuthyLogPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);}
        $con->beginTransaction();
        try {
            $deleteQuery = AuthyLogQuery::create()->filterByPrimaryKey($this->getPrimaryKey());
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
            $con = Propel::getConnection(AuthyLogPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            if (!$isInsert) {
            }
            if ($isInsert) {
            }
            $affectedRows = $this->doSave($con);
            $con->commit();
            AuthyLogPeer::addInstanceToPool($this);

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

            if ($this->aAuthy !== null) {
                if ($this->aAuthy->isModified() || $this->aAuthy->isNew()) {
                    $affectedRows += $this->aAuthy->save($con);
                }
                $this->setAuthy($this->aAuthy);
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

        $this->modifiedColumns[] = AuthyLogPeer::ID_AUTHY_LOG;
        if (null !== $this->id_authy_log) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AuthyLogPeer::ID_AUTHY_LOG . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AuthyLogPeer::ID_AUTHY_LOG)) {
            $modifiedColumns[':p' . $index++]  = '`id_authy_log`';
        }
        if ($this->isColumnModified(AuthyLogPeer::ID_AUTHY)) {
            $modifiedColumns[':p' . $index++]  = '`id_authy`';
        }
        if ($this->isColumnModified(AuthyLogPeer::TIMESTAMP)) {
            $modifiedColumns[':p' . $index++]  = '`timestamp`';
        }
        if ($this->isColumnModified(AuthyLogPeer::LOGIN)) {
            $modifiedColumns[':p' . $index++]  = '`login`';
        }
        if ($this->isColumnModified(AuthyLogPeer::USERID)) {
            $modifiedColumns[':p' . $index++]  = '`userid`';
        }
        if ($this->isColumnModified(AuthyLogPeer::RESULT)) {
            $modifiedColumns[':p' . $index++]  = '`result`';
        }
        if ($this->isColumnModified(AuthyLogPeer::IP)) {
            $modifiedColumns[':p' . $index++]  = '`ip`';
        }
        if ($this->isColumnModified(AuthyLogPeer::COUNT)) {
            $modifiedColumns[':p' . $index++]  = '`count`';
        }

        $sql = sprintf(
            'INSERT INTO `authy_log` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id_authy_log`':
                        $stmt->bindValue($identifier, $this->id_authy_log, PDO::PARAM_INT);
                        break;
                    case '`id_authy`':
                        $stmt->bindValue($identifier, $this->id_authy, PDO::PARAM_INT);
                        break;
                    case '`timestamp`':
                        $stmt->bindValue($identifier, $this->timestamp, PDO::PARAM_INT);
                        break;
                    case '`login`':
                        $stmt->bindValue($identifier, $this->login, PDO::PARAM_STR);
                        break;
                    case '`userid`':
                        $stmt->bindValue($identifier, $this->userid, PDO::PARAM_INT);
                        break;
                    case '`result`':
                        $stmt->bindValue($identifier, $this->result, PDO::PARAM_STR);
                        break;
                    case '`ip`':
                        $stmt->bindValue($identifier, $this->ip, PDO::PARAM_STR);
                        break;
                    case '`count`':
                        $stmt->bindValue($identifier, $this->count, PDO::PARAM_INT);
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
        $this->setIdAuthyLog($pk);

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

        if(!$_SESSION['CurrentRights']){$_SESSION['CurrentRights']='AuthyLog';}
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

            if ($this->aAuthy !== null) {
                if (!$this->aAuthy->validate($columns)) {$failureMap = array_merge($failureMap, $this->aAuthy->getValidationFailures()); }
            }

            if (($retval = AuthyLogPeer::doValidate($this, $columns)) !== true){$failureMap = array_merge($failureMap, $retval);}

            $this->alreadyInValidation = false;
        }
        return (!empty($failureMap) ? $failureMap : true);
    }


    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AuthyLogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }


    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['AuthyLog'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AuthyLog'][$this->getPrimaryKey()] = true;
        $keys = AuthyLogPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdAuthyLog(),
            $keys[1] => $this->getIdAuthy(),
            $keys[2] => $this->getTimestamp(),
            $keys[3] => $this->getLogin(),
            $keys[4] => $this->getUserid(),
            $keys[5] => $this->getResult(),
            $keys[6] => $this->getIp(),
            $keys[7] => $this->getCount(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAuthy) {
                $result['Authy'] = $this->aAuthy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }


    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AuthyLogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }


    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdAuthyLog($value);
                break;
            case 1:
                $this->setIdAuthy($value);
                break;
            case 2:
                $this->setTimestamp($value);
                break;
            case 3:
                $this->setLogin($value);
                break;
            case 4:
                $this->setUserid($value);
                break;
            case 5:
                $this->setResult($value);
                break;
            case 6:
                $this->setIp($value);
                break;
            case 7:
                $this->setCount($value);
                break;
        } // switch()
    }


    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = AuthyLogPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdAuthyLog($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdAuthy($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTimestamp($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setLogin($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUserid($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setResult($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIp($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setCount($arr[$keys[7]]);
    }

    public function buildCriteria()
    {
        $criteria = new Criteria(AuthyLogPeer::DATABASE_NAME);

        if ($this->isColumnModified(AuthyLogPeer::ID_AUTHY_LOG)) $criteria->add(AuthyLogPeer::ID_AUTHY_LOG, $this->id_authy_log);
        if ($this->isColumnModified(AuthyLogPeer::ID_AUTHY)) $criteria->add(AuthyLogPeer::ID_AUTHY, $this->id_authy);
        if ($this->isColumnModified(AuthyLogPeer::TIMESTAMP)) $criteria->add(AuthyLogPeer::TIMESTAMP, $this->timestamp);
        if ($this->isColumnModified(AuthyLogPeer::LOGIN)) $criteria->add(AuthyLogPeer::LOGIN, $this->login);
        if ($this->isColumnModified(AuthyLogPeer::USERID)) $criteria->add(AuthyLogPeer::USERID, $this->userid);
        if ($this->isColumnModified(AuthyLogPeer::RESULT)) $criteria->add(AuthyLogPeer::RESULT, $this->result);
        if ($this->isColumnModified(AuthyLogPeer::IP)) $criteria->add(AuthyLogPeer::IP, $this->ip);
        if ($this->isColumnModified(AuthyLogPeer::COUNT)) $criteria->add(AuthyLogPeer::COUNT, $this->count);

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
        $criteria = new Criteria(AuthyLogPeer::DATABASE_NAME);
        $criteria->add(AuthyLogPeer::ID_AUTHY_LOG, $this->id_authy_log);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdAuthyLog();
    }

    /**
     * Generic method to set the primary key (id_authy_log column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdAuthyLog($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdAuthyLog();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of AuthyLog (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true){
        $copyObj->setIdAuthy($this->getIdAuthy());
        $copyObj->setTimestamp($this->getTimestamp());
        $copyObj->setLogin($this->getLogin());
        $copyObj->setUserid($this->getUserid());
        $copyObj->setResult($this->getResult());
        $copyObj->setIp($this->getIp());
        $copyObj->setCount($this->getCount());

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
            $copyObj->setIdAuthyLog(NULL); // this is a auto-increment column, so set to default value
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
     * @return AuthyLog Clone of current object.
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
     * @return AuthyLogPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AuthyLogPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Authy object.
     *
     * @param                  Authy $v
     * @return AuthyLog The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthy(Authy $v = null)
    {
        if ($v === null) {
            $this->setIdAuthy(NULL);
        } else {
            $this->setIdAuthy($v->getIdAuthy());
        }

        $this->aAuthy = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Authy object, it will not be re-added.
        if ($v !== null) {
            $v->addAuthyLog($this);
        }


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
    public function getAuthy(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAuthy === null && ($this->id_authy !== null) && $doQuery) {
            $this->aAuthy = AuthyQuery::create()->findPk($this->id_authy, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthy->addAuthyLogs($this);
             */
        }

        return $this->aAuthy;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_authy_log = null;
        $this->id_authy = null;
        $this->timestamp = null;
        $this->login = null;
        $this->userid = null;
        $this->result = null;
        $this->ip = null;
        $this->count = null;
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
            if ($this->aAuthy instanceof Persistent) {
              $this->aAuthy->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aAuthy = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AuthyLogPeer::DEFAULT_STRING_FORMAT);
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

}
