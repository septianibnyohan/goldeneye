<?PHP
/** -------------------------- Class MyDBI 0.3.2 -----------------------------
 * Project:		MyDBI (MySQL DB Interface)
 * File:		dpf/mydbi.php
 * Created:		13/07/2003 21:12:34
 * Modified:	2/20/2005 10:23:55 PM
 *
 * NOTE:
 * This class is developed and enhanced based on Justin Vincent's
 * popular ezSQL. Visit his website at http://php.justinvincent.com.
 *
 * +++
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @copyright 2007
 * @author
 * @package DeepFrame::MyDBI
 * @version 0.3.2
 *
 *
 * ---------------------------------------------------------- */

/**
* General MYDBI constant
*/

define("MYDBI_VERSION","0.3.2");
define("OBJECT","OBJECT",true);
define("ARRAY_A","ARRAY_A",true);
define("ARRAY_N","ARRAY_N",true);

/**
 * @package MyDBI
 */
class MyDBI
{
	var $dbh;
	/**#@+
     * MyDBI Configuration Section
     */

	/**
     * The name of the database host server, usually "localhost"
     *
     * @var string
     */
	var $hostname;

	/**
     * The user which used to connect the databae
     *
     * @var string
     */
	var $username;

	/**
     * The password which used to connect the databae
     *
     * @var string
     */
	var $password;

	/**
     * The name of the database to be connected
     *
     * @var string
     */
	var $dbname;

	/**
     * Debug called
     *
     * @var boolean
     */
	var $debug_called;

	/**
     * Vardump called
     *
     * @var boolean
     */
	var $vardump_called;

	/**
     * Setting the MyDBI error reporting. If it is set true, MyDBI will
     * bring friendly error message to the screen instead of default
     * PHP-MySql error warning.
     *
     * @var boolean
     */
	//var $show_errors = true; //default value remark by ams
	var $show_errors = false;

    //var $show sqlquery text
    var $show_queries = false;

/**#@+
 * END MyDBI Configuration Section
 * There should be no need to touch anything below this line.
 * @access private
 */

	/**
     * Private instance to save the current table which MyDBI in operation
     *
     * @var string
     */
	var $_tbl_handler = NULL;

	/**
     * The instance of the active table in MyDBI
     *
     * @var string
     */
	var $_op_handler = NULL;

	/**
     * The instance of conditional SQL statement should the MyDBI taken to
     *
     * @var string
     */
	var $_op_where = NULL;			// In WHERE condition the statement be?

	/**
     * The list of insert operational.
     *
     * @var array
     */
	var $_op_insert = Array();

	/**
     * The list of update operational.
     *
     * @var array
     */
	var $_op_update = Array();

	/**
	* @return void
	* @param string $dbname2connect
	* @desc connect MyDBI to the database
	*/
	function connect($dbname2connect = "")
	{
		$this->dbh = mysqli_connect($this->hostname, $this->username, $this->password) or 
			die ("<ol><b>Error establishing a database connection!</b><li>Are you sure you have the correct user/password?<li>Are you sure that you have typed the correct hostname?<li>Are you sure that the database server is running?</ol>"); ;
		
			/*
		if ( ! $this->dbh )
		{
			$this->print_error("<ol><b>Error establishing a database connection!</b><li>Are you sure you have the correct user/password?<li>Are you sure that you have typed the correct hostname?<li>Are you sure that the database server is running?</ol>");
		}
		*/

		// If OK, select the database
		if ( $this->dbname == "")
		{
			$this->select($this->dbname);
		}
		else
		{
			$this->select($dbname2connect);
		}
    }


	/**
	* @return void
	* @param string $db
	* @desc Select a DB (if another one needs to be selected)
	*/
	function select($db)
	{
		if ( !mysqli_select_db($this->dbh, $db))
		{
			$this->print_error("<ol><b>Error selecting database <u>$db</u>!</b><li>Are you sure it exists?<li>Are you sure there is a valid database connection?</ol>");
		}
	}
	// End select function ==============================================


	/**
	* Format a string correctly for safe insert under all PHP conditions
	*
	* @return unknown
	* @param string $str
	*/
	function escape($str)
	{
		return mysql_escape_string(stripslashes($str));
	}
	// End escape funstion ==============================================


	/**
	* @return unknown
	* @param unknown $str
	* @desc Print SQL/DB error.
	*/
	function print_error($str = "")
	{
		// All erros go to the global error array $EZSQL_ERROR..
		global $MYDB_ERROR;

		// If no special error string then use mysql default..
		if ( !$str ) $str = mysqli_error($this->dbh);

		// Log this error to the global array..
		$MYDB_ERROR[] = array
						(
							"query" => $this->last_query,
							"error_str"  => $str
						);

		// Is error output turned on or not..
		if ( $this->show_errors )
		{
			// If there is an error then take note of it
			print "<blockquote><font face=arial size=2 color=ff0000>";
			print "<b>MyDBI " . MYDBI_VERSION . " : SQL/DB Error --</b> ";
			print "[<font color=000077>$str</font>]";
			print "</font></blockquote>";
		}
		else
		{
			return false;
		}
	}


	/**
	* @return void
	* @desc Turn error handling on or off..
	*/
	function show_errors()
	{
		$this->show_errors = true;
	}

	/**
	* @return void
	* @desc Hide the internal MyDBI error reporting
	*/
	function hide_errors()
	{
		$this->show_errors = false;
	}


	/**
	* @return void
	* @desc Kill cached query results
	*/
	function flush()
	{
		// Get rid of these
		$this->last_result = null;
		$this->col_info = null;
		$this->last_query = null;
	}


	/**
	* @return unknown
	* @param unknown $query
	* @desc Basic Query	- see docs for more detail
	*/
	function query($query)
	{
		//echo "<br />" . $query;
		// Flush cached values..
		$this->flush();

		// Log how the function was called
		$this->func_call = "\$db->query(\"$query\")";

		// Keep track of the last query for debug..
		$this->last_query = $query;

        //added by ams (self customization)
        if($this->show_queries)
            echo $query;

		// Perform the query via std mysql_query function..
		$this->result = mysqli_query($this->dbh, $query);

		// If there was an insert, delete or update see how many rows were affected
		// (Also, If there there was an insert take note of the insert_id
		$query_type = array("insert","delete","update","replace");

		// loop through the above array
		foreach ( $query_type as $word )
		{
			// This is true if the query starts with insert, delete or update
			if ( preg_match("/^\\s*$word /i",$query) )
			{
				$this->rows_affected = mysqli_affected_rows($this->dbh);

				// This gets the insert ID
				if ( $word == "insert" || $word == "replace" )
				{
					$this->insert_id = mysqli_insert_id($this->dbh);
				}

				$this->result = false;
			}
		}

		if ( mysqli_error($this->dbh) )
		{
			// If there is an error then take note of it..
			$this->print_error();
		}
		else
		{
			// In other words if this was a select statement..
			if ( $this->result )
			{
				// =======================================================
				// Take note of column info
				$i=0;
				while ($i < mysqli_num_fields($this->result))
				{
					$this->col_info[$i] = mysqli_fetch_field($this->result);
					$i++;
				}

				// =======================================================
				// Store Query Results
				$i=0;
				while ( $row = mysqli_fetch_object($this->result) )
				{
					// Store relults as an objects within main array
					$this->last_result[$i] = $row;

					$i++;
				}

				// Log number of rows the query returned
				$this->num_rows = $i;

				mysqli_free_result($this->result);


				// If there were results then return true for $db->query
				if ( $i )
				{
					return true;
				}
				else
				{
					return false;
				}
			} // if ($this->result)
			else
			{
				// Update insert etc. was good..
				return true;
			}
		}
	}


	/**
	* Get one variable from the DB
	*
	* @return mixed
	* @param string $query
	* @param integer $x
	* @param integer $y
	*/
	function get_var($query=null,$x=0,$y=0)
	{
		// Log how the function was called
		$this->func_call = "\$db->get_var(\"$query\",$x,$y)";

		// If there is a query then perform it if not then use cached results..
		if ( $query )
		{
			$this->query($query);
		}

		// Extract var out of cached results based x,y vals
		if ( $this->last_result[$y] )
		{
			$values = array_values(get_object_vars($this->last_result[$y]));
		}

		// If there is a value return it else return null
		return (isset($values[$x]) && $values[$x]!=='')?$values[$x]:null;
	}


	/**
	* Get one row from the DB - see docs for more detail
	*
	* @return mixed
	* @param string $query
	* @param mixed $output
	* @param integer $y
	*/
	function get_row($query=null,$output=OBJECT,$y=0)
	{
		// Log how the function was called
		$this->func_call = "\$db->get_row(\"$query\",$output,$y)";

		// If there is a query then perform it if not then use cached results..
		if ( $query )
		{
			$this->query($query);
		}

		// If the output is an object then return object using the row offset..
		if ( $output == OBJECT )
		{
			return $this->last_result[$y]?$this->last_result[$y]:null;
		}

		// If the output is an associative array then return row as such..
		elseif ( $output == ARRAY_A )
		{
			return $this->last_result[$y]?get_object_vars($this->last_result[$y]):null;
		}

		// If the output is an numerical array then return row as such..
		elseif ( $output == ARRAY_N )
		{
			return $this->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
		}

		// If invalid output type was specified..
		else
		{
			$this->print_error(" \$db->get_row(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N");
		}
	}

	/**
	* Function to get 1 column from the cached result set based in X index
	* see docs for usage and info
	*
	* @return array
	* @param string $query
	* @param integer $x
	*/
	function get_col($query=null,$x=0)
	{
		// If there is a query then perform it if not then use cached results..
		if ( $query )
		{
			$this->query($query);
		}

		// Extract the column values
		for ( $i=0; $i < count($this->last_result); $i++ )
		{
			$new_array[$i] = $this->get_var(null,$x,$i);
		}

		return $new_array;
	}


	/**
	* Return the the query as a result set - see docs for more details
	* @return mixed|array
	* @param string $query
	* @param object $output
	*/
	function get_results($query=null, $output = OBJECT)
	{
		// Log how the function was called
		$this->func_call = "\$db->get_results(\"$query\", $output)";

		// If there is a query then perform it if not then use cached results..
		if ( $query )
		{
			$this->query($query);
		}

		// Send back array of objects. Each row is an object
		if ( $output == OBJECT )
		{
			return $this->last_result;
		}
		elseif ( $output == ARRAY_A || $output == ARRAY_N )
		{
			if ( $this->last_result )
			{
				$i=0;
				foreach( $this->last_result as $row )
				{
					$new_array[$i] = get_object_vars($row);

					if ( $output == ARRAY_N )
					{
						$new_array[$i] = array_values($new_array[$i]);
					}

					$i++;
				}

				return $new_array;
			}
			else
			{
				return null;
			}
		}
	}


	/**
	* Function to get column meta data info pertaining to the last query
	* see docs for more info and usage
	*
	* @return mixed
	* @param string $info_type
	* @param integer $col_offset
	*/
	function get_col_info($info_type="name",$col_offset=-1)
	{
		if ( $this->col_info )
		{
			if ( $col_offset == -1 )
			{
				$i=0;
				foreach($this->col_info as $col )
				{
					$new_array[$i] = $col->{$info_type};
					$i++;
				}
				return $new_array;
			}
			else
			{
				return $this->col_info[$col_offset]->{$info_type};
			}
		}
	}


	/**
	* Dumps the contents of any input variable to screen in a nicely
	* formatted and easy to understand way - any type: Object, Var or Array
	*
	* @return void
	* @param mixed $mixed
	*/
	function vardump($mixed)
	{
		echo "<blockquote><font color=000090>";
		echo "<pre><font face=arial>";

		if ( ! $this->vardump_called )
		{
			echo "<font color=800080><b>MyDB</b> (v".MYDB_VERSION.") <b>Variable Dump..</b></font>\n\n";
		}

		$var_type = gettype ($mixed);
		print_r(($mixed?$mixed:"<font color=red>No Value / False</font>"));
		echo "\n\n<b>Type:</b> " . ucfirst($var_type) . "\n";
		echo "<b>Last Query:</b> ".($this->last_query?$this->last_query:"NULL")."\n";
		echo "<b>Last Function Call:</b> " . ($this->func_call?$this->func_call:"None")."\n";
		echo "<b>Last Rows Returned:</b> ".count($this->last_result)."\n";
		echo "</font></pre></font></blockquote>";
		echo "\n<hr size=1 noshade color=dddddd>";

		$this->vardump_called = true;
	}

	/**
	* Alias for the vardump function
	*
	* @return void
	* @param mixed $mixed
	*/
	function dumpvar($mixed)
	{
		$this->vardump($mixed);
	}


	/**
	* Displays the last query string that was sent to the database & a
	* table listing results (if there were any).
	* (abstracted into a seperate file to save server overhead).
	*
	* @return void
	*/
	function debug()
	{

		echo "<blockquote>";

		// Only show ezSQL credits once..
		if ( ! $this->debug_called )
		{
			echo "<font color=800080 face=arial size=2><b>MyDB</b> (v".MYDB_VERSION.") <b>Debug..</b></font><p>\n";
		}
		echo "<font face=arial size=2 color=000099><b>Query --</b> ";
		echo "[<font color=000000><b>$this->last_query</b></font>]</font><p>";

			echo "<font face=arial size=2 color=000099><b>Query Result..</b></font>";
			echo "<blockquote>";

		if ( $this->col_info )
		{

			// =====================================================
			// Results top rows

			echo "<table cellpadding=5 cellspacing=1 bgcolor=555555>";
			echo "<tr bgcolor=eeeeee><td nowrap valign=bottom><font color=555599 face=arial size=2><b>(row)</b></font></td>";


			for ( $i=0; $i < count($this->col_info); $i++ )
			{
				echo "<td nowrap align=left valign=top><font size=1 color=555599 face=arial>{$this->col_info[$i]->type} {$this->col_info[$i]->max_length}</font><br><font size=2><b>{$this->col_info[$i]->name}</b></font></td>";
			}

			echo "</tr>";

			// ======================================================
			// print main results

		if ( $this->last_result )
		{

			$i=0;
			foreach ( $this->get_results(null,ARRAY_N) as $one_row )
			{
				$i++;
				echo "<tr bgcolor=ffffff><td bgcolor=eeeeee nowrap align=middle><font size=2 color=555599 face=arial>$i</font></td>";

				foreach ( $one_row as $item )
				{
					echo "<td nowrap><font face=arial size=2>$item</font></td>";
				}

				echo "</tr>";
			}

		} // if last result
		else
		{
			echo "<tr bgcolor=ffffff><td colspan=".(count($this->col_info)+1)."><font face=arial size=2>No Results</font></td></tr>";
		}

		echo "</table>";

		} // if col_info
		else
		{
			echo "<font face=arial size=2>No Results</font>";
		}

		echo "</blockquote></blockquote><hr noshade color=dddddd size=1>";


		$this->debug_called = true;
	}
	// End debug function ===========================================

	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^
	// End Justin Vincent function





	// ======================================
	// Easy DB Operation routines
	// Modified: 13/07/2003 19:06:35
	// ======================================


	/**
	* @return void
	* @param string $tblname the name of the table to be inserted
	* @desc creates new insert operation instance
	*/
	function create_insert($tblname)
	{
			$this->_tbl_handler = $tblname;		// Set the table handler
			$this->_op_handler = 'INSERT';	// Set the triggers for INSERT
			$this->_op_insert = array();		// (re)Initiate the insert array list
	}
	// End create_insert ===================================================


	/**
	* add inserted column to the insert operation
	*
	* @return void
	* @param string $col the column name to insert
	* @param mixed $val the value to be inserted
	* @param string $type the OPTIONAL variable juggling
	*/
	function add_insert($col, $val, $type = '') {
		// $type is a posibility for variable juggling

		// Check if the active operation handler is INSERT
		if ($this->_op_handler == 'INSERT')
		{
			if ($type=='')
			{
				// Default insert without any variable juggling
				$this->_op_insert[] = array($col => $val);
			}
			elseif ($type=='STRING')
			{
				// STRING juggling
				$this->_op_insert[] = array($col => (string) $val);
			}
			elseif ($type=='INT')
			{
				// Variable juggling to INT (integer)
				$this->_op_insert[] = array($col => (int) $val);
			}
			else
			{
				// Anything else, juggled it to STRING for safety reason
				$this->_op_insert[] = array($col => (string) $val);
			}
		} // If op_handler=='INSERT'
		else
		{
			// If not, brings error message
			$this->print_error("<ol><b>Error add_insert</b><li>You're trying a mis-operation handler<li>This function can be called if <u>create_insert</u> has been initiated</li></ol>");
		}
	}


	/**
	* creates new update operation instance
	*
	* @return void
	* @param string $tblname
	*/
	function create_update($tblname)
	{
			$this->_tbl_handler = $tblname;		// Set the table handler
			$this->_op_handler = 'UPDATE';	// Set the triggers for INSERT
			$this->_op_update = array();		// (re)Initiated the update array list
	}


	/**
	 * creates new update operation instance
	 *
	 * @return void
	 * @param string $col the column name to be updated
	 * @param string $val the value to be updated in the column
	 * @param string $type the OPTIONAL string of juggling variable
	 */
	function add_update($col, $val, $type = '') {
		// $type is a posibility for variable juggling

		// Check if the active operation handler is UPDATE
		if ($this->_op_handler == 'UPDATE')
		{
			if ($type=='')
			{
				// Default update without any variable juggling
				$this->_op_update[] = array($col => $val);
			}
			else if ($type=='STRING')
			{
				// STRING juggling
				$this->_op_update[] = array($col => (string) $val);
			}
			else if ($type=='INT')
			{
				// INT juggling
				$this->_op_update[] = array($col => (int) $val);
			}
			else
			{
				// Anything else, brings to STRING juggling
				$this->_op_update[] = array($col => (string) $val);
			}
		} // If op_handler=='UPDATE'
		else
		{
			// If not, brings error message
			$this->print_error("<ol><b>Error add_update</b><li>You're trying a mis-operation handler<li>This function only can be called if <u>create_update</u> has been initiated</li></ol>");
		}
	}


	/**
	* @return void
	* @param string $tblname
	* @desc creates new delete operation instance
	*/
	function create_delete($tblname) {
		$this->_tbl_handler = $tblname;
		$this->_op_handler = 'DELETE';
	}


	/**
	* Set the WHERE condition for every DB operation
	* Example:
	* $db->set_condition("COL_NAME = 'Name');
	*
	* @return void
	* @param string $condition_str
	*/
	function set_condition($condition_str)
	{
		if ($condition_str=="")
		{
			$this->print_error("<ol><b>Error <u>setCondition('WHERE statements')</u>!</b><li>Are you leave it blank in your setCondition?</li><li>Please provide it with a complete WHERE statements</ol>");
		}
		else
		{
			if (($this->_op_handler == 'UPDATE')||($this->_op_handler == 'DELETE')) {
				$this->_op_where = $condition_str;
			}
		}
	}


	/**
	* Executes the active db operation (INSERT, UPDATE, DELETE)
	* which activated by the previous add_insert or add_update or
	* add_delete operation.
	*
	* @return void
	* @param boolean $exec_mode
	*/
	function execute($exec_mode = true)
	{
		// Check whether the op_handler called, if not, brings error message
		if (is_null($this->_op_handler))
		{
			$this->print_error("<ol><b>Error Execution!</b><li><b>MyDB->Execute</b> should be called after <u>create_insert</u> or <u>create_update</u> or <u>create_delete</u></ol>");
		}
		else
		{
			$sqlstr = '';			// Give empty SQL string

			switch ($this->_op_handler)
			{
				case 'INSERT':
					// Error handling if there is blank INSERT
					if (count($this->_op_insert)==0)
					{
						$this->print_error("insert=".count($this->_op_insert));
						$this->print_error("<ol><b>Error Execution!</b><li><b>MyDB->Execute</b> should be called after <u>create_insert</u> and there is at least one field inserted by <u>add_insert</u></ol>");
						break;
					}

					$strcol = array();
					$strval = array();

					// Retrieve list of INSERT data in previous given task
					while (list($k,$v) = each($this->_op_insert))
					{
						$strcol[] = key($v);		// Get the key for column name
						$vv = $v[key($v)];			// And get the value

						if (is_null($vv))
						{
							// If NULL, remember to set it to 'NULL' in SQL string (as string, not exact NULL variable)
							$strval[] = "NULL";
						}
						else
						{
							if (is_int($vv))
							{
								// Save the value to value array without ' if it's integer value
								$strval[] = $vv;
							}
							else
							{
								// Save the value with ' if it's string
								if ( !get_magic_quotes_gpc() ) {
									$vv = addslashes($vv);
								}

								$strval[] = "'". $vv . "'";
							}
						}
					}

			$str_sql = 'INSERT INTO '.$this->_tbl_handler.' ('.implode(',', $strcol).') VALUES('.implode(',', $strval).')';
					break;
				// End case 'INSERT'

				case 'UPDATE':
					// Error handling if there is blank UPDATE
					if (count($this->_op_update)==0)
					{
						$this->print_error("<ol><b>Error Execution!</b><li><b>MyDB->Execute</b> should be called after <u>create_update</u> and there is at least one field inserted by <u>add_update</u></ol>");
						break;
					}

					$str_sql = array();

					// Retrieve list of UPDATE data in previous given task
					while (list($k,$v) = each($this->_op_update))
					{
						$kk = key($v);				// Get the key for column name
						$vv = $v[$kk];				// And get the value

						if (is_null($vv))
						{
							// If NULL, remember to set it to 'NULL' in SQL string (as string, not exact NULL variable)
							$vv = 'NULL';
						}
						else
						{
							if (is_string($vv))
							{
								// Save the value with ' if it's string
								if ( !get_magic_quotes_gpc() ) {
									$vv = addslashes($vv);
								}

								$vv = "'". $vv . "'";
							}
						}
						$str_sql[] = $kk . '=' . $vv;		// Glue it in pair of column and value UPDATE for future SET statement
					}

					// Glue all value for complete UPDATE statement
					$str_sql = 'UPDATE '.$this->_tbl_handler.' SET '. implode(',', $str_sql);

					// Give WHERE based on op_where where activated by set_condition
					if ($this->_op_where!='') $str_sql .= ' WHERE '.$this->_op_where;
					break;
				// End case 'UPDATE'

				case 'DELETE':
					// Create DELETE statement
					$str_sql = 'DELETE FROM '.$this->_tbl_handler;

					// Give WHERE based on op_where where activated by set_condition
					if ($this->_op_where!='') $str_sql .= ' WHERE '.$this->_op_where;

					break;
				// End case 'DELETE'

				default: break;			// Default
			}
		} // If ->op_handler is NULL

		$this->_tbl_handler = NULL;
		$this->_op_handler = NULL;

		if ($exec_mode) {
			$this->query($str_sql);
		} else {
			$this->print_error($str_sql);
		}
	}
}

/* ---------------------------------------------------------------------
*                     END MyDBI Class 0.3.2
* ------------------------------------------------------------------- */
?>