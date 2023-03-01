<?php


/**
 * Base static class for performing query and update operations on the 'authy' table.
 *
 * Usagers
 *
 * @package propel.generator.gen.om
 */
abstract class BaseAuthyPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'authy';

    /** the related Propel class for this table */
    const OM_CLASS = 'Authy';

    /** the related TableMap class for this table */
    const TM_CLASS = 'AuthyTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 24;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 3;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 21;

    const ID_AUTHY = 'authy.id_authy';

    const ID_GROUP_CREATION = 'authy.id_group_creation';

    const VALIDATION_KEY = 'authy.validation_key';

    const USERNAME = 'authy.username';

    const PASSWD_HASH = 'authy.passwd_hash';

    const EMAIL = 'authy.email';

    const IS_ROOT = 'authy.is_root';

    const GROUP = 'authy.group';

    const EXPIRE = 'authy.expire';

    const DEACTIVATE = 'authy.deactivate';

    const DATE_REQUESTED = 'authy.date_requested';

    const LANGUAGE = 'authy.language';

    const LAST_POKE = 'authy.last_poke';

    const LAST_POKE_IP = 'authy.last_poke_ip';

    const RIGHTS = 'authy.rights';

    const WBS_PUBLIC = 'authy.wbs_public';

    const WBS_PRIVATE = 'authy.wbs_private';

    const ONGLET = 'authy.onglet';

    const PASSWD_HASH_TEMP = 'authy.passwd_hash_temp';

    const DATE_CREATION = 'authy.date_creation';

    const DATE_MODIFICATION = 'authy.date_modification';

    const PASSWD_DATE = 'authy.passwd_date';

    const ID_CREATION = 'authy.id_creation';

    const ID_MODIFICATION = 'authy.id_modification';

    const IS_ROOT_NON = 'Non';
    const IS_ROOT_OUI = 'Oui';

    const GROUP_NORMAL = 'Normal';
    const GROUP_ADMIN = 'Admin';

    const DEACTIVATE_OUI = 'Oui';
    const DEACTIVATE_NON = 'Non';

    const LANGUAGE_FRANCAIS = 'Francais';
    const LANGUAGE_ANGLAIS = 'Anglais';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Authy objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Authy[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. AuthyPeer::$fieldNames[AuthyPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdAuthy', 'IdGroupCreation', 'ValidationKey', 'Username', 'PasswdHash', 'Email', 'IsRoot', 'Group', 'Expire', 'Deactivate', 'DateRequested', 'Language', 'LastPoke', 'LastPokeIp', 'Rights', 'WbsPublic', 'WbsPrivate', 'Onglet', 'PasswdHashTemp', 'DateCreation', 'DateModification', 'PasswdDate', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idAuthy', 'idGroupCreation', 'validationKey', 'username', 'passwdHash', 'email', 'isRoot', 'group', 'expire', 'deactivate', 'dateRequested', 'language', 'lastPoke', 'lastPokeIp', 'rights', 'wbsPublic', 'wbsPrivate', 'onglet', 'passwdHashTemp', 'dateCreation', 'dateModification', 'passwdDate', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (AuthyPeer::ID_AUTHY, AuthyPeer::ID_GROUP_CREATION, AuthyPeer::VALIDATION_KEY, AuthyPeer::USERNAME, AuthyPeer::PASSWD_HASH, AuthyPeer::EMAIL, AuthyPeer::IS_ROOT, AuthyPeer::GROUP, AuthyPeer::EXPIRE, AuthyPeer::DEACTIVATE, AuthyPeer::DATE_REQUESTED, AuthyPeer::LANGUAGE, AuthyPeer::LAST_POKE, AuthyPeer::LAST_POKE_IP, AuthyPeer::RIGHTS, AuthyPeer::WBS_PUBLIC, AuthyPeer::WBS_PRIVATE, AuthyPeer::ONGLET, AuthyPeer::PASSWD_HASH_TEMP, AuthyPeer::DATE_CREATION, AuthyPeer::DATE_MODIFICATION, AuthyPeer::PASSWD_DATE, AuthyPeer::ID_CREATION, AuthyPeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_AUTHY', 'ID_GROUP_CREATION', 'VALIDATION_KEY', 'USERNAME', 'PASSWD_HASH', 'EMAIL', 'IS_ROOT', 'GROUP', 'EXPIRE', 'DEACTIVATE', 'DATE_REQUESTED', 'LANGUAGE', 'LAST_POKE', 'LAST_POKE_IP', 'RIGHTS', 'WBS_PUBLIC', 'WBS_PRIVATE', 'ONGLET', 'PASSWD_HASH_TEMP', 'DATE_CREATION', 'DATE_MODIFICATION', 'PASSWD_DATE', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_authy', 'id_group_creation', 'validation_key', 'username', 'passwd_hash', 'email', 'is_root', 'group', 'expire', 'deactivate', 'date_requested', 'language', 'last_poke', 'last_poke_ip', 'rights', 'wbs_public', 'wbs_private', 'onglet', 'passwd_hash_temp', 'date_creation', 'date_modification', 'passwd_date', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. AuthyPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdAuthy' => 0, 'IdGroupCreation' => 1, 'ValidationKey' => 2, 'Username' => 3, 'PasswdHash' => 4, 'Email' => 5, 'IsRoot' => 6, 'Group' => 7, 'Expire' => 8, 'Deactivate' => 9, 'DateRequested' => 10, 'Language' => 11, 'LastPoke' => 12, 'LastPokeIp' => 13, 'Rights' => 14, 'WbsPublic' => 15, 'WbsPrivate' => 16, 'Onglet' => 17, 'PasswdHashTemp' => 18, 'DateCreation' => 19, 'DateModification' => 20, 'PasswdDate' => 21, 'IdCreation' => 22, 'IdModification' => 23, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idAuthy' => 0, 'idGroupCreation' => 1, 'validationKey' => 2, 'username' => 3, 'passwdHash' => 4, 'email' => 5, 'isRoot' => 6, 'group' => 7, 'expire' => 8, 'deactivate' => 9, 'dateRequested' => 10, 'language' => 11, 'lastPoke' => 12, 'lastPokeIp' => 13, 'rights' => 14, 'wbsPublic' => 15, 'wbsPrivate' => 16, 'onglet' => 17, 'passwdHashTemp' => 18, 'dateCreation' => 19, 'dateModification' => 20, 'passwdDate' => 21, 'idCreation' => 22, 'idModification' => 23, ),
        BasePeer::TYPE_COLNAME => array (AuthyPeer::ID_AUTHY => 0, AuthyPeer::ID_GROUP_CREATION => 1, AuthyPeer::VALIDATION_KEY => 2, AuthyPeer::USERNAME => 3, AuthyPeer::PASSWD_HASH => 4, AuthyPeer::EMAIL => 5, AuthyPeer::IS_ROOT => 6, AuthyPeer::GROUP => 7, AuthyPeer::EXPIRE => 8, AuthyPeer::DEACTIVATE => 9, AuthyPeer::DATE_REQUESTED => 10, AuthyPeer::LANGUAGE => 11, AuthyPeer::LAST_POKE => 12, AuthyPeer::LAST_POKE_IP => 13, AuthyPeer::RIGHTS => 14, AuthyPeer::WBS_PUBLIC => 15, AuthyPeer::WBS_PRIVATE => 16, AuthyPeer::ONGLET => 17, AuthyPeer::PASSWD_HASH_TEMP => 18, AuthyPeer::DATE_CREATION => 19, AuthyPeer::DATE_MODIFICATION => 20, AuthyPeer::PASSWD_DATE => 21, AuthyPeer::ID_CREATION => 22, AuthyPeer::ID_MODIFICATION => 23, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_AUTHY' => 0, 'ID_GROUP_CREATION' => 1, 'VALIDATION_KEY' => 2, 'USERNAME' => 3, 'PASSWD_HASH' => 4, 'EMAIL' => 5, 'IS_ROOT' => 6, 'GROUP' => 7, 'EXPIRE' => 8, 'DEACTIVATE' => 9, 'DATE_REQUESTED' => 10, 'LANGUAGE' => 11, 'LAST_POKE' => 12, 'LAST_POKE_IP' => 13, 'RIGHTS' => 14, 'WBS_PUBLIC' => 15, 'WBS_PRIVATE' => 16, 'ONGLET' => 17, 'PASSWD_HASH_TEMP' => 18, 'DATE_CREATION' => 19, 'DATE_MODIFICATION' => 20, 'PASSWD_DATE' => 21, 'ID_CREATION' => 22, 'ID_MODIFICATION' => 23, ),
        BasePeer::TYPE_FIELDNAME => array ('id_authy' => 0, 'id_group_creation' => 1, 'validation_key' => 2, 'username' => 3, 'passwd_hash' => 4, 'email' => 5, 'is_root' => 6, 'group' => 7, 'expire' => 8, 'deactivate' => 9, 'date_requested' => 10, 'language' => 11, 'last_poke' => 12, 'last_poke_ip' => 13, 'rights' => 14, 'wbs_public' => 15, 'wbs_private' => 16, 'onglet' => 17, 'passwd_hash_temp' => 18, 'date_creation' => 19, 'date_modification' => 20, 'passwd_date' => 21, 'id_creation' => 22, 'id_modification' => 23, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        AuthyPeer::IS_ROOT => array(
            AuthyPeer::IS_ROOT_NON,
            AuthyPeer::IS_ROOT_OUI,
        ),
        AuthyPeer::GROUP => array(
            AuthyPeer::GROUP_NORMAL,
            AuthyPeer::GROUP_ADMIN,
        ),
        AuthyPeer::DEACTIVATE => array(
            AuthyPeer::DEACTIVATE_OUI,
            AuthyPeer::DEACTIVATE_NON,
        ),
        AuthyPeer::LANGUAGE => array(
            AuthyPeer::LANGUAGE_FRANCAIS,
            AuthyPeer::LANGUAGE_ANGLAIS,
        ),
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = AuthyPeer::getFieldNames($toType);
        $key = isset(AuthyPeer::$fieldKeys[$fromType][$name]) ? AuthyPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(AuthyPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, AuthyPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return AuthyPeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return AuthyPeer::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM column
     *
     * @param string $colname The ENUM column name.
     *
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = AuthyPeer::getValueSets();

        if (!isset($valueSets[$colname])) {
            throw new PropelException(sprintf('Column "%s" has no ValueSet.', $colname));
        }

        return $valueSets[$colname];
    }

    /**
     * Gets the SQL value for the ENUM column value
     *
     * @param string $colname ENUM column name.
     * @param string $enumVal ENUM value.
     *
     * @return int SQL value
     */
    public static function getSqlValueForEnum($colname, $enumVal)
    {
        $values = AuthyPeer::getValueSet($colname);
        if (!in_array($enumVal, $values)) {
            throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $colname));
        }

        return array_search($enumVal, $values);
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. AuthyPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(AuthyPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AuthyPeer::ID_AUTHY);
            $criteria->addSelectColumn(AuthyPeer::ID_GROUP_CREATION);
            $criteria->addSelectColumn(AuthyPeer::VALIDATION_KEY);
            $criteria->addSelectColumn(AuthyPeer::USERNAME);
            $criteria->addSelectColumn(AuthyPeer::PASSWD_HASH);
            $criteria->addSelectColumn(AuthyPeer::EMAIL);
            $criteria->addSelectColumn(AuthyPeer::IS_ROOT);
            $criteria->addSelectColumn(AuthyPeer::GROUP);
            $criteria->addSelectColumn(AuthyPeer::EXPIRE);
            $criteria->addSelectColumn(AuthyPeer::DEACTIVATE);
            $criteria->addSelectColumn(AuthyPeer::DATE_REQUESTED);
            $criteria->addSelectColumn(AuthyPeer::LANGUAGE);
            $criteria->addSelectColumn(AuthyPeer::LAST_POKE);
            $criteria->addSelectColumn(AuthyPeer::LAST_POKE_IP);
            $criteria->addSelectColumn(AuthyPeer::RIGHTS);
            $criteria->addSelectColumn(AuthyPeer::WBS_PUBLIC);
            $criteria->addSelectColumn(AuthyPeer::WBS_PRIVATE);
            $criteria->addSelectColumn(AuthyPeer::ONGLET);
            $criteria->addSelectColumn(AuthyPeer::PASSWD_HASH_TEMP);
            $criteria->addSelectColumn(AuthyPeer::ID_CREATION);
            $criteria->addSelectColumn(AuthyPeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_authy');
            $criteria->addSelectColumn($alias . '.id_group_creation');
            $criteria->addSelectColumn($alias . '.validation_key');
            $criteria->addSelectColumn($alias . '.username');
            $criteria->addSelectColumn($alias . '.passwd_hash');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.is_root');
            $criteria->addSelectColumn($alias . '.group');
            $criteria->addSelectColumn($alias . '.expire');
            $criteria->addSelectColumn($alias . '.deactivate');
            $criteria->addSelectColumn($alias . '.date_requested');
            $criteria->addSelectColumn($alias . '.language');
            $criteria->addSelectColumn($alias . '.last_poke');
            $criteria->addSelectColumn($alias . '.last_poke_ip');
            $criteria->addSelectColumn($alias . '.rights');
            $criteria->addSelectColumn($alias . '.wbs_public');
            $criteria->addSelectColumn($alias . '.wbs_private');
            $criteria->addSelectColumn($alias . '.onglet');
            $criteria->addSelectColumn($alias . '.passwd_hash_temp');
            $criteria->addSelectColumn($alias . '.id_creation');
            $criteria->addSelectColumn($alias . '.id_modification');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AuthyPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AuthyPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(AuthyPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return Authy
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = AuthyPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return AuthyPeer::populateObjects(AuthyPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            AuthyPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(AuthyPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param Authy $obj A Authy object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdAuthy();
            } // if key === null
            AuthyPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A Authy object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Authy) {
                $key = (string) $value->getIdAuthy();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Authy object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(AuthyPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Authy Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(AuthyPeer::$instances[$key])) {
                return AuthyPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (AuthyPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        AuthyPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to authy
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {

        AuthyShortcutPeer::clearInstancePool();

        AccountPeer::clearInstancePool();

        AuthyLogPeer::clearInstancePool();

        GroupRightAuthyPeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = AuthyPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = AuthyPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = AuthyPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AuthyPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (Authy object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = AuthyPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + AuthyPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AuthyPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            AuthyPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function getIsRootSqlValue($enumVal)
    {
        return AuthyPeer::getSqlValueForEnum(AuthyPeer::IS_ROOT, $enumVal);
    }

    public static function getGroupSqlValue($enumVal)
    {
        return AuthyPeer::getSqlValueForEnum(AuthyPeer::GROUP, $enumVal);
    }

    public static function getDeactivateSqlValue($enumVal)
    {
        return AuthyPeer::getSqlValueForEnum(AuthyPeer::DEACTIVATE, $enumVal);
    }

    public static function getLanguageSqlValue($enumVal)
    {
        return AuthyPeer::getSqlValueForEnum(AuthyPeer::LANGUAGE, $enumVal);
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(AuthyPeer::DATABASE_NAME)->getTable(AuthyPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseAuthyPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseAuthyPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \AuthyTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return AuthyPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Authy or Criteria object.
     *
     * @param      mixed $values Criteria or Authy object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Authy object
        }

        if ($criteria->containsKey(AuthyPeer::ID_AUTHY) && $criteria->keyContainsValue(AuthyPeer::ID_AUTHY) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AuthyPeer::ID_AUTHY.')');
        }


        // Set the correct dbName
        $criteria->setDbName(AuthyPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Authy or Criteria object.
     *
     * @param      mixed $values Criteria or Authy object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(AuthyPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(AuthyPeer::ID_AUTHY);
            $value = $criteria->remove(AuthyPeer::ID_AUTHY);
            if ($value) {
                $selectCriteria->add(AuthyPeer::ID_AUTHY, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(AuthyPeer::TABLE_NAME);
            }

        } else { // $values is Authy object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(AuthyPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the authy table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(AuthyPeer::TABLE_NAME, $con, AuthyPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AuthyPeer::clearInstancePool();
            AuthyPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }


     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            AuthyPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Authy) { // it's a model object
            // invalidate the cache for this single object
            AuthyPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AuthyPeer::DATABASE_NAME);
            $criteria->add(AuthyPeer::ID_AUTHY, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                AuthyPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(AuthyPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            AuthyPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Authy object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Authy $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(AuthyPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(AuthyPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        if ($obj->isNew() || $obj->isColumnModified(AuthyPeer::USERNAME))
            $columns[AuthyPeer::USERNAME] = $obj->getUsername();

        if ($obj->isNew() || $obj->isColumnModified(AuthyPeer::PASSWD_HASH))
            $columns[AuthyPeer::PASSWD_HASH] = $obj->getPasswdHash();

        }

        return BasePeer::doValidate(AuthyPeer::DATABASE_NAME, AuthyPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Authy
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = AuthyPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(AuthyPeer::DATABASE_NAME);
        $criteria->add(AuthyPeer::ID_AUTHY, $pk);

        $v = AuthyPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Authy[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(AuthyPeer::DATABASE_NAME);
            $criteria->add(AuthyPeer::ID_AUTHY, $pks, Criteria::IN);
            $objs = AuthyPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseAuthyPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseAuthyPeer::buildTableMap();

