<?php


/**
 * Base static class for performing query and update operations on the 'content' table.
 *
 * Contenu
 *
 * @package propel.generator.gen.om
 */
abstract class BaseContentPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'content';

    /** the related Propel class for this table */
    const OM_CLASS = 'Content';

    /** the related TableMap class for this table */
    const TM_CLASS = 'ContentTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 13;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 11;

    const ID_CONTENT = 'content.id_content';

    const STATUS = 'content.status';

    const MENU_VISIBLE = 'content.menu_visible';

    const SLUG = 'content.slug';

    const HOME = 'content.home';

    const ORDER = 'content.order';

    const ID_MENU = 'content.id_menu';

    const NAME_MENU = 'content.name_menu';

    const TYPE = 'content.type';

    const DATE_CREATION = 'content.date_creation';

    const DATE_MODIFICATION = 'content.date_modification';

    const ID_CREATION = 'content.id_creation';

    const ID_MODIFICATION = 'content.id_modification';

    const STATUS_BROUILLON = 'Brouillon';
    const STATUS_PUBLIé = 'Publié';
    const STATUS_DéSACTIVé = 'Désactivé';

    const MENU_VISIBLE_OUI = 'Oui';
    const MENU_VISIBLE_NON = 'Non';

    const HOME_NON = 'Non';
    const HOME_OUI = 'Oui';

    const TYPE_CONTENU_FIXE = 'Contenu fixe';
    const TYPE_CONTENU_DYNAMIQUE = 'Contenu dynamique';
    const TYPE_NOUVELLES = 'Nouvelles';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Content objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Content[]
     */
    public static $instances = array();


    // i18n behavior

    /**
     * The default locale to use for translations
     * @var        string
     */
    const DEFAULT_LOCALE = 'en_US';
    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. ContentPeer::$fieldNames[ContentPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdContent', 'Status', 'MenuVisible', 'Slug', 'Home', 'Order', 'IdMenu', 'NameMenu', 'Type', 'DateCreation', 'DateModification', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idContent', 'status', 'menuVisible', 'slug', 'home', 'order', 'idMenu', 'nameMenu', 'type', 'dateCreation', 'dateModification', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (ContentPeer::ID_CONTENT, ContentPeer::STATUS, ContentPeer::MENU_VISIBLE, ContentPeer::SLUG, ContentPeer::HOME, ContentPeer::ORDER, ContentPeer::ID_MENU, ContentPeer::NAME_MENU, ContentPeer::TYPE, ContentPeer::DATE_CREATION, ContentPeer::DATE_MODIFICATION, ContentPeer::ID_CREATION, ContentPeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_CONTENT', 'STATUS', 'MENU_VISIBLE', 'SLUG', 'HOME', 'ORDER', 'ID_MENU', 'NAME_MENU', 'TYPE', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_content', 'status', 'menu_visible', 'slug', 'home', 'order', 'id_menu', 'name_menu', 'type', 'date_creation', 'date_modification', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. ContentPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdContent' => 0, 'Status' => 1, 'MenuVisible' => 2, 'Slug' => 3, 'Home' => 4, 'Order' => 5, 'IdMenu' => 6, 'NameMenu' => 7, 'Type' => 8, 'DateCreation' => 9, 'DateModification' => 10, 'IdCreation' => 11, 'IdModification' => 12, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idContent' => 0, 'status' => 1, 'menuVisible' => 2, 'slug' => 3, 'home' => 4, 'order' => 5, 'idMenu' => 6, 'nameMenu' => 7, 'type' => 8, 'dateCreation' => 9, 'dateModification' => 10, 'idCreation' => 11, 'idModification' => 12, ),
        BasePeer::TYPE_COLNAME => array (ContentPeer::ID_CONTENT => 0, ContentPeer::STATUS => 1, ContentPeer::MENU_VISIBLE => 2, ContentPeer::SLUG => 3, ContentPeer::HOME => 4, ContentPeer::ORDER => 5, ContentPeer::ID_MENU => 6, ContentPeer::NAME_MENU => 7, ContentPeer::TYPE => 8, ContentPeer::DATE_CREATION => 9, ContentPeer::DATE_MODIFICATION => 10, ContentPeer::ID_CREATION => 11, ContentPeer::ID_MODIFICATION => 12, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_CONTENT' => 0, 'STATUS' => 1, 'MENU_VISIBLE' => 2, 'SLUG' => 3, 'HOME' => 4, 'ORDER' => 5, 'ID_MENU' => 6, 'NAME_MENU' => 7, 'TYPE' => 8, 'DATE_CREATION' => 9, 'DATE_MODIFICATION' => 10, 'ID_CREATION' => 11, 'ID_MODIFICATION' => 12, ),
        BasePeer::TYPE_FIELDNAME => array ('id_content' => 0, 'status' => 1, 'menu_visible' => 2, 'slug' => 3, 'home' => 4, 'order' => 5, 'id_menu' => 6, 'name_menu' => 7, 'type' => 8, 'date_creation' => 9, 'date_modification' => 10, 'id_creation' => 11, 'id_modification' => 12, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        ContentPeer::STATUS => array(
            ContentPeer::STATUS_BROUILLON,
            ContentPeer::STATUS_PUBLIé,
            ContentPeer::STATUS_DéSACTIVé,
        ),
        ContentPeer::MENU_VISIBLE => array(
            ContentPeer::MENU_VISIBLE_OUI,
            ContentPeer::MENU_VISIBLE_NON,
        ),
        ContentPeer::HOME => array(
            ContentPeer::HOME_NON,
            ContentPeer::HOME_OUI,
        ),
        ContentPeer::TYPE => array(
            ContentPeer::TYPE_CONTENU_FIXE,
            ContentPeer::TYPE_CONTENU_DYNAMIQUE,
            ContentPeer::TYPE_NOUVELLES,
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
        $toNames = ContentPeer::getFieldNames($toType);
        $key = isset(ContentPeer::$fieldKeys[$fromType][$name]) ? ContentPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(ContentPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, ContentPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return ContentPeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return ContentPeer::$enumValueSets;
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
        $valueSets = ContentPeer::getValueSets();

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
        $values = ContentPeer::getValueSet($colname);
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
     * @param      string $column The column name for current table. (i.e. ContentPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(ContentPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(ContentPeer::ID_CONTENT);
            $criteria->addSelectColumn(ContentPeer::STATUS);
            $criteria->addSelectColumn(ContentPeer::MENU_VISIBLE);
            $criteria->addSelectColumn(ContentPeer::SLUG);
            $criteria->addSelectColumn(ContentPeer::HOME);
            $criteria->addSelectColumn(ContentPeer::ORDER);
            $criteria->addSelectColumn(ContentPeer::ID_MENU);
            $criteria->addSelectColumn(ContentPeer::NAME_MENU);
            $criteria->addSelectColumn(ContentPeer::TYPE);
            $criteria->addSelectColumn(ContentPeer::ID_CREATION);
            $criteria->addSelectColumn(ContentPeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_content');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.menu_visible');
            $criteria->addSelectColumn($alias . '.slug');
            $criteria->addSelectColumn($alias . '.home');
            $criteria->addSelectColumn($alias . '.order');
            $criteria->addSelectColumn($alias . '.id_menu');
            $criteria->addSelectColumn($alias . '.name_menu');
            $criteria->addSelectColumn($alias . '.type');
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
        $criteria->setPrimaryTableName(ContentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ContentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(ContentPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return Content
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = ContentPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return ContentPeer::populateObjects(ContentPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            ContentPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(ContentPeer::DATABASE_NAME);

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
     * @param Content $obj A Content object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdContent();
            } // if key === null
            ContentPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Content object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Content) {
                $key = (string) $value->getIdContent();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Content object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(ContentPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Content Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(ContentPeer::$instances[$key])) {
                return ContentPeer::$instances[$key];
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
        foreach (ContentPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        ContentPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to content
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {

        BlockPeer::clearInstancePool();

        ContentFilePeer::clearInstancePool();

        ContentI18nVersionPeer::clearInstancePool();

        ContentI18nPeer::clearInstancePool();
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
        $cls = ContentPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = ContentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = ContentPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ContentPeer::addInstanceToPool($obj, $key);
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
     * @return array (Content object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = ContentPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = ContentPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + ContentPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ContentPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            ContentPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function getStatusSqlValue($enumVal)
    {
        return ContentPeer::getSqlValueForEnum(ContentPeer::STATUS, $enumVal);
    }

    public static function getMenuVisibleSqlValue($enumVal)
    {
        return ContentPeer::getSqlValueForEnum(ContentPeer::MENU_VISIBLE, $enumVal);
    }

    public static function getHomeSqlValue($enumVal)
    {
        return ContentPeer::getSqlValueForEnum(ContentPeer::HOME, $enumVal);
    }

    public static function getTypeSqlValue($enumVal)
    {
        return ContentPeer::getSqlValueForEnum(ContentPeer::TYPE, $enumVal);
    }

    public static function doCountJoinMenu(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ContentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ContentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ContentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ContentPeer::ID_MENU, MenuPeer::ID_MENU, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinMenu(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ContentPeer::DATABASE_NAME);
        }

        ContentPeer::addSelectColumns($criteria);
        $startcol = ContentPeer::NUM_HYDRATE_COLUMNS;
        MenuPeer::addSelectColumns($criteria);

        $criteria->addJoin(ContentPeer::ID_MENU, MenuPeer::ID_MENU, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ContentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ContentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ContentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ContentPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = MenuPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = MenuPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MenuPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    MenuPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Content) to $obj2 (Menu)
                $obj2->addContent($obj1);

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
        $criteria->setPrimaryTableName(ContentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ContentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ContentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ContentPeer::ID_MENU, MenuPeer::ID_MENU, $join_behavior);

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
            $criteria->setDbName(ContentPeer::DATABASE_NAME);
        }

        ContentPeer::addSelectColumns($criteria);
        $startcol2 = ContentPeer::NUM_HYDRATE_COLUMNS;

        MenuPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + MenuPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ContentPeer::ID_MENU, MenuPeer::ID_MENU, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ContentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ContentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ContentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ContentPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Menu rows

            $key2 = MenuPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = MenuPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MenuPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    MenuPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Content) to the collection in $obj2 (Menu)
                $obj2->addContent($obj1);
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
        return Propel::getDatabaseMap(ContentPeer::DATABASE_NAME)->getTable(ContentPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseContentPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseContentPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \ContentTableMap());
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
        return ContentPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Content or Criteria object.
     *
     * @param      mixed $values Criteria or Content object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Content object
        }

        if ($criteria->containsKey(ContentPeer::ID_CONTENT) && $criteria->keyContainsValue(ContentPeer::ID_CONTENT) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ContentPeer::ID_CONTENT.')');
        }


        // Set the correct dbName
        $criteria->setDbName(ContentPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Content or Criteria object.
     *
     * @param      mixed $values Criteria or Content object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(ContentPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(ContentPeer::ID_CONTENT);
            $value = $criteria->remove(ContentPeer::ID_CONTENT);
            if ($value) {
                $selectCriteria->add(ContentPeer::ID_CONTENT, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ContentPeer::TABLE_NAME);
            }

        } else { // $values is Content object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(ContentPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the content table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(ContentPeer::TABLE_NAME, $con, ContentPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ContentPeer::clearInstancePool();
            ContentPeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            ContentPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Content) { // it's a model object
            // invalidate the cache for this single object
            ContentPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ContentPeer::DATABASE_NAME);
            $criteria->add(ContentPeer::ID_CONTENT, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                ContentPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(ContentPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            ContentPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Content object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Content $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(ContentPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(ContentPeer::TABLE_NAME);

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

        return BasePeer::doValidate(ContentPeer::DATABASE_NAME, ContentPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Content
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = ContentPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(ContentPeer::DATABASE_NAME);
        $criteria->add(ContentPeer::ID_CONTENT, $pk);

        $v = ContentPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Content[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(ContentPeer::DATABASE_NAME);
            $criteria->add(ContentPeer::ID_CONTENT, $pks, Criteria::IN);
            $objs = ContentPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseContentPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseContentPeer::buildTableMap();

