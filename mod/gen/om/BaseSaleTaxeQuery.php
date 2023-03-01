<?php


/**
 * Base class that represents a query for the 'sale_taxe' table.
 *
 * Taxe
 *
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseSaleTaxeQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseSaleTaxeQuery object.
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
            $modelName = 'SaleTaxe';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new SaleTaxeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   SaleTaxeQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return SaleTaxeQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof SaleTaxeQuery) {return $criteria;}
        $query = new SaleTaxeQuery(null, null, $modelAlias);
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
     * @return   SaleTaxe|SaleTaxe[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SaleTaxePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(SaleTaxePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 SaleTaxe A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdSaleTaxe($key, $con = null)
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
     * @return                 SaleTaxe A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_sale_taxe`, `id_abonnement`, `id_taxe`, `name`, `pourcent`, `montant`, `id_creation`, `id_modification` FROM `sale_taxe` WHERE `id_sale_taxe` = :p0';
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
            $obj = new SaleTaxe();
            $obj->hydrate($row);
            SaleTaxePeer::addInstanceToPool($obj, (string) $key);
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
     * @return SaleTaxe|SaleTaxe[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|SaleTaxe[]|mixed the list of results, formatted by the current formatter
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
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SaleTaxePeer::ID_SALE_TAXE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SaleTaxePeer::ID_SALE_TAXE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_sale_taxe column
     *
     * Example usage:
     * <code>
     * $query->filterByIdSaleTaxe(1234); // WHERE id_sale_taxe = 1234
     * $query->filterByIdSaleTaxe(array(12, 34)); // WHERE id_sale_taxe IN (12, 34)
     * $query->filterByIdSaleTaxe(array('min' => 12)); // WHERE id_sale_taxe >= 12
     * $query->filterByIdSaleTaxe(array('max' => 12)); // WHERE id_sale_taxe <= 12
     * </code>
     *
     * @param     mixed $idSaleTaxe The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByIdSaleTaxe($idSaleTaxe = null, $comparison = null)
    {
        if (is_array($idSaleTaxe)) {
            $useMinMax = false;
            if (isset($idSaleTaxe['min'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_SALE_TAXE, $idSaleTaxe['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSaleTaxe['max'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_SALE_TAXE, $idSaleTaxe['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SaleTaxePeer::ID_SALE_TAXE, $idSaleTaxe, $comparison);
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
     * @see       filterByAbonnement()
     *
     * @param     mixed $idAbonnement The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByIdAbonnement($idAbonnement = null, $comparison = null)
    {
        if (is_array($idAbonnement)) {
            $useMinMax = false;
            if (isset($idAbonnement['min'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_ABONNEMENT, $idAbonnement['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAbonnement['max'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_ABONNEMENT, $idAbonnement['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SaleTaxePeer::ID_ABONNEMENT, $idAbonnement, $comparison);
    }

    /**
     * Filter the query on the id_taxe column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTaxe(1234); // WHERE id_taxe = 1234
     * $query->filterByIdTaxe(array(12, 34)); // WHERE id_taxe IN (12, 34)
     * $query->filterByIdTaxe(array('min' => 12)); // WHERE id_taxe >= 12
     * $query->filterByIdTaxe(array('max' => 12)); // WHERE id_taxe <= 12
     * </code>
     *
     * @see       filterByTaxe()
     *
     * @param     mixed $idTaxe The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByIdTaxe($idTaxe = null, $comparison = null)
    {
        if (is_array($idTaxe)) {
            $useMinMax = false;
            if (isset($idTaxe['min'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_TAXE, $idTaxe['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTaxe['max'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_TAXE, $idTaxe['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SaleTaxePeer::ID_TAXE, $idTaxe, $comparison);
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
     * @return SaleTaxeQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SaleTaxePeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the pourcent column
     *
     * Example usage:
     * <code>
     * $query->filterByPourcent(1234); // WHERE pourcent = 1234
     * $query->filterByPourcent(array(12, 34)); // WHERE pourcent IN (12, 34)
     * $query->filterByPourcent(array('min' => 12)); // WHERE pourcent >= 12
     * $query->filterByPourcent(array('max' => 12)); // WHERE pourcent <= 12
     * </code>
     *
     * @param     mixed $pourcent The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByPourcent($pourcent = null, $comparison = null)
    {
        if (is_array($pourcent)) {
            $useMinMax = false;
            if (isset($pourcent['min'])) {
                $this->addUsingAlias(SaleTaxePeer::POURCENT, $pourcent['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pourcent['max'])) {
                $this->addUsingAlias(SaleTaxePeer::POURCENT, $pourcent['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SaleTaxePeer::POURCENT, $pourcent, $comparison);
    }

    /**
     * Filter the query on the montant column
     *
     * Example usage:
     * <code>
     * $query->filterByMontant(1234); // WHERE montant = 1234
     * $query->filterByMontant(array(12, 34)); // WHERE montant IN (12, 34)
     * $query->filterByMontant(array('min' => 12)); // WHERE montant >= 12
     * $query->filterByMontant(array('max' => 12)); // WHERE montant <= 12
     * </code>
     *
     * @param     mixed $montant The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByMontant($montant = null, $comparison = null)
    {
        if (is_array($montant)) {
            $useMinMax = false;
            if (isset($montant['min'])) {
                $this->addUsingAlias(SaleTaxePeer::MONTANT, $montant['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($montant['max'])) {
                $this->addUsingAlias(SaleTaxePeer::MONTANT, $montant['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SaleTaxePeer::MONTANT, $montant, $comparison);
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
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(SaleTaxePeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(SaleTaxePeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SaleTaxePeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(SaleTaxePeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(SaleTaxePeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SaleTaxePeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SaleTaxePeer::ID_CREATION, $idCreation, $comparison);
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
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(SaleTaxePeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SaleTaxePeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related Abonnement object
     *
     * @param   Abonnement|PropelObjectCollection $abonnement The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SaleTaxeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAbonnement($abonnement, $comparison = null)
    {
        if ($abonnement instanceof Abonnement) {
            return $this
                ->addUsingAlias(SaleTaxePeer::ID_ABONNEMENT, $abonnement->getIdAbonnement(), $comparison);
        } elseif ($abonnement instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SaleTaxePeer::ID_ABONNEMENT, $abonnement->toKeyValue('PrimaryKey', 'IdAbonnement'), $comparison);
        } else {
            throw new PropelException('filterByAbonnement() only accepts arguments of type Abonnement or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Abonnement relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function joinAbonnement($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Abonnement');

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
            $this->addJoinObject($join, 'Abonnement');
        }

        return $this;
    }

    /**
     * Use the Abonnement relation Abonnement object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   AbonnementQuery A secondary query class using the current class as primary query
     */
    public function useAbonnementQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAbonnement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Abonnement', 'AbonnementQuery');
    }

    /**
     * Filter the query by a related Taxe object
     *
     * @param   Taxe|PropelObjectCollection $taxe The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SaleTaxeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTaxe($taxe, $comparison = null)
    {
        if ($taxe instanceof Taxe) {
            return $this
                ->addUsingAlias(SaleTaxePeer::ID_TAXE, $taxe->getIdTaxe(), $comparison);
        } elseif ($taxe instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SaleTaxePeer::ID_TAXE, $taxe->toKeyValue('PrimaryKey', 'IdTaxe'), $comparison);
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
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function joinTaxe($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useTaxeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTaxe($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Taxe', 'TaxeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   SaleTaxe $saleTaxe Object to remove from the list of results
     *
     * @return SaleTaxeQuery The current query, for fluid interface
     */
    public function prune($saleTaxe = null)
    {
        if ($saleTaxe) {
            $this->addUsingAlias(SaleTaxePeer::ID_SALE_TAXE, $saleTaxe->getIdSaleTaxe(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // TableStampBehavior behavior

    /**Filter by the latest updated
     * @param      int $nbDays Maximum age of the latest update in days
     * @return     SaleTaxeQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(SaleTaxePeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by update date desc
     * @return     SaleTaxeQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(SaleTaxePeer::DATE_MODIFICATION);
    }

    /**Order by update date asc
     * @return     SaleTaxeQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(SaleTaxePeer::DATE_MODIFICATION);
    }

    /**Filter by the latest created
     * @param      int $nbDays Maximum age of in days
     * @return     SaleTaxeQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(SaleTaxePeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by create date desc
     * @return     SaleTaxeQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(SaleTaxePeer::DATE_CREATION);
    }

    /**Order by create date asc
     * @return     SaleTaxeQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(SaleTaxePeer::DATE_CREATION);
    }
}
