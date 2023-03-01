<?php


/**
 * Base class that represents a query for the 'ticket' table.
 *
 * Ticket
 *
 *
 * @package    propel.generator.acc.om
 */
abstract class BaseTicketQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTicketQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'acc';
        }
        if (null === $modelName) {
            $modelName = 'Ticket';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TicketQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   TicketQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return TicketQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TicketQuery) {return $criteria;}
        $query = new TicketQuery(null, null, $modelAlias);
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
     * @return   Ticket|Ticket[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TicketPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TicketPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Ticket A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdTicket($key, $con = null)
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
     * @return                 Ticket A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_ticket`, `author`, `project`, `date`, `online`, `id_creation`, `id_modification` FROM `ticket` WHERE `id_ticket` = :p0';
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
            $obj = new Ticket();
            $obj->hydrate($row);
            TicketPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Ticket|Ticket[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Ticket[]|mixed the list of results, formatted by the current formatter
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
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TicketPeer::ID_TICKET, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TicketPeer::ID_TICKET, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_ticket column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTicket(1234); // WHERE id_ticket = 1234
     * $query->filterByIdTicket(array(12, 34)); // WHERE id_ticket IN (12, 34)
     * $query->filterByIdTicket(array('min' => 12)); // WHERE id_ticket >= 12
     * $query->filterByIdTicket(array('max' => 12)); // WHERE id_ticket <= 12
     * </code>
     *
     * @param     mixed $idTicket The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByIdTicket($idTicket = null, $comparison = null)
    {
        if (is_array($idTicket)) {
            $useMinMax = false;
            if (isset($idTicket['min'])) {
                $this->addUsingAlias(TicketPeer::ID_TICKET, $idTicket['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTicket['max'])) {
                $this->addUsingAlias(TicketPeer::ID_TICKET, $idTicket['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TicketPeer::ID_TICKET, $idTicket, $comparison);
    }

    /**
     * Filter the query on the author column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthor('fooValue');   // WHERE author = 'fooValue'
     * $query->filterByAuthor('%fooValue%'); // WHERE author LIKE '%fooValue%'
     * </code>
     *
     * @param     string $author The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByAuthor($author = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($author)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $author)) {
                $author = str_replace('*', '%', $author);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TicketPeer::AUTHOR, $author, $comparison);
    }

    /**
     * Filter the query on the project column
     *
     * Example usage:
     * <code>
     * $query->filterByProject('fooValue');   // WHERE project = 'fooValue'
     * $query->filterByProject('%fooValue%'); // WHERE project LIKE '%fooValue%'
     * </code>
     *
     * @param     string $project The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByProject($project = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($project)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $project)) {
                $project = str_replace('*', '%', $project);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TicketPeer::PROJECT, $project, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE date < '2011-03-13'
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(TicketPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(TicketPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TicketPeer::DATE, $date, $comparison);
    }

    /**
     * Filter the query on the online column
     *
     * @param     mixed $online The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TicketQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByOnline($online = null, $comparison = null)
    {
        if (is_scalar($online)) {
            $online = TicketPeer::getSqlValueForEnum(TicketPeer::ONLINE, $online);
        } elseif (is_array($online)) {
            $convertedValues = array();
            foreach ($online as $value) {
                $convertedValues[] = TicketPeer::getSqlValueForEnum(TicketPeer::ONLINE, $value);
            }
            $online = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TicketPeer::ONLINE, $online, $comparison);
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
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(TicketPeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(TicketPeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TicketPeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(TicketPeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(TicketPeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TicketPeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(TicketPeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(TicketPeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TicketPeer::ID_CREATION, $idCreation, $comparison);
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
     * @return TicketQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(TicketPeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(TicketPeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TicketPeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related TicketChat object
     *
     * @param   TicketChat|PropelObjectCollection $ticketChat  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TicketQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTicketChat($ticketChat, $comparison = null)
    {
        if ($ticketChat instanceof TicketChat) {
            return $this
                ->addUsingAlias(TicketPeer::ID_TICKET, $ticketChat->getIdTicket(), $comparison);
        } elseif ($ticketChat instanceof PropelObjectCollection) {
            return $this
                ->useTicketChatQuery()
                ->filterByPrimaryKeys($ticketChat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTicketChat() only accepts arguments of type TicketChat or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TicketChat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TicketQuery The current query, for fluid interface
     */
    public function joinTicketChat($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TicketChat');

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
            $this->addJoinObject($join, 'TicketChat');
        }

        return $this;
    }

    /**
     * Use the TicketChat relation TicketChat object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   TicketChatQuery A secondary query class using the current class as primary query
     */
    public function useTicketChatQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTicketChat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TicketChat', 'TicketChatQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Ticket $ticket Object to remove from the list of results
     *
     * @return TicketQuery The current query, for fluid interface
     */
    public function prune($ticket = null)
    {
        if ($ticket) {
            $this->addUsingAlias(TicketPeer::ID_TICKET, $ticket->getIdTicket(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // TableStampBehavior behavior

    /**Filter by the latest updated
     * @param      int $nbDays Maximum age of the latest update in days
     * @return     TicketQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(TicketPeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by update date desc
     * @return     TicketQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(TicketPeer::DATE_MODIFICATION);
    }

    /**Order by update date asc
     * @return     TicketQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(TicketPeer::DATE_MODIFICATION);
    }

    /**Filter by the latest created
     * @param      int $nbDays Maximum age of in days
     * @return     TicketQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(TicketPeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by create date desc
     * @return     TicketQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(TicketPeer::DATE_CREATION);
    }

    /**Order by create date asc
     * @return     TicketQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(TicketPeer::DATE_CREATION);
    }
}
