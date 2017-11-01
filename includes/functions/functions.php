<?php
	
	/*
	** Get Records Functions v1.0
	** Function to get categories from database
	*/

	function getCat() {
		
		global $db;
		
		$getCat = $db->prepare('SELECT * FROM categories');
		$getCat->execute();

		return $getCat->fetchAll(PDO::FETCH_ASSOC);
	}


	/*
	** Get Items Function v2.0
	** Fucntion to get Items from database
	*/

	function getItems($where, $value, $approve=NULL) {

		global $db;
        
        $sql = ($approve == NULL) ? 'AND Approve = 1' : NULL;

		$getItems = $db->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_ID DESC");

	    $getItems->execute(array($value));

	    return $getItems->fetchAll(PDO::FETCH_ASSOC);
	}


	/*
	** Check If User Not Activated
	** Function to check RegStaus of the user
	*/

	function checkUserStatus($user) {

		global $db;

	 	$stmt = $db->prepare('SELECT Username FROM users WHERE Username = ? AND RegStatus = 1');
	 	$stmt->execute(array($user));

	 	return $stmt->rowCount();

	}


	/*
	 ** Title Function v1.0
     ** Title Function Dat Echo The Title In Case The Page
     ** Has The Variable $pageTitle
	*/

	function getTitle() {

		global $pageTitle;

		if (isset($pageTitle)) {
			echo $pageTitle;
		} else {
			echo 'Default';
		}

	}



	/*
	 ** Home Redirect Function v2.0
	 ** This function accept parameters
	 ** $theMsg   = Echo the message [ Error | Success | Warning ]
	 ** $url 	  = The link you to redirect to 
	 ** $seconds  = Seconds before Redirecting
	*/

	function redirectHome($theMsg, $url=null, $seconds=3) {

		if ($url !== null && $url !== 'back') {

			$link = $url;
			$url = trim($url . '.php');
			
		} elseif ($url === 'back') {
			$url =  (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') ? $_SERVER['HTTP_REFERER'] : 'index.php';
			$link = 'previous page';
		} elseif ($url === null) {
			$url = 'index.php'; 
			$link = 'Home'; 
		}
		echo $theMsg;
		echo "<div class='alert alert-info'>You will be redirect to $link page after $seconds seconds</div>";

		header("refresh:$seconds;url=$url");
		exit();

	}



	/*
     ** Check Items Function v1.0
     ** Function to check items in database [ Function accept parameters ]
     ** $select = the item to select [ Example: user, item, category  ]
     ** $table   = the table to select from [ Example: users, items, categories ]
     ** $value  = the value to search in the table 
	*/

	function checkItem($select, $table, $value) {

		global $db;
		$statement = $db->prepare("SELECT $select FROM $table WHERE $select = ?");
		$statement->execute(array($value));

		return $statement->rowCount();
	}


	/*
	** Count Number Of Items Function v1.0
	** Function To count Number Of Items(rows)
	** $item = the item to count
	** $table = the table to select from
	*/

	function countItems($item, $table) {

		global $db;

		$stmt2 = $db->prepare("SELECT COUNT($item) FROM $table"); 
		$stmt2->execute();

		return $stmt2->fetchColumn();
	}



	/*
	** Get Latest Record Function v1.0
	** Function to get latest items from database [Users, Items, Comments]
	** $select = Field to select
	** $table  = The table to select from
	** $order  = The DESC ordering
	** $limit  = Numbers of records to get
	*/

	function getLatest($select, $table, $order,$limit=5) {

		global $db;

		$getStmt = $db->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
		$getStmt->execute();
		$rows = $getStmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}