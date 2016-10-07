<?php
namespace ContenderApps\CatalystBot;

use PDO;

/**
 * @author Marc Rochkind - from his PHP book
 * @author Adam Szewera	(added some stuff...)
 * @version 2014-08-03
 * @desc  A simple class to simplify the common task of connecting to a database.
 */


class DbAccess {

	/**
	 * TODO: what does it do ?
	 * @return PDO
	 */
	protected function getPDO() {
		static $pdo;

		// todo find another way to include the settings
		$config = include 'config.php';

		if (!isset($pdo)) {
// 			$dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
// 			$pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
			$pdo = new PDO('sqlite:' . $config['db_path']);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		// error reporting, throws exceptions
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);	// returns an array indexed by column
																				// 			name as returned in your result set
// 			$pdo->exec('SET SESSION SQL_MODE = TRADITIONAL');					// mysql configuration
// 			$pdo->exec('SET SESSION INNODB_STRICT_MODE = on');
		}
		return $pdo;
	}


	/**
	 * Execute a SQL query
	 * @param $sql
	 * @param null $input_parameters
	 * @param null $insert_id
	 * @return mixed
	 */
	function query($sql, $input_parameters=null, &$insert_id=null) {
		$pdo = $this->getPDO();
		$insert_id = null;
		if (is_null($input_parameters))	{	// if there are no parameters, then it is a select
			$stmt =  $pdo->query($sql);
		} else {
			$stmt = $pdo->prepare($sql);
			$stmt->execute($input_parameters);
		}
		if (stripos($sql, 'insert ') === 0) {
			$insert_id = $pdo->lastInsertId();
		}
		return $stmt;
	}
	
	
	/**
	 * Update rows in a specific table.
	 * Note: it assumes that the table has a primary key that is composed of ONLY one field.
	 * 
	 * @param string 		$table
	 * @param string or int $pkfield	given if updating a specific tuple, null otherwise
	 * @param array 		$fields		fields to update
	 * @param array 		$data		associative array with pairs key->value where key is part of the fields array
	 * @param int  			$row_count
	 */
	public function update($table, $pkfield, $fields, $data, &$row_count=null) {
		var_dump($fields);
		var_dump($data);
		$input_parameters = array();
		$upd = '';						// SQL update string	
		foreach($fields as $f) { 
			if( !isset( $data[$f] ) || is_null($data[$f])) { 
				$v = 'NULL';			// (given a good db design) the database design should refuse this	
			} else { 
				$v = ":$f";
				$input_parameters[$f] = $data[$f];	
			}
			$upd .= ", $f=$v";			// update that field $f with value $v (which is going to be encoded by PDO class for security reasons)
		}
		$upd = substr($upd, 2);			// remove the starting ", " from the upd str
		if (empty($data[$pkfield])) { 	// does this query update a specific row ? i.e. identified by a pk
			$sql = "INSERT $table SET $upd";
		} else {
			$input_parameters[$pkfield] = $data[$pkfield];
			$sql = "UPDATE $table set $upd WHERE $pkfield=:$pkfield";
		}
		$stmt = $this->query($sql, $input_parameters, $insert_id);
		$row_count = $stmt->rowCount();
		return $insert_id;
	}	
	
	

}
