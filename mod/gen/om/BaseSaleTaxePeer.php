<?php


/**
 * Base static class for performing query and update operations on the 'sale_taxe' table.
 *
 * Taxe
 *
 * @package propel.generator.gen.om
 */
abstract class BaseSaleTaxePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = _PROJECT_NAME;

    /** the table name for this class */
    const TABLE_NAME = 'sale_taxe';

    /** the related Propel class for this table */
    const OM_CLASS = 'SaleTaxe';

    /** the related TableMap class for this table */
    const TM_CLASS = 'SaleTaxeTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 10;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 2;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 8;

    const ID_SALE_TAXE = 'sale_taxe.id_sale_taxe';

    const ID_ABONNEMENT = 'sale_taxe.id_abonnement';

    const ID_TAXE = 'sale_taxe.id_taxe';

    const NAME = 'sale_taxe.name';

    const POURCENT = 'sale_taxe.pourcent';

    const MONTANT = 'sale_taxe.montant';

    const DATE_CREATION = 'sale_taxe.date_creation';

    const DATE_MODIFICATION = 'sale_taxe.date_modification';

    const ID_CREATION = 'sale_taxe.id_creation';

    const ID_MODIFICATION = 'sale_taxe.id_modification';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of SaleTaxe objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array SaleTaxe[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. SaleTaxePeer::$fieldNames[SaleTaxePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('IdSaleTaxe', 'IdAbonnement', 'IdTaxe', 'Name', 'Pourcent', 'Montant', 'DateCreation', 'DateModification', 'IdCreation', 'IdModification', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idSaleTaxe', 'idAbonnement', 'idTaxe', 'name', 'pourcent', 'montant', 'dateCreation', 'dateModification', 'idCreation', 'idModification', ),
        BasePeer::TYPE_COLNAME => array (SaleTaxePeer::ID_SALE_TAXE, SaleTaxePeer::ID_ABONNEMENT, SaleTaxePeer::ID_TAXE, SaleTaxePeer::NAME, SaleTaxePeer::POURCENT, SaleTaxePeer::MONTANT, SaleTaxePeer::DATE_CREATION, SaleTaxePeer::DATE_MODIFICATION, SaleTaxePeer::ID_CREATION, SaleTaxePeer::ID_MODIFICATION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_SALE_TAXE', 'ID_ABONNEMENT', 'ID_TAXE', 'NAME', 'POURCENT', 'MONTANT', 'DATE_CREATION', 'DATE_MODIFICATION', 'ID_CREATION', 'ID_MODIFICATION', ),
        BasePeer::TYPE_FIELDNAME => array ('id_sale_taxe', 'id_abonnement', 'id_taxe', 'name', 'pourcent', 'montant', 'date_creation', 'date_modification', 'id_creation', 'id_modification', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. SaleTaxePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('IdSaleTaxe' => 0, 'IdAbonnement' => 1, 'IdTaxe' => 2, 'Name' => 3, 'Pourcent' => 4, 'Montant' => 5, 'DateCreation' => 6, 'DateModification' => 7, 'IdCreation' => 8, 'IdModification' => 9, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('idSaleTaxe' => 0, 'idAbonnement' => 1, 'idTaxe' => 2, 'name' => 3, 'pourcent' => 4, 'montant' => 5, 'dateCreation' => 6, 'dateModification' => 7, 'idCreation' => 8, 'idModification' => 9, ),
        BasePeer::TYPE_COLNAME => array (SaleTaxePeer::ID_SALE_TAXE => 0, SaleTaxePeer::ID_ABONNEMENT => 1, SaleTaxePeer::ID_TAXE => 2, SaleTaxePeer::NAME => 3, SaleTaxePeer::POURCENT => 4, SaleTaxePeer::MONTANT => 5, SaleTaxePeer::DATE_CREATION => 6, SaleTaxePeer::DATE_MODIFICATION => 7, SaleTaxePeer::ID_CREATION => 8, SaleTaxePeer::ID_MODIFICATION => 9, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID_SALE_TAXE' => 0, 'ID_ABONNEMENT' => 1, 'ID_TAXE' => 2, 'NAME' => 3, 'POURCENT' => 4, 'MONTANT' => 5, 'DATE_CREATION' => 6, 'DATE_MODIFICATION' => 7, 'ID_CREATION' => 8, 'ID_MODIFICATION' => 9, ),
        BasePeer::TYPE_FIELDNAME => array ('id_sale_taxe' => 0, 'id_abonnement' => 1, 'id_taxe' => 2, 'name' => 3, 'pourcent' => 4, 'montant' => 5, 'date_creation' => 6, 'date_modification' => 7, 'id_creation' => 8, 'id_modification' => 9, ),
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
        $toNames = SaleTaxePeer::getFieldNames($toType);
        $key = isset(SaleTaxePeer::$fieldKeys[$fromType][$name]) ? SaleTaxePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(SaleTaxePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, SaleTaxePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return SaleTaxePeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. SaleTaxePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(SaleTaxePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(SaleTaxePeer::ID_SALE_TAXE);
            $criteria->addSelectColumn(SaleTaxePeer::ID_ABONNEMENT);
            $criteria->addSelectColumn(SaleTaxePeer::ID_TAXE);
            $criteria->addSelectColumn(SaleTaxePeer::NAME);
            $criteria->addSelectColumn(SaleTaxePeer::POURCENT);
            $criteria->addSelectColumn(SaleTaxePeer::MONTANT);
            $criteria->addSelectColumn(SaleTaxePeer::ID_CREATION);
            $criteria->addSelectColumn(SaleTaxePeer::ID_MODIFICATION);
        } else {
            $criteria->addSelectColumn($alias . '.id_sale_taxe');
            $criteria->addSelectColumn($alias . '.id_abonnement');
            $criteria->addSelectColumn($alias . '.id_taxe');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.pourcent');
            $criteria->addSelectColumn($alias . '.montant');
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
        $criteria->setPrimaryTableName(SaleTaxePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SaleTaxePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return SaleTaxe
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = SaleTaxePeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }

    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return SaleTaxePeer::populateObjects(SaleTaxePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            SaleTaxePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);

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
     * @param SaleTaxe $obj A SaleTaxe object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getIdSaleTaxe();
            } // if key === null
            SaleTaxePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A SaleTaxe object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof SaleTaxe) {
                $key = (string) $value->getIdSaleTaxe();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or SaleTaxe object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(SaleTaxePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return SaleTaxe Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(SaleTaxePeer::$instances[$key])) {
                return SaleTaxePeer::$instances[$key];
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
        foreach (SaleTaxePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        SaleTaxePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to sale_taxe
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
        $cls = SaleTaxePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = SaleTaxePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = SaleTaxePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SaleTaxePeer::addInstanceToPool($obj, $key);
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
     * @return array (SaleTaxe object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = SaleTaxePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = SaleTaxePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + SaleTaxePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SaleTaxePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            SaleTaxePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    public static function doCountJoinAbonnement(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(SaleTaxePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SaleTaxePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(SaleTaxePeer::ID_ABONNEMENT, AbonnementPeer::ID_ABONNEMENT, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    public static function doCountJoinTaxe(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(SaleTaxePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SaleTaxePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(SaleTaxePeer::ID_TAXE, TaxePeer::ID_TAXE, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinAbonnement(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);
        }

        SaleTaxePeer::addSelectColumns($criteria);
        $startcol = SaleTaxePeer::NUM_HYDRATE_COLUMNS;
        AbonnementPeer::addSelectColumns($criteria);

        $criteria->addJoin(SaleTaxePeer::ID_ABONNEMENT, AbonnementPeer::ID_ABONNEMENT, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = SaleTaxePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = SaleTaxePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = SaleTaxePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                SaleTaxePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AbonnementPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AbonnementPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AbonnementPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AbonnementPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (SaleTaxe) to $obj2 (Abonnement)
                $obj2->addSaleTaxe($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinTaxe(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);
        }

        SaleTaxePeer::addSelectColumns($criteria);
        $startcol = SaleTaxePeer::NUM_HYDRATE_COLUMNS;
        TaxePeer::addSelectColumns($criteria);

        $criteria->addJoin(SaleTaxePeer::ID_TAXE, TaxePeer::ID_TAXE, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = SaleTaxePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = SaleTaxePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = SaleTaxePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                SaleTaxePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = TaxePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = TaxePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = TaxePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    TaxePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (SaleTaxe) to $obj2 (Taxe)
                $obj2->addSaleTaxe($obj1);

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
        $criteria->setPrimaryTableName(SaleTaxePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SaleTaxePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(SaleTaxePeer::ID_ABONNEMENT, AbonnementPeer::ID_ABONNEMENT, $join_behavior);

        $criteria->addJoin(SaleTaxePeer::ID_TAXE, TaxePeer::ID_TAXE, $join_behavior);

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
            $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);
        }

        SaleTaxePeer::addSelectColumns($criteria);
        $startcol2 = SaleTaxePeer::NUM_HYDRATE_COLUMNS;

        AbonnementPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AbonnementPeer::NUM_HYDRATE_COLUMNS;

        TaxePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + TaxePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(SaleTaxePeer::ID_ABONNEMENT, AbonnementPeer::ID_ABONNEMENT, $join_behavior);

        $criteria->addJoin(SaleTaxePeer::ID_TAXE, TaxePeer::ID_TAXE, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = SaleTaxePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = SaleTaxePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = SaleTaxePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                SaleTaxePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Abonnement rows

            $key2 = AbonnementPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AbonnementPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AbonnementPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AbonnementPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (SaleTaxe) to the collection in $obj2 (Abonnement)
                $obj2->addSaleTaxe($obj1);
            } // if joined row not null

            // Add objects for joined Taxe rows

            $key3 = TaxePeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = TaxePeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = TaxePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    TaxePeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (SaleTaxe) to the collection in $obj3 (Taxe)
                $obj3->addSaleTaxe($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doCountJoinAllExceptAbonnement(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(SaleTaxePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SaleTaxePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(SaleTaxePeer::ID_TAXE, TaxePeer::ID_TAXE, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doCountJoinAllExceptTaxe(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(SaleTaxePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SaleTaxePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(SaleTaxePeer::ID_ABONNEMENT, AbonnementPeer::ID_ABONNEMENT, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }



    public static function doSelectJoinAllExceptAbonnement(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);
        }

        SaleTaxePeer::addSelectColumns($criteria);
        $startcol2 = SaleTaxePeer::NUM_HYDRATE_COLUMNS;

        TaxePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + TaxePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(SaleTaxePeer::ID_TAXE, TaxePeer::ID_TAXE, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = SaleTaxePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = SaleTaxePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = SaleTaxePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                SaleTaxePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Taxe rows

                $key2 = TaxePeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = TaxePeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = TaxePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    TaxePeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (SaleTaxe) to the collection in $obj2 (Taxe)
                $obj2->addSaleTaxe($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }



    public static function doSelectJoinAllExceptTaxe(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);
        }

        SaleTaxePeer::addSelectColumns($criteria);
        $startcol2 = SaleTaxePeer::NUM_HYDRATE_COLUMNS;

        AbonnementPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AbonnementPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(SaleTaxePeer::ID_ABONNEMENT, AbonnementPeer::ID_ABONNEMENT, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = SaleTaxePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = SaleTaxePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = SaleTaxePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                SaleTaxePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Abonnement rows

                $key2 = AbonnementPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AbonnementPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AbonnementPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AbonnementPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (SaleTaxe) to the collection in $obj2 (Abonnement)
                $obj2->addSaleTaxe($obj1);

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
        return Propel::getDatabaseMap(SaleTaxePeer::DATABASE_NAME)->getTable(SaleTaxePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseSaleTaxePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseSaleTaxePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \SaleTaxeTableMap());
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
        return SaleTaxePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a SaleTaxe or Criteria object.
     *
     * @param      mixed $values Criteria or SaleTaxe object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from SaleTaxe object
        }

        if ($criteria->containsKey(SaleTaxePeer::ID_SALE_TAXE) && $criteria->keyContainsValue(SaleTaxePeer::ID_SALE_TAXE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SaleTaxePeer::ID_SALE_TAXE.')');
        }


        // Set the correct dbName
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a SaleTaxe or Criteria object.
     *
     * @param      mixed $values Criteria or SaleTaxe object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(SaleTaxePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(SaleTaxePeer::ID_SALE_TAXE);
            $value = $criteria->remove(SaleTaxePeer::ID_SALE_TAXE);
            if ($value) {
                $selectCriteria->add(SaleTaxePeer::ID_SALE_TAXE, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(SaleTaxePeer::TABLE_NAME);
            }

        } else { // $values is SaleTaxe object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the sale_taxe table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(SaleTaxePeer::TABLE_NAME, $con, SaleTaxePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SaleTaxePeer::clearInstancePool();
            SaleTaxePeer::clearRelatedInstancePool();
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
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            SaleTaxePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof SaleTaxe) { // it's a model object
            // invalidate the cache for this single object
            SaleTaxePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SaleTaxePeer::DATABASE_NAME);
            $criteria->add(SaleTaxePeer::ID_SALE_TAXE, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                SaleTaxePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(SaleTaxePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            SaleTaxePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given SaleTaxe object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param SaleTaxe $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(SaleTaxePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(SaleTaxePeer::TABLE_NAME);

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

        return BasePeer::doValidate(SaleTaxePeer::DATABASE_NAME, SaleTaxePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return SaleTaxe
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = SaleTaxePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(SaleTaxePeer::DATABASE_NAME);
        $criteria->add(SaleTaxePeer::ID_SALE_TAXE, $pk);

        $v = SaleTaxePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return SaleTaxe[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(SaleTaxePeer::DATABASE_NAME);
            $criteria->add(SaleTaxePeer::ID_SALE_TAXE, $pks, Criteria::IN);
            $objs = SaleTaxePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseSaleTaxePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseSaleTaxePeer::buildTableMap();

