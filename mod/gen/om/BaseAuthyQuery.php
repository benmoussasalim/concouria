<?php


/**
 * Base class that represents a query for the 'authy' table.
 *
 * Usagers
 *
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseAuthyQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAuthyQuery object.
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
            $modelName = 'Authy';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AuthyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AuthyQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AuthyQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AuthyQuery) {return $criteria;}
        $query = new AuthyQuery(null, null, $modelAlias);
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
     * @return   Authy|Authy[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AuthyPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AuthyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Authy A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdAuthy($key, $con = null)
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
     * @return                 Authy A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id_authy`, `id_group_creation`, `validation_key`, `username`, `passwd_hash`, `email`, `is_root`, `group`, `expire`, `deactivate`, `date_requested`, `language`, `last_poke`, `last_poke_ip`, `rights`, `wbs_public`, `wbs_private`, `onglet`, `passwd_hash_temp`, `id_creation`, `id_modification` FROM `authy` WHERE `id_authy` = :p0';
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
            $obj = new Authy();
            $obj->hydrate($row);
            AuthyPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Authy|Authy[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Authy[]|mixed the list of results, formatted by the current formatter
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AuthyPeer::ID_AUTHY, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AuthyPeer::ID_AUTHY, $keys, Criteria::IN);
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
     * @param     mixed $idAuthy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByIdAuthy($idAuthy = null, $comparison = null)
    {
        if (is_array($idAuthy)) {
            $useMinMax = false;
            if (isset($idAuthy['min'])) {
                $this->addUsingAlias(AuthyPeer::ID_AUTHY, $idAuthy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAuthy['max'])) {
                $this->addUsingAlias(AuthyPeer::ID_AUTHY, $idAuthy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ID_AUTHY, $idAuthy, $comparison);
    }

    /**
     * Filter the query on the id_group_creation column
     *
     * Example usage:
     * <code>
     * $query->filterByIdGroupCreation(1234); // WHERE id_group_creation = 1234
     * $query->filterByIdGroupCreation(array(12, 34)); // WHERE id_group_creation IN (12, 34)
     * $query->filterByIdGroupCreation(array('min' => 12)); // WHERE id_group_creation >= 12
     * $query->filterByIdGroupCreation(array('max' => 12)); // WHERE id_group_creation <= 12
     * </code>
     *
     * @param     mixed $idGroupCreation The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByIdGroupCreation($idGroupCreation = null, $comparison = null)
    {
        if (is_array($idGroupCreation)) {
            $useMinMax = false;
            if (isset($idGroupCreation['min'])) {
                $this->addUsingAlias(AuthyPeer::ID_GROUP_CREATION, $idGroupCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGroupCreation['max'])) {
                $this->addUsingAlias(AuthyPeer::ID_GROUP_CREATION, $idGroupCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ID_GROUP_CREATION, $idGroupCreation, $comparison);
    }

    /**
     * Filter the query on the validation_key column
     *
     * Example usage:
     * <code>
     * $query->filterByValidationKey('fooValue');   // WHERE validation_key = 'fooValue'
     * $query->filterByValidationKey('%fooValue%'); // WHERE validation_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $validationKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByValidationKey($validationKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($validationKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $validationKey)) {
                $validationKey = str_replace('*', '%', $validationKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::VALIDATION_KEY, $validationKey, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $username)) {
                $username = str_replace('*', '%', $username);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the passwd_hash column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswdHash('fooValue');   // WHERE passwd_hash = 'fooValue'
     * $query->filterByPasswdHash('%fooValue%'); // WHERE passwd_hash LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passwdHash The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByPasswdHash($passwdHash = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passwdHash)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $passwdHash)) {
                $passwdHash = str_replace('*', '%', $passwdHash);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::PASSWD_HASH, $passwdHash, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the is_root column
     *
     * @param     mixed $isRoot The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByIsRoot($isRoot = null, $comparison = null)
    {
        if (is_scalar($isRoot)) {
            $isRoot = AuthyPeer::getSqlValueForEnum(AuthyPeer::IS_ROOT, $isRoot);
        } elseif (is_array($isRoot)) {
            $convertedValues = array();
            foreach ($isRoot as $value) {
                $convertedValues[] = AuthyPeer::getSqlValueForEnum(AuthyPeer::IS_ROOT, $value);
            }
            $isRoot = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::IS_ROOT, $isRoot, $comparison);
    }

    /**
     * Filter the query on the group column
     *
     * @param     mixed $group The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByGroup($group = null, $comparison = null)
    {
        if (is_scalar($group)) {
            $group = AuthyPeer::getSqlValueForEnum(AuthyPeer::GROUP, $group);
        } elseif (is_array($group)) {
            $convertedValues = array();
            foreach ($group as $value) {
                $convertedValues[] = AuthyPeer::getSqlValueForEnum(AuthyPeer::GROUP, $value);
            }
            $group = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::GROUP, $group, $comparison);
    }

    /**
     * Filter the query on the expire column
     *
     * Example usage:
     * <code>
     * $query->filterByExpire('2011-03-14'); // WHERE expire = '2011-03-14'
     * $query->filterByExpire('now'); // WHERE expire = '2011-03-14'
     * $query->filterByExpire(array('max' => 'yesterday')); // WHERE expire < '2011-03-13'
     * </code>
     *
     * @param     mixed $expire The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByExpire($expire = null, $comparison = null)
    {
        if (is_array($expire)) {
            $useMinMax = false;
            if (isset($expire['min'])) {
                $this->addUsingAlias(AuthyPeer::EXPIRE, $expire['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expire['max'])) {
                $this->addUsingAlias(AuthyPeer::EXPIRE, $expire['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::EXPIRE, $expire, $comparison);
    }

    /**
     * Filter the query on the deactivate column
     *
     * @param     mixed $deactivate The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByDeactivate($deactivate = null, $comparison = null)
    {
        if (is_scalar($deactivate)) {
            $deactivate = AuthyPeer::getSqlValueForEnum(AuthyPeer::DEACTIVATE, $deactivate);
        } elseif (is_array($deactivate)) {
            $convertedValues = array();
            foreach ($deactivate as $value) {
                $convertedValues[] = AuthyPeer::getSqlValueForEnum(AuthyPeer::DEACTIVATE, $value);
            }
            $deactivate = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::DEACTIVATE, $deactivate, $comparison);
    }

    /**
     * Filter the query on the date_requested column
     *
     * Example usage:
     * <code>
     * $query->filterByDateRequested('2011-03-14'); // WHERE date_requested = '2011-03-14'
     * $query->filterByDateRequested('now'); // WHERE date_requested = '2011-03-14'
     * $query->filterByDateRequested(array('max' => 'yesterday')); // WHERE date_requested < '2011-03-13'
     * </code>
     *
     * @param     mixed $dateRequested The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByDateRequested($dateRequested = null, $comparison = null)
    {
        if (is_array($dateRequested)) {
            $useMinMax = false;
            if (isset($dateRequested['min'])) {
                $this->addUsingAlias(AuthyPeer::DATE_REQUESTED, $dateRequested['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateRequested['max'])) {
                $this->addUsingAlias(AuthyPeer::DATE_REQUESTED, $dateRequested['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::DATE_REQUESTED, $dateRequested, $comparison);
    }

    /**
     * Filter the query on the language column
     *
     * @param     mixed $language The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByLanguage($language = null, $comparison = null)
    {
        if (is_scalar($language)) {
            $language = AuthyPeer::getSqlValueForEnum(AuthyPeer::LANGUAGE, $language);
        } elseif (is_array($language)) {
            $convertedValues = array();
            foreach ($language as $value) {
                $convertedValues[] = AuthyPeer::getSqlValueForEnum(AuthyPeer::LANGUAGE, $value);
            }
            $language = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::LANGUAGE, $language, $comparison);
    }

    /**
     * Filter the query on the last_poke column
     *
     * Example usage:
     * <code>
     * $query->filterByLastPoke(1234); // WHERE last_poke = 1234
     * $query->filterByLastPoke(array(12, 34)); // WHERE last_poke IN (12, 34)
     * $query->filterByLastPoke(array('min' => 12)); // WHERE last_poke >= 12
     * $query->filterByLastPoke(array('max' => 12)); // WHERE last_poke <= 12
     * </code>
     *
     * @param     mixed $lastPoke The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByLastPoke($lastPoke = null, $comparison = null)
    {
        if (is_array($lastPoke)) {
            $useMinMax = false;
            if (isset($lastPoke['min'])) {
                $this->addUsingAlias(AuthyPeer::LAST_POKE, $lastPoke['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastPoke['max'])) {
                $this->addUsingAlias(AuthyPeer::LAST_POKE, $lastPoke['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::LAST_POKE, $lastPoke, $comparison);
    }

    /**
     * Filter the query on the last_poke_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByLastPokeIp('fooValue');   // WHERE last_poke_ip = 'fooValue'
     * $query->filterByLastPokeIp('%fooValue%'); // WHERE last_poke_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastPokeIp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByLastPokeIp($lastPokeIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastPokeIp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastPokeIp)) {
                $lastPokeIp = str_replace('*', '%', $lastPokeIp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::LAST_POKE_IP, $lastPokeIp, $comparison);
    }

    /**
     * Filter the query on the rights column
     *
     * Example usage:
     * <code>
     * $query->filterByRights('fooValue');   // WHERE rights = 'fooValue'
     * $query->filterByRights('%fooValue%'); // WHERE rights LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rights The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByRights($rights = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rights)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rights)) {
                $rights = str_replace('*', '%', $rights);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::RIGHTS, $rights, $comparison);
    }

    /**
     * Filter the query on the wbs_public column
     *
     * Example usage:
     * <code>
     * $query->filterByWbsPublic('fooValue');   // WHERE wbs_public = 'fooValue'
     * $query->filterByWbsPublic('%fooValue%'); // WHERE wbs_public LIKE '%fooValue%'
     * </code>
     *
     * @param     string $wbsPublic The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByWbsPublic($wbsPublic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($wbsPublic)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $wbsPublic)) {
                $wbsPublic = str_replace('*', '%', $wbsPublic);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::WBS_PUBLIC, $wbsPublic, $comparison);
    }

    /**
     * Filter the query on the wbs_private column
     *
     * Example usage:
     * <code>
     * $query->filterByWbsPrivate('fooValue');   // WHERE wbs_private = 'fooValue'
     * $query->filterByWbsPrivate('%fooValue%'); // WHERE wbs_private LIKE '%fooValue%'
     * </code>
     *
     * @param     string $wbsPrivate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByWbsPrivate($wbsPrivate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($wbsPrivate)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $wbsPrivate)) {
                $wbsPrivate = str_replace('*', '%', $wbsPrivate);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::WBS_PRIVATE, $wbsPrivate, $comparison);
    }

    /**
     * Filter the query on the onglet column
     *
     * Example usage:
     * <code>
     * $query->filterByOnglet('fooValue');   // WHERE onglet = 'fooValue'
     * $query->filterByOnglet('%fooValue%'); // WHERE onglet LIKE '%fooValue%'
     * </code>
     *
     * @param     string $onglet The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByOnglet($onglet = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($onglet)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $onglet)) {
                $onglet = str_replace('*', '%', $onglet);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ONGLET, $onglet, $comparison);
    }

    /**
     * Filter the query on the passwd_hash_temp column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswdHashTemp('fooValue');   // WHERE passwd_hash_temp = 'fooValue'
     * $query->filterByPasswdHashTemp('%fooValue%'); // WHERE passwd_hash_temp LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passwdHashTemp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByPasswdHashTemp($passwdHashTemp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passwdHashTemp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $passwdHashTemp)) {
                $passwdHashTemp = str_replace('*', '%', $passwdHashTemp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthyPeer::PASSWD_HASH_TEMP, $passwdHashTemp, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(AuthyPeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(AuthyPeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(AuthyPeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(AuthyPeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::DATE_MODIFICATION, $dateModification, $comparison);
    }

    /**
     * Filter the query on the passwd_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswdDate('2011-03-14'); // WHERE passwd_date = '2011-03-14'
     * $query->filterByPasswdDate('now'); // WHERE passwd_date = '2011-03-14'
     * $query->filterByPasswdDate(array('max' => 'yesterday')); // WHERE passwd_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $passwdDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByPasswdDate($passwdDate = null, $comparison = null)
    {
        if (is_array($passwdDate)) {
            $useMinMax = false;
            if (isset($passwdDate['min'])) {
                $this->addUsingAlias(AuthyPeer::PASSWD_DATE, $passwdDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($passwdDate['max'])) {
                $this->addUsingAlias(AuthyPeer::PASSWD_DATE, $passwdDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::PASSWD_DATE, $passwdDate, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(AuthyPeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(AuthyPeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ID_CREATION, $idCreation, $comparison);
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
     * @return AuthyQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(AuthyPeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(AuthyPeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthyPeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related AuthyShortcut object
     *
     * @param   AuthyShortcut|PropelObjectCollection $authyShortcut  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyShortcut($authyShortcut, $comparison = null)
    {
        if ($authyShortcut instanceof AuthyShortcut) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $authyShortcut->getIdAuthy(), $comparison);
        } elseif ($authyShortcut instanceof PropelObjectCollection) {
            return $this
                ->useAuthyShortcutQuery()
                ->filterByPrimaryKeys($authyShortcut->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyShortcut() only accepts arguments of type AuthyShortcut or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyShortcut relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAuthyShortcut($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyShortcut');

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
            $this->addJoinObject($join, 'AuthyShortcut');
        }

        return $this;
    }

    /**
     * Use the AuthyShortcut relation AuthyShortcut object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   AuthyShortcutQuery A secondary query class using the current class as primary query
     */
    public function useAuthyShortcutQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuthyShortcut($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyShortcut', 'AuthyShortcutQuery');
    }

    /**
     * Filter the query by a related Mail object
     *
     * @param   Mail|PropelObjectCollection $mail  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMailRelatedByIdModification($mail, $comparison = null)
    {
        if ($mail instanceof Mail) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $mail->getIdModification(), $comparison);
        } elseif ($mail instanceof PropelObjectCollection) {
            return $this
                ->useMailRelatedByIdModificationQuery()
                ->filterByPrimaryKeys($mail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMailRelatedByIdModification() only accepts arguments of type Mail or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MailRelatedByIdModification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinMailRelatedByIdModification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MailRelatedByIdModification');

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
            $this->addJoinObject($join, 'MailRelatedByIdModification');
        }

        return $this;
    }

    /**
     * Use the MailRelatedByIdModification relation Mail object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   MailQuery A secondary query class using the current class as primary query
     */
    public function useMailRelatedByIdModificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMailRelatedByIdModification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MailRelatedByIdModification', 'MailQuery');
    }

    /**
     * Filter the query by a related Mail object
     *
     * @param   Mail|PropelObjectCollection $mail  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMailRelatedByIdCreation($mail, $comparison = null)
    {
        if ($mail instanceof Mail) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $mail->getIdCreation(), $comparison);
        } elseif ($mail instanceof PropelObjectCollection) {
            return $this
                ->useMailRelatedByIdCreationQuery()
                ->filterByPrimaryKeys($mail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMailRelatedByIdCreation() only accepts arguments of type Mail or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MailRelatedByIdCreation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinMailRelatedByIdCreation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MailRelatedByIdCreation');

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
            $this->addJoinObject($join, 'MailRelatedByIdCreation');
        }

        return $this;
    }

    /**
     * Use the MailRelatedByIdCreation relation Mail object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   MailQuery A secondary query class using the current class as primary query
     */
    public function useMailRelatedByIdCreationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMailRelatedByIdCreation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MailRelatedByIdCreation', 'MailQuery');
    }

    /**
     * Filter the query by a related Account object
     *
     * @param   Account|PropelObjectCollection $account  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAccount($account, $comparison = null)
    {
        if ($account instanceof Account) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $account->getIdAuthy(), $comparison);
        } elseif ($account instanceof PropelObjectCollection) {
            return $this
                ->useAccountQuery()
                ->filterByPrimaryKeys($account->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccount() only accepts arguments of type Account or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Account relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAccount($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Account');

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
            $this->addJoinObject($join, 'Account');
        }

        return $this;
    }

    /**
     * Use the Account relation Account object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   AccountQuery A secondary query class using the current class as primary query
     */
    public function useAccountQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccount($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Account', 'AccountQuery');
    }

    /**
     * Filter the query by a related AuthyLog object
     *
     * @param   AuthyLog|PropelObjectCollection $authyLog  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthyLog($authyLog, $comparison = null)
    {
        if ($authyLog instanceof AuthyLog) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $authyLog->getIdAuthy(), $comparison);
        } elseif ($authyLog instanceof PropelObjectCollection) {
            return $this
                ->useAuthyLogQuery()
                ->filterByPrimaryKeys($authyLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuthyLog() only accepts arguments of type AuthyLog or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuthyLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinAuthyLog($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuthyLog');

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
            $this->addJoinObject($join, 'AuthyLog');
        }

        return $this;
    }

    /**
     * Use the AuthyLog relation AuthyLog object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   AuthyLogQuery A secondary query class using the current class as primary query
     */
    public function useAuthyLogQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuthyLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuthyLog', 'AuthyLogQuery');
    }

    /**
     * Filter the query by a related GroupRightAuthy object
     *
     * @param   GroupRightAuthy|PropelObjectCollection $groupRightAuthy  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AuthyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByGroupRightAuthy($groupRightAuthy, $comparison = null)
    {
        if ($groupRightAuthy instanceof GroupRightAuthy) {
            return $this
                ->addUsingAlias(AuthyPeer::ID_AUTHY, $groupRightAuthy->getIdAuthy(), $comparison);
        } elseif ($groupRightAuthy instanceof PropelObjectCollection) {
            return $this
                ->useGroupRightAuthyQuery()
                ->filterByPrimaryKeys($groupRightAuthy->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupRightAuthy() only accepts arguments of type GroupRightAuthy or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupRightAuthy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function joinGroupRightAuthy($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupRightAuthy');

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
            $this->addJoinObject($join, 'GroupRightAuthy');
        }

        return $this;
    }

    /**
     * Use the GroupRightAuthy relation GroupRightAuthy object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   GroupRightAuthyQuery A secondary query class using the current class as primary query
     */
    public function useGroupRightAuthyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupRightAuthy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupRightAuthy', 'GroupRightAuthyQuery');
    }

    /**
     * Filter the query by a related GroupRight object
     * using the group_right_authy table as cross reference
     *
     * @param   GroupRight $groupRight the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   AuthyQuery The current query, for fluid interface
     */
    public function filterByGroupRight($groupRight, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useGroupRightAuthyQuery()
            ->filterByGroupRight($groupRight, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   Authy $authy Object to remove from the list of results
     *
     * @return AuthyQuery The current query, for fluid interface
     */
    public function prune($authy = null)
    {
        if ($authy) {
            $this->addUsingAlias(AuthyPeer::ID_AUTHY, $authy->getIdAuthy(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // TableStampBehavior behavior

    /**Filter by the latest updated
     * @param      int $nbDays Maximum age of the latest update in days
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(AuthyPeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by update date desc
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(AuthyPeer::DATE_MODIFICATION);
    }

    /**Order by update date asc
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(AuthyPeer::DATE_MODIFICATION);
    }

    /**Filter by the latest created
     * @param      int $nbDays Maximum age of in days
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(AuthyPeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by create date desc
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(AuthyPeer::DATE_CREATION);
    }

    /**Order by create date asc
     * @return     AuthyQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(AuthyPeer::DATE_CREATION);
    }
}
