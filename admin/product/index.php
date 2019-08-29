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
	     
		  case 'add': 
				$info['table']    = "product";
				$data['product_name']   = $_REQUEST['product_name'];
                $data['cost']   = $_REQUEST['cost'];
                $data['product_code']   = $_REQUEST['product_code'];
                $data['bar_code']   = $_REQUEST['bar_code'];
                $data['brand']   = $_REQUEST['brand'];
                     
				if(strlen($_FILES['file_picture']['name'])>0 && $_FILES['file_picture']['size']>0)
				{
					
					if(!file_exists("../../product_images"))
					{ 
					   mkdir("../../product_images",0755);	
					}
					if(empty($_REQUEST['id']))
					{
					  $file=getMaxId($db)."_".str_replace(" ","_",strtolower(trim($_FILES['file_picture']['name'])));
					}
					else
					{
					  $file=trim($_REQUEST['id'])."_".str_replace(" ","_",strtolower(trim($_FILES['file_picture']['name'])));
					}
					$filePath="../../product_images/".$file;
					move_uploaded_file($_FILES['file_picture']['tmp_name'],$filePath);
					$data['file_picture']="product_images/".trim($file);
				}
                
				
				$info['data']     =  $data;
				
				if(empty($_REQUEST['id']))
				{
					 $db->insert($info);
				}
				else
				{
					$Id            = $_REQUEST['id'];
					$info['where'] = "id=".$Id;
					
					$db->update($info);
				}
				
				include("product_list.php");						   
				break;    
		case "edit":      
				$Id               = $_REQUEST['id'];
				if( !empty($Id ))
				{
					$info['table']    = "product";
					$info['fields']   = array("*");   	   
					$info['where']    =  "id=".$Id;
				   
					$res  =  $db->select($info);
				   
					$Id        = $res[0]['id'];  
					$product_name    = $res[0]['product_name'];
					$cost    = $res[0]['cost'];
					$product_code    = $res[0]['product_code'];
					$bar_code    = $res[0]['bar_code'];
					$brand    = $res[0]['brand'];
					$file_picture    = $res[0]['file_picture'];
					
				 }				
				include("product_editor.php");						  
				break;
						   
         case 'delete': 
				$Id               = $_REQUEST['id'];
				
				$info['table']    = "product";
				$info['where']    = "id='$Id'";
				
				if($Id)
				{
					$db->delete($info);
				}
				include("product_list.php");						   
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
				include("product_list.php");
				break; 
        case "search_product":
				$_REQUEST['page'] = 1;  
				$_SESSION["search"]="yes";
				$_SESSION['field_name'] = $_REQUEST['field_name'];
				$_SESSION["field_value"] = $_REQUEST['field_value'];
				include("product_list.php");
				break;  								   
						
	     default :    
		       include("product_list.php");		         
	   }

//Protect same image name
 function getMaxId($db)
 {	  
   $sql    = "SHOW TABLE STATUS LIKE 'product'";
	$result = $db->execQuery($sql);
	$row    = $db->resultArray();
	return $row[0]['Auto_increment'];	   
 } 	 
?>
