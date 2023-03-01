<?php


/**
 * Base static class for performing query and update operations on the 'content_i18n' table.
 *
 *
 *
 * @package propel.generator.gen.om
 */
abstract class BaseContentI18nPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'content_i18n';

    /** the related Propel class for this table */
    const OM_CLASS = 'ContentI18n';

    /** the related TableMap class for this table */
    const TM_CLASS = 'ContentI18nTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 12;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 10;

    const ID_CONTENT = 'content_i18n.id_content';

    const LOCALE = 'content_i18n.locale';

    const NAME = 'content_i18n.name';

    const TEXT = 'content_i18n.text';

    const META_KEYWORD = 'content_i18n.meta_keyword';

    const META_DESCRIPTION = 'content_i18n.meta_description';

    const META_TITLE = 'content_i18n.meta_title';

    const VERSION = 'content_i18n.version';

    const DATE_CREATION = 'content_i18n.date_creation';

    const DATE_MODIFICATION = 'content_i18n.date_modification';

    const ID_CREATION = 'content_i18n.id_creation';

    const ID_MODIFICATION = 'content_i18n.id_modification';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of ContentI18n objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array ContentI18n[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. ContentI18nPeer::$fieldNames[ContentI18nPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdContent', 'Locale', 'Name', 'Text', 'MetaKeyword', 'MetaDescription', 'MetaTitle', 'Version', 'DateCreation', 'DateModification', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idContent', 'locale', 'name', 'text', 'metaKeyword', 'metaDescription', 'metaTitle', 'version', 'dateCreation', 'dateModification', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (ContentI18nPeer::ID_CONTENT, ContentI18nPeer::LOCALE, ContentI18nPeer::NAME, ContentI18nPeer::TEXT, ContentI18nPeer::META_KEYWORD, ContentI18nPeer::META_DESCRIPTION, ContentI18nPeer::META_TITLE, ContentI18nPeer::VERSION, ContentI18nPeer::DATE_CREATION, ContentI18nPeer::DATE_MODIFICATION, ContentI18nPeer::ID_CREATION, ContentI18nPeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_CONTENT', 'LOCALE', 'NAME', 'TEXT', 'META_KEYWORD', 'META_DESCRIPTION', 'META_TITLE', 'VERSION', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_content', 'locale', 'name', 'text', 'meta_keyword', 'meta_description', 'meta_title', 'version', 'date_creation', 'date_modification', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. ContentI18nPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdContent' => 0, 'Locale' => 1, 'Name' => 2, 'Text' => 3, 'MetaKeyword' => 4, 'MetaDescription' => 5, 'MetaTitle' => 6, 'Version' => 7, 'DateCreation' => 8, 'DateModification' => 9, 'IdCreation' => 10, 'IdModification' => 11, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idContent' => 0, 'locale' => 1, 'name' => 2, 'text' => 3, 'metaKeyword' => 4, 'metaDescription' => 5, 'metaTitle' => 6, 'version' => 7, 'dateCreation' => 8, 'dateModification' => 9, 'idCreation' => 10, 'idModification' => 11, ),
        BasePeer::TYPE_COLNAME => array (ContentI18nPeer::ID_CONTENT => 0, ContentI18nPeer::LOCALE => 1, ContentI18nPeer::NAME => 2, ContentI18nPeer::TEXT => 3, ContentI18nPeer::META_KEYWORD => 4, ContentI18nPeer::META_DESCRIPTION => 5, ContentI18nPeer::META_TITLE => 6, ContentI18nPeer::VERSION => 7, ContentI18nPeer::DATE_CREATION => 8, ContentI18nPeer::DATE_MODIFICATION => 9, ContentI18nPeer::ID_CREATION => 10, ContentI18nPeer::ID_MODIFICATION => 11, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_CONTENT' => 0, 'LOCALE' => 1, 'NAME' => 2, 'TEXT' => 3, 'META_KEYWORD' => 4, 'META_DESCRIPTION' => 5, 'META_TITLE' => 6, 'VERSION' => 7, 'DATE_CREATION' => 8, 'DATE_MODIFICATION' => 9, 'ID_CREATION' => 10, 'ID_MODIFICATION' => 11, ),
        BasePeer::TYPE_FIELDNAME => array ('id_content' => 0, 'locale' => 1, 'name' => 2, 'text' => 3, 'meta_keyword' => 4, 'meta_description' => 5, 'meta_title' => 6, 'version' => 7, 'date_creation' => 8, 'date_modification' => 9, 'id_creation' => 10, 'id_modification' => 11, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
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
        $toNames = ContentI18nPeer::getFieldNames($toType);
        $key = isset(ContentI18nPeer::$fieldKeys[$fromType][$name]) ? ContentI18nPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(ContentI18nPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, ContentI18nPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return ContentI18nPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. ContentI18nPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(ContentI18nPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(ContentI18nPeer::ID_CONTENT);
            $criteria->addSelectColumn(ContentI18nPeer::LOCALE);
            $criteria->addSelectColumn(ContentI18nPeer::NAME);
            $criteria->addSelectColumn(ContentI18nPeer::TEXT);
            $criteria->addSelectColumn(ContentI18nPeer::META_KEYWORD);
            $criteria->addSelectColumn(ContentI18nPeer::META_DESCRIPTION);
            $criteria->addSelectColumn(ContentI18nPeer::META_TITLE);
            $criteria->addSelectColumn(ContentI18nPeer::VERSION);
            $criteria->addSelectColumn(ContentI18nPeer::ID_CREATION);
            $criteria->addSelectColumn(ContentI18nPeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_content');
            $criteria->addSelectColumn($alias . '.locale');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.text');
            $criteria->addSelectColumn($alias . '.meta_keyword');
            $criteria->addSelectColumn($alias . '.meta_description');
            $criteria->addSelectColumn($alias . '.meta_title');
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
        $criteria->setPrimaryTableName(ContentI18nPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ContentI18nPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(ContentI18nPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return ContentI18n
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = ContentI18nPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return ContentI18nPeer::populateObjects(ContentI18nPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            ContentI18nPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(ContentI18nPeer::DATABASE_NAME);

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
     * @param ContentI18n $obj A ContentI18n object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = serialize(array((string) $obj->getIdContent(), (string) $obj->getLocale()));
            } // if key === null
            ContentI18nPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A ContentI18n object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof ContentI18n) {
                $key = serialize(array((string) $value->getIdContent(), (string) $value->getLocale()));
            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or ContentI18n object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(ContentI18nPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return ContentI18n Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(ContentI18nPeer::$instances[$key])) {
                return ContentI18nPeer::$instances[$key];
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
        foreach (ContentI18nPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        ContentI18nPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to content_i18n
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
        if ($row[$startcol] === null && $row[$startcol + 1] === null) {
            return null;
        }

        return serialize(array((string) $row[$startcol], (string) $row[$startcol + 1]));
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

        return array((int) $row[$startcol], (string) $row[$startcol + 1]);
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
        $cls = ContentI18nPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = ContentI18nPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = ContentI18nPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ContentI18nPeer::addInstanceToPool($obj, $key);
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
     * @return array (ContentI18n object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = ContentI18nPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = ContentI18nPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + ContentI18nPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ContentI18nPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            ContentI18nPeer::addInstanceToPool($obj, $key);
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
        $criteria->setPrimaryTableName(ContentI18nPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ContentI18nPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ContentI18nPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ContentI18nPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

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
            $criteria->setDbName(ContentI18nPeer::DATABASE_NAME);
        }

        ContentI18nPeer::addSelectColumns($criteria);
        $startcol = ContentI18nPeer::NUM_HYDRATE_COLUMNS;
        ContentPeer::addSelectColumns($criteria);

        $criteria->addJoin(ContentI18nPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ContentI18nPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ContentI18nPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ContentI18nPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ContentI18nPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (ContentI18n) to $obj2 (Content)
                $obj2->addContentI18n($obj1);

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
        $criteria->setPrimaryTableName(ContentI18nPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ContentI18nPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ContentI18nPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ContentI18nPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

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
            $criteria->setDbName(ContentI18nPeer::DATABASE_NAME);
        }

        ContentI18nPeer::addSelectColumns($criteria);
        $startcol2 = ContentI18nPeer::NUM_HYDRATE_COLUMNS;

        ContentPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContentPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ContentI18nPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ContentI18nPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ContentI18nPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ContentI18nPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ContentI18nPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (ContentI18n) to the collection in $obj2 (Content)
                $obj2->addContentI18n($obj1);
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
        return Propel::getDatabaseMap(ContentI18nPeer::DATABASE_NAME)->getTable(ContentI18nPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseContentI18nPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseContentI18nPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \ContentI18nTableMap());
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
        return ContentI18nPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a ContentI18n or Criteria object.
     *
     * @param      mixed $values Criteria or ContentI18n object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from ContentI18n object
        }


        // Set the correct dbName
        $criteria->setDbName(ContentI18nPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a ContentI18n or Criteria object.
     *
     * @param      mixed $values Criteria or ContentI18n object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(ContentI18nPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(ContentI18nPeer::ID_CONTENT);
            $value = $criteria->remove(ContentI18nPeer::ID_CONTENT);
            if ($value) {
                $selectCriteria->add(ContentI18nPeer::ID_CONTENT, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ContentI18nPeer::TABLE_NAME);
            }

            $comparison = $criteria->getComparison(ContentI18nPeer::LOCALE);
            $value = $criteria->remove(ContentI18nPeer::LOCALE);
            if ($value) {
                $selectCriteria->add(ContentI18nPeer::LOCALE, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ContentI18nPeer::TABLE_NAME);
            }

        } else { // $values is ContentI18n object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(ContentI18nPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the content_i18n table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(ContentI18nPeer::TABLE_NAME, $con, ContentI18nPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ContentI18nPeer::clearInstancePool();
            ContentI18nPeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            ContentI18nPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof ContentI18n) { // it's a model object
            // invalidate the cache for this single object
            ContentI18nPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ContentI18nPeer::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(ContentI18nPeer::ID_CONTENT, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(ContentI18nPeer::LOCALE, $value[1]));
                $criteria->addOr($criterion);
                // we can invalidate the cache for this single PK
                ContentI18nPeer::removeInstanceFromPool($value);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(ContentI18nPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            ContentI18nPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given ContentI18n object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param ContentI18n $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(ContentI18nPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(ContentI18nPeer::TABLE_NAME);

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

        return BasePeer::doValidate(ContentI18nPeer::DATABASE_NAME, ContentI18nPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve object using using composite pkey values.
     * @param   int $id_content
     * @param   string $locale
     * @param      PropelPDO $con
     * @return ContentI18n
     */
    public static function retrieveByPK($id_content, $locale, PropelPDO $con = null) {
        $_instancePoolKey = serialize(array((string) $id_content, (string) $locale));
         if (null !== ($obj = ContentI18nPeer::getInstanceFromPool($_instancePoolKey))) {
             return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(ContentI18nPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $criteria = new Criteria(ContentI18nPeer::DATABASE_NAME);
        $criteria->add(ContentI18nPeer::ID_CONTENT, $id_content);
        $criteria->add(ContentI18nPeer::LOCALE, $locale);
        $v = ContentI18nPeer::doSelect($criteria, $con);

        return !empty($v) ? $v[0] : null;
    }
} // BaseContentI18nPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseContentI18nPeer::buildTableMap();

