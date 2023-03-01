<?php


/**
 * Base class that represents a query for the 'account' table.
 *
 * Compte
 *
 *
 * @package    propel.generator.gen.om
 */
abstract class BaseAccountQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAccountQuery object.
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
            $modelName = 'Account';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AccountQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AccountQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AccountQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AccountQuery) {return $criteria;}
        $query = new AccountQuery(null, null, $modelAlias);
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
     * @return   Account|Account[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AccountPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Account A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdAccount($key, $con = null)
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
     * @return                 Account A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `stripe_customer`, `id_account`, `id_authy`, `stripe_subscription`, `couple`, `status`, `export_ready`, `export_status`, `sexe`, `birth_date`, `firstname`, `lastname`, `email`, `date_expire`, `home_phone`, `other_phone`, `cellphone`, `ext_phone`, `reference`, `address`, `app`, `postal_code`, `proprietaire`, `id_ville`, `id_region`, `id_province`, `id_pays`, `note`, `workplace`, `work`, `username_contest`, `email_contest`, `password_email_contest`, `password_contest`, `air_miles`, `cinoche_username`, `hershey_username`, `hershey_password`, `canton_username`, `presse_username`, `hbc_card`, `milliplein_card`, `metro_card`, `cinoche_password`, `hotmail_password`, `facebook_username`, `facebook_password`, `casa_username`, `id_creation`, `id_modification` FROM `account` WHERE `id_account` = :p0';
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
            $obj = new Account();
            $obj->hydrate($row);
            AccountPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Account|Account[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Account[]|mixed the list of results, formatted by the current formatter
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
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AccountPeer::ID_ACCOUNT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AccountPeer::ID_ACCOUNT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the stripe_customer column
     *
     * Example usage:
     * <code>
     * $query->filterByStripeCustomer('fooValue');   // WHERE stripe_customer = 'fooValue'
     * $query->filterByStripeCustomer('%fooValue%'); // WHERE stripe_customer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stripeCustomer The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByStripeCustomer($stripeCustomer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stripeCustomer)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $stripeCustomer)) {
                $stripeCustomer = str_replace('*', '%', $stripeCustomer);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::STRIPE_CUSTOMER, $stripeCustomer, $comparison);
    }

    /**
     * Filter the query on the id_account column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAccount(1234); // WHERE id_account = 1234
     * $query->filterByIdAccount(array(12, 34)); // WHERE id_account IN (12, 34)
     * $query->filterByIdAccount(array('min' => 12)); // WHERE id_account >= 12
     * $query->filterByIdAccount(array('max' => 12)); // WHERE id_account <= 12
     * </code>
     *
     * @param     mixed $idAccount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByIdAccount($idAccount = null, $comparison = null)
    {
        if (is_array($idAccount)) {
            $useMinMax = false;
            if (isset($idAccount['min'])) {
                $this->addUsingAlias(AccountPeer::ID_ACCOUNT, $idAccount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAccount['max'])) {
                $this->addUsingAlias(AccountPeer::ID_ACCOUNT, $idAccount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::ID_ACCOUNT, $idAccount, $comparison);
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
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByIdAuthy($idAuthy = null, $comparison = null)
    {
        if (is_array($idAuthy)) {
            $useMinMax = false;
            if (isset($idAuthy['min'])) {
                $this->addUsingAlias(AccountPeer::ID_AUTHY, $idAuthy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAuthy['max'])) {
                $this->addUsingAlias(AccountPeer::ID_AUTHY, $idAuthy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::ID_AUTHY, $idAuthy, $comparison);
    }

    /**
     * Filter the query on the stripe_subscription column
     *
     * Example usage:
     * <code>
     * $query->filterByStripeSubscription('fooValue');   // WHERE stripe_subscription = 'fooValue'
     * $query->filterByStripeSubscription('%fooValue%'); // WHERE stripe_subscription LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stripeSubscription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByStripeSubscription($stripeSubscription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stripeSubscription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $stripeSubscription)) {
                $stripeSubscription = str_replace('*', '%', $stripeSubscription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::STRIPE_SUBSCRIPTION, $stripeSubscription, $comparison);
    }

    /**
     * Filter the query on the couple column
     *
     * @param     mixed $couple The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByCouple($couple = null, $comparison = null)
    {
        if (is_scalar($couple)) {
            $couple = AccountPeer::getSqlValueForEnum(AccountPeer::COUPLE, $couple);
        } elseif (is_array($couple)) {
            $convertedValues = array();
            foreach ($couple as $value) {
                $convertedValues[] = AccountPeer::getSqlValueForEnum(AccountPeer::COUPLE, $value);
            }
            $couple = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::COUPLE, $couple, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * @param     mixed $status The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_scalar($status)) {
            $status = AccountPeer::getSqlValueForEnum(AccountPeer::STATUS, $status);
        } elseif (is_array($status)) {
            $convertedValues = array();
            foreach ($status as $value) {
                $convertedValues[] = AccountPeer::getSqlValueForEnum(AccountPeer::STATUS, $value);
            }
            $status = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the export_ready column
     *
     * @param     mixed $exportReady The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByExportReady($exportReady = null, $comparison = null)
    {
        if (is_scalar($exportReady)) {
            $exportReady = AccountPeer::getSqlValueForEnum(AccountPeer::EXPORT_READY, $exportReady);
        } elseif (is_array($exportReady)) {
            $convertedValues = array();
            foreach ($exportReady as $value) {
                $convertedValues[] = AccountPeer::getSqlValueForEnum(AccountPeer::EXPORT_READY, $value);
            }
            $exportReady = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::EXPORT_READY, $exportReady, $comparison);
    }

    /**
     * Filter the query on the export_status column
     *
     * @param     mixed $exportStatus The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByExportStatus($exportStatus = null, $comparison = null)
    {
        if (is_scalar($exportStatus)) {
            $exportStatus = AccountPeer::getSqlValueForEnum(AccountPeer::EXPORT_STATUS, $exportStatus);
        } elseif (is_array($exportStatus)) {
            $convertedValues = array();
            foreach ($exportStatus as $value) {
                $convertedValues[] = AccountPeer::getSqlValueForEnum(AccountPeer::EXPORT_STATUS, $value);
            }
            $exportStatus = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::EXPORT_STATUS, $exportStatus, $comparison);
    }

    /**
     * Filter the query on the sexe column
     *
     * @param     mixed $sexe The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterBySexe($sexe = null, $comparison = null)
    {
        if (is_scalar($sexe)) {
            $sexe = AccountPeer::getSqlValueForEnum(AccountPeer::SEXE, $sexe);
        } elseif (is_array($sexe)) {
            $convertedValues = array();
            foreach ($sexe as $value) {
                $convertedValues[] = AccountPeer::getSqlValueForEnum(AccountPeer::SEXE, $value);
            }
            $sexe = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::SEXE, $sexe, $comparison);
    }

    /**
     * Filter the query on the birth_date column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthDate('fooValue');   // WHERE birth_date = 'fooValue'
     * $query->filterByBirthDate('%fooValue%'); // WHERE birth_date LIKE '%fooValue%'
     * </code>
     *
     * @param     string $birthDate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByBirthDate($birthDate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($birthDate)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $birthDate)) {
                $birthDate = str_replace('*', '%', $birthDate);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::BIRTH_DATE, $birthDate, $comparison);
    }

    /**
     * Filter the query on the firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE firstname = 'fooValue'
     * $query->filterByFirstname('%fooValue%'); // WHERE firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstname)) {
                $firstname = str_replace('*', '%', $firstname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE lastname = 'fooValue'
     * $query->filterByLastname('%fooValue%'); // WHERE lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastname)) {
                $lastname = str_replace('*', '%', $lastname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::LASTNAME, $lastname, $comparison);
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
     * @return AccountQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AccountPeer::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the date_expire column
     *
     * Example usage:
     * <code>
     * $query->filterByDateExpire('2011-03-14'); // WHERE date_expire = '2011-03-14'
     * $query->filterByDateExpire('now'); // WHERE date_expire = '2011-03-14'
     * $query->filterByDateExpire(array('max' => 'yesterday')); // WHERE date_expire < '2011-03-13'
     * </code>
     *
     * @param     mixed $dateExpire The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByDateExpire($dateExpire = null, $comparison = null)
    {
        if (is_array($dateExpire)) {
            $useMinMax = false;
            if (isset($dateExpire['min'])) {
                $this->addUsingAlias(AccountPeer::DATE_EXPIRE, $dateExpire['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateExpire['max'])) {
                $this->addUsingAlias(AccountPeer::DATE_EXPIRE, $dateExpire['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::DATE_EXPIRE, $dateExpire, $comparison);
    }

    /**
     * Filter the query on the home_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByHomePhone('fooValue');   // WHERE home_phone = 'fooValue'
     * $query->filterByHomePhone('%fooValue%'); // WHERE home_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $homePhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByHomePhone($homePhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($homePhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $homePhone)) {
                $homePhone = str_replace('*', '%', $homePhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::HOME_PHONE, $homePhone, $comparison);
    }

    /**
     * Filter the query on the other_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByOtherPhone('fooValue');   // WHERE other_phone = 'fooValue'
     * $query->filterByOtherPhone('%fooValue%'); // WHERE other_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $otherPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByOtherPhone($otherPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($otherPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $otherPhone)) {
                $otherPhone = str_replace('*', '%', $otherPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::OTHER_PHONE, $otherPhone, $comparison);
    }

    /**
     * Filter the query on the cellphone column
     *
     * Example usage:
     * <code>
     * $query->filterByCellphone('fooValue');   // WHERE cellphone = 'fooValue'
     * $query->filterByCellphone('%fooValue%'); // WHERE cellphone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cellphone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByCellphone($cellphone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cellphone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cellphone)) {
                $cellphone = str_replace('*', '%', $cellphone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::CELLPHONE, $cellphone, $comparison);
    }

    /**
     * Filter the query on the ext_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByExtPhone('fooValue');   // WHERE ext_phone = 'fooValue'
     * $query->filterByExtPhone('%fooValue%'); // WHERE ext_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $extPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByExtPhone($extPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($extPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $extPhone)) {
                $extPhone = str_replace('*', '%', $extPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::EXT_PHONE, $extPhone, $comparison);
    }

    /**
     * Filter the query on the reference column
     *
     * Example usage:
     * <code>
     * $query->filterByReference('fooValue');   // WHERE reference = 'fooValue'
     * $query->filterByReference('%fooValue%'); // WHERE reference LIKE '%fooValue%'
     * </code>
     *
     * @param     string $reference The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByReference($reference = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($reference)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $reference)) {
                $reference = str_replace('*', '%', $reference);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::REFERENCE, $reference, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%'); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address)) {
                $address = str_replace('*', '%', $address);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the app column
     *
     * Example usage:
     * <code>
     * $query->filterByApp('fooValue');   // WHERE app = 'fooValue'
     * $query->filterByApp('%fooValue%'); // WHERE app LIKE '%fooValue%'
     * </code>
     *
     * @param     string $app The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByApp($app = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($app)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $app)) {
                $app = str_replace('*', '%', $app);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::APP, $app, $comparison);
    }

    /**
     * Filter the query on the postal_code column
     *
     * Example usage:
     * <code>
     * $query->filterByPostalCode('fooValue');   // WHERE postal_code = 'fooValue'
     * $query->filterByPostalCode('%fooValue%'); // WHERE postal_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postalCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByPostalCode($postalCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postalCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $postalCode)) {
                $postalCode = str_replace('*', '%', $postalCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::POSTAL_CODE, $postalCode, $comparison);
    }

    /**
     * Filter the query on the proprietaire column
     *
     * @param     mixed $proprietaire The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByProprietaire($proprietaire = null, $comparison = null)
    {
        if (is_scalar($proprietaire)) {
            $proprietaire = AccountPeer::getSqlValueForEnum(AccountPeer::PROPRIETAIRE, $proprietaire);
        } elseif (is_array($proprietaire)) {
            $convertedValues = array();
            foreach ($proprietaire as $value) {
                $convertedValues[] = AccountPeer::getSqlValueForEnum(AccountPeer::PROPRIETAIRE, $value);
            }
            $proprietaire = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::PROPRIETAIRE, $proprietaire, $comparison);
    }

    /**
     * Filter the query on the id_ville column
     *
     * Example usage:
     * <code>
     * $query->filterByIdVille(1234); // WHERE id_ville = 1234
     * $query->filterByIdVille(array(12, 34)); // WHERE id_ville IN (12, 34)
     * $query->filterByIdVille(array('min' => 12)); // WHERE id_ville >= 12
     * $query->filterByIdVille(array('max' => 12)); // WHERE id_ville <= 12
     * </code>
     *
     * @see       filterByVille()
     *
     * @param     mixed $idVille The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByIdVille($idVille = null, $comparison = null)
    {
        if (is_array($idVille)) {
            $useMinMax = false;
            if (isset($idVille['min'])) {
                $this->addUsingAlias(AccountPeer::ID_VILLE, $idVille['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idVille['max'])) {
                $this->addUsingAlias(AccountPeer::ID_VILLE, $idVille['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::ID_VILLE, $idVille, $comparison);
    }

    /**
     * Filter the query on the id_region column
     *
     * Example usage:
     * <code>
     * $query->filterByIdRegion(1234); // WHERE id_region = 1234
     * $query->filterByIdRegion(array(12, 34)); // WHERE id_region IN (12, 34)
     * $query->filterByIdRegion(array('min' => 12)); // WHERE id_region >= 12
     * $query->filterByIdRegion(array('max' => 12)); // WHERE id_region <= 12
     * </code>
     *
     * @see       filterByRegion()
     *
     * @param     mixed $idRegion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByIdRegion($idRegion = null, $comparison = null)
    {
        if (is_array($idRegion)) {
            $useMinMax = false;
            if (isset($idRegion['min'])) {
                $this->addUsingAlias(AccountPeer::ID_REGION, $idRegion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idRegion['max'])) {
                $this->addUsingAlias(AccountPeer::ID_REGION, $idRegion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::ID_REGION, $idRegion, $comparison);
    }

    /**
     * Filter the query on the id_province column
     *
     * Example usage:
     * <code>
     * $query->filterByIdProvince(1234); // WHERE id_province = 1234
     * $query->filterByIdProvince(array(12, 34)); // WHERE id_province IN (12, 34)
     * $query->filterByIdProvince(array('min' => 12)); // WHERE id_province >= 12
     * $query->filterByIdProvince(array('max' => 12)); // WHERE id_province <= 12
     * </code>
     *
     * @see       filterByProvince()
     *
     * @param     mixed $idProvince The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByIdProvince($idProvince = null, $comparison = null)
    {
        if (is_array($idProvince)) {
            $useMinMax = false;
            if (isset($idProvince['min'])) {
                $this->addUsingAlias(AccountPeer::ID_PROVINCE, $idProvince['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProvince['max'])) {
                $this->addUsingAlias(AccountPeer::ID_PROVINCE, $idProvince['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::ID_PROVINCE, $idProvince, $comparison);
    }

    /**
     * Filter the query on the id_pays column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPays(1234); // WHERE id_pays = 1234
     * $query->filterByIdPays(array(12, 34)); // WHERE id_pays IN (12, 34)
     * $query->filterByIdPays(array('min' => 12)); // WHERE id_pays >= 12
     * $query->filterByIdPays(array('max' => 12)); // WHERE id_pays <= 12
     * </code>
     *
     * @see       filterByPays()
     *
     * @param     mixed $idPays The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByIdPays($idPays = null, $comparison = null)
    {
        if (is_array($idPays)) {
            $useMinMax = false;
            if (isset($idPays['min'])) {
                $this->addUsingAlias(AccountPeer::ID_PAYS, $idPays['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPays['max'])) {
                $this->addUsingAlias(AccountPeer::ID_PAYS, $idPays['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::ID_PAYS, $idPays, $comparison);
    }

    /**
     * Filter the query on the note column
     *
     * Example usage:
     * <code>
     * $query->filterByNote('fooValue');   // WHERE note = 'fooValue'
     * $query->filterByNote('%fooValue%'); // WHERE note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $note The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByNote($note = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $note)) {
                $note = str_replace('*', '%', $note);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::NOTE, $note, $comparison);
    }

    /**
     * Filter the query on the workplace column
     *
     * Example usage:
     * <code>
     * $query->filterByWorkplace('fooValue');   // WHERE workplace = 'fooValue'
     * $query->filterByWorkplace('%fooValue%'); // WHERE workplace LIKE '%fooValue%'
     * </code>
     *
     * @param     string $workplace The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByWorkplace($workplace = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($workplace)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $workplace)) {
                $workplace = str_replace('*', '%', $workplace);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::WORKPLACE, $workplace, $comparison);
    }

    /**
     * Filter the query on the work column
     *
     * Example usage:
     * <code>
     * $query->filterByWork('fooValue');   // WHERE work = 'fooValue'
     * $query->filterByWork('%fooValue%'); // WHERE work LIKE '%fooValue%'
     * </code>
     *
     * @param     string $work The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByWork($work = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($work)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $work)) {
                $work = str_replace('*', '%', $work);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::WORK, $work, $comparison);
    }

    /**
     * Filter the query on the username_contest column
     *
     * Example usage:
     * <code>
     * $query->filterByUsernameContest('fooValue');   // WHERE username_contest = 'fooValue'
     * $query->filterByUsernameContest('%fooValue%'); // WHERE username_contest LIKE '%fooValue%'
     * </code>
     *
     * @param     string $usernameContest The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByUsernameContest($usernameContest = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($usernameContest)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $usernameContest)) {
                $usernameContest = str_replace('*', '%', $usernameContest);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::USERNAME_CONTEST, $usernameContest, $comparison);
    }

    /**
     * Filter the query on the email_contest column
     *
     * Example usage:
     * <code>
     * $query->filterByEmailContest('fooValue');   // WHERE email_contest = 'fooValue'
     * $query->filterByEmailContest('%fooValue%'); // WHERE email_contest LIKE '%fooValue%'
     * </code>
     *
     * @param     string $emailContest The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByEmailContest($emailContest = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($emailContest)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $emailContest)) {
                $emailContest = str_replace('*', '%', $emailContest);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::EMAIL_CONTEST, $emailContest, $comparison);
    }

    /**
     * Filter the query on the password_email_contest column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswordEmailContest('fooValue');   // WHERE password_email_contest = 'fooValue'
     * $query->filterByPasswordEmailContest('%fooValue%'); // WHERE password_email_contest LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passwordEmailContest The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByPasswordEmailContest($passwordEmailContest = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passwordEmailContest)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $passwordEmailContest)) {
                $passwordEmailContest = str_replace('*', '%', $passwordEmailContest);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::PASSWORD_EMAIL_CONTEST, $passwordEmailContest, $comparison);
    }

    /**
     * Filter the query on the password_contest column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswordContest('fooValue');   // WHERE password_contest = 'fooValue'
     * $query->filterByPasswordContest('%fooValue%'); // WHERE password_contest LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passwordContest The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByPasswordContest($passwordContest = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passwordContest)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $passwordContest)) {
                $passwordContest = str_replace('*', '%', $passwordContest);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::PASSWORD_CONTEST, $passwordContest, $comparison);
    }

    /**
     * Filter the query on the air_miles column
     *
     * Example usage:
     * <code>
     * $query->filterByAirMiles('fooValue');   // WHERE air_miles = 'fooValue'
     * $query->filterByAirMiles('%fooValue%'); // WHERE air_miles LIKE '%fooValue%'
     * </code>
     *
     * @param     string $airMiles The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByAirMiles($airMiles = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($airMiles)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $airMiles)) {
                $airMiles = str_replace('*', '%', $airMiles);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::AIR_MILES, $airMiles, $comparison);
    }

    /**
     * Filter the query on the cinoche_username column
     *
     * Example usage:
     * <code>
     * $query->filterByCinocheUsername('fooValue');   // WHERE cinoche_username = 'fooValue'
     * $query->filterByCinocheUsername('%fooValue%'); // WHERE cinoche_username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cinocheUsername The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByCinocheUsername($cinocheUsername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cinocheUsername)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cinocheUsername)) {
                $cinocheUsername = str_replace('*', '%', $cinocheUsername);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::CINOCHE_USERNAME, $cinocheUsername, $comparison);
    }

    /**
     * Filter the query on the hershey_username column
     *
     * Example usage:
     * <code>
     * $query->filterByHersheyUsername('fooValue');   // WHERE hershey_username = 'fooValue'
     * $query->filterByHersheyUsername('%fooValue%'); // WHERE hershey_username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hersheyUsername The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByHersheyUsername($hersheyUsername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hersheyUsername)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hersheyUsername)) {
                $hersheyUsername = str_replace('*', '%', $hersheyUsername);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::HERSHEY_USERNAME, $hersheyUsername, $comparison);
    }

    /**
     * Filter the query on the hershey_password column
     *
     * Example usage:
     * <code>
     * $query->filterByHersheyPassword('fooValue');   // WHERE hershey_password = 'fooValue'
     * $query->filterByHersheyPassword('%fooValue%'); // WHERE hershey_password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hersheyPassword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByHersheyPassword($hersheyPassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hersheyPassword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hersheyPassword)) {
                $hersheyPassword = str_replace('*', '%', $hersheyPassword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::HERSHEY_PASSWORD, $hersheyPassword, $comparison);
    }

    /**
     * Filter the query on the canton_username column
     *
     * Example usage:
     * <code>
     * $query->filterByCantonUsername('fooValue');   // WHERE canton_username = 'fooValue'
     * $query->filterByCantonUsername('%fooValue%'); // WHERE canton_username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cantonUsername The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByCantonUsername($cantonUsername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cantonUsername)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cantonUsername)) {
                $cantonUsername = str_replace('*', '%', $cantonUsername);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::CANTON_USERNAME, $cantonUsername, $comparison);
    }

    /**
     * Filter the query on the presse_username column
     *
     * Example usage:
     * <code>
     * $query->filterByPresseUsername('fooValue');   // WHERE presse_username = 'fooValue'
     * $query->filterByPresseUsername('%fooValue%'); // WHERE presse_username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $presseUsername The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByPresseUsername($presseUsername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($presseUsername)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $presseUsername)) {
                $presseUsername = str_replace('*', '%', $presseUsername);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::PRESSE_USERNAME, $presseUsername, $comparison);
    }

    /**
     * Filter the query on the hbc_card column
     *
     * Example usage:
     * <code>
     * $query->filterByHbcCard('fooValue');   // WHERE hbc_card = 'fooValue'
     * $query->filterByHbcCard('%fooValue%'); // WHERE hbc_card LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hbcCard The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByHbcCard($hbcCard = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hbcCard)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hbcCard)) {
                $hbcCard = str_replace('*', '%', $hbcCard);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::HBC_CARD, $hbcCard, $comparison);
    }

    /**
     * Filter the query on the milliplein_card column
     *
     * Example usage:
     * <code>
     * $query->filterByMillipleinCard('fooValue');   // WHERE milliplein_card = 'fooValue'
     * $query->filterByMillipleinCard('%fooValue%'); // WHERE milliplein_card LIKE '%fooValue%'
     * </code>
     *
     * @param     string $millipleinCard The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByMillipleinCard($millipleinCard = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($millipleinCard)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $millipleinCard)) {
                $millipleinCard = str_replace('*', '%', $millipleinCard);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::MILLIPLEIN_CARD, $millipleinCard, $comparison);
    }

    /**
     * Filter the query on the metro_card column
     *
     * Example usage:
     * <code>
     * $query->filterByMetroCard('fooValue');   // WHERE metro_card = 'fooValue'
     * $query->filterByMetroCard('%fooValue%'); // WHERE metro_card LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metroCard The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByMetroCard($metroCard = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metroCard)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metroCard)) {
                $metroCard = str_replace('*', '%', $metroCard);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::METRO_CARD, $metroCard, $comparison);
    }

    /**
     * Filter the query on the cinoche_password column
     *
     * Example usage:
     * <code>
     * $query->filterByCinochePassword('fooValue');   // WHERE cinoche_password = 'fooValue'
     * $query->filterByCinochePassword('%fooValue%'); // WHERE cinoche_password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cinochePassword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByCinochePassword($cinochePassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cinochePassword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cinochePassword)) {
                $cinochePassword = str_replace('*', '%', $cinochePassword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::CINOCHE_PASSWORD, $cinochePassword, $comparison);
    }

    /**
     * Filter the query on the hotmail_password column
     *
     * Example usage:
     * <code>
     * $query->filterByHotmailPassword('fooValue');   // WHERE hotmail_password = 'fooValue'
     * $query->filterByHotmailPassword('%fooValue%'); // WHERE hotmail_password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hotmailPassword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByHotmailPassword($hotmailPassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hotmailPassword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hotmailPassword)) {
                $hotmailPassword = str_replace('*', '%', $hotmailPassword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::HOTMAIL_PASSWORD, $hotmailPassword, $comparison);
    }

    /**
     * Filter the query on the facebook_username column
     *
     * Example usage:
     * <code>
     * $query->filterByFacebookUsername('fooValue');   // WHERE facebook_username = 'fooValue'
     * $query->filterByFacebookUsername('%fooValue%'); // WHERE facebook_username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $facebookUsername The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByFacebookUsername($facebookUsername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($facebookUsername)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $facebookUsername)) {
                $facebookUsername = str_replace('*', '%', $facebookUsername);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::FACEBOOK_USERNAME, $facebookUsername, $comparison);
    }

    /**
     * Filter the query on the facebook_password column
     *
     * Example usage:
     * <code>
     * $query->filterByFacebookPassword('fooValue');   // WHERE facebook_password = 'fooValue'
     * $query->filterByFacebookPassword('%fooValue%'); // WHERE facebook_password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $facebookPassword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByFacebookPassword($facebookPassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($facebookPassword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $facebookPassword)) {
                $facebookPassword = str_replace('*', '%', $facebookPassword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::FACEBOOK_PASSWORD, $facebookPassword, $comparison);
    }

    /**
     * Filter the query on the casa_username column
     *
     * Example usage:
     * <code>
     * $query->filterByCasaUsername('fooValue');   // WHERE casa_username = 'fooValue'
     * $query->filterByCasaUsername('%fooValue%'); // WHERE casa_username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $casaUsername The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByCasaUsername($casaUsername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($casaUsername)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $casaUsername)) {
                $casaUsername = str_replace('*', '%', $casaUsername);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountPeer::CASA_USERNAME, $casaUsername, $comparison);
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
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByDateCreation($dateCreation = null, $comparison = null)
    {
        if (is_array($dateCreation)) {
            $useMinMax = false;
            if (isset($dateCreation['min'])) {
                $this->addUsingAlias(AccountPeer::DATE_CREATION, $dateCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreation['max'])) {
                $this->addUsingAlias(AccountPeer::DATE_CREATION, $dateCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::DATE_CREATION, $dateCreation, $comparison);
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
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByDateModification($dateModification = null, $comparison = null)
    {
        if (is_array($dateModification)) {
            $useMinMax = false;
            if (isset($dateModification['min'])) {
                $this->addUsingAlias(AccountPeer::DATE_MODIFICATION, $dateModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModification['max'])) {
                $this->addUsingAlias(AccountPeer::DATE_MODIFICATION, $dateModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::DATE_MODIFICATION, $dateModification, $comparison);
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
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByIdCreation($idCreation = null, $comparison = null)
    {
        if (is_array($idCreation)) {
            $useMinMax = false;
            if (isset($idCreation['min'])) {
                $this->addUsingAlias(AccountPeer::ID_CREATION, $idCreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCreation['max'])) {
                $this->addUsingAlias(AccountPeer::ID_CREATION, $idCreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::ID_CREATION, $idCreation, $comparison);
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
     * @return AccountQuery The current query, for fluid interface
     */
    public function filterByIdModification($idModification = null, $comparison = null)
    {
        if (is_array($idModification)) {
            $useMinMax = false;
            if (isset($idModification['min'])) {
                $this->addUsingAlias(AccountPeer::ID_MODIFICATION, $idModification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idModification['max'])) {
                $this->addUsingAlias(AccountPeer::ID_MODIFICATION, $idModification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountPeer::ID_MODIFICATION, $idModification, $comparison);
    }

    /**
     * Filter the query by a related Authy object
     *
     * @param   Authy|PropelObjectCollection $authy The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AccountQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAuthy($authy, $comparison = null)
    {
        if ($authy instanceof Authy) {
            return $this
                ->addUsingAlias(AccountPeer::ID_AUTHY, $authy->getIdAuthy(), $comparison);
        } elseif ($authy instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccountPeer::ID_AUTHY, $authy->toKeyValue('PrimaryKey', 'IdAuthy'), $comparison);
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
     * @return AccountQuery The current query, for fluid interface
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
     * Filter the query by a related Ville object
     *
     * @param   Ville|PropelObjectCollection $ville The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AccountQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByVille($ville, $comparison = null)
    {
        if ($ville instanceof Ville) {
            return $this
                ->addUsingAlias(AccountPeer::ID_VILLE, $ville->getIdVille(), $comparison);
        } elseif ($ville instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccountPeer::ID_VILLE, $ville->toKeyValue('PrimaryKey', 'IdVille'), $comparison);
        } else {
            throw new PropelException('filterByVille() only accepts arguments of type Ville or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Ville relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function joinVille($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Ville');

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
            $this->addJoinObject($join, 'Ville');
        }

        return $this;
    }

    /**
     * Use the Ville relation Ville object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   VilleQuery A secondary query class using the current class as primary query
     */
    public function useVilleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVille($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Ville', 'VilleQuery');
    }

    /**
     * Filter the query by a related Region object
     *
     * @param   Region|PropelObjectCollection $region The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AccountQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRegion($region, $comparison = null)
    {
        if ($region instanceof Region) {
            return $this
                ->addUsingAlias(AccountPeer::ID_REGION, $region->getIdRegion(), $comparison);
        } elseif ($region instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccountPeer::ID_REGION, $region->toKeyValue('PrimaryKey', 'IdRegion'), $comparison);
        } else {
            throw new PropelException('filterByRegion() only accepts arguments of type Region or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Region relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function joinRegion($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Region');

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
            $this->addJoinObject($join, 'Region');
        }

        return $this;
    }

    /**
     * Use the Region relation Region object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   RegionQuery A secondary query class using the current class as primary query
     */
    public function useRegionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRegion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Region', 'RegionQuery');
    }

    /**
     * Filter the query by a related Province object
     *
     * @param   Province|PropelObjectCollection $province The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AccountQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProvince($province, $comparison = null)
    {
        if ($province instanceof Province) {
            return $this
                ->addUsingAlias(AccountPeer::ID_PROVINCE, $province->getIdProvince(), $comparison);
        } elseif ($province instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccountPeer::ID_PROVINCE, $province->toKeyValue('PrimaryKey', 'IdProvince'), $comparison);
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
     * @return AccountQuery The current query, for fluid interface
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
     * Filter the query by a related Pays object
     *
     * @param   Pays|PropelObjectCollection $pays The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AccountQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPays($pays, $comparison = null)
    {
        if ($pays instanceof Pays) {
            return $this
                ->addUsingAlias(AccountPeer::ID_PAYS, $pays->getIdPays(), $comparison);
        } elseif ($pays instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccountPeer::ID_PAYS, $pays->toKeyValue('PrimaryKey', 'IdPays'), $comparison);
        } else {
            throw new PropelException('filterByPays() only accepts arguments of type Pays or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pays relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function joinPays($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pays');

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
            $this->addJoinObject($join, 'Pays');
        }

        return $this;
    }

    /**
     * Use the Pays relation Pays object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   PaysQuery A secondary query class using the current class as primary query
     */
    public function usePaysQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPays($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pays', 'PaysQuery');
    }

    /**
     * Filter the query by a related Sale object
     *
     * @param   Sale|PropelObjectCollection $sale  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AccountQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySale($sale, $comparison = null)
    {
        if ($sale instanceof Sale) {
            return $this
                ->addUsingAlias(AccountPeer::ID_ACCOUNT, $sale->getIdAccount(), $comparison);
        } elseif ($sale instanceof PropelObjectCollection) {
            return $this
                ->useSaleQuery()
                ->filterByPrimaryKeys($sale->getPrimaryKeys())
                ->endUse();
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
     * @return AccountQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Account $account Object to remove from the list of results
     *
     * @return AccountQuery The current query, for fluid interface
     */
    public function prune($account = null)
    {
        if ($account) {
            $this->addUsingAlias(AccountPeer::ID_ACCOUNT, $account->getIdAccount(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // TableStampBehavior behavior

    /**Filter by the latest updated
     * @param      int $nbDays Maximum age of the latest update in days
     * @return     AccountQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7){
        return $this->addUsingAlias(AccountPeer::DATE_MODIFICATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by update date desc
     * @return     AccountQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst(){
        return $this->addDescendingOrderByColumn(AccountPeer::DATE_MODIFICATION);
    }

    /**Order by update date asc
     * @return     AccountQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst(){
        return $this->addAscendingOrderByColumn(AccountPeer::DATE_MODIFICATION);
    }

    /**Filter by the latest created
     * @param      int $nbDays Maximum age of in days
     * @return     AccountQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7){
        return $this->addUsingAlias(AccountPeer::DATE_CREATION, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**Order by create date desc
     * @return     AccountQuery The current query, for fluid interface
     */
    public function lastCreatedFirst(){
        return $this->addDescendingOrderByColumn(AccountPeer::DATE_CREATION);
    }

    /**Order by create date asc
     * @return     AccountQuery The current query, for fluid interface
     */
    public function firstCreatedFirst(){
        return $this->addAscendingOrderByColumn(AccountPeer::DATE_CREATION);
    }
}
