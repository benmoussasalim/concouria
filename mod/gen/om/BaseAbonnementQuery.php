<?php


/**
 * Base class that represents a query for the 'abonnement' table.
 *
 * Renouvellement
 *
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseAbonnementQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAbonnementQuery object.
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
            $modelName = 'Abonnement';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AbonnementQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AbonnementQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AbonnementQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AbonnementQuery) {return $criteria;}
        $query = new AbonnementQuery(null, null, $modelAlias);
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
     * @return   Abonnement|Abonnement[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AbonnementPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AbonnementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Abonnement A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdAbonnement($key, $con = null)
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
     * @return                 Abonnement A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_abonnement`, `id_sale`, `date_paiement`, `sub_amount`, `amount`, `abonnement_price`, `stripe_response`, `type`, `id_creation`, `id_modification` FROM `abonnement` WHERE `id_abonnement` = :p0';
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
            $obj = new Abonnement();
            $obj->hydrate($row);
            AbonnementPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Abonnement|Abonnement[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Abonnement[]|mixed the list of results, formatted by the current formatter
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
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AbonnementPeer::ID_ABONNEMENT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AbonnementPeer::ID_ABONNEMENT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_abonnement column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAbonnement(1234); // WHERE id_abonnement = 1234
     * $query->filterByIdAbonnement(array(12, 34)); // WHERE id_abonnement IN (12, 34)
     * $query->filterByIdAbonnement(array('min' => 12)); // WHERE id_abonnement >= 12
     * $query->filterByIdAbonnement(array('max' => 12)); // WHERE id_abonnement <= 12
     * </code>
     *
     * @param     mixed $idAbonnement The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByIdAbonnement($idAbonnement = null, $comparison = null)
    {
        if (is_array($idAbonnement)) {
            $useMinMax = false;
            if (isset($idAbonnement['min'])) {
                $this->addUsingAlias(AbonnementPeer::ID_ABONNEMENT, $idAbonnement['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAbonnement['max'])) {
                $this->addUsingAlias(AbonnementPeer::ID_ABONNEMENT, $idAbonnement['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::ID_ABONNEMENT, $idAbonnement, $comparison);
    }

    /**
     * Filter the query on the id_sale column
     *
     * Example usage:
     * <code>
     * $query->filterByIdSale(1234); // WHERE id_sale = 1234
     * $query->filterByIdSale(array(12, 34)); // WHERE id_sale IN (12, 34)
     * $query->filterByIdSale(array('min' => 12)); // WHERE id_sale >= 12
     * $query->filterByIdSale(array('max' => 12)); // WHERE id_sale <= 12
     * </code>
     *
     * @see       filterBySale()
     *
     * @param     mixed $idSale The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByIdSale($idSale = null, $comparison = null)
    {
        if (is_array($idSale)) {
            $useMinMax = false;
            if (isset($idSale['min'])) {
                $this->addUsingAlias(AbonnementPeer::ID_SALE, $idSale['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSale['max'])) {
                $this->addUsingAlias(AbonnementPeer::ID_SALE, $idSale['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::ID_SALE, $idSale, $comparison);
    }

    /**
     * Filter the query on the date_paiement column
     *
     * Example usage:
     * <code>
     * $query->filterByDatePaiement('2011-03-14'); // WHERE date_paiement = '2011-03-14'
     * $query->filterByDatePaiement('now'); // WHERE date_paiement = '2011-03-14'
     * $query->filterByDatePaiement(array('max' => 'yesterday')); // WHERE date_paiement < '2011-03-13'
     * </code>
     *
     * @param     mixed $datePaiement The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByDatePaiement($datePaiement = null, $comparison = null)
    {
        if (is_array($datePaiement)) {
            $useMinMax = false;
            if (isset($datePaiement['min'])) {
                $this->addUsingAlias(AbonnementPeer::DATE_PAIEMENT, $datePaiement['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datePaiement['max'])) {
                $this->addUsingAlias(AbonnementPeer::DATE_PAIEMENT, $datePaiement['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::DATE_PAIEMENT, $datePaiement, $comparison);
    }

    /**
     * Filter the query on the sub_amount column
     *
     * Example usage:
     * <code>
     * $query->filterBySubAmount('fooValue');   // WHERE sub_amount = 'fooValue'
     * $query->filterBySubAmount('%fooValue%'); // WHERE sub_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterBySubAmount($subAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $subAmount)) {
                $subAmount = str_replace('*', '%', $subAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::SUB_AMOUNT, $subAmount, $comparison);
    }

    /**
     * Filter the query on the amount column
     *
     * Example usage:
     * <code>
     * $query->filterByAmount('fooValue');   // WHERE amount = 'fooValue'
     * $query->filterByAmount('%fooValue%'); // WHERE amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $amount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByAmount($amount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($amount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $amount)) {
                $amount = str_replace('*', '%', $amount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::AMOUNT, $amount, $comparison);
    }

    /**
     * Filter the query on the abonnement_price column
     *
     * Example usage:
     * <code>
     * $query->filterByAbonnementPrice('fooValue');   // WHERE abonnement_price = 'fooValue'
     * $query->filterByAbonnementPrice('%fooValue%'); // WHERE abonnement_price LIKE '%fooValue%'
     * </code>
     *
     * @param     string $abonnementPrice The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByAbonnementPrice($abonnementPrice = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($abonnementPrice)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $abonnementPrice)) {
                $abonnementPrice = str_replace('*', '%', $abonnementPrice);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::ABONNEMENT_PRICE, $abonnementPrice, $comparison);
    }

    /**
     * Filter the query on the stripe_response column
     *
     * Example usage:
     * <code>
     * $query->filterByStripeResponse('fooValue');   // WHERE stripe_response = 'fooValue'
     * $query->filterByStripeResponse('%fooValue%'); // WHERE stripe_response LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stripeResponse The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByStripeResponse($stripeResponse = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stripeResponse)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $stripeResponse)) {
                $stripeResponse = str_replace('*', '%', $stripeResponse);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::STRIPE_RESPONSE, $stripeResponse, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AbonnementQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_scalar($type)) {
            $type = AbonnementPeer::getSqlValueForEnum(AbonnementPeer::TYPE, $type);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                $convertedValues[] = AbonnementPeer::getSqlValueForEnum(AbonnementPeer::TYPE, $value);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::TYPE, $type, $comparison);
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
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(AbonnementPeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(AbonnementPeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(AbonnementPeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(AbonnementPeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(AbonnementPeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(AbonnementPeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::ID_CREATION, $idCreation, $comparison);
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
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(AbonnementPeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(AbonnementPeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbonnementPeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related Sale object
     *
     * @param   Sale|PropelObjectCollection $sale The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AbonnementQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySale($sale, $comparison = null)
    {
        if ($sale instanceof Sale) {
            return $this
                ->addUsingAlias(AbonnementPeer::ID_SALE, $sale->getIdSale(), $comparison);
        } elseif ($sale instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AbonnementPeer::ID_SALE, $sale->toKeyValue('PrimaryKey', 'IdSale'), $comparison);
        } else {
            throw new PropelException('filterBySale() only accepts arguments of type Sale or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sale relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function joinSale($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sale');

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
            $this->addJoinObject($join, 'Sale');
        }

        return $this;
    }

    /**
     * Use the Sale relation Sale object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   SaleQuery A secondary query class using the current class as primary query
     */
    public function useSaleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSale($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sale', 'SaleQuery');
    }

    /**
     * Filter the query by a related SaleTaxe object
     *
     * @param   SaleTaxe|PropelObjectCollection $saleTaxe  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AbonnementQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySaleTaxe($saleTaxe, $comparison = null)
    {
        if ($saleTaxe instanceof SaleTaxe) {
            return $this
                ->addUsingAlias(AbonnementPeer::ID_ABONNEMENT, $saleTaxe->getIdAbonnement(), $comparison);
        } elseif ($saleTaxe instanceof PropelObjectCollection) {
            return $this
                ->useSaleTaxeQuery()
                ->filterByPrimaryKeys($saleTaxe->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySaleTaxe() only accepts arguments of type SaleTaxe or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SaleTaxe relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function joinSaleTaxe($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SaleTaxe');

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
            $this->addJoinObject($join, 'SaleTaxe');
        }

        return $this;
    }

    /**
     * Use the SaleTaxe relation SaleTaxe object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   SaleTaxeQuery A secondary query class using the current class as primary query
     */
    public function useSaleTaxeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSaleTaxe($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SaleTaxe', 'SaleTaxeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Abonnement $abonnement Object to remove from the list of results
     *
     * @return AbonnementQuery The current query, for fluid interface
     */
    public function prune($abonnement = null)
    {
        if ($abonnement) {
            $this->addUsingAlias(AbonnementPeer::ID_ABONNEMENT, $abonnement->getIdAbonnement(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // TableStampBehavior behavior

    /**Filter by the latest updated
     * @param      int $nbDays Maximum age of the latest update in days
     * @return     AbonnementQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(AbonnementPeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by update date desc
     * @return     AbonnementQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(AbonnementPeer::DATE_MODIFICATION);
    }

    /**Order by update date asc
     * @return     AbonnementQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(AbonnementPeer::DATE_MODIFICATION);
    }

    /**Filter by the latest created
     * @param      int $nbDays Maximum age of in days
     * @return     AbonnementQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(AbonnementPeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by create date desc
     * @return     AbonnementQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(AbonnementPeer::DATE_CREATION);
    }

    /**Order by create date asc
     * @return     AbonnementQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(AbonnementPeer::DATE_CREATION);
    }
}
