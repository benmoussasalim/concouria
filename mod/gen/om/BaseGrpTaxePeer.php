<?php


/**
 * Base static class for performing query and update operations on the 'grp_taxe' table.
 *
 * Groupe de taxe
 *
 * @package propel.generator.gen.om
 */
abstract class BaseGrpTaxePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'grp_taxe';

    /** the related Propel class for this table */
    const OM_CLASS = 'GrpTaxe';

    /** the related TableMap class for this table */
    const TM_CLASS = 'GrpTaxeTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 10;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 8;

    const ID_GROUP_TAXE_SUP = 'grp_taxe.id_group_taxe_sup';

    const CALC_ID = 'grp_taxe.calc_id';

    const NAME = 'grp_taxe.name';

    const DEFAUT = 'grp_taxe.defaut';

    const EQUIVALENCE = 'grp_taxe.equivalence';

    const RATIO = 'grp_taxe.ratio';

    const DATE_CREATION = 'grp_taxe.date_creation';

    const DATE_MODIFICATION = 'grp_taxe.date_modification';

    const ID_CREATION = 'grp_taxe.id_creation';

    const ID_MODIFICATION = 'grp_taxe.id_modification';

    const DEFAUT_NON = 'Non';
    const DEFAUT_OUI = 'Oui';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of GrpTaxe objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array GrpTaxe[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. GrpTaxePeer::$fieldNames[GrpTaxePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdGroupTaxeSup', 'CalcId', 'Name', 'Defaut', 'Equivalence', 'Ratio', 'DateCreation', 'DateModification', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idGroupTaxeSup', 'calcId', 'name', 'defaut', 'equivalence', 'ratio', 'dateCreation', 'dateModification', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (GrpTaxePeer::ID_GROUP_TAXE_SUP, GrpTaxePeer::CALC_ID, GrpTaxePeer::NAME, GrpTaxePeer::DEFAUT, GrpTaxePeer::EQUIVALENCE, GrpTaxePeer::RATIO, GrpTaxePeer::DATE_CREATION, GrpTaxePeer::DATE_MODIFICATION, GrpTaxePeer::ID_CREATION, GrpTaxePeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_GROUP_TAXE_SUP', 'CALC_ID', 'NAME', 'DEFAUT', 'EQUIVALENCE', 'RATIO', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_group_taxe_sup', 'calc_id', 'name', 'defaut', 'equivalence', 'ratio', 'date_creation', 'date_modification', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. GrpTaxePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdGroupTaxeSup' => 0, 'CalcId' => 1, 'Name' => 2, 'Defaut' => 3, 'Equivalence' => 4, 'Ratio' => 5, 'DateCreation' => 6, 'DateModification' => 7, 'IdCreation' => 8, 'IdModification' => 9, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idGroupTaxeSup' => 0, 'calcId' => 1, 'name' => 2, 'defaut' => 3, 'equivalence' => 4, 'ratio' => 5, 'dateCreation' => 6, 'dateModification' => 7, 'idCreation' => 8, 'idModification' => 9, ),
        BasePeer::TYPE_COLNAME => array (GrpTaxePeer::ID_GROUP_TAXE_SUP => 0, GrpTaxePeer::CALC_ID => 1, GrpTaxePeer::NAME => 2, GrpTaxePeer::DEFAUT => 3, GrpTaxePeer::EQUIVALENCE => 4, GrpTaxePeer::RATIO => 5, GrpTaxePeer::DATE_CREATION => 6, GrpTaxePeer::DATE_MODIFICATION => 7, GrpTaxePeer::ID_CREATION => 8, GrpTaxePeer::ID_MODIFICATION => 9, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_GROUP_TAXE_SUP' => 0, 'CALC_ID' => 1, 'NAME' => 2, 'DEFAUT' => 3, 'EQUIVALENCE' => 4, 'RATIO' => 5, 'DATE_CREATION' => 6, 'DATE_MODIFICATION' => 7, 'ID_CREATION' => 8, 'ID_MODIFICATION' => 9, ),
        BasePeer::TYPE_FIELDNAME => array ('id_group_taxe_sup' => 0, 'calc_id' => 1, 'name' => 2, 'defaut' => 3, 'equivalence' => 4, 'ratio' => 5, 'date_creation' => 6, 'date_modification' => 7, 'id_creation' => 8, 'id_modification' => 9, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        GrpTaxePeer::DEFAUT => array(
            GrpTaxePeer::DEFAUT_NON,
            GrpTaxePeer::DEFAUT_OUI,
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
        $toNames = GrpTaxePeer::getFieldNames($toType);
        $key = isset(GrpTaxePeer::$fieldKeys[$fromType][$name]) ? GrpTaxePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(GrpTaxePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, GrpTaxePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return GrpTaxePeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return GrpTaxePeer::$enumValueSets;
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
        $valueSets = GrpTaxePeer::getValueSets();

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
        $values = GrpTaxePeer::getValueSet($colname);
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
     * @param      string $column The column name for current table. (i.e. GrpTaxePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(GrpTaxePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(GrpTaxePeer::ID_GROUP_TAXE_SUP);
            $criteria->addSelectColumn(GrpTaxePeer::CALC_ID);
            $criteria->addSelectColumn(GrpTaxePeer::NAME);
            $criteria->addSelectColumn(GrpTaxePeer::DEFAUT);
            $criteria->addSelectColumn(GrpTaxePeer::EQUIVALENCE);
            $criteria->addSelectColumn(GrpTaxePeer::RATIO);
            $criteria->addSelectColumn(GrpTaxePeer::ID_CREATION);
            $criteria->addSelectColumn(GrpTaxePeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_group_taxe_sup');
            $criteria->addSelectColumn($alias . '.calc_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.defaut');
            $criteria->addSelectColumn($alias . '.equivalence');
            $criteria->addSelectColumn($alias . '.ratio');
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
        $criteria->setPrimaryTableName(GrpTaxePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            GrpTaxePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(GrpTaxePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(GrpTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return GrpTaxe
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = GrpTaxePeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return GrpTaxePeer::populateObjects(GrpTaxePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(GrpTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            GrpTaxePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(GrpTaxePeer::DATABASE_NAME);

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
     * @param GrpTaxe $obj A GrpTaxe object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdGroupTaxeSup();
            } // if key === null
            GrpTaxePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A GrpTaxe object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof GrpTaxe) {
                $key = (string) $value->getIdGroupTaxeSup();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or GrpTaxe object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(GrpTaxePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return GrpTaxe Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(GrpTaxePeer::$instances[$key])) {
                return GrpTaxePeer::$instances[$key];
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
        foreach (GrpTaxePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        GrpTaxePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to grp_taxe
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {

        TaxePeer::clearInstancePool();
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
        $cls = GrpTaxePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = GrpTaxePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = GrpTaxePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GrpTaxePeer::addInstanceToPool($obj, $key);
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
     * @return array (GrpTaxe object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = GrpTaxePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = GrpTaxePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + GrpTaxePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GrpTaxePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            GrpTaxePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function getDefautSqlValue($enumVal)
    {
        return GrpTaxePeer::getSqlValueForEnum(GrpTaxePeer::DEFAUT, $enumVal);
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
        return Propel::getDatabaseMap(GrpTaxePeer::DATABASE_NAME)->getTable(GrpTaxePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseGrpTaxePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseGrpTaxePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \GrpTaxeTableMap());
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
        return GrpTaxePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a GrpTaxe or Criteria object.
     *
     * @param      mixed $values Criteria or GrpTaxe object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GrpTaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from GrpTaxe object
        }

        if ($criteria->containsKey(GrpTaxePeer::ID_GROUP_TAXE_SUP) && $criteria->keyContainsValue(GrpTaxePeer::ID_GROUP_TAXE_SUP) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GrpTaxePeer::ID_GROUP_TAXE_SUP.')');
        }


        // Set the correct dbName
        $criteria->setDbName(GrpTaxePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a GrpTaxe or Criteria object.
     *
     * @param      mixed $values Criteria or GrpTaxe object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GrpTaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(GrpTaxePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(GrpTaxePeer::ID_GROUP_TAXE_SUP);
            $value = $criteria->remove(GrpTaxePeer::ID_GROUP_TAXE_SUP);
            if ($value) {
                $selectCriteria->add(GrpTaxePeer::ID_GROUP_TAXE_SUP, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(GrpTaxePeer::TABLE_NAME);
            }

        } else { // $values is GrpTaxe object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(GrpTaxePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the grp_taxe table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GrpTaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(GrpTaxePeer::TABLE_NAME, $con, GrpTaxePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GrpTaxePeer::clearInstancePool();
            GrpTaxePeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(GrpTaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            GrpTaxePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof GrpTaxe) { // it's a model object
            // invalidate the cache for this single object
            GrpTaxePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GrpTaxePeer::DATABASE_NAME);
            $criteria->add(GrpTaxePeer::ID_GROUP_TAXE_SUP, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                GrpTaxePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(GrpTaxePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            GrpTaxePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given GrpTaxe object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param GrpTaxe $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(GrpTaxePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(GrpTaxePeer::TABLE_NAME);

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

        if ($obj->isNew() || $obj->isColumnModified(GrpTaxePeer::NAME))
            $columns[GrpTaxePeer::NAME] = $obj->getName();

        }

        return BasePeer::doValidate(GrpTaxePeer::DATABASE_NAME, GrpTaxePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return GrpTaxe
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = GrpTaxePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(GrpTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(GrpTaxePeer::DATABASE_NAME);
        $criteria->add(GrpTaxePeer::ID_GROUP_TAXE_SUP, $pk);

        $v = GrpTaxePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return GrpTaxe[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(GrpTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(GrpTaxePeer::DATABASE_NAME);
            $criteria->add(GrpTaxePeer::ID_GROUP_TAXE_SUP, $pks, Criteria::IN);
            $objs = GrpTaxePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseGrpTaxePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseGrpTaxePeer::buildTableMap();

