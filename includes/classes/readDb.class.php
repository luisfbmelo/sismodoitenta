<?php

/**
##### Avaliable functions: #####

 haveValues();
 
 theValues();
 
 isLastValue();
  
 printValue();
 
 getValue();
 
 getRowValues();
 
 getNumRows();
 
 getNumFields()
 

##### Debug Function #####
 
 debugRowValues();
 
 debugAllValues();
 
 printErrors();
 

##### Usage Example #####

	$q = new readDb("SELECT * FROM table",true);
	if($q->haveValues()){
		
		while($q->theValues()){
			$q->printValue("tableColumn");
		}
		
	}else{
		echo "No values in query";
	}

 */
 
 
 /**
  * readDb - Used to query the db
  * 
  * @author DanielSilva
  * @copyright 2011
  * @version 1.0
  * @access public
  */
 class readDb{
 	
 	/**
 	 * Current row no in query result
	 */ 
 	private $currentRow = 0;
 	/**
 	
 	/**
 	 * Rows in query result
	 */ 
 	private $rows = 0;
 	/**
 	 * Fields in query result
	 */ 
 	private $fields = 0;
 	
 	/**
 	 * Errors in query
	 */ 
 	private $errors = array();
 	
 	/**
 	 * Die on error
	 */ 
 	private $errorDie = false;
 	
 	/**
 	 * If array has been fetched
	 */ 
 	private $start = true;
 	
 	/**
 	 * Stores de current row's values
	 */ 
 	private $data = array();
 	
 	/**
 	 * Resource form db
	 */ 
 	private $result;
 	
 	/**
 	 * Create queries to get data from the database
 	 * 
 	 * @param String $query
 	 * @param bool $errorDie - Optional. Use true if you want to die on error
 	 * @return void
 	 */
 	function __construct($query, $errorDie = false){
 		$this->errorDie = $errorDie;
 		
 		if($this->errorDie){
 			$this->result = mysql_query($query) or die(mysql_error()." Reported by mysql_error().");
 		}else{
 			$this->result = mysql_query($query);
 			if(mysql_error()) $this->errors[] = mysql_error()." Reported by mysql_error().";
 		} 
		
		if(empty($this->errors)){ 		
			$this->rows = mysql_num_rows($this->result);
			$this->fields = mysql_num_fields($this->result);
 		}
 	}
 	
 	function __destruct(){
 		if(is_resource($this->result)){
 			mysql_free_result($this->result);
 		}
 	}
 	
 	/**
 	 * Checks if there are values in the result.
 	 * Note: Never use haveValues() in a loop condition whithout using theValues() in the beginning of the loop.
 	 * The loop will go on forever.
 	 * 
 	 * @return Boolean
 	 */
 	function haveValues(){
 		if($this->currentRow >= $this->rows){
 			return false;
 		}else{
 			return true;
 		}
 	}
 	/**
 	 * Checks if current iteration is the last
 	 * 
 	 * @return Boolean
 	 */
 	function isLastValue(){
 		if($this->currentRow == $this->rows){
 			return true;
 		}else{
 			return false;
 		}
 	}
 	
 	
 	/**
 	 * Iterates between values in resource
 	 * Returns true or false depending on whether data exist or not
 	 * 
 	 * @return Boolean
 	 */
 	public function theValues(){
 		//check if $this->result is a valid resource
 		if(!is_resource($this->result)){
 			return false;
 		}
 		
 		//after using this function the fecth has been done
 		if($this->start) $this->start = false;
 		$this->currentRow++;
 		
 		if($this->data = mysql_fetch_assoc($this->result)){
 			return true;
 		}else{
 			return false;
 		}
 		
 	}
 	
 	/**
 	 * Prints a value from current row's values
 	 * 
 	 * @param String $v - Which value to print. Corresponds to the field name in db
 	 * @return void
 	 */
 	public function printValue($v){
 		//if not in a loop where using theValues() this must be done at least one time
 		if($this->start) $this->theValues();
 		
 		if(empty($this->data)){
 			if($this->errorDie){
				die("Error: There isn't values in query result. Reported by printValue().");
			}else{
				$this->errors[] = "Error: There isn't values in query result. Reported by printValue().";
				return;
			}
 		}
 				
 		if(array_key_exists($v, $this->data)){
			echo $this->data[$v];	
		}else{
			if($this->errorDie){
				die("Error: Field ".$v." does not exist in query result. Reported by printValue().");
			}else{
				$this->errors[] = "Error: Field ".$v." does not exist in query result. Reported by printValue().";
			}
		}
 	}
 	
 	/**
 	 * Returns a value from current row's values
 	 * 
 	 * @param String $v - Which value to return. Corresponds to the field name in db
 	 * @return void
 	 */
 	public function getValue($v){
 		//if not in a loop where using theValues() this must be done at least one time
 		if($this->start) $this->theValues();
 		
 		
 		if(empty($this->data)){
 			if($this->errorDie){
				die("Error: There isn't values in query result. Reported by getValue().");
			}else{
				$this->errors[] = "Error: There isn't values in query result. Reported by getValue().";
				return;
			}
 		}
		
		if(array_key_exists($v, $this->data)){
			return $this->data[$v];	
		}else{
			if($this->errorDie){
				die("Error: Field ".$v." does not exist in query result. Reported by getValue().");
			}else{
				$this->errors[] = "Error: Field ".$v." does not exist in query result. Reported by getValue().";
			}
		}
		
		
 	}
 	
 	/**
 	 * Returns the current row's values in an associative array
 	 * 
 	 * @return array
 	 */
 	public function getRowValues(){
 		//if not in a loop where using theValues() this must be done at least one time
 		if($this->start) $this->theValues();

		return $this->data;

 	}
 	
 	/**
 	 * Returns the specified field from the specified result row
 	 * 
 	 * @param String $field
 	 * @param Int $rowNum - Optional. 0 by default
 	 * @return string
 	 */
 	public function getRowField($field, $rowNum=0){
		if($this->rows>0){
			if(!mysql_data_seek($this->result, $rowNum)){
				if($this->errorDie){
					die("Error: Row ".$rowNum." does not exist in query result. Reported by getRowField().");
				}else{
					$this->errors[] = "Error: Row ".$rowNum." does not exist in query result. Reported by getRowField().";
				}
			}else{
				$this->theValues();
				if(array_key_exists($field, $this->data)){
					return $this->data[$field];	
				}else{
					if($this->errorDie){
						die("Error: Field ".$field." does not exist in query result. Reported by getValue().");
					}else{
						$this->errors[] = "Error: Field ".$field." does not exist in query result. Reported by getValue().";
					}
				}
			}
		}
 	}
 	
 	/**
 	 * Prints the current row's values inside <pre></pre>
 	 * Use only for debug
 	 * 
 	 * @return void
 	 */
 	public function debugRowValues(){
 		//if not in a loop where using theValues() this must be done at least one time
 		if($this->start) $this->theValues();
 		
 		echo "<pre>";
 		if(empty($this->data)){
 			echo "Error: no data avaliable";
 		}else{
 			print_r($this->data);
	 	}
 		echo "</pre>";
 	}
 	/**
 	 * Prints all resource values inside <pre></pre>
 	 * Use only for debug
 	 * 
 	 * @return void
 	 */
 	public function debugAllValues(){
 		if($this->rows>0){
	 		$this->currentRow=0;
	 		mysql_data_seek($this->result, 0);
	 		
	 		//if not in a loop where using theValues() this must be done at least one time
	 		while($this->haveValues()){
	 			$this->theValues();
	 			$this->debugRowValues();
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
 	 * Get number of resulting rows
 	 * 
 	 * @return int
 	 */
 	public function getNumRows(){
 		return $this->rows;
 	}
 	
 	/**
 	 * Get number of resulting fields
 	 * 
 	 * @return int
 	 */
 	public function getNumFields(){
 		return $this->fields;
 	}
 	
 }

?>