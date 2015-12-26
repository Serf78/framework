<?php
/**
 * Abstract Engine.
 *
 * @author Tom Valk - tomvalk@lt-box.info
 * @version 3.0
 * @date December 19th, 2015
 */

namespace Nova\Database;

/**
 * Interface Engine
 * @package Nova\Database\Engine
 */
interface Engine
{
    /**
     * Get the name of the driver
     * @return string
     */
    public function getDriverName();

    /**
     * Get driver code, used in config as driver string.
     * @return string
     */
    public function getDriverCode();

    /**
     * Get configuration for instance
     * @return array
     */
    public function getConfiguration();

    /**
     * Get native connection. Could be \PDO
     * @return mixed|\PDO
     */
    public function getConnection();

    /**
     * Get total executed queries.
     *
     * @return int
     */
    public function getTotalQueries();



    /** Generic Public Api Commands */

    /**
     * Basic execute statement. Only for queries with no binding parameters
     *
     * @param string $sql
     * @param boolean $fetch
     * @return mixed
     */
    public function raw($sql, $fetch = false);
    public function rawQuery($sql);


    /**
     * Execute Select Query, bind values into the $sql query. And give optional method and class for fetch result
     * The result MUST be an array!
     *
     * @param string $sql
     * @param array $bindParams
     * @param bool $fetchAll Ask the method to fetch all the records or not.
     * @param null $method Customized method for fetching, null for engine default or config default.
     * @param null $class Class for fetching into classes.
     * @return array|null
     *
     * @throws \Exception
     */
    public function select($sql, $bindParams = array(), $fetchAll = false, $method = null, $class = null);

    /**
     * Convenience methods for selecting records.
     *
     * @param string $sql
     * @param array $bindParams
     * @param null $method Customized method for fetching, null for engine default or config default.
     * @param null $class Class for fetching into classes.
     * @return array|null
     *
     * @throws \Exception
     */
    public function selectOne($sql, $bindParams = array(), $method = null, $class = null);
    public function selectAll($sql, $bindParams = array(), $method = null, $class = null);

    /**
     * Execute insert query, will automatically build query for you.
     * You can also give an array as $data, this will try to insert each entry in the array.
     * Not all engine's support this! Check the manual!
     *
     * @param string $table Table to execute the insert.
     * @param array $data Represents one record, could also have multidimensional arrays inside to insert
     *                    multiple rows in one call. The engine must support this! Check manual!
     * @param bool $transaction
     * @return bool|int
     *
     * @throws \Exception
     */
    public function insert($table, $data, $transaction = false);

    /**
     * Execute insert query, will automatically build query for you.
     * You can also give an array as $data, this will try to insert each entry in the array.
     * Not all engine's support this! Check the manual!
     *
     * @param string $table Table to execute the insert.
     * @param array $data Represents one record, could also have multidimensional arrays inside to insert
     *                    multiple rows in one call. The engine must support this! Check manual!
     * @param bool $transaction
     * @return bool|int
     */
    public function insertBatch($table, $data, $transaction = false);

    /**
     * Execute update query, will automatically build query for you.
     *
     * @param string $table Table to execute the statement.
     * @param array $data The updated array, will map into an update statement.
     * @param array $where Use key->value like column->value for where mapping.
     * @return int|bool
     *
     * @throws \Exception
     */
    public function update($table, $data, $where);

    /**
     * Execute Delete statement, this will automatically build the query for you.
     *
     * @param string $table Table to execute the statement.
     * @param array $where Use key->value like column->value for where mapping.
     * @return bool
     *
     * @throws \Exception
     */
    public function delete($table, $where);

    /**
     * Truncate table
     * @param  string $table table name
     * @return int number of rows affected
     */
    public function truncate($table);

    /**
     * Prepare the query and return a prepared statement.
     * Optional bind is available.
     *
     * @param string $sql Query
     * @param array $bind optional binding values
     * @param int|null $method custom method
     * @param string|null $class class fetch, the class, full class with namespace.
     * @return \PDOStatement|mixed
     *
     * @throws \Exception
     */
    public function rawPrepare($sql, $bind = array(), $method = null, $class = null);
}
