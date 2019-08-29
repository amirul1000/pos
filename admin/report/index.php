<?php
       session_start();
       include("../../common/lib.php");
	   include("../../lib/class.db.php");
	   include("../../common/config.php");
	   
	    if(empty($_SESSION['users_id'])) 
	   {
	     Header("Location: ../login/");
	   }
	  
	   $cmd = $_REQUEST['cmd'];
	   switch($cmd)
	   {
		 case "customer_name":
		       $info["table"] = "customers";
				$info["fields"] = array("customers.*"); 
				$info["where"]   = "1 ORDER BY customer_name ASC";
				$arr =  $db->select($info);
				echo json_encode($arr);
		       break;
	     case "search":
		      include("report_view.php");	
		     break;		   
         case "list" :    	 
			  if(!empty($_REQUEST['page'])&&$_SESSION["search"]=="yes")
				{
				  $_SESSION["search"]="yes";
				}
				else
				{
				   $_SESSION["search"]="no";
					unset($_SESSION["search"]);
					unset($_SESSION['field_name']);
					unset($_SESSION["field_value"]); 
				}
				include("report_view.php");
				break; 
    
	     default :    
		       include("report_view.php");		         
	   }

//Protect same image name
 function getMaxId($db)
 {	  
    $sql    = "SHOW TABLE STATUS LIKE 'invoice'";
	$result = $db->execQuery($sql);
	$row    = $db->resultArray();
	return $row[0]['Auto_increment'];	   
 } 	
 
 /*
   save csutomer 
 */ 
 function save_customer($db)
 {
	 
	$info['table']    = "customers";
	$data['customer_name']   = $_REQUEST['customer_name_2'];
	$data['address']   = $_REQUEST['address'];
	$data['city']   = $_REQUEST['city'];
	$data['state']   = $_REQUEST['state'];
	$data['zip']   = $_REQUEST['zip'];
	$data['contact']   = $_REQUEST['contact'];
	$info['data']     =  $data;
	
	if(empty($_REQUEST['customers_id']))
	{
		 $db->insert($info);
		 $Id = $db->lastInsert(true);
	}
	else
	{
		$Id            = $_REQUEST['customers_id'];
		$info['where'] = "id=".$Id;
		
		$db->update($info);
	}
	
	return $Id;
 }
?>
