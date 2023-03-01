<?php


/**
 * Base static class for performing query and update operations on the 'block_i18n_version' table.
 *
 *
 *
 * @package propel.generator.gen.om
 */
abstract class BaseBlockI18nVersionPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'block_i18n_version';

    /** the related Propel class for this table */
    const OM_CLASS = 'BlockI18nVersion';

    /** the related TableMap class for this table */
    const TM_CLASS = 'BlockI18nVersionTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 9;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 7;

    const ID_BLOCK_I18N_VERSION = 'block_i18n_version.id_block_i18n_version';

    const ID_BLOCK = 'block_i18n_version.id_block';

    const LOCALE = 'block_i18n_version.locale';

    const TEXT = 'block_i18n_version.text';

    const VERSION = 'block_i18n_version.version';

    const DATE_CREATION = 'block_i18n_version.date_creation';

    const DATE_MODIFICATION = 'block_i18n_version.date_modification';

    const ID_CREATION = 'block_i18n_version.id_creation';

    const ID_MODIFICATION = 'block_i18n_version.id_modification';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of BlockI18nVersion objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array BlockI18nVersion[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. BlockI18nVersionPeer::$fieldNames[BlockI18nVersionPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdBlockI18nVersion', 'IdBlock', 'Locale', 'Text', 'Version', 'DateCreation', 'DateModification', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idBlockI18nVersion', 'idBlock', 'locale', 'text', 'version', 'dateCreation', 'dateModification', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION, BlockI18nVersionPeer::ID_BLOCK, BlockI18nVersionPeer::LOCALE, BlockI18nVersionPeer::TEXT, BlockI18nVersionPeer::VERSION, BlockI18nVersionPeer::DATE_CREATION, BlockI18nVersionPeer::DATE_MODIFICATION, BlockI18nVersionPeer::ID_CREATION, BlockI18nVersionPeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_BLOCK_I18N_VERSION', 'ID_BLOCK', 'LOCALE', 'TEXT', 'VERSION', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_block_i18n_version', 'id_block', 'locale', 'text', 'version', 'date_creation', 'date_modification', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. BlockI18nVersionPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdBlockI18nVersion' => 0, 'IdBlock' => 1, 'Locale' => 2, 'Text' => 3, 'Version' => 4, 'DateCreation' => 5, 'DateModification' => 6, 'IdCreation' => 7, 'IdModification' => 8, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idBlockI18nVersion' => 0, 'idBlock' => 1, 'locale' => 2, 'text' => 3, 'version' => 4, 'dateCreation' => 5, 'dateModification' => 6, 'idCreation' => 7, 'idModification' => 8, ),
        BasePeer::TYPE_COLNAME => array (BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION => 0, BlockI18nVersionPeer::ID_BLOCK => 1, BlockI18nVersionPeer::LOCALE => 2, BlockI18nVersionPeer::TEXT => 3, BlockI18nVersionPeer::VERSION => 4, BlockI18nVersionPeer::DATE_CREATION => 5, BlockI18nVersionPeer::DATE_MODIFICATION => 6, BlockI18nVersionPeer::ID_CREATION => 7, BlockI18nVersionPeer::ID_MODIFICATION => 8, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_BLOCK_I18N_VERSION' => 0, 'ID_BLOCK' => 1, 'LOCALE' => 2, 'TEXT' => 3, 'VERSION' => 4, 'DATE_CREATION' => 5, 'DATE_MODIFICATION' => 6, 'ID_CREATION' => 7, 'ID_MODIFICATION' => 8, ),
        BasePeer::TYPE_FIELDNAME => array ('id_block_i18n_version' => 0, 'id_block' => 1, 'locale' => 2, 'text' => 3, 'version' => 4, 'date_creation' => 5, 'date_modification' => 6, 'id_creation' => 7, 'id_modification' => 8, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $toNames = BlockI18nVersionPeer::getFieldNames($toType);
        $key = isset(BlockI18nVersionPeer::$fieldKeys[$fromType][$name]) ? BlockI18nVersionPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(BlockI18nVersionPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, BlockI18nVersionPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return BlockI18nVersionPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. BlockI18nVersionPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(BlockI18nVersionPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION);
            $criteria->addSelectColumn(BlockI18nVersionPeer::ID_BLOCK);
            $criteria->addSelectColumn(BlockI18nVersionPeer::LOCALE);
            $criteria->addSelectColumn(BlockI18nVersionPeer::TEXT);
            $criteria->addSelectColumn(BlockI18nVersionPeer::VERSION);
            $criteria->addSelectColumn(BlockI18nVersionPeer::ID_CREATION);
            $criteria->addSelectColumn(BlockI18nVersionPeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_block_i18n_version');
            $criteria->addSelectColumn($alias . '.id_block');
            $criteria->addSelectColumn($alias . '.locale');
            $criteria->addSelectColumn($alias . '.text');
            $criteria->addSelectColumn($alias . '.version');
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
        $criteria->setPrimaryTableName(BlockI18nVersionPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BlockI18nVersionPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(BlockI18nVersionPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return BlockI18nVersion
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = BlockI18nVersionPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return BlockI18nVersionPeer::populateObjects(BlockI18nVersionPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            BlockI18nVersionPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(BlockI18nVersionPeer::DATABASE_NAME);

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
     * @param BlockI18nVersion $obj A BlockI18nVersion object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdBlockI18nVersion();
            } // if key === null
            BlockI18nVersionPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A BlockI18nVersion object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof BlockI18nVersion) {
                $key = (string) $value->getIdBlockI18nVersion();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or BlockI18nVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(BlockI18nVersionPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return BlockI18nVersion Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(BlockI18nVersionPeer::$instances[$key])) {
                return BlockI18nVersionPeer::$instances[$key];
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
        foreach (BlockI18nVersionPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        BlockI18nVersionPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to block_i18n_version
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
        $cls = BlockI18nVersionPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = BlockI18nVersionPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = BlockI18nVersionPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BlockI18nVersionPeer::addInstanceToPool($obj, $key);
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
     * @return array (BlockI18nVersion object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = BlockI18nVersionPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = BlockI18nVersionPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + BlockI18nVersionPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BlockI18nVersionPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            BlockI18nVersionPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function doCountJoinBlock(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BlockI18nVersionPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BlockI18nVersionPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BlockI18nVersionPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BlockI18nVersionPeer::ID_BLOCK, BlockPeer::ID_BLOCK, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinBlock(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BlockI18nVersionPeer::DATABASE_NAME);
        }

        BlockI18nVersionPeer::addSelectColumns($criteria);
        $startcol = BlockI18nVersionPeer::NUM_HYDRATE_COLUMNS;
        BlockPeer::addSelectColumns($criteria);

        $criteria->addJoin(BlockI18nVersionPeer::ID_BLOCK, BlockPeer::ID_BLOCK, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BlockI18nVersionPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BlockI18nVersionPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BlockI18nVersionPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BlockI18nVersionPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = BlockPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = BlockPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BlockPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    BlockPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (BlockI18nVersion) to $obj2 (Block)
                $obj2->addBlockI18nVersion($obj1);

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
        $criteria->setPrimaryTableName(BlockI18nVersionPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BlockI18nVersionPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BlockI18nVersionPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BlockI18nVersionPeer::ID_BLOCK, BlockPeer::ID_BLOCK, $join_behavior);

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
            $criteria->setDbName(BlockI18nVersionPeer::DATABASE_NAME);
        }

        BlockI18nVersionPeer::addSelectColumns($criteria);
        $startcol2 = BlockI18nVersionPeer::NUM_HYDRATE_COLUMNS;

        BlockPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BlockPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BlockI18nVersionPeer::ID_BLOCK, BlockPeer::ID_BLOCK, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BlockI18nVersionPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BlockI18nVersionPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BlockI18nVersionPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BlockI18nVersionPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Block rows

            $key2 = BlockPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = BlockPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BlockPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    BlockPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (BlockI18nVersion) to the collection in $obj2 (Block)
                $obj2->addBlockI18nVersion($obj1);
            } // if joined row not null

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
        return Propel::getDatabaseMap(BlockI18nVersionPeer::DATABASE_NAME)->getTable(BlockI18nVersionPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseBlockI18nVersionPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseBlockI18nVersionPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \BlockI18nVersionTableMap());
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
        return BlockI18nVersionPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a BlockI18nVersion or Criteria object.
     *
     * @param      mixed $values Criteria or BlockI18nVersion object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from BlockI18nVersion object
        }

        if ($criteria->containsKey(BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION) && $criteria->keyContainsValue(BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION.')');
        }


        // Set the correct dbName
        $criteria->setDbName(BlockI18nVersionPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a BlockI18nVersion or Criteria object.
     *
     * @param      mixed $values Criteria or BlockI18nVersion object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(BlockI18nVersionPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION);
            $value = $criteria->remove(BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION);
            if ($value) {
                $selectCriteria->add(BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(BlockI18nVersionPeer::TABLE_NAME);
            }

        } else { // $values is BlockI18nVersion object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(BlockI18nVersionPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the block_i18n_version table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(BlockI18nVersionPeer::TABLE_NAME, $con, BlockI18nVersionPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BlockI18nVersionPeer::clearInstancePool();
            BlockI18nVersionPeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            BlockI18nVersionPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof BlockI18nVersion) { // it's a model object
            // invalidate the cache for this single object
            BlockI18nVersionPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BlockI18nVersionPeer::DATABASE_NAME);
            $criteria->add(BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                BlockI18nVersionPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(BlockI18nVersionPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            BlockI18nVersionPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given BlockI18nVersion object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param BlockI18nVersion $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(BlockI18nVersionPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(BlockI18nVersionPeer::TABLE_NAME);

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

        }

        return BasePeer::doValidate(BlockI18nVersionPeer::DATABASE_NAME, BlockI18nVersionPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return BlockI18nVersion
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = BlockI18nVersionPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(BlockI18nVersionPeer::DATABASE_NAME);
        $criteria->add(BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION, $pk);

        $v = BlockI18nVersionPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return BlockI18nVersion[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BlockI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(BlockI18nVersionPeer::DATABASE_NAME);
            $criteria->add(BlockI18nVersionPeer::ID_BLOCK_I18N_VERSION, $pks, Criteria::IN);
            $objs = BlockI18nVersionPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseBlockI18nVersionPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseBlockI18nVersionPeer::buildTableMap();

