<?php
/**
 * Interface for database drivers
 *
 * PHP Version 5.3
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 * @package   DB
 * @author    Johannes Schlüter <johannes@php.net>
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2007-2015 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2007-08-19
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    exit();
}

/**
 * PMF_DB_Driver
 *
 * @category  phpMyFAQ
 * @package   DB
 * @author    Johannes Schlüter <johannes@php.net>
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2007-2015 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2007-08-19
 */
interface PMF_DB_Driver
{
    /**
     * Connects to the database server
     *
     * @param string $host     Hostname
     * @param string $user     Username
     * @param string $password Password
     * @param string $db       Database name
     *
     * @return boolean
     */
    public function connect($host, $user, $password, $db = '');

    /**
     * This function sends a query to the database.
     *
     * @param string  $query
     * @param integer $offset
     * @param integer $rowcount
     *
     * @return  mixed $result
     */
    public function query($query, $offset = 0, $rowcount = 0);

    /**
     * Escapes a string for use in a query
     *
     * @param   string
     * @return  string
     */
    public function escape($string);

    /**
     * Fetch a result row as an object
     *
     * @param   mixed $result
     * @return  mixed
     */
    public function fetchObject($result);

    /**
     * Fetch a result row as an array.
     *
     * @param   mixed $result
     * @return  array
     */
    public function fetchArray($result);

    /**
     * Fetches a complete result as an object
     *
     * @param  resource      $result Resultset
     * @return PMF_DB_Driver
     */
    public function fetchAll($result);

    /**
     * Number of rows in a result
     *
     * @param   mixed $result
     * @return  integer
     */
    public function numRows($result);

    /**
     * Logs the queries
     *
     * @return integer
     */
    public function log();

    /**
     * This function returns the table status.
     *
     * @access  public
     * @return  array
     */
    public function getTableStatus();

    /**
     * Returns the next ID of a table
     *
     * @param   string      the name of the table
     * @param   string      the name of the ID column
     * @return  int
     */
    public function nextId($table, $id);

    /**
     * Returns the error string.
     *
     * @return string
     */
    public function error();

    /**
     * Returns the libary version string.
     *
     * @return string
     */
    public function clientVersion();

    /**
     * Returns the libary version string.
     *
     * @return string
     */
    public function serverVersion();

    /**
     * Returns an array with all table names
     *
     * @param  string $prefix Table prefix
     *
     * @return array
     */
    public function getTableNames($prefix = '');

    /**
     * Closes the connection to the database.
     *
     * @access boolean
     */
    public function close();
    
    /**
     * Return SQL expression that yeilds current datetime in the local timezone.
     * The actual SQL value may be of SQL datetime type (or timestamp or similar)
     * or it may be varchar/text (as is in SQLite3) - so make sure the consumer
     * code doesn't depend on the actual type.
     *
     * @return string String that you can pass to SQL as in: SELECT <result of PMF_Db_Driver_instance->now()>
     */
    public function now();
}
