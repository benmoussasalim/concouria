<?php


/**
 * Base static class for performing query and update operations on the 'content_i18n_version' table.
 *
 *
 *
 * @package propel.generator.gen.om
 */
abstract class BaseContentI18nVersionPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'content_i18n_version';

    /** the related Propel class for this table */
    const OM_CLASS = 'ContentI18nVersion';

    /** the related TableMap class for this table */
    const TM_CLASS = 'ContentI18nVersionTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 9;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 7;

    const ID_CONTENT_I18N_VERSION = 'content_i18n_version.id_content_i18n_version';

    const ID_CONTENT = 'content_i18n_version.id_content';

    const LOCALE = 'content_i18n_version.locale';

    const TEXT = 'content_i18n_version.text';

    const VERSION = 'content_i18n_version.version';

    const DATE_CREATION = 'content_i18n_version.date_creation';

    const DATE_MODIFICATION = 'content_i18n_version.date_modification';

    const ID_CREATION = 'content_i18n_version.id_creation';

    const ID_MODIFICATION = 'content_i18n_version.id_modification';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of ContentI18nVersion objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array ContentI18nVersion[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. ContentI18nVersionPeer::$fieldNames[ContentI18nVersionPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdContentI18nVersion', 'IdContent', 'Locale', 'Text', 'Version', 'DateCreation', 'DateModification', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idContentI18nVersion', 'idContent', 'locale', 'text', 'version', 'dateCreation', 'dateModification', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION, ContentI18nVersionPeer::ID_CONTENT, ContentI18nVersionPeer::LOCALE, ContentI18nVersionPeer::TEXT, ContentI18nVersionPeer::VERSION, ContentI18nVersionPeer::DATE_CREATION, ContentI18nVersionPeer::DATE_MODIFICATION, ContentI18nVersionPeer::ID_CREATION, ContentI18nVersionPeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_CONTENT_I18N_VERSION', 'ID_CONTENT', 'LOCALE', 'TEXT', 'VERSION', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_content_i18n_version', 'id_content', 'locale', 'text', 'version', 'date_creation', 'date_modification', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. ContentI18nVersionPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdContentI18nVersion' => 0, 'IdContent' => 1, 'Locale' => 2, 'Text' => 3, 'Version' => 4, 'DateCreation' => 5, 'DateModification' => 6, 'IdCreation' => 7, 'IdModification' => 8, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idContentI18nVersion' => 0, 'idContent' => 1, 'locale' => 2, 'text' => 3, 'version' => 4, 'dateCreation' => 5, 'dateModification' => 6, 'idCreation' => 7, 'idModification' => 8, ),
        BasePeer::TYPE_COLNAME => array (ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION => 0, ContentI18nVersionPeer::ID_CONTENT => 1, ContentI18nVersionPeer::LOCALE => 2, ContentI18nVersionPeer::TEXT => 3, ContentI18nVersionPeer::VERSION => 4, ContentI18nVersionPeer::DATE_CREATION => 5, ContentI18nVersionPeer::DATE_MODIFICATION => 6, ContentI18nVersionPeer::ID_CREATION => 7, ContentI18nVersionPeer::ID_MODIFICATION => 8, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_CONTENT_I18N_VERSION' => 0, 'ID_CONTENT' => 1, 'LOCALE' => 2, 'TEXT' => 3, 'VERSION' => 4, 'DATE_CREATION' => 5, 'DATE_MODIFICATION' => 6, 'ID_CREATION' => 7, 'ID_MODIFICATION' => 8, ),
        BasePeer::TYPE_FIELDNAME => array ('id_content_i18n_version' => 0, 'id_content' => 1, 'locale' => 2, 'text' => 3, 'version' => 4, 'date_creation' => 5, 'date_modification' => 6, 'id_creation' => 7, 'id_modification' => 8, ),
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
        $toNames = ContentI18nVersionPeer::getFieldNames($toType);
        $key = isset(ContentI18nVersionPeer::$fieldKeys[$fromType][$name]) ? ContentI18nVersionPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(ContentI18nVersionPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, ContentI18nVersionPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return ContentI18nVersionPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. ContentI18nVersionPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(ContentI18nVersionPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION);
            $criteria->addSelectColumn(ContentI18nVersionPeer::ID_CONTENT);
            $criteria->addSelectColumn(ContentI18nVersionPeer::LOCALE);
            $criteria->addSelectColumn(ContentI18nVersionPeer::TEXT);
            $criteria->addSelectColumn(ContentI18nVersionPeer::VERSION);
            $criteria->addSelectColumn(ContentI18nVersionPeer::ID_CREATION);
            $criteria->addSelectColumn(ContentI18nVersionPeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_content_i18n_version');
            $criteria->addSelectColumn($alias . '.id_content');
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
        $criteria->setPrimaryTableName(ContentI18nVersionPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ContentI18nVersionPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(ContentI18nVersionPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return ContentI18nVersion
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = ContentI18nVersionPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return ContentI18nVersionPeer::populateObjects(ContentI18nVersionPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            ContentI18nVersionPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(ContentI18nVersionPeer::DATABASE_NAME);

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
     * @param ContentI18nVersion $obj A ContentI18nVersion object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdContentI18nVersion();
            } // if key === null
            ContentI18nVersionPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A ContentI18nVersion object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof ContentI18nVersion) {
                $key = (string) $value->getIdContentI18nVersion();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or ContentI18nVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(ContentI18nVersionPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return ContentI18nVersion Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(ContentI18nVersionPeer::$instances[$key])) {
                return ContentI18nVersionPeer::$instances[$key];
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
        foreach (ContentI18nVersionPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        ContentI18nVersionPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to content_i18n_version
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
        $cls = ContentI18nVersionPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = ContentI18nVersionPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = ContentI18nVersionPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ContentI18nVersionPeer::addInstanceToPool($obj, $key);
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
     * @return array (ContentI18nVersion object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = ContentI18nVersionPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = ContentI18nVersionPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + ContentI18nVersionPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ContentI18nVersionPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            ContentI18nVersionPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function doCountJoinContent(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ContentI18nVersionPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ContentI18nVersionPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ContentI18nVersionPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ContentI18nVersionPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinContent(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ContentI18nVersionPeer::DATABASE_NAME);
        }

        ContentI18nVersionPeer::addSelectColumns($criteria);
        $startcol = ContentI18nVersionPeer::NUM_HYDRATE_COLUMNS;
        ContentPeer::addSelectColumns($criteria);

        $criteria->addJoin(ContentI18nVersionPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ContentI18nVersionPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ContentI18nVersionPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ContentI18nVersionPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ContentI18nVersionPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ContentPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ContentPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ContentPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ContentPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (ContentI18nVersion) to $obj2 (Content)
                $obj2->addContentI18nVersion($obj1);

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
        $criteria->setPrimaryTableName(ContentI18nVersionPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ContentI18nVersionPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ContentI18nVersionPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ContentI18nVersionPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

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
            $criteria->setDbName(ContentI18nVersionPeer::DATABASE_NAME);
        }

        ContentI18nVersionPeer::addSelectColumns($criteria);
        $startcol2 = ContentI18nVersionPeer::NUM_HYDRATE_COLUMNS;

        ContentPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContentPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ContentI18nVersionPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ContentI18nVersionPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ContentI18nVersionPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ContentI18nVersionPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ContentI18nVersionPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Content rows

            $key2 = ContentPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = ContentPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ContentPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    ContentPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (ContentI18nVersion) to the collection in $obj2 (Content)
                $obj2->addContentI18nVersion($obj1);
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
        return Propel::getDatabaseMap(ContentI18nVersionPeer::DATABASE_NAME)->getTable(ContentI18nVersionPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseContentI18nVersionPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseContentI18nVersionPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \ContentI18nVersionTableMap());
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
        return ContentI18nVersionPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a ContentI18nVersion or Criteria object.
     *
     * @param      mixed $values Criteria or ContentI18nVersion object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from ContentI18nVersion object
        }

        if ($criteria->containsKey(ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION) && $criteria->keyContainsValue(ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION.')');
        }


        // Set the correct dbName
        $criteria->setDbName(ContentI18nVersionPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a ContentI18nVersion or Criteria object.
     *
     * @param      mixed $values Criteria or ContentI18nVersion object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(ContentI18nVersionPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION);
            $value = $criteria->remove(ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION);
            if ($value) {
                $selectCriteria->add(ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ContentI18nVersionPeer::TABLE_NAME);
            }

        } else { // $values is ContentI18nVersion object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(ContentI18nVersionPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the content_i18n_version table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(ContentI18nVersionPeer::TABLE_NAME, $con, ContentI18nVersionPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ContentI18nVersionPeer::clearInstancePool();
            ContentI18nVersionPeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            ContentI18nVersionPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof ContentI18nVersion) { // it's a model object
            // invalidate the cache for this single object
            ContentI18nVersionPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ContentI18nVersionPeer::DATABASE_NAME);
            $criteria->add(ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                ContentI18nVersionPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(ContentI18nVersionPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            ContentI18nVersionPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given ContentI18nVersion object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param ContentI18nVersion $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(ContentI18nVersionPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(ContentI18nVersionPeer::TABLE_NAME);

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

        return BasePeer::doValidate(ContentI18nVersionPeer::DATABASE_NAME, ContentI18nVersionPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return ContentI18nVersion
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = ContentI18nVersionPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(ContentI18nVersionPeer::DATABASE_NAME);
        $criteria->add(ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION, $pk);

        $v = ContentI18nVersionPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return ContentI18nVersion[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentI18nVersionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(ContentI18nVersionPeer::DATABASE_NAME);
            $criteria->add(ContentI18nVersionPeer::ID_CONTENT_I18N_VERSION, $pks, Criteria::IN);
            $objs = ContentI18nVersionPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseContentI18nVersionPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseContentI18nVersionPeer::buildTableMap();

