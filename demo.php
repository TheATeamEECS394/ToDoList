HEY GUYS<?php

require "connect.php";
require "todo.class.php";


// Select all the todos, ordered by position:
$query = mysql_query("SELECT * FROM `tz_todo` ORDER BY `PriorityNumber` ASC");

$todos = array();

// Filling the $todos array with new ToDo objects:

while($row = mysql_fetch_assoc($query)){
	$todos[] = new ToDo($row);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Including the jQuery UI Human Theme -->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/humanity/jquery-ui.css" type="text/css" media="all" />

<!-- Our own stylesheet -->
<link rel="stylesheet" type="text/css" href="styles.css" />

</head>

<body>

<div id="main">

	<ul class="todoList">
		
        <?php
		
		// Looping and outputting the $todos array. The __toString() method
		// is used internally to convert the objects to strings:
		
		foreach($todos as $item){
			echo $item;
		}
		
		?>

    </ul>

<a id="addButton" class="green-button" href="#">Add a ToDo</a>

</div>

<!-- This div is used as the base for the confirmation jQuery UI POPUP. Hidden by CSS. -->
<div id="dialog-confirm" title="Delete TODO Item?">Are you sure you want to delete this TODO item?</div>


<!-- Including our scripts -->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/trunk/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js" charset="utf-8"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js" charset="utf-8"></script>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript" src="jquery.autocomplete.pack.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
	$("#city").autocomplete("http://ws.geonames.org/searchJSON", {
		dataType: 'jsonp',
		parse: function(data) {
			var rows = new Array();
			data = data.geonames;
			for(var i=0; i<data.length; i++){
				rows[i] = { data:data[i], value:data[i].name, result:data[i].name };
			}
			return rows;
		},
		formatItem: function(row, i, n) {
			return row.name + ', ' + row.adminCode1;
		},
		extraParams: {
			// geonames doesn't support q and limit, which are the autocomplete plugin defaults, so let's blank them out.
			q: '',
			limit: '',
			country: 'US',
			featureClass: 'P',
			style: 'full',
			maxRows: 50,
			name_startsWith: function () { return $("#city").val() }
		},
		max: 50
	}); 
     
  });
</script>



</body>
</html>
