<?php 
	if (isset($_SESSION['user'])) {
		header('location:admin');
	}else{
		header('location:public');
	}	
	#by birendra gurung and teammates
?>