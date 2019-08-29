<?php
    unset($info);
	unset($data);
  $info["table"] = "company";
  $info["fields"] = array("company.*"); 
  $info["where"]   = "1";
  $rescompany =  $db->select($info);
?>
<table class="table" align="center">    
    <tr>
    <td align="center">
      <img src="../../<?=$rescompany[0]['file_company_logo']?>" style="height:100px;"> 
      <h3><?=$rescompany[0]['company_name']?></h3>
      <?=$rescompany[0]['zip']?>,<?=$rescompany[0]['city']?>,<?=$rescompany[0]['state']?>,<?=$rescompany[0]['country']?><br>
    </td>
    </tr>
</table>


<br><br><br>
 <!--mpdf
					
                    <htmlpageheader name="firstpage" style="display:none">
                    </htmlpageheader>
                    
                    <htmlpageheader name="otherpages" style="display:none;">
                        <span style="float:left;">Patient ID:<?=$arrpatient[0]['Patient_ID']?> </span>
						<span  style="padding:5px;"> &nbsp; &nbsp; &nbsp;
						 &nbsp; &nbsp; &nbsp;</span>
                        <span style="float:right;"></span>         
                    </htmlpageheader>  
                    
                    <sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
                    <sethtmlpageheader name="otherpages" value="on" />
                    
                    
                      <htmlpagefooter name="myfooter"  style="display:none">                          
                   		 <div align="center">
                         	    <?=$rescompany[0]['report_footer']?> 
                                   <br><span style="padding:10px;">Page {PAGENO} of {nbpg}</span> 
                         </div>
					
					</htmlpagefooter>
					
					<sethtmlpagefooter name="myfooter" value="on" />
                    
                    
                    <style>
                    
                    
                    @page :first {
                    header: firstpage;
                    }
                    
                    @page {
                    header: otherpages;
                    }
                    
                    @page {
                    footer: myfooter;
                    }
                    </style>
                    
                  mpdf--> 
                  
<?php  
	$info["table"] = "invoice";
	$info["fields"] = array("invoice.*"); 
	$info["where"]   = "1   AND id='".$_REQUEST['id']."'";
	$arr =  $db->select($info);
	
	
?>	
 <div class="panel-heading">
            <h3 style="color: #fff;
    background-color: #000;
    border-color: #ddd;
    text-align: center;
    width: 139px;
    float: right;
    padding: 9px 10px;
    border-top-left-radius: 15px;
    border-top-right-radius: 12px;"><strong>Invoice</strong></h3>
        </div>
<br><br>
CUSTOMER 
<hr> 
 <table  cellspacing="3" cellpadding="3" class="table" align="center">
    <?php
              unset($info);
              unset($data);		  
        $info["table"] = "customers";
        $info["fields"] = array("customers.*"); 
        $info["where"]   = "1   AND id='".$arr[0]['customers_id']."' ";
        
        $res =  $db->select($info);
   ?>
    
      <tr><td>Customer Name</td><td><?=$res[0]['customer_name']?></td></tr>
      <tr><td valign="top">Address</td><td><?=$res[0]['address']?>
                               <br>
                              <?=$res[0]['zip']?>,<?=$res[0]['city']?>,<?=$res[0]['state']?>,US</td></tr>
      <tr><td>Contact</td>		<td><?=$res[0]['contact']?></td></tr>
    
</table>        
     
<br><br>               
ITEM  
<hr>                 
<table  cellspacing="3" cellpadding="3" class="table">
    <tr bgcolor="#ABCAE0">
        <td>product</td>
        <td>Item Cost</td>
        <td>Item Quantity</td>
        <td>Item Total</td>                            
    </tr>
 <?php
        
          unset($info);
		  unset($data);
        $info["table"] = "item_invoice";
        $info["fields"] = array("item_invoice.*"); 
        $info["where"]   = "1   AND invoice_id='".$arr[0]['id']."' ";
                            
        
        $res =  $db->select($info);
        
        for($j=0;$j<count($res);$j++)
        {
 ?>
    <tr>
      <td>
            <?php
                unset($info2);        
                $info2['table']    = "product";	
                $info2['fields']   = array("product_name");	   	   
                $info2['where']    =  "1 AND id='".$res[$j]['product_id']."' LIMIT 0,1";
                $res2  =  $db->select($info2);
                echo $res2[0]['product_name'];	
            ?>
      </td>
      <td><?=$res[$j]['item_cost']?></td>
      <td><?=$res[$j]['item_quantity']?></td>
      <td><?=$res[$j]['item_total']?></td>
    </tr>
<?php
          }
?>
</table>

<br><br>
GENERAL INFO
<hr>
<table  cellspacing="3" cellpadding="3" class="table" align="center">
<tr><td>Date of product</td><td><?=$arr[0]['date_of_product']?></td></tr>
<tr><td>Tech</td><td>
    <?php
        unset($info2);        
        $info2['table']    = "users";	
        $info2['fields']   = array("*");	   	   
        $info2['where']    =  "1 AND id='".$arr[0]['tech_users_id']."' LIMIT 0,1";
        $res2  =  $db->select($info2);
        echo $res2[0]['first_name'].' '.$res2[0]['last_name'];	
    ?>
</td></tr>
<tr><td>description</td><td><?=$arr[0]['description']?></td></tr>
<tr><td>Total cost</td><td><?=$arr[0]['total_cost']?></td></tr>
<tr><td>Amount paid</td><td><?=$arr[0]['amount_paid']?></td></tr>		
</table>
