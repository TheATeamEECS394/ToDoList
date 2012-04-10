<?php

require "connect.php";
require "todo.class.php";


$id = (int)$_GET['id'];

try{

	switch($_GET['action'])
	{
		case 'delete':
			ToDo::delete($id);
			break;
			
		case 'rearrange':
			ToDo::rearrange($_GET['positions']);
			break;
			
		case 'edit':
			ToDo::edit($id,$_GET['text'],$_GET['PriorityNumber'],$_GET['Location']);
			break;
			
		case 'new':
			ToDo::createNew($_GET['text']);
			break;
	}

}
catch(Exception $e){
//	echo $e->getMessage();
	die("0");
}

echo "1";
?>