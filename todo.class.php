<?php

/* Defining the ToDo class */

class ToDo{
	
	/* An array that stores the todo item data: */
	
	private $data;
	
	/* The constructor */
	public function __construct($par){
		if(is_array($par))
			$this->data = $par;
	}
	
	/*
		This is an in-build "magic" method that is automatically called 
		by PHP when we output the ToDo objects with echo. 
	*/
		
	public function __toString(){
		
		// The string we return is outputted by the echo statement
		
		return '
			<li id="todo-'.$this->data['id'].'" class="todo">
			
				<div class="text">'.$this->data['text'].'</div>
				Priority Number: <div class="priorityNumber">'.$this->data['PriorityNumber'].'</div>
        		Location:<form name="test" class="cool" action="">
        		<div class="stuff">'.$this->data['Location'].'</div></form>
				
				<div class="actions">
					<a href="#" class="edit">Edit</a>
					<a href="#" class="delete">Delete</a>
				</div>
				
			</li>';
	}
	
	
	/*
		The following are static methods. These are available
		directly, without the need of creating an object.
	*/
	
	
	
	/*
		The edit method takes the ToDo item id and the new text
		of the ToDo. Updates the database.
	*/
		
	public static function edit($id, $text, $PriorityNumber, $Location){
		
		$text = self::esc($text);
		$PriorityNumber = self::esc($PriorityNumber);
		
		if(!$text) throw new Exception("Wrong update text!");
		
		mysql_query("	UPDATE tz_todo
						SET text='".$text."'
						WHERE id=".$id
					);
				mysql_query("	UPDATE tz_todo
						SET PriorityNumber ='".$PriorityNumber."'
						WHERE id=".$id
					);
		mysql_query("	UPDATE tz_todo
						SET Location='".$Location."'
						WHERE id=".$id
					);
		
		if(mysql_affected_rows($GLOBALS['link'])!=1)
			throw new Exception("Couldn't update item!");
	}
	
	/*
		The delete method. Takes the id of the ToDo item
		and deletes it from the database.
	*/
	
	public static function delete($id){
		
		mysql_query("DELETE FROM tz_todo WHERE id=".$id);
		
		if(mysql_affected_rows($GLOBALS['link'])!=1)
			throw new Exception("Couldn't delete item!");
	}
	
	/*
		The rearrange method is called when the ordering of
		the todos is changed. Takes an array parameter, which
		contains the ids of the todos in the new order.
	*/
	
	public static function rearrange($key_value){
		
		$updateVals = array();
		foreach($key_value as $k=>$v)
		{
			$strVals[] = 'WHEN '.(int)$v.' THEN '.((int)$k+1).PHP_EOL;
		}
		
		if(!$strVals) throw new Exception("No data!");
		
		// We are using the CASE SQL operator to update the ToDo positions en masse:
		
		mysql_query("	UPDATE tz_todo SET position = CASE id
						".join($strVals)."
						ELSE position
						END");
		
		if(mysql_error($GLOBALS['link']))
			throw new Exception("Error updating positions!");
	}
	
	/*
		The createNew method takes only the text of the todo,
		writes to the databse and outputs the new todo back to
		the AJAX front-end.
	*/
	
	public static function createNew($text){
		
		$text = self::esc($text);
		if(!$text) throw new Exception("Wrong input data!");
		
		$posResult = mysql_query("SELECT MAX(position)+1 FROM tz_todo");
		
		if(mysql_num_rows($posResult))
			list($position) = mysql_fetch_array($posResult);

		if(!$position) $position = 1;

		mysql_query("INSERT INTO tz_todo SET text='".$text."', position = ".$position);

		if(mysql_affected_rows($GLOBALS['link'])!=1)
			throw new Exception("Error inserting TODO!");
		
		// Creating a new ToDo and outputting it directly:
		
		echo (new ToDo(array(
			'id'	=> mysql_insert_id($GLOBALS['link']),
			'text'	=> $text
		)));
		
		exit;
	}
	
	/*
		A helper method to sanitize a string:
	*/
	
	public static function esc($str){
		
		if(ini_get('magic_quotes_gpc'))
			$str = stripslashes($str);
		
		return mysql_real_escape_string(strip_tags($str));
	}
	
} // closing the class definition

?>

