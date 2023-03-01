<?php


/**
 * Base static class for performing query and update operations on the 'group_right' table.
 *
 * Groupe
 *
 * @package propel.generator.gen.om
 */
abstract class BaseGroupRightPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'group_right';

    /** the related Propel class for this table */
    const OM_CLASS = 'GroupRight';

    /** the related TableMap class for this table */
    const TM_CLASS = 'GroupRightTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 10;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 8;

    const ID_GROUP_RIGHT = 'group_right.id_group_right';

    const ID_CREATION = 'group_right.id_creation';

    const ID_MODIFICATION = 'group_right.id_modification';

    const NAME = 'group_right.name';

    const DESC = 'group_right.desc';

    const RIGHTS_ADMIN = 'group_right.rights_admin';

    const RIGHTS_OWNER = 'group_right.rights_owner';

    const RIGHTS_GROUP = 'group_right.rights_group';

    const DATE_CREATION = 'group_right.date_creation';

    const DATE_MODIFICATION = 'group_right.date_modification';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of GroupRight objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array GroupRight[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. GroupRightPeer::$fieldNames[GroupRightPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdGroupRight', 'IdCreation', 'IdModification', 'Name', 'Desc', 'RightsAdmin', 'RightsOwner', 'RightsGroup', 'DateCreation', 'DateModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idGroupRight', 'idCreation', 'idModification', 'name', 'desc', 'rightsAdmin', 'rightsOwner', 'rightsGroup', 'dateCreation', 'dateModification', ),
        BasePeer::TYPE_COLNAME => array (GroupRightPeer::ID_GROUP_RIGHT, GroupRightPeer::ID_CREATION, GroupRightPeer::ID_MODIFICATION, GroupRightPeer::NAME, GroupRightPeer::DESC, GroupRightPeer::RIGHTS_ADMIN, GroupRightPeer::RIGHTS_OWNER, GroupRightPeer::RIGHTS_GROUP, GroupRightPeer::DATE_CREATION, GroupRightPeer::DATE_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_GROUP_RIGHT', 'ID_CREATION', 'ID_MODIFICATION', 'NAME', 'DESC', 'RIGHTS_ADMIN', 'RIGHTS_OWNER', 'RIGHTS_GROUP', 'DATE_CREATION', 'DATE_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_group_right', 'id_creation', 'id_modification', 'name', 'desc', 'rights_admin', 'rights_owner', 'rights_group', 'date_creation', 'date_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. GroupRightPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdGroupRight' => 0, 'IdCreation' => 1, 'IdModification' => 2, 'Name' => 3, 'Desc' => 4, 'RightsAdmin' => 5, 'RightsOwner' => 6, 'RightsGroup' => 7, 'DateCreation' => 8, 'DateModification' => 9, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idGroupRight' => 0, 'idCreation' => 1, 'idModification' => 2, 'name' => 3, 'desc' => 4, 'rightsAdmin' => 5, 'rightsOwner' => 6, 'rightsGroup' => 7, 'dateCreation' => 8, 'dateModification' => 9, ),
        BasePeer::TYPE_COLNAME => array (GroupRightPeer::ID_GROUP_RIGHT => 0, GroupRightPeer::ID_CREATION => 1, GroupRightPeer::ID_MODIFICATION => 2, GroupRightPeer::NAME => 3, GroupRightPeer::DESC => 4, GroupRightPeer::RIGHTS_ADMIN => 5, GroupRightPeer::RIGHTS_OWNER => 6, GroupRightPeer::RIGHTS_GROUP => 7, GroupRightPeer::DATE_CREATION => 8, GroupRightPeer::DATE_MODIFICATION => 9, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_GROUP_RIGHT' => 0, 'ID_CREATION' => 1, 'ID_MODIFICATION' => 2, 'NAME' => 3, 'DESC' => 4, 'RIGHTS_ADMIN' => 5, 'RIGHTS_OWNER' => 6, 'RIGHTS_GROUP' => 7, 'DATE_CREATION' => 8, 'DATE_MODIFICATION' => 9, ),
        BasePeer::TYPE_FIELDNAME => array ('id_group_right' => 0, 'id_creation' => 1, 'id_modification' => 2, 'name' => 3, 'desc' => 4, 'rights_admin' => 5, 'rights_owner' => 6, 'rights_group' => 7, 'date_creation' => 8, 'date_modification' => 9, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $toNames = GroupRightPeer::getFieldNames($toType);
        $key = isset(GroupRightPeer::$fieldKeys[$fromType][$name]) ? GroupRightPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(GroupRightPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, GroupRightPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return GroupRightPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. GroupRightPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(GroupRightPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(GroupRightPeer::ID_GROUP_RIGHT);
            $criteria->addSelectColumn(GroupRightPeer::ID_CREATION);
            $criteria->addSelectColumn(GroupRightPeer::ID_MODIFICATION);
            $criteria->addSelectColumn(GroupRightPeer::NAME);
            $criteria->addSelectColumn(GroupRightPeer::DESC);
            $criteria->addSelectColumn(GroupRightPeer::RIGHTS_ADMIN);
            $criteria->addSelectColumn(GroupRightPeer::RIGHTS_OWNER);
            $criteria->addSelectColumn(GroupRightPeer::RIGHTS_GROUP);
        } else {
            $criteria->addSelectColumn($alias . '.id_group_right');
            $criteria->addSelectColumn($alias . '.id_creation');
            $criteria->addSelectColumn($alias . '.id_modification');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.desc');
            $criteria->addSelectColumn($alias . '.rights_admin');
            $criteria->addSelectColumn($alias . '.rights_owner');
            $criteria->addSelectColumn($alias . '.rights_group');
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
        $criteria->setPrimaryTableName(GroupRightPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            GroupRightPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(GroupRightPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return GroupRight
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = GroupRightPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return GroupRightPeer::populateObjects(GroupRightPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            GroupRightPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(GroupRightPeer::DATABASE_NAME);

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
     * @param GroupRight $obj A GroupRight object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdGroupRight();
            } // if key === null
            GroupRightPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A GroupRight object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof GroupRight) {
                $key = (string) $value->getIdGroupRight();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or GroupRight object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(GroupRightPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return GroupRight Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(GroupRightPeer::$instances[$key])) {
                return GroupRightPeer::$instances[$key];
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
        foreach (GroupRightPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        GroupRightPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to group_right
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {

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
        $cls = GroupRightPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = GroupRightPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = GroupRightPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GroupRightPeer::addInstanceToPool($obj, $key);
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
     * @return array (GroupRight object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = GroupRightPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = GroupRightPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + GroupRightPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GroupRightPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            GroupRightPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
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
        return Propel::getDatabaseMap(GroupRightPeer::DATABASE_NAME)->getTable(GroupRightPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseGroupRightPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseGroupRightPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \GroupRightTableMap());
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
        return GroupRightPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a GroupRight or Criteria object.
     *
     * @param      mixed $values Criteria or GroupRight object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from GroupRight object
        }

        if ($criteria->containsKey(GroupRightPeer::ID_GROUP_RIGHT) && $criteria->keyContainsValue(GroupRightPeer::ID_GROUP_RIGHT) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GroupRightPeer::ID_GROUP_RIGHT.')');
        }


        // Set the correct dbName
        $criteria->setDbName(GroupRightPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a GroupRight or Criteria object.
     *
     * @param      mixed $values Criteria or GroupRight object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(GroupRightPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(GroupRightPeer::ID_GROUP_RIGHT);
            $value = $criteria->remove(GroupRightPeer::ID_GROUP_RIGHT);
            if ($value) {
                $selectCriteria->add(GroupRightPeer::ID_GROUP_RIGHT, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(GroupRightPeer::TABLE_NAME);
            }

        } else { // $values is GroupRight object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(GroupRightPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the group_right table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(GroupRightPeer::TABLE_NAME, $con, GroupRightPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupRightPeer::clearInstancePool();
            GroupRightPeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            GroupRightPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof GroupRight) { // it's a model object
            // invalidate the cache for this single object
            GroupRightPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GroupRightPeer::DATABASE_NAME);
            $criteria->add(GroupRightPeer::ID_GROUP_RIGHT, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                GroupRightPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(GroupRightPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            GroupRightPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given GroupRight object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param GroupRight $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(GroupRightPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(GroupRightPeer::TABLE_NAME);

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

        if ($obj->isNew() || $obj->isColumnModified(GroupRightPeer::NAME))
            $columns[GroupRightPeer::NAME] = $obj->getName();

        }

        return BasePeer::doValidate(GroupRightPeer::DATABASE_NAME, GroupRightPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return GroupRight
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = GroupRightPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(GroupRightPeer::DATABASE_NAME);
        $criteria->add(GroupRightPeer::ID_GROUP_RIGHT, $pk);

        $v = GroupRightPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return GroupRight[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GroupRightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(GroupRightPeer::DATABASE_NAME);
            $criteria->add(GroupRightPeer::ID_GROUP_RIGHT, $pks, Criteria::IN);
            $objs = GroupRightPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseGroupRightPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseGroupRightPeer::buildTableMap();

