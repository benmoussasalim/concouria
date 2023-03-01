<?php


/**
 * Base class that represents a query for the 'authy_shortcut' table.
 *
 * Raccourcis
 *
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseAuthyShortcutQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAuthyShortcutQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = _PROJECT_NAME;
        }
        if (null === $modelName) {
            $modelName = 'AuthyShortcut';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AuthyShortcutQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AuthyShortcutQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AuthyShortcutQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AuthyShortcutQuery) {return $criteria;}
        $query = new AuthyShortcutQuery(null, null, $modelAlias);
        if ($criteria instanceof Criteria) { $query->mergeWith($criteria);}
        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   AuthyShortcut|AuthyShortcut[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AuthyShortcutPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AuthyShortcutPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 AuthyShortcut A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdAuthyShortcut($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 AuthyShortcut A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_authy_shortcut`, `name`, `id_authy`, `table_shortcut`, `id_name`, `type`, `origin`, `id_creation`, `id_modification` FROM `authy_shortcut` WHERE `id_authy_shortcut` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new AuthyShortcut();
            $obj->hydrate($row);
            AuthyShortcutPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return AuthyShortcut|AuthyShortcut[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|AuthyShortcut[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AuthyShortcutPeer::ID_AUTHY_SHORTCUT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AuthyShortcutPeer::ID_AUTHY_SHORTCUT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_authy_shortcut column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAuthyShortcut(1234); // WHERE id_authy_shortcut = 1234
     * $query->filterByIdAuthyShortcut(array(12, 34)); // WHERE id_authy_shortcut IN (12, 34)
     * $query->filterByIdAuthyShortcut(array('min' => 12)); // WHERE id_authy_shortcut >= 12
     * $query->filterByIdAuthyShortcut(array('max' => 12)); // WHERE id_authy_shortcut <= 12
     * </code>
     *
     * @param     mixed $idAuthyShortcut The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByIdAuthyShortcut($idAuthyShortcut = null, $comparison = null)
    {
        if (is_array($idAuthyShortcut)) {
            $useMinMax = false;
            if (isset($idAuthyShortcut['min'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_AUTHY_SHORTCUT, $idAuthyShortcut['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAuthyShortcut['max'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_AUTHY_SHORTCUT, $idAuthyShortcut['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::ID_AUTHY_SHORTCUT, $idAuthyShortcut, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the id_authy column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAuthy(1234); // WHERE id_authy = 1234
     * $query->filterByIdAuthy(array(12, 34)); // WHERE id_authy IN (12, 34)
     * $query->filterByIdAuthy(array('min' => 12)); // WHERE id_authy >= 12
     * $query->filterByIdAuthy(array('max' => 12)); // WHERE id_authy <= 12
     * </code>
     *
     * @see       filterByAuthy()
     *
     * @param     mixed $idAuthy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByIdAuthy($idAuthy = null, $comparison = null)
    {
        if (is_array($idAuthy)) {
            $useMinMax = false;
            if (isset($idAuthy['min'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_AUTHY, $idAuthy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAuthy['max'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_AUTHY, $idAuthy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::ID_AUTHY, $idAuthy, $comparison);
    }

    /**
     * Filter the query on the table_shortcut column
     *
     * Example usage:
     * <code>
     * $query->filterByTableShortcut('fooValue');   // WHERE table_shortcut = 'fooValue'
     * $query->filterByTableShortcut('%fooValue%'); // WHERE table_shortcut LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tableShortcut The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByTableShortcut($tableShortcut = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tableShortcut)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tableShortcut)) {
                $tableShortcut = str_replace('*', '%', $tableShortcut);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::TABLE_SHORTCUT, $tableShortcut, $comparison);
    }

    /**
     * Filter the query on the id_name column
     *
     * Example usage:
     * <code>
     * $query->filterByIdName(1234); // WHERE id_name = 1234
     * $query->filterByIdName(array(12, 34)); // WHERE id_name IN (12, 34)
     * $query->filterByIdName(array('min' => 12)); // WHERE id_name >= 12
     * $query->filterByIdName(array('max' => 12)); // WHERE id_name <= 12
     * </code>
     *
     * @param     mixed $idName The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByIdName($idName = null, $comparison = null)
    {
        if (is_array($idName)) {
            $useMinMax = false;
            if (isset($idName['min'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_NAME, $idName['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idName['max'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_NAME, $idName['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::ID_NAME, $idName, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_scalar($type)) {
            $type = AuthyShortcutPeer::getSqlValueForEnum(AuthyShortcutPeer::TYPE, $type);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                $convertedValues[] = AuthyShortcutPeer::getSqlValueForEnum(AuthyShortcutPeer::TYPE, $value);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the origin column
     *
     * Example usage:
     * <code>
     * $query->filterByOrigin('fooValue');   // WHERE origin = 'fooValue'
     * $query->filterByOrigin('%fooValue%'); // WHERE origin LIKE '%fooValue%'
     * </code>
     *
     * @param     string $origin The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByOrigin($origin = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($origin)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $origin)) {
                $origin = str_replace('*', '%', $origin);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::ORIGIN, $origin, $comparison);
    }

    /**
     * Filter the query on the date_creation column
     *
     * Example usage:
     * <code>
     * $query->filterByDateCreation('2011-03-14'); // WHERE date_creation = '2011-03-14'
     * $query->filterByDateCreation('now'); // WHERE date_creation = '2011-03-14'
     * $query->filterByDateCreation(array('max' => 'yesterday')); // WHERE date_creation < '2011-03-13'
     * </code>
     *
     * @param     mixed $dateCreation The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(AuthyShortcutPeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(AuthyShortcutPeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::DATE_CREATION, $dateCreation, $comparison);
    }

    /**
     * Filter the query on the date_modification column
     *
     * Example usage:
     * <code>
     * $query->filterByDateModification('2011-03-14'); // WHERE date_modification = '2011-03-14'
     * $query->filterByDateModification('now'); // WHERE date_modification = '2011-03-14'
     * $query->filterByDateModification(array('max' => 'yesterday')); // WHERE date_modification < '2011-03-13'
     * </code>
     *
     * @param     mixed $dateModification The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(AuthyShortcutPeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(AuthyShortcutPeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::DATE_MODIFICATION, $dateModification, $comparison);
    }

    /**
     * Filter the query on the id_creation column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCreation(1234); // WHERE id_creation = 1234
     * $query->filterByIdCreation(array(12, 34)); // WHERE id_creation IN (12, 34)
     * $query->filterByIdCreation(array('min' => 12)); // WHERE id_creation >= 12
     * $query->filterByIdCreation(array('max' => 12)); // WHERE id_creation <= 12
     * </code>
     *
     * @param     mixed $idCreation The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::ID_CREATION, $idCreation, $comparison);
    }

    /**
     * Filter the query on the id_modification column
     *
     * Example usage:
     * <code>
     * $query->filterByIdModification(1234); // WHERE id_modification = 1234
     * $query->filterByIdModification(array(12, 34)); // WHERE id_modification IN (12, 34)
     * $query->filterByIdModification(array('min' => 12)); // WHERE id_modification >= 12
     * $query->filterByIdModification(array('max' => 12)); // WHERE id_modification <= 12
     * </code>
     *
     * @param     mixed $idModification The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(AuthyShortcutPeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyShortcutPeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related Authy object
     *
     * @param   Authy|PropelObjectCollection $authy The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyShortcutQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthy($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AuthyShortcutPeer::ID_AUTHY, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthyShortcutPeer::ID_AUTHY, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
        } else {
            throw new PropelException('filterByAuthy() only accepts arguments of type Authy or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Authy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function joinAuthy($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Authy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Authy');
        }

        return $this;
    }

    /**
     * Use the Authy relation Authy object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   AuthyQuery A secondary query class using the current class as primary query
     */
    public function useAuthyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuthy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Authy', 'AuthyQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   AuthyShortcut $authyShortcut Object to remove from the list of results
     *
     * @return AuthyShortcutQuery The current query, for fluid interface
     */
    public function prune($authyShortcut = null)
    {
        if ($authyShortcut) {
            $this->addUsingAlias(AuthyShortcutPeer::ID_AUTHY_SHORTCUT, $authyShortcut->getIdAuthyShortcut(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // TableStampBehavior behavior

    /**Filter by the latest updated
     * @param      int $nbDays Maximum age of the latest update in days
     * @return     AuthyShortcutQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(AuthyShortcutPeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by update date desc
     * @return     AuthyShortcutQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(AuthyShortcutPeer::DATE_MODIFICATION);
    }

    /**Order by update date asc
     * @return     AuthyShortcutQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(AuthyShortcutPeer::DATE_MODIFICATION);
    }

    /**Filter by the latest created
     * @param      int $nbDays Maximum age of in days
     * @return     AuthyShortcutQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(AuthyShortcutPeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by create date desc
     * @return     AuthyShortcutQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(AuthyShortcutPeer::DATE_CREATION);
    }

    /**Order by create date asc
     * @return     AuthyShortcutQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(AuthyShortcutPeer::DATE_CREATION);
    }
}
