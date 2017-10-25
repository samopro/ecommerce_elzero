<?php

	function lang($phrase) {
		
		static $lang = array(

				// Dashboard Page
				// NavBar Links
				'HOME_ADMIN' 	=> 'Admin Area', 
				'CATEGORIES' 	=> 'Categories', 
				'ITEMS' 		=> 'Items', 
				'MEMBERS' 		=> 'Members', 
				'STATISTICS' 	=> 'Statistics',
				'COMMENTS'		=> 'Comments',
				'LOGS' 			=> 'Logs',
			);

		return $lang[$phrase];
	}