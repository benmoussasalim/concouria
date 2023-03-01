<?php


/**
 * Base static class for performing query and update operations on the 'group_right_authy' table.
 *
 * Group
 *
 * @package propel.generator.gen.om
 */
abstract class BaseGroupRightAuthyPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'group_right_authy';

    /** the related Propel class for this table */
    const OM_CLASS = 'GroupRightAuthy';

    /** the related TableMap class for this table */
    const TM_CLASS = 'GroupRightAuthyTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 8;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 8;

    const ID_CREATION = 'group_right_authy.id_creation';

    const ID_MODIFICATION = 'group_right_authy.id_modification';

    const DATE_CREATION = 'group_right_authy.date_creation';

    const DATE_MODIFICATION = 'group_right_authy.date_modification';

    const ID_AUTHY = 'group_right_authy.id_authy';

    const ID_GROUP_RIGHT = 'group_right_authy.id_group_right';

    const IS_SET = 'group_right_authy.is_set';

    const PRIMARY = 'group_right_authy.primary';

    const IS_SET_NON_MEMBRE = 'Non Membre';
    const IS_SET_MEMBRE = 'Membre';

    const PRIMARY_NON = 'Non';
    const PRIMARY_OUI = 'Oui';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of GroupRightAuthy objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array GroupRightAuthy[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. GroupRightAuthyPeer::$fieldNames[GroupRightAuthyPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdCreation', 'IdModification', 'DateCreation', 'DateModification', 'IdAuthy', 'IdGroupRight', 'IsSet', 'Primary', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idCreation', 'idModification', 'dateCreation', 'dateModification', 'idAuthy', 'idGroupRight', 'isSet', 'primary', ),
        BasePeer::TYPE_COLNAME => array (GroupRightAuthyPeer::ID_CREATION, GroupRightAuthyPeer::ID_MODIFICATION, GroupRightAuthyPeer::DATE_CREATION, GroupRightAuthyPeer::DATE_MODIFICATION, GroupRightAuthyPeer::ID_AUTHY, GroupRightAuthyPeer::ID_GROUP_RIGHT, GroupRightAuthyPeer::IS_SET, GroupRightAuthyPeer::PRIMARY, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_CREATION', 'ID_MODIFICATION', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_AUTHY', 'ID_GROUP_RIGHT', 'IS_SET', 'PRIMARY', ),
        BasePeer::TYPE_FIELDNAME => array ('id_creation', 'id_modification', 'date_creation', 'date_modification', 'id_authy', 'id_group_right', 'is_set', 'primary', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. GroupRightAuthyPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdCreation' => 0, 'IdModification' => 1, 'DateCreation' => 2, 'DateModification' => 3, 'IdAuthy' => 4, 'IdGroupRight' => 5, 'IsSet' => 6, 'Primary' => 7, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idCreation' => 0, 'idModification' => 1, 'dateCreation' => 2, 'dateModification' => 3, 'idAuthy' => 4, 'idGroupRight' => 5, 'isSet' => 6, 'primary' => 7, ),
        BasePeer::TYPE_COLNAME => array (GroupRightAuthyPeer::ID_CREATION => 0, GroupRightAuthyPeer::ID_MODIFICATION => 1, GroupRightAuthyPeer::DATE_CREATION => 2, GroupRightAuthyPeer::DATE_MODIFICATION => 3, GroupRightAuthyPeer::ID_AUTHY => 4, GroupRightAuthyPeer::ID_GROUP_RIGHT => 5, GroupRightAuthyPeer::IS_SET => 6, GroupRightAuthyPeer::PRIMARY => 7, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_CREATION' => 0, 'ID_MODIFICATION' => 1, 'DATE_CREATION' => 2, 'DATE_MODIFICATION' => 3, 'ID_AUTHY' => 4, 'ID_GROUP_RIGHT' => 5, 'IS_SET' => 6, 'PRIMARY' => 7, ),
        BasePeer::TYPE_FIELDNAME => array ('id_creation' => 0, 'id_modification' => 1, 'date_creation' => 2, 'date_modification' => 3, 'id_authy' => 4, 'id_group_right' => 5, 'is_set' => 6, 'primary' => 7, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        GroupRightAuthyPeer::IS_SET => array(
            GroupRightAuthyPeer::IS_SET_NON_MEMBRE,
            GroupRightAuthyPeer::IS_SET_MEMBRE,
        ),
        GroupRightAuthyPeer::PRIMARY => array(
            GroupRightAuthyPeer::PRIMARY_NON,
            GroupRightAuthyPeer::PRIMARY_OUI,
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
        $toNames = GroupRightAuthyPeer::getFieldNames($toType);
        $key = isset(GroupRightAuthyPeer::$fieldKeys[$fromType][$name]) ? GroupRightAuthyPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(GroupRightAuthyPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, GroupRightAuthyPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return GroupRightAuthyPeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return GroupRightAuthyPeer::$enumValueSets;
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
        $valueSets = GroupRightAuthyPeer::getValueSets();

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
        $values = GroupRightAuthyPeer::getValueSet($colname);
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
     * @param      string $column The column name for current table. (i.e. GroupRightAuthyPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(GroupRightAuthyPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(GroupRightAuthyPeer::ID_CREATION);
            $criteria->addSelectColumn(GroupRightAuthyPeer::ID_MODIFICATION);
            $criteria->addSelectColumn(GroupRightAuthyPeer::DATE_CREATION);
            $criteria->addSelectColumn(GroupRightAuthyPeer::DATE_MODIFICATION);
            $criteria->addSelectColumn(GroupRightAuthyPeer::ID_AUTHY);
            $criteria->addSelectColumn(GroupRightAuthyPeer::ID_GROUP_RIGHT);
            $criteria->addSelectColumn(GroupRightAuthyPeer::IS_SET);
            $criteria->addSelectColumn(GroupRightAuthyPeer::PRIMARY);
        } else {
            $criteria->addSelectColumn($alias . '.id_creation');
            $criteria->addSelectColumn($alias . '.id_modification');
            $criteria->addSelectColumn($alias . '.date_creation');
            $criteria->addSelectColumn($alias . '.date_modification');
            $criteria->addSelectColumn($alias . '.id_authy');
            $criteria->addSelectColumn($alias . '.id_group_right');
            $criteria->addSelectColumn($alias . '.is_set');
            $criteria->addSelectColumn($alias . '.primary');
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
        $criteria->setPrimaryTableName(GroupRightAuthyPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            GroupRightAuthyPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return GroupRightAuthy
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = GroupRightAuthyPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return GroupRightAuthyPeer::populateObjects(GroupRightAuthyPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            GroupRightAuthyPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);

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
     * @param GroupRightAuthy $obj A GroupRightAuthy object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = serialize(array((string) $obj->getIdAuthy(), (string) $obj->getIdGroupRight()));
            } // if key === null
            GroupRightAuthyPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A GroupRightAuthy object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof GroupRightAuthy) {
                $key = serialize(array((string) $value->getIdAuthy(), (string) $value->getIdGroupRight()));
            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or GroupRightAuthy object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(GroupRightAuthyPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return GroupRightAuthy Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(GroupRightAuthyPeer::$instances[$key])) {
                return GroupRightAuthyPeer::$instances[$key];
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
        foreach (GroupRightAuthyPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        GroupRightAuthyPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to group_right_authy
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
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
        if ($row[$startcol + 4] === null && $row[$startcol + 5] === null) {
            return null;
        }

        return serialize(array((string) $row[$startcol + 4], (string) $row[$startcol + 5]));
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

        return array((int) $row[$startcol + 4], (int) $row[$startcol + 5]);
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
        $cls = GroupRightAuthyPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = GroupRightAuthyPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = GroupRightAuthyPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GroupRightAuthyPeer::addInstanceToPool($obj, $key);
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
     * @return array (GroupRightAuthy object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = GroupRightAuthyPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = GroupRightAuthyPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + GroupRightAuthyPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GroupRightAuthyPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            GroupRightAuthyPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function getIsSetSqlValue($enumVal)
    {
        return GroupRightAuthyPeer::getSqlValueForEnum(GroupRightAuthyPeer::IS_SET, $enumVal);
    }

    public static function getPrimarySqlValue($enumVal)
    {
        return GroupRightAuthyPeer::getSqlValueForEnum(GroupRightAuthyPeer::PRIMARY, $enumVal);
    }

    public static function doCountJoinGroupRight(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(GroupRightAuthyPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            GroupRightAuthyPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(GroupRightAuthyPeer::ID_GROUP_RIGHT, GroupRightPeer::ID_GROUP_RIGHT, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    public static function doCountJoinAuthy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(GroupRightAuthyPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            GroupRightAuthyPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(GroupRightAuthyPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinGroupRight(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);
        }

        GroupRightAuthyPeer::addSelectColumns($criteria);
        $startcol = GroupRightAuthyPeer::NUM_HYDRATE_COLUMNS;
        GroupRightPeer::addSelectColumns($criteria);

        $criteria->addJoin(GroupRightAuthyPeer::ID_GROUP_RIGHT, GroupRightPeer::ID_GROUP_RIGHT, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = GroupRightAuthyPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = GroupRightAuthyPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = GroupRightAuthyPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                GroupRightAuthyPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = GroupRightPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = GroupRightPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = GroupRightPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    GroupRightPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (GroupRightAuthy) to $obj2 (GroupRight)
                $obj2->addGroupRightAuthy($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinAuthy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);
        }

        GroupRightAuthyPeer::addSelectColumns($criteria);
        $startcol = GroupRightAuthyPeer::NUM_HYDRATE_COLUMNS;
        AuthyPeer::addSelectColumns($criteria);

        $criteria->addJoin(GroupRightAuthyPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = GroupRightAuthyPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = GroupRightAuthyPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = GroupRightAuthyPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                GroupRightAuthyPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AuthyPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (GroupRightAuthy) to $obj2 (Authy)
                $obj2->addGroupRightAuthy($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(GroupRightAuthyPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            GroupRightAuthyPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(GroupRightAuthyPeer::ID_GROUP_RIGHT, GroupRightPeer::ID_GROUP_RIGHT, $join_behavior);

        $criteria->addJoin(GroupRightAuthyPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);
        }

        GroupRightAuthyPeer::addSelectColumns($criteria);
        $startcol2 = GroupRightAuthyPeer::NUM_HYDRATE_COLUMNS;

        GroupRightPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + GroupRightPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(GroupRightAuthyPeer::ID_GROUP_RIGHT, GroupRightPeer::ID_GROUP_RIGHT, $join_behavior);

        $criteria->addJoin(GroupRightAuthyPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = GroupRightAuthyPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = GroupRightAuthyPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = GroupRightAuthyPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                GroupRightAuthyPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined GroupRight rows

            $key2 = GroupRightPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = GroupRightPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = GroupRightPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    GroupRightPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (GroupRightAuthy) to the collection in $obj2 (GroupRight)
                $obj2->addGroupRightAuthy($obj1);
            } // if joined row not null

            // Add objects for joined Authy rows

            $key3 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = AuthyPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = AuthyPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AuthyPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (GroupRightAuthy) to the collection in $obj3 (Authy)
                $obj3->addGroupRightAuthy($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doCountJoinAllExceptGroupRight(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(GroupRightAuthyPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            GroupRightAuthyPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(GroupRightAuthyPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doCountJoinAllExceptAuthy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(GroupRightAuthyPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            GroupRightAuthyPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(GroupRightAuthyPeer::ID_GROUP_RIGHT, GroupRightPeer::ID_GROUP_RIGHT, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinAllExceptGroupRight(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);
        }

        GroupRightAuthyPeer::addSelectColumns($criteria);
        $startcol2 = GroupRightAuthyPeer::NUM_HYDRATE_COLUMNS;

        AuthyPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AuthyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(GroupRightAuthyPeer::ID_AUTHY, AuthyPeer::ID_AUTHY, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = GroupRightAuthyPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = GroupRightAuthyPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = GroupRightAuthyPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                GroupRightAuthyPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Authy rows

                $key2 = AuthyPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AuthyPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AuthyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AuthyPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (GroupRightAuthy) to the collection in $obj2 (Authy)
                $obj2->addGroupRightAuthy($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinAllExceptAuthy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);
        }

        GroupRightAuthyPeer::addSelectColumns($criteria);
        $startcol2 = GroupRightAuthyPeer::NUM_HYDRATE_COLUMNS;

        GroupRightPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + GroupRightPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(GroupRightAuthyPeer::ID_GROUP_RIGHT, GroupRightPeer::ID_GROUP_RIGHT, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = GroupRightAuthyPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = GroupRightAuthyPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = GroupRightAuthyPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                GroupRightAuthyPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined GroupRight rows

                $key2 = GroupRightPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = GroupRightPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = GroupRightPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    GroupRightPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (GroupRightAuthy) to the collection in $obj2 (GroupRight)
                $obj2->addGroupRightAuthy($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
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
        return Propel::getDatabaseMap(GroupRightAuthyPeer::DATABASE_NAME)->getTable(GroupRightAuthyPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseGroupRightAuthyPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseGroupRightAuthyPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \GroupRightAuthyTableMap());
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
        return GroupRightAuthyPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a GroupRightAuthy or Criteria object.
     *
     * @param      mixed $values Criteria or GroupRightAuthy object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from GroupRightAuthy object
        }


        // Set the correct dbName
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a GroupRightAuthy or Criteria object.
     *
     * @param      mixed $values Criteria or GroupRightAuthy object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(GroupRightAuthyPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(GroupRightAuthyPeer::ID_AUTHY);
            $value = $criteria->remove(GroupRightAuthyPeer::ID_AUTHY);
            if ($value) {
                $selectCriteria->add(GroupRightAuthyPeer::ID_AUTHY, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(GroupRightAuthyPeer::TABLE_NAME);
            }

            $comparison = $criteria->getComparison(GroupRightAuthyPeer::ID_GROUP_RIGHT);
            $value = $criteria->remove(GroupRightAuthyPeer::ID_GROUP_RIGHT);
            if ($value) {
                $selectCriteria->add(GroupRightAuthyPeer::ID_GROUP_RIGHT, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(GroupRightAuthyPeer::TABLE_NAME);
            }

        } else { // $values is GroupRightAuthy object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the group_right_authy table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(GroupRightAuthyPeer::TABLE_NAME, $con, GroupRightAuthyPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupRightAuthyPeer::clearInstancePool();
            GroupRightAuthyPeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            GroupRightAuthyPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof GroupRightAuthy) { // it's a model object
            // invalidate the cache for this single object
            GroupRightAuthyPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GroupRightAuthyPeer::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(GroupRightAuthyPeer::ID_AUTHY, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(GroupRightAuthyPeer::ID_GROUP_RIGHT, $value[1]));
                $criteria->addOr($criterion);
                // we can invalidate the cache for this single PK
                GroupRightAuthyPeer::removeInstanceFromPool($value);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(GroupRightAuthyPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            GroupRightAuthyPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given GroupRightAuthy object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param GroupRightAuthy $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(GroupRightAuthyPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(GroupRightAuthyPeer::TABLE_NAME);

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

        if ($obj->isNew() || $obj->isColumnModified(GroupRightAuthyPeer::ID_GROUP_RIGHT))
            $columns[GroupRightAuthyPeer::ID_GROUP_RIGHT] = $obj->getIdGroupRight();

        if ($obj->isNew() || $obj->isColumnModified(GroupRightAuthyPeer::ID_AUTHY))
            $columns[GroupRightAuthyPeer::ID_AUTHY] = $obj->getIdAuthy();

        }

        return BasePeer::doValidate(GroupRightAuthyPeer::DATABASE_NAME, GroupRightAuthyPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve object using using composite pkey values.
     * @param   int $id_authy
     * @param   int $id_group_right
     * @param      PropelPDO $con
     * @return GroupRightAuthy
     */
    public static function retrieveByPK($id_authy, $id_group_right, PropelPDO $con = null) {
        $_instancePoolKey = serialize(array((string) $id_authy, (string) $id_group_right));
         if (null !== ($obj = GroupRightAuthyPeer::getInstanceFromPool($_instancePoolKey))) {
             return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(GroupRightAuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $criteria = new Criteria(GroupRightAuthyPeer::DATABASE_NAME);
        $criteria->add(GroupRightAuthyPeer::ID_AUTHY, $id_authy);
        $criteria->add(GroupRightAuthyPeer::ID_GROUP_RIGHT, $id_group_right);
        $v = GroupRightAuthyPeer::doSelect($criteria, $con);

        return !empty($v) ? $v[0] : null;
    }
} // BaseGroupRightAuthyPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseGroupRightAuthyPeer::buildTableMap();

