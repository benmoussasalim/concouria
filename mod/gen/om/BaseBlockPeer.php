<?php


/**
 * Base static class for performing query and update operations on the 'block' table.
 *
 * Block
 *
 * @package propel.generator.gen.om
 */
abstract class BaseBlockPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'block';

    /** the related Propel class for this table */
    const OM_CLASS = 'Block';

    /** the related TableMap class for this table */
    const TM_CLASS = 'BlockTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 14;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 12;

    const ID_BLOCK = 'block.id_block';

    const ID_CONTENT = 'block.id_content';

    const TITLE = 'block.title';

    const STATUS = 'block.status';

    const TYPE = 'block.type';

    const ID_PARENT = 'block.id_parent';

    const POSITION = 'block.position';

    const ORDER = 'block.order';

    const DISPLAY = 'block.display';

    const SLUG = 'block.slug';

    const DATE_CREATION = 'block.date_creation';

    const DATE_MODIFICATION = 'block.date_modification';

    const ID_CREATION = 'block.id_creation';

    const ID_MODIFICATION = 'block.id_modification';

    const STATUS_BROUILLON = 'Brouillon';
    const STATUS_PUBLIé = 'Publié';
    const STATUS_DéSACTIVé = 'Désactivé';

    const TYPE_CONTENU_FIXE = 'Contenu fixe';
    const TYPE_CONTENU_DYNAMIQUE = 'Contenu dynamique';
    const TYPE_SLIDESHOW = 'Slideshow';
    const TYPE_MENU = 'Menu';
    const TYPE_CONTENEUR = 'Conteneur';

    const POSITION_EN_HAUT = 'En haut';
    const POSITION_EN_BAS = 'En bas';

    const DISPLAY_TOUTES_LES_PAGES = 'Toutes les pages';
    const DISPLAY_ACCUEIL_SEULEMENT = 'Accueil seulement';
    const DISPLAY_MANUEL = 'Manuel';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Block objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Block[]
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
     * e.g. BlockPeer::$fieldNames[BlockPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdBlock', 'IdContent', 'Title', 'Status', 'Type', 'IdParent', 'Position', 'Order', 'Display', 'Slug', 'DateCreation', 'DateModification', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idBlock', 'idContent', 'title', 'status', 'type', 'idParent', 'position', 'order', 'display', 'slug', 'dateCreation', 'dateModification', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (BlockPeer::ID_BLOCK, BlockPeer::ID_CONTENT, BlockPeer::TITLE, BlockPeer::STATUS, BlockPeer::TYPE, BlockPeer::ID_PARENT, BlockPeer::POSITION, BlockPeer::ORDER, BlockPeer::DISPLAY, BlockPeer::SLUG, BlockPeer::DATE_CREATION, BlockPeer::DATE_MODIFICATION, BlockPeer::ID_CREATION, BlockPeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_BLOCK', 'ID_CONTENT', 'TITLE', 'STATUS', 'TYPE', 'ID_PARENT', 'POSITION', 'ORDER', 'DISPLAY', 'SLUG', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_block', 'id_content', 'title', 'status', 'type', 'id_parent', 'position', 'order', 'display', 'slug', 'date_creation', 'date_modification', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. BlockPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdBlock' => 0, 'IdContent' => 1, 'Title' => 2, 'Status' => 3, 'Type' => 4, 'IdParent' => 5, 'Position' => 6, 'Order' => 7, 'Display' => 8, 'Slug' => 9, 'DateCreation' => 10, 'DateModification' => 11, 'IdCreation' => 12, 'IdModification' => 13, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idBlock' => 0, 'idContent' => 1, 'title' => 2, 'status' => 3, 'type' => 4, 'idParent' => 5, 'position' => 6, 'order' => 7, 'display' => 8, 'slug' => 9, 'dateCreation' => 10, 'dateModification' => 11, 'idCreation' => 12, 'idModification' => 13, ),
        BasePeer::TYPE_COLNAME => array (BlockPeer::ID_BLOCK => 0, BlockPeer::ID_CONTENT => 1, BlockPeer::TITLE => 2, BlockPeer::STATUS => 3, BlockPeer::TYPE => 4, BlockPeer::ID_PARENT => 5, BlockPeer::POSITION => 6, BlockPeer::ORDER => 7, BlockPeer::DISPLAY => 8, BlockPeer::SLUG => 9, BlockPeer::DATE_CREATION => 10, BlockPeer::DATE_MODIFICATION => 11, BlockPeer::ID_CREATION => 12, BlockPeer::ID_MODIFICATION => 13, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_BLOCK' => 0, 'ID_CONTENT' => 1, 'TITLE' => 2, 'STATUS' => 3, 'TYPE' => 4, 'ID_PARENT' => 5, 'POSITION' => 6, 'ORDER' => 7, 'DISPLAY' => 8, 'SLUG' => 9, 'DATE_CREATION' => 10, 'DATE_MODIFICATION' => 11, 'ID_CREATION' => 12, 'ID_MODIFICATION' => 13, ),
        BasePeer::TYPE_FIELDNAME => array ('id_block' => 0, 'id_content' => 1, 'title' => 2, 'status' => 3, 'type' => 4, 'id_parent' => 5, 'position' => 6, 'order' => 7, 'display' => 8, 'slug' => 9, 'date_creation' => 10, 'date_modification' => 11, 'id_creation' => 12, 'id_modification' => 13, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        BlockPeer::STATUS => array(
            BlockPeer::STATUS_BROUILLON,
            BlockPeer::STATUS_PUBLIé,
            BlockPeer::STATUS_DéSACTIVé,
        ),
        BlockPeer::TYPE => array(
            BlockPeer::TYPE_CONTENU_FIXE,
            BlockPeer::TYPE_CONTENU_DYNAMIQUE,
            BlockPeer::TYPE_SLIDESHOW,
            BlockPeer::TYPE_MENU,
            BlockPeer::TYPE_CONTENEUR,
        ),
        BlockPeer::POSITION => array(
            BlockPeer::POSITION_EN_HAUT,
            BlockPeer::POSITION_EN_BAS,
        ),
        BlockPeer::DISPLAY => array(
            BlockPeer::DISPLAY_TOUTES_LES_PAGES,
            BlockPeer::DISPLAY_ACCUEIL_SEULEMENT,
            BlockPeer::DISPLAY_MANUEL,
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
        $toNames = BlockPeer::getFieldNames($toType);
        $key = isset(BlockPeer::$fieldKeys[$fromType][$name]) ? BlockPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(BlockPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, BlockPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return BlockPeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return BlockPeer::$enumValueSets;
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
        $valueSets = BlockPeer::getValueSets();

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
        $values = BlockPeer::getValueSet($colname);
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
     * @param      string $column The column name for current table. (i.e. BlockPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(BlockPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(BlockPeer::ID_BLOCK);
            $criteria->addSelectColumn(BlockPeer::ID_CONTENT);
            $criteria->addSelectColumn(BlockPeer::TITLE);
            $criteria->addSelectColumn(BlockPeer::STATUS);
            $criteria->addSelectColumn(BlockPeer::TYPE);
            $criteria->addSelectColumn(BlockPeer::ID_PARENT);
            $criteria->addSelectColumn(BlockPeer::POSITION);
            $criteria->addSelectColumn(BlockPeer::ORDER);
            $criteria->addSelectColumn(BlockPeer::DISPLAY);
            $criteria->addSelectColumn(BlockPeer::SLUG);
            $criteria->addSelectColumn(BlockPeer::ID_CREATION);
            $criteria->addSelectColumn(BlockPeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_block');
            $criteria->addSelectColumn($alias . '.id_content');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.id_parent');
            $criteria->addSelectColumn($alias . '.position');
            $criteria->addSelectColumn($alias . '.order');
            $criteria->addSelectColumn($alias . '.display');
            $criteria->addSelectColumn($alias . '.slug');
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
        $criteria->setPrimaryTableName(BlockPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BlockPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(BlockPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return Block
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = BlockPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return BlockPeer::populateObjects(BlockPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            BlockPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(BlockPeer::DATABASE_NAME);

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
     * @param Block $obj A Block object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdBlock();
            } // if key === null
            BlockPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Block object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Block) {
                $key = (string) $value->getIdBlock();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Block object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(BlockPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Block Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(BlockPeer::$instances[$key])) {
                return BlockPeer::$instances[$key];
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
        foreach (BlockPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        BlockPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to block
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {

        BlockPeer::clearInstancePool();

        BlockFilePeer::clearInstancePool();

        BlockI18nVersionPeer::clearInstancePool();

        BlockI18nPeer::clearInstancePool();
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
        $cls = BlockPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = BlockPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = BlockPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BlockPeer::addInstanceToPool($obj, $key);
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
     * @return array (Block object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = BlockPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = BlockPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + BlockPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BlockPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            BlockPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function getStatusSqlValue($enumVal)
    {
        return BlockPeer::getSqlValueForEnum(BlockPeer::STATUS, $enumVal);
    }

    public static function getTypeSqlValue($enumVal)
    {
        return BlockPeer::getSqlValueForEnum(BlockPeer::TYPE, $enumVal);
    }

    public static function getPositionSqlValue($enumVal)
    {
        return BlockPeer::getSqlValueForEnum(BlockPeer::POSITION, $enumVal);
    }

    public static function getDisplaySqlValue($enumVal)
    {
        return BlockPeer::getSqlValueForEnum(BlockPeer::DISPLAY, $enumVal);
    }

    public static function doCountJoinContent(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BlockPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BlockPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BlockPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BlockPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

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
            $criteria->setDbName(BlockPeer::DATABASE_NAME);
        }

        BlockPeer::addSelectColumns($criteria);
        $startcol = BlockPeer::NUM_HYDRATE_COLUMNS;
        ContentPeer::addSelectColumns($criteria);

        $criteria->addJoin(BlockPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BlockPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BlockPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BlockPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BlockPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Block) to $obj2 (Content)
                $obj2->addBlock($obj1);

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
        $criteria->setPrimaryTableName(BlockPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BlockPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BlockPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BlockPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

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
            $criteria->setDbName(BlockPeer::DATABASE_NAME);
        }

        BlockPeer::addSelectColumns($criteria);
        $startcol2 = BlockPeer::NUM_HYDRATE_COLUMNS;

        ContentPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContentPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BlockPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BlockPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BlockPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BlockPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BlockPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Block) to the collection in $obj2 (Content)
                $obj2->addBlock($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doCountJoinAllExceptBlockRelatedByIdParent(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BlockPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BlockPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BlockPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BlockPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doCountJoinAllExceptContent(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BlockPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BlockPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BlockPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinAllExceptBlockRelatedByIdParent(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BlockPeer::DATABASE_NAME);
        }

        BlockPeer::addSelectColumns($criteria);
        $startcol2 = BlockPeer::NUM_HYDRATE_COLUMNS;

        ContentPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContentPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BlockPeer::ID_CONTENT, ContentPeer::ID_CONTENT, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BlockPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BlockPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BlockPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BlockPeer::addInstanceToPool($obj1, $key1);
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
                } // if $obj2 already loaded

                // Add the $obj1 (Block) to the collection in $obj2 (Content)
                $obj2->addBlock($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinAllExceptContent(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BlockPeer::DATABASE_NAME);
        }

        BlockPeer::addSelectColumns($criteria);
        $startcol2 = BlockPeer::NUM_HYDRATE_COLUMNS;


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BlockPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BlockPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BlockPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BlockPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

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
        return Propel::getDatabaseMap(BlockPeer::DATABASE_NAME)->getTable(BlockPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseBlockPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseBlockPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \BlockTableMap());
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
        return BlockPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Block or Criteria object.
     *
     * @param      mixed $values Criteria or Block object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Block object
        }

        if ($criteria->containsKey(BlockPeer::ID_BLOCK) && $criteria->keyContainsValue(BlockPeer::ID_BLOCK) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BlockPeer::ID_BLOCK.')');
        }


        // Set the correct dbName
        $criteria->setDbName(BlockPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Block or Criteria object.
     *
     * @param      mixed $values Criteria or Block object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(BlockPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(BlockPeer::ID_BLOCK);
            $value = $criteria->remove(BlockPeer::ID_BLOCK);
            if ($value) {
                $selectCriteria->add(BlockPeer::ID_BLOCK, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(BlockPeer::TABLE_NAME);
            }

        } else { // $values is Block object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(BlockPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the block table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(BlockPeer::TABLE_NAME, $con, BlockPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BlockPeer::clearInstancePool();
            BlockPeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            BlockPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Block) { // it's a model object
            // invalidate the cache for this single object
            BlockPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BlockPeer::DATABASE_NAME);
            $criteria->add(BlockPeer::ID_BLOCK, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                BlockPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(BlockPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            BlockPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Block object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Block $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(BlockPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(BlockPeer::TABLE_NAME);

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

        return BasePeer::doValidate(BlockPeer::DATABASE_NAME, BlockPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Block
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = BlockPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(BlockPeer::DATABASE_NAME);
        $criteria->add(BlockPeer::ID_BLOCK, $pk);

        $v = BlockPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Block[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BlockPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(BlockPeer::DATABASE_NAME);
            $criteria->add(BlockPeer::ID_BLOCK, $pks, Criteria::IN);
            $objs = BlockPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseBlockPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseBlockPeer::buildTableMap();

