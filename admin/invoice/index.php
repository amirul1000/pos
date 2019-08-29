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
				$info['table']    = "invoice";
				$data['customers_id']   = save_customer($db);
				$data['date_of_product']   = $_REQUEST['date_of_product'];
                $data['tech_users_id']   = $_SESSION['users_id'];
                $data['description']   = $_REQUEST['description'];
                $data['internal_notes_tech']   = $_REQUEST['internal_notes_tech'];
                $data['total_cost']   = $_REQUEST['total_cost'];
                $data['amount_paid']   = $_REQUEST['amount_paid'];
				$info['data']     =  $data;
				
				if(empty($_REQUEST['id']))
				{
					 $db->insert($info);
					 $Id = $db->lastInsert(true);
				}
				else
				{
					$Id            = $_REQUEST['id'];
					$info['where'] = "id=".$Id;
					$db->update($info);
				}
				
				////////////save item////////////
					unset($info);
					unset($data);
				$info['table']    = "item_invoice";
				$info['where']    = "invoice_id='$Id'";
					$db->delete($info);
					
				for($i=0;$i<count($_REQUEST['product_id']);$i++)
				{
					   unset($info);
					   unset($data);
					$info['table']    = "item_invoice";
					$data['invoice_id']   = $Id;
					$data['product_id']   = $_REQUEST['product_id'][$i];
					$data['item_cost']   = $_REQUEST['item_cost'][$i];
					$data['item_quantity']   = $_REQUEST['item_quantity'][$i];
					$data['item_total']   = $_REQUEST['item_total'][$i];
					$info['data']     =  $data;
						 $db->insert($info);
				}
				
				include("invoice_list.php");						   
				break;    
		case "edit":      
				$Id               = $_REQUEST['id'];
				if( !empty($Id ))
				{
					  unset($info);
					  unset($data);
					$info['table']    = "invoice";
					$info['fields']   = array("*");   	   
					$info['where']    =  "id=".$Id;
				   
					$res  =  $db->select($info);
				   
					$Id        = $res[0]['id'];  
					$customers_id    = $res[0]['customers_id'];
					$date_of_product    = $res[0]['date_of_product'];
					$tech_users_id    = $res[0]['tech_users_id'];
					$description    = $res[0]['description'];
					$internal_notes_tech    = $res[0]['internal_notes_tech'];
					$total_cost    = $res[0]['total_cost'];
					$amount_paid    = $res[0]['amount_paid'];
					
					/////////////Customer///////////////
					  unset($info);
					  unset($data);
					$info['table']    = "customers";
					$info['fields']   = array("*");   	   
					$info['where']    =  "id=".$customers_id;
				   
					$res  =  $db->select($info);
				   
					$customer_id        = $res[0]['id'];  
					$customer_name    = $res[0]['customer_name'];
					$customer_name_2    = $res[0]['customer_name'];
					$address    = $res[0]['address'];
					$city    = $res[0]['city'];
					$state    = $res[0]['state'];
					$zip    = $res[0]['zip'];
					$contact    = $res[0]['contact'];
					
					//////////////////item invoice///////////////////
					$info["table"] = "item_invoice";
					$info["fields"] = array("item_invoice.*"); 
					$info["where"]   = "1  AND invoice_id='".$_REQUEST['id']."'";
					$arr_item_invoice =  $db->select($info);
					
				 }
					unset($info);
					unset($data);
				$info["table"] = "product";
				$info["fields"] = array("product.*"); 
				$info["where"]   = "1 ORDER BY product_name ASC";
				$arrproduct =  $db->select($info);	
					   		   
				include("invoice_editor.php");						  
				break;
						   
         case 'delete': 
				$Id               = $_REQUEST['id'];
				  unset($info);
				  unset($data);  
				$info['table']    = "invoice";
				$info['where']    = "id='$Id'";
				if($Id)
				{
					$db->delete($info);
					
					//item invoice
					$info['table']    = "item_invoice";
					$info['where']    = "invoice_id='$Id'";
						$db->delete($info);
						
					//delete
					$info['table']    = "invoice_pictures";
					$info['where']    = "invoice_id='$Id'";
						$db->delete($info);
						
				}
				include("invoice_list.php");						   
				break; 
		case "delete_picture":
					$info['table']    = "invoice_pictures";
					$info['where']    = "id='".$_REQUEST['id']."'";
						$db->delete($info);     
		       include("invoice_list.php");						   
				break; 	
		 case "product":
		       $info["table"] = "product";
				$info["fields"] = array("product.*"); 
				$info["where"]   = "1 ORDER BY product_name ASC";
				$arr =  $db->select($info);
				echo json_encode($arr);
		       break;
		 case "product_detail":
				$info["table"] = "product";
				$info["fields"] = array("product.*"); 
				$info["where"]   = "1  AND id='".$_REQUEST['id']."' ORDER BY product_name ASC";
				$arr =  $db->select($info);
				echo json_encode($arr);
		       break;
			   
		case "customer":
				$info["table"] = "customers";
				$info["fields"] = array("customers.*"); 
				$info["where"]   = "1 ORDER BY customer_name ASC";
				$arr =  $db->select($info);    
		        echo json_encode($arr);
		      break;
		case "customer_detail":
				$info["table"] = "customers";
				$info["fields"] = array("customers.*"); 
				$info["where"]   = "1  AND id='".$_REQUEST['id']."'";
				$arr =  $db->select($info);
				echo json_encode($arr);
		       break;
			     	   
		case "address":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(address) as address"); 
				$info["where"]   = "1 ORDER BY address ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_addresss[] = $arr[$i]['address'];
				}
				
				
				$json = '[';
				foreach($found_addresss as $key => $address) {
					$json .= '{"name": "' . $address . '"}';
		
					if ($address !== end($found_addresss)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
			   
		case "city":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(city) as city"); 
				$info["where"]   = "1 ORDER BY city ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_citys[] = $arr[$i]['city'];
				}
				
				
				$json = '[';
				foreach($found_citys as $key => $city) {
					$json .= '{"name": "' . $city . '"}';
		
					if ($city !== end($found_citys)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
			   
		case "state":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(state) as state"); 
				$info["where"]   = "1 ORDER BY state ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_states[] = $arr[$i]['state'];
				}
				
				
				$json = '[';
				foreach($found_states as $key => $state) {
					$json .= '{"name": "' . $state . '"}';
		
					if ($state !== end($found_states)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
			   
		case "zip":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(zip) as zip"); 
				$info["where"]   = "1 ORDER BY zip ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_zips[] = $arr[$i]['zip'];
				}
				
				
				$json = '[';
				foreach($found_zips as $key => $zip) {
					$json .= '{"name": "' . $zip . '"}';
		
					if ($zip !== end($found_zips)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
			   
		case "contact":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(contact) as contact"); 
				$info["where"]   = "1 ORDER BY contact ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_contacts[] = $arr[$i]['contact'];
				}
				
				
				$json = '[';
				foreach($found_contacts as $key => $contact) {
					$json .= '{"name": "' . $contact . '"}';
		
					if ($contact !== end($found_contacts)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
			   
		 case "product_detail":
		           unset($info);
				   unset($data);
				$info['table']    = "product";
				$info['fields']   = array("*");   	   
				$info['where']    = "1  AND id='".$_REQUEST['id']."'";
				$arr  =  $db->select($info);
				
				if(!empty($_REQUEST['customers_id']))
				{
					  unset($info);
					  unset($data);
					$info['table']    = "invoice";
					$info['fields']   = array("*");   	   
					$info['where']    =  "customers_id=".$_REQUEST['customers_id']." ORDER BY id DESC LIMIT 0,1";
					$res1  =  $db->select($info);
					
					if(count($res1)>0)
					{
						 unset($info);
						 unset($data);
						$info['table']    = "item_invoice";
						$info['fields']   = array("*");   	   
						$info['where']    =  "invoice_id=".$res1[0]['id']." ORDER BY id DESC LIMIT 0,1";
						$res2  =  $db->select($info);
					}
					
				}
				
				$arr2[0]['id'] = $arr[0]['id'];
				$arr2[0]['product_name'] = $arr[0]['product_name'];
				$arr2[0]['cost']         = $arr[0]['cost'];
				
				$arr2[0]['make']         = $res2[0]['make'];
				$arr2[0]['model']        = $res2[0]['model'];
				$arr2[0]['color']        = $res2[0]['color'];
				$arr2[0]['year']         = $res2[0]['year'];
				$arr2[0]['vin']          = $res2[0]['vin'];
				$arr2[0]['tag']          = $res2[0]['tag'];
				
				echo json_encode($arr2);
		       break;
		 case "print":
		                unset($info);
						unset($data);
					  $info["table"] = "company";
					  $info["fields"] = array("company.*"); 
					  $info["where"]   = "1";
					  $rescompany =  $db->select($info);
                      // get the HTML
					    ob_start();
					    include(dirname(__FILE__).'/print_template.php');
					    $html = ob_get_clean();
						
					
		           
						include("../../mpdf60/mpdf.php");					
							$mpdf=new mPDF('','A4'); 
						
						//$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
						//$mpdf->mirrorMargins = true;

                       $mpdf->SetDisplayMode('fullpage');
						//==============================================================
						$mpdf->autoScriptToLang = true;
						$mpdf->baseScript = 1;	// Use values in classes/ucdn.php  1 = LATIN
						$mpdf->autoVietnamese = true;
						$mpdf->autoArabic = true;
						
						$mpdf->autoLangToFont = true;
						
						$mpdf->setAutoBottomMargin = 'stretch'; 
						
						/* This works almost exactly the same as using autoLangToFont:
							$stylesheet = file_get_contents('../lang2fonts.css');
							$mpdf->WriteHTML($stylesheet,1);
						*/
						$mpdf->SetWatermarkImage('../../'.$rescompany[0]['file_report_background'], 0.20, 'F');
						$mpdf->showWatermarkImage = true;
						
						$stylesheet = file_get_contents('../../mpdf60/lang2fonts.css');
						$mpdf->WriteHTML($stylesheet,1);
						
						$mpdf->WriteHTML($html);
						//$mpdf->AddPage();
						
						
												
						$mpdf->Output($filePath);
						$mpdf->Output();
						//$mpdf->Output( $filePath,'S');
						exit;	
				  break;
	     case "details":
		            include("invoice_details.php");  
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
				include("invoice_list.php");
				break; 
        case "search_invoice":
				$_REQUEST['page'] = 1;  
				$_SESSION["search"]="yes";
				$_SESSION['field_name'] = $_REQUEST['field_name'];
				$_SESSION["field_value"] = $_REQUEST['field_value'];
				include("invoice_list.php");
				break;  								   
						
	     default :    
		       include("invoice_editor.php");		         
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
