<?php


/**
 * Base static class for performing query and update operations on the 'slider_file' table.
 *
 * Upload d'images
 *
 * @package propel.generator.gen.om
 */
abstract class BaseSliderFilePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'slider_file';

    /** the related Propel class for this table */
    const OM_CLASS = 'SliderFile';

    /** the related TableMap class for this table */
    const TM_CLASS = 'SliderFileTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 11;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 9;

    const ID_SLIDER_FILE = 'slider_file.id_slider_file';

    const ID_SLIDER = 'slider_file.id_slider';

    const EXT = 'slider_file.ext';

    const NAME = 'slider_file.name';

    const SIZE = 'slider_file.size';

    const FICHIER = 'slider_file.fichier';

    const BLOB = 'slider_file.blob';

    const DATE_CREATION = 'slider_file.date_creation';

    const DATE_MODIFICATION = 'slider_file.date_modification';

    const ID_CREATION = 'slider_file.id_creation';

    const ID_MODIFICATION = 'slider_file.id_modification';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of SliderFile objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array SliderFile[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. SliderFilePeer::$fieldNames[SliderFilePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdSliderFile', 'IdSlider', 'Ext', 'Name', 'Size', 'Fichier', 'Blob', 'DateCreation', 'DateModification', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idSliderFile', 'idSlider', 'ext', 'name', 'size', 'fichier', 'blob', 'dateCreation', 'dateModification', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (SliderFilePeer::ID_SLIDER_FILE, SliderFilePeer::ID_SLIDER, SliderFilePeer::EXT, SliderFilePeer::NAME, SliderFilePeer::SIZE, SliderFilePeer::FICHIER, SliderFilePeer::BLOB, SliderFilePeer::DATE_CREATION, SliderFilePeer::DATE_MODIFICATION, SliderFilePeer::ID_CREATION, SliderFilePeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_SLIDER_FILE', 'ID_SLIDER', 'EXT', 'NAME', 'SIZE', 'FICHIER', 'BLOB', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_slider_file', 'id_slider', 'ext', 'name', 'size', 'fichier', 'blob', 'date_creation', 'date_modification', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. SliderFilePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdSliderFile' => 0, 'IdSlider' => 1, 'Ext' => 2, 'Name' => 3, 'Size' => 4, 'Fichier' => 5, 'Blob' => 6, 'DateCreation' => 7, 'DateModification' => 8, 'IdCreation' => 9, 'IdModification' => 10, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idSliderFile' => 0, 'idSlider' => 1, 'ext' => 2, 'name' => 3, 'size' => 4, 'fichier' => 5, 'blob' => 6, 'dateCreation' => 7, 'dateModification' => 8, 'idCreation' => 9, 'idModification' => 10, ),
        BasePeer::TYPE_COLNAME => array (SliderFilePeer::ID_SLIDER_FILE => 0, SliderFilePeer::ID_SLIDER => 1, SliderFilePeer::EXT => 2, SliderFilePeer::NAME => 3, SliderFilePeer::SIZE => 4, SliderFilePeer::FICHIER => 5, SliderFilePeer::BLOB => 6, SliderFilePeer::DATE_CREATION => 7, SliderFilePeer::DATE_MODIFICATION => 8, SliderFilePeer::ID_CREATION => 9, SliderFilePeer::ID_MODIFICATION => 10, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_SLIDER_FILE' => 0, 'ID_SLIDER' => 1, 'EXT' => 2, 'NAME' => 3, 'SIZE' => 4, 'FICHIER' => 5, 'BLOB' => 6, 'DATE_CREATION' => 7, 'DATE_MODIFICATION' => 8, 'ID_CREATION' => 9, 'ID_MODIFICATION' => 10, ),
        BasePeer::TYPE_FIELDNAME => array ('id_slider_file' => 0, 'id_slider' => 1, 'ext' => 2, 'name' => 3, 'size' => 4, 'fichier' => 5, 'blob' => 6, 'date_creation' => 7, 'date_modification' => 8, 'id_creation' => 9, 'id_modification' => 10, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $toNames = SliderFilePeer::getFieldNames($toType);
        $key = isset(SliderFilePeer::$fieldKeys[$fromType][$name]) ? SliderFilePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(SliderFilePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, SliderFilePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return SliderFilePeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. SliderFilePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(SliderFilePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(SliderFilePeer::ID_SLIDER_FILE);
            $criteria->addSelectColumn(SliderFilePeer::ID_SLIDER);
            $criteria->addSelectColumn(SliderFilePeer::EXT);
            $criteria->addSelectColumn(SliderFilePeer::NAME);
            $criteria->addSelectColumn(SliderFilePeer::SIZE);
            $criteria->addSelectColumn(SliderFilePeer::FICHIER);
            $criteria->addSelectColumn(SliderFilePeer::BLOB);
            $criteria->addSelectColumn(SliderFilePeer::ID_CREATION);
            $criteria->addSelectColumn(SliderFilePeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_slider_file');
            $criteria->addSelectColumn($alias . '.id_slider');
            $criteria->addSelectColumn($alias . '.ext');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.size');
            $criteria->addSelectColumn($alias . '.fichier');
            $criteria->addSelectColumn($alias . '.blob');
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
        $criteria->setPrimaryTableName(SliderFilePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SliderFilePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(SliderFilePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return SliderFile
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = SliderFilePeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return SliderFilePeer::populateObjects(SliderFilePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            SliderFilePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(SliderFilePeer::DATABASE_NAME);

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
     * @param SliderFile $obj A SliderFile object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdSliderFile();
            } // if key === null
            SliderFilePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A SliderFile object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof SliderFile) {
                $key = (string) $value->getIdSliderFile();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or SliderFile object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(SliderFilePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return SliderFile Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(SliderFilePeer::$instances[$key])) {
                return SliderFilePeer::$instances[$key];
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
        foreach (SliderFilePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        SliderFilePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to slider_file
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
        $cls = SliderFilePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = SliderFilePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = SliderFilePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SliderFilePeer::addInstanceToPool($obj, $key);
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
     * @return array (SliderFile object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = SliderFilePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = SliderFilePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + SliderFilePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SliderFilePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            SliderFilePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function doCountJoinSlider(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(SliderFilePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SliderFilePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(SliderFilePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(SliderFilePeer::ID_SLIDER, SliderPeer::ID_SLIDER, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinSlider(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(SliderFilePeer::DATABASE_NAME);
        }

        SliderFilePeer::addSelectColumns($criteria);
        $startcol = SliderFilePeer::NUM_HYDRATE_COLUMNS;
        SliderPeer::addSelectColumns($criteria);

        $criteria->addJoin(SliderFilePeer::ID_SLIDER, SliderPeer::ID_SLIDER, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = SliderFilePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = SliderFilePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = SliderFilePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                SliderFilePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = SliderPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = SliderPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = SliderPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    SliderPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (SliderFile) to $obj2 (Slider)
                $obj2->addSliderFile($obj1);

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
        $criteria->setPrimaryTableName(SliderFilePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SliderFilePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(SliderFilePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(SliderFilePeer::ID_SLIDER, SliderPeer::ID_SLIDER, $join_behavior);

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
            $criteria->setDbName(SliderFilePeer::DATABASE_NAME);
        }

        SliderFilePeer::addSelectColumns($criteria);
        $startcol2 = SliderFilePeer::NUM_HYDRATE_COLUMNS;

        SliderPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + SliderPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(SliderFilePeer::ID_SLIDER, SliderPeer::ID_SLIDER, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = SliderFilePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = SliderFilePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = SliderFilePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                SliderFilePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Slider rows

            $key2 = SliderPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = SliderPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = SliderPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    SliderPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (SliderFile) to the collection in $obj2 (Slider)
                $obj2->addSliderFile($obj1);
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
        return Propel::getDatabaseMap(SliderFilePeer::DATABASE_NAME)->getTable(SliderFilePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseSliderFilePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseSliderFilePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \SliderFileTableMap());
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
        return SliderFilePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a SliderFile or Criteria object.
     *
     * @param      mixed $values Criteria or SliderFile object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from SliderFile object
        }

        if ($criteria->containsKey(SliderFilePeer::ID_SLIDER_FILE) && $criteria->keyContainsValue(SliderFilePeer::ID_SLIDER_FILE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SliderFilePeer::ID_SLIDER_FILE.')');
        }


        // Set the correct dbName
        $criteria->setDbName(SliderFilePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a SliderFile or Criteria object.
     *
     * @param      mixed $values Criteria or SliderFile object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(SliderFilePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(SliderFilePeer::ID_SLIDER_FILE);
            $value = $criteria->remove(SliderFilePeer::ID_SLIDER_FILE);
            if ($value) {
                $selectCriteria->add(SliderFilePeer::ID_SLIDER_FILE, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(SliderFilePeer::TABLE_NAME);
            }

        } else { // $values is SliderFile object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(SliderFilePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the slider_file table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(SliderFilePeer::TABLE_NAME, $con, SliderFilePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SliderFilePeer::clearInstancePool();
            SliderFilePeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            SliderFilePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof SliderFile) { // it's a model object
            // invalidate the cache for this single object
            SliderFilePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SliderFilePeer::DATABASE_NAME);
            $criteria->add(SliderFilePeer::ID_SLIDER_FILE, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                SliderFilePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(SliderFilePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            SliderFilePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given SliderFile object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param SliderFile $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(SliderFilePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(SliderFilePeer::TABLE_NAME);

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

        return BasePeer::doValidate(SliderFilePeer::DATABASE_NAME, SliderFilePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return SliderFile
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = SliderFilePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(SliderFilePeer::DATABASE_NAME);
        $criteria->add(SliderFilePeer::ID_SLIDER_FILE, $pk);

        $v = SliderFilePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return SliderFile[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SliderFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(SliderFilePeer::DATABASE_NAME);
            $criteria->add(SliderFilePeer::ID_SLIDER_FILE, $pks, Criteria::IN);
            $objs = SliderFilePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseSliderFilePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseSliderFilePeer::buildTableMap();

