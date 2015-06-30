<?php

/**
##### Avaliable functions: #####
  
 exec();
 
 addQuery($query);

 
##### Debug Function #####

 printErrors();
  
 debugQueries($qNo = "");
 
 
 ##### Usage Example #####

	$q = new writeDb(true); //use true if you want it to die on error
	
	//you can add one or more queries
	$q->addQuery("INSETR INTO table VALUES(1,2,3)");
	$q->addQuery("DELETO FROM table WHERE id=1");
	
	$q-exec();

*/ 



 /**
  * readDb - Used to query the db
  * 
  * @author DanielSilva
  * @copyright 2011
  * @version 1.0
  * @access public
  */
 class writeDb{
 	/**
 	 * Errors in query
	 */ 
 	private $errors = array();
 	
 	/**
 	 * Die on error
	 */ 
 	private $errorDie = false;
 	
 	/**
 	 * If "transaction" has been initializated
	 */ 
 	private $start = false;
 	
 	/**
 	 * Stores the queries added by user
	 */ 
 	private $queries = array();
 	
 	
 	/**
 	 * Do queries that change the database
 	 * 
 	 * @param bool $errorDie - Optional. Use true if you want it to die on error
 	 * @return void
 	 */
 	function __construct($errorDie = false){
 		if(func_num_args()>1){
 			die("Wrong number of parameters. See class documentation");
 		}
 		$this->errorDie = $errorDie;
 		$this->startTransaction();
 	}
 	
 	/**
 	 * Executes all the given queries
 	 * Commit changes on success
 	 * 
 	 * @return boolean
 	 */
 	public function exec(){
 		if(empty($this->queries)){
	 		return false;
	 	}
	 	if(!$this->start){
	 		$this->startTransaction();
	 	}
 		
 		$queryNo=0;
 		
 		foreach($this->queries as $q){
 			
 			if(!mysql_query($q)){
 				$error = mysql_error();
 				mysql_query("ROLLBACK");
 				
 				if($this->errorDie){
 					die($error." Reported by exec(), in query ".$queryNo);
 				}else{
 					$this->errors[] = $error." Reported by exec(), in query ".$queryNo;
 					return false;
 				}
 				
 			}
 			
			$queryNo++;
 		}
 		mysql_query("COMMIT");
 		$this->start=false;
 		
 		//clean queries
 		$this->queries = array();
 		return true;
 	}
 	
 	
 	/**
 	 * Adds a query to the query array
 	 * Returns false if no query given
 	 * Returns string with query on success
 	 * 
 	 * @return mixed
 	 */
 	public function addQuery($query){
 		if(isset($query)){
 			$this->queries[] = $query;
 			return $query;
 		}else{
 			return false;
 		}
 	}
 	
 	/**
 	 * Starts the transaction if not started yet
 	 * 
 	 * @return void
 	 */
 	private function startTransaction(){
 		if(!$this->start){
	 		if($this->errorDie){
	 			mysql_query("START TRANSACTION") or die(mysql_error()." Reported by mysql_error().");
				mysql_query("BEGIN") or die(mysql_error()." Reported by mysql_error().");
	 		}else{
	 			mysql_query("START TRANSACTION");
	 			if(mysql_error()) $this->errors[] = mysql_error()." Reported by mysql_error().";
	 			mysql_query("BEGIN");
	 			if(mysql_error()) $this->errors[] = mysql_error()." Reported by mysql_error().";
	 		}
	 		if(empty($this->errors)){
	 			$this->start = true;
	 		}
 		}
 	}
 	
 	/**
 	 * Prints errors using <pre></pre>
 	 * Use only for debug
 	 * 
 	 * @return void
 	 */
 	public function printErrors(){
 		echo "<pre>";
 		if(empty($this->errors)){
 			echo "No errors!";
 		}else{
 			print_r($this->errors);
	 	}
 		echo "</pre>";
 	}	
 
  	/**
 	 * Prints queries in <pre></pre>
 	 * Use only for debug
 	 * 
 	 * @param $aNo - Optional. Input a query num for specific query.
 	 * @return void
 	 */
 	public function debugQueries($qNo = ""){
 		echo "<pre>";
 		if(empty($this->queries)){
 			echo "No queries!";
 		}else{
 			echo "Added queries since last exec();";
	 		if($qNo != ""){
	 			print_r($this->queries[$qNo]);
	 		}else{
	 			print_r($this->queries);
	 		}
 		}
 		echo "</pre>";
 	}	
 }

?>