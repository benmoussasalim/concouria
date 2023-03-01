<?php


/**
 * Base class that represents a query for the 'concours_file' table.
 *
 * Photo
 *
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseConcoursFileQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseConcoursFileQuery object.
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
            $modelName = 'ConcoursFile';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ConcoursFileQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ConcoursFileQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ConcoursFileQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ConcoursFileQuery) {return $criteria;}
        $query = new ConcoursFileQuery(null, null, $modelAlias);
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
     * @return   ConcoursFile|ConcoursFile[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ConcoursFilePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ConcoursFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ConcoursFile A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdConcoursFile($key, $con = null)
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
     * @return                 ConcoursFile A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_concours_file`, `id_concours`, `ext`, `name`, `size`, `fichier`, `blob`, `id_creation`, `id_modification` FROM `concours_file` WHERE `id_concours_file` = :p0';
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
            $obj = new ConcoursFile();
            $obj->hydrate($row);
            ConcoursFilePeer::addInstanceToPool($obj, (string) $key);
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
     * @return ConcoursFile|ConcoursFile[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ConcoursFile[]|mixed the list of results, formatted by the current formatter
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
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ConcoursFilePeer::ID_CONCOURS_FILE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ConcoursFilePeer::ID_CONCOURS_FILE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_concours_file column
     *
     * Example usage:
     * <code>
     * $query->filterByIdConcoursFile(1234); // WHERE id_concours_file = 1234
     * $query->filterByIdConcoursFile(array(12, 34)); // WHERE id_concours_file IN (12, 34)
     * $query->filterByIdConcoursFile(array('min' => 12)); // WHERE id_concours_file >= 12
     * $query->filterByIdConcoursFile(array('max' => 12)); // WHERE id_concours_file <= 12
     * </code>
     *
     * @param     mixed $idConcoursFile The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByIdConcoursFile($idConcoursFile = null, $comparison = null)
    {
        if (is_array($idConcoursFile)) {
            $useMinMax = false;
            if (isset($idConcoursFile['min'])) {
                $this->addUsingAlias(ConcoursFilePeer::ID_CONCOURS_FILE, $idConcoursFile['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idConcoursFile['max'])) {
                $this->addUsingAlias(ConcoursFilePeer::ID_CONCOURS_FILE, $idConcoursFile['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConcoursFilePeer::ID_CONCOURS_FILE, $idConcoursFile, $comparison);
    }

    /**
     * Filter the query on the id_concours column
     *
     * Example usage:
     * <code>
     * $query->filterByIdConcours(1234); // WHERE id_concours = 1234
     * $query->filterByIdConcours(array(12, 34)); // WHERE id_concours IN (12, 34)
     * $query->filterByIdConcours(array('min' => 12)); // WHERE id_concours >= 12
     * $query->filterByIdConcours(array('max' => 12)); // WHERE id_concours <= 12
     * </code>
     *
     * @see       filterByConcours()
     *
     * @param     mixed $idConcours The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByIdConcours($idConcours = null, $comparison = null)
    {
        if (is_array($idConcours)) {
            $useMinMax = false;
            if (isset($idConcours['min'])) {
                $this->addUsingAlias(ConcoursFilePeer::ID_CONCOURS, $idConcours['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idConcours['max'])) {
                $this->addUsingAlias(ConcoursFilePeer::ID_CONCOURS, $idConcours['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConcoursFilePeer::ID_CONCOURS, $idConcours, $comparison);
    }

    /**
     * Filter the query on the ext column
     *
     * Example usage:
     * <code>
     * $query->filterByExt('fooValue');   // WHERE ext = 'fooValue'
     * $query->filterByExt('%fooValue%'); // WHERE ext LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ext The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByExt($ext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ext)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ext)) {
                $ext = str_replace('*', '%', $ext);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConcoursFilePeer::EXT, $ext, $comparison);
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
     * @return ConcoursFileQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ConcoursFilePeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the size column
     *
     * Example usage:
     * <code>
     * $query->filterBySize(1234); // WHERE size = 1234
     * $query->filterBySize(array(12, 34)); // WHERE size IN (12, 34)
     * $query->filterBySize(array('min' => 12)); // WHERE size >= 12
     * $query->filterBySize(array('max' => 12)); // WHERE size <= 12
     * </code>
     *
     * @param     mixed $size The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterBySize($size = null, $comparison = null)
    {
        if (is_array($size)) {
            $useMinMax = false;
            if (isset($size['min'])) {
                $this->addUsingAlias(ConcoursFilePeer::SIZE, $size['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($size['max'])) {
                $this->addUsingAlias(ConcoursFilePeer::SIZE, $size['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConcoursFilePeer::SIZE, $size, $comparison);
    }

    /**
     * Filter the query on the fichier column
     *
     * Example usage:
     * <code>
     * $query->filterByFichier('fooValue');   // WHERE fichier = 'fooValue'
     * $query->filterByFichier('%fooValue%'); // WHERE fichier LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fichier The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByFichier($fichier = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fichier)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fichier)) {
                $fichier = str_replace('*', '%', $fichier);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConcoursFilePeer::FICHIER, $fichier, $comparison);
    }

    /**
     * Filter the query on the blob column
     *
     * @param     mixed $blob The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByBlob($blob = null, $comparison = null)
    {

        return $this->addUsingAlias(ConcoursFilePeer::BLOB, $blob, $comparison);
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
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(ConcoursFilePeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(ConcoursFilePeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConcoursFilePeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(ConcoursFilePeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(ConcoursFilePeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConcoursFilePeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(ConcoursFilePeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(ConcoursFilePeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConcoursFilePeer::ID_CREATION, $idCreation, $comparison);
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
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(ConcoursFilePeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(ConcoursFilePeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConcoursFilePeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related Concours object
     *
     * @param   Concours|PropelObjectCollection $concours The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ConcoursFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByConcours($concours, $comparison = null)
    {
        if ($concours instanceof Concours) {
            return $this
                ->addUsingAlias(ConcoursFilePeer::ID_CONCOURS, $concours->getIdConcours(), $comparison);
        } elseif ($concours instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ConcoursFilePeer::ID_CONCOURS, $concours->toKeyValue('PrimaryKey', 'IdConcours'), $comparison);
        } else {
            throw new PropelException('filterByConcours() only accepts arguments of type Concours or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Concours relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function joinConcours($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Concours');

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
            $this->addJoinObject($join, 'Concours');
        }

        return $this;
    }

    /**
     * Use the Concours relation Concours object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   ConcoursQuery A secondary query class using the current class as primary query
     */
    public function useConcoursQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinConcours($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Concours', 'ConcoursQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ConcoursFile $concoursFile Object to remove from the list of results
     *
     * @return ConcoursFileQuery The current query, for fluid interface
     */
    public function prune($concoursFile = null)
    {
        if ($concoursFile) {
            $this->addUsingAlias(ConcoursFilePeer::ID_CONCOURS_FILE, $concoursFile->getIdConcoursFile(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // TableStampBehavior behavior

    /**Filter by the latest updated
     * @param      int $nbDays Maximum age of the latest update in days
     * @return     ConcoursFileQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(ConcoursFilePeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by update date desc
     * @return     ConcoursFileQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(ConcoursFilePeer::DATE_MODIFICATION);
    }

    /**Order by update date asc
     * @return     ConcoursFileQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(ConcoursFilePeer::DATE_MODIFICATION);
    }

    /**Filter by the latest created
     * @param      int $nbDays Maximum age of in days
     * @return     ConcoursFileQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(ConcoursFilePeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by create date desc
     * @return     ConcoursFileQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(ConcoursFilePeer::DATE_CREATION);
    }

    /**Order by create date asc
     * @return     ConcoursFileQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(ConcoursFilePeer::DATE_CREATION);
    }
}
