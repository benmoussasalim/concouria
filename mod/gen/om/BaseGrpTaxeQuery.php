<?php


/**
 * Base class that represents a query for the 'grp_taxe' table.
 *
 * Groupe de taxe
 *
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseGrpTaxeQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseGrpTaxeQuery object.
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
            $modelName = 'GrpTaxe';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new GrpTaxeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   GrpTaxeQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return GrpTaxeQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof GrpTaxeQuery) {return $criteria;}
        $query = new GrpTaxeQuery(null, null, $modelAlias);
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
     * @return   GrpTaxe|GrpTaxe[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GrpTaxePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(GrpTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 GrpTaxe A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdGroupTaxeSup($key, $con = null)
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
     * @return                 GrpTaxe A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_group_taxe_sup`, `calc_id`, `name`, `defaut`, `equivalence`, `ratio`, `id_creation`, `id_modification` FROM `grp_taxe` WHERE `id_group_taxe_sup` = :p0';
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
            $obj = new GrpTaxe();
            $obj->hydrate($row);
            GrpTaxePeer::addInstanceToPool($obj, (string) $key);
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
     * @return GrpTaxe|GrpTaxe[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|GrpTaxe[]|mixed the list of results, formatted by the current formatter
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
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GrpTaxePeer::ID_GROUP_TAXE_SUP, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GrpTaxePeer::ID_GROUP_TAXE_SUP, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_group_taxe_sup column
     *
     * Example usage:
     * <code>
     * $query->filterByIdGroupTaxeSup(1234); // WHERE id_group_taxe_sup = 1234
     * $query->filterByIdGroupTaxeSup(array(12, 34)); // WHERE id_group_taxe_sup IN (12, 34)
     * $query->filterByIdGroupTaxeSup(array('min' => 12)); // WHERE id_group_taxe_sup >= 12
     * $query->filterByIdGroupTaxeSup(array('max' => 12)); // WHERE id_group_taxe_sup <= 12
     * </code>
     *
     * @param     mixed $idGroupTaxeSup The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByIdGroupTaxeSup($idGroupTaxeSup = null, $comparison = null)
    {
        if (is_array($idGroupTaxeSup)) {
            $useMinMax = false;
            if (isset($idGroupTaxeSup['min'])) {
                $this->addUsingAlias(GrpTaxePeer::ID_GROUP_TAXE_SUP, $idGroupTaxeSup['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGroupTaxeSup['max'])) {
                $this->addUsingAlias(GrpTaxePeer::ID_GROUP_TAXE_SUP, $idGroupTaxeSup['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrpTaxePeer::ID_GROUP_TAXE_SUP, $idGroupTaxeSup, $comparison);
    }

    /**
     * Filter the query on the calc_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCalcId('fooValue');   // WHERE calc_id = 'fooValue'
     * $query->filterByCalcId('%fooValue%'); // WHERE calc_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $calcId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByCalcId($calcId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($calcId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $calcId)) {
                $calcId = str_replace('*', '%', $calcId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GrpTaxePeer::CALC_ID, $calcId, $comparison);
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
     * @return GrpTaxeQuery The current query, for fluid interface
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

        return $this->addUsingAlias(GrpTaxePeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the defaut column
     *
     * @param     mixed $defaut The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GrpTaxeQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByDefaut($defaut = null, $comparison = null)
    {
        if (is_scalar($defaut)) {
            $defaut = GrpTaxePeer::getSqlValueForEnum(GrpTaxePeer::DEFAUT, $defaut);
        } elseif (is_array($defaut)) {
            $convertedValues = array();
            foreach ($defaut as $value) {
                $convertedValues[] = GrpTaxePeer::getSqlValueForEnum(GrpTaxePeer::DEFAUT, $value);
            }
            $defaut = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrpTaxePeer::DEFAUT, $defaut, $comparison);
    }

    /**
     * Filter the query on the equivalence column
     *
     * Example usage:
     * <code>
     * $query->filterByEquivalence(1234); // WHERE equivalence = 1234
     * $query->filterByEquivalence(array(12, 34)); // WHERE equivalence IN (12, 34)
     * $query->filterByEquivalence(array('min' => 12)); // WHERE equivalence >= 12
     * $query->filterByEquivalence(array('max' => 12)); // WHERE equivalence <= 12
     * </code>
     *
     * @param     mixed $equivalence The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByEquivalence($equivalence = null, $comparison = null)
    {
        if (is_array($equivalence)) {
            $useMinMax = false;
            if (isset($equivalence['min'])) {
                $this->addUsingAlias(GrpTaxePeer::EQUIVALENCE, $equivalence['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($equivalence['max'])) {
                $this->addUsingAlias(GrpTaxePeer::EQUIVALENCE, $equivalence['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrpTaxePeer::EQUIVALENCE, $equivalence, $comparison);
    }

    /**
     * Filter the query on the ratio column
     *
     * Example usage:
     * <code>
     * $query->filterByRatio(1234); // WHERE ratio = 1234
     * $query->filterByRatio(array(12, 34)); // WHERE ratio IN (12, 34)
     * $query->filterByRatio(array('min' => 12)); // WHERE ratio >= 12
     * $query->filterByRatio(array('max' => 12)); // WHERE ratio <= 12
     * </code>
     *
     * @param     mixed $ratio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByRatio($ratio = null, $comparison = null)
    {
        if (is_array($ratio)) {
            $useMinMax = false;
            if (isset($ratio['min'])) {
                $this->addUsingAlias(GrpTaxePeer::RATIO, $ratio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ratio['max'])) {
                $this->addUsingAlias(GrpTaxePeer::RATIO, $ratio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrpTaxePeer::RATIO, $ratio, $comparison);
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
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(GrpTaxePeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(GrpTaxePeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrpTaxePeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(GrpTaxePeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(GrpTaxePeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrpTaxePeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(GrpTaxePeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(GrpTaxePeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrpTaxePeer::ID_CREATION, $idCreation, $comparison);
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
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(GrpTaxePeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(GrpTaxePeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrpTaxePeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related Taxe object
     *
     * @param   Taxe|PropelObjectCollection $taxe  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 GrpTaxeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTaxe($taxe, $comparison = null)
    {
        if ($taxe instanceof Taxe) {
            return $this
                ->addUsingAlias(GrpTaxePeer::ID_GROUP_TAXE_SUP, $taxe->getIdGroupTaxeSup(), $comparison);
        } elseif ($taxe instanceof PropelObjectCollection) {
            return $this
                ->useTaxeQuery()
                ->filterByPrimaryKeys($taxe->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTaxe() only accepts arguments of type Taxe or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Taxe relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function joinTaxe($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Taxe');

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
            $this->addJoinObject($join, 'Taxe');
        }

        return $this;
    }

    /**
     * Use the Taxe relation Taxe object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   TaxeQuery A secondary query class using the current class as primary query
     */
    public function useTaxeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTaxe($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Taxe', 'TaxeQuery');
    }

    /**
     * Filter the query by a related Province object
     *
     * @param   Province|PropelObjectCollection $province  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 GrpTaxeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProvince($province, $comparison = null)
    {
        if ($province instanceof Province) {
            return $this
                ->addUsingAlias(GrpTaxePeer::ID_GROUP_TAXE_SUP, $province->getIdGrpTaxe(), $comparison);
        } elseif ($province instanceof PropelObjectCollection) {
            return $this
                ->useProvinceQuery()
                ->filterByPrimaryKeys($province->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProvince() only accepts arguments of type Province or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Province relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function joinProvince($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Province');

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
            $this->addJoinObject($join, 'Province');
        }

        return $this;
    }

    /**
     * Use the Province relation Province object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   ProvinceQuery A secondary query class using the current class as primary query
     */
    public function useProvinceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProvince($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Province', 'ProvinceQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   GrpTaxe $grpTaxe Object to remove from the list of results
     *
     * @return GrpTaxeQuery The current query, for fluid interface
     */
    public function prune($grpTaxe = null)
    {
        if ($grpTaxe) {
            $this->addUsingAlias(GrpTaxePeer::ID_GROUP_TAXE_SUP, $grpTaxe->getIdGroupTaxeSup(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // TableStampBehavior behavior

    /**Filter by the latest updated
     * @param      int $nbDays Maximum age of the latest update in days
     * @return     GrpTaxeQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(GrpTaxePeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by update date desc
     * @return     GrpTaxeQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(GrpTaxePeer::DATE_MODIFICATION);
    }

    /**Order by update date asc
     * @return     GrpTaxeQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(GrpTaxePeer::DATE_MODIFICATION);
    }

    /**Filter by the latest created
     * @param      int $nbDays Maximum age of in days
     * @return     GrpTaxeQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(GrpTaxePeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by create date desc
     * @return     GrpTaxeQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(GrpTaxePeer::DATE_CREATION);
    }

    /**Order by create date asc
     * @return     GrpTaxeQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(GrpTaxePeer::DATE_CREATION);
    }
}
