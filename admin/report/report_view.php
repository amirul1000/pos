<?php
 include("../template/header.php");
?>
<script language="javascript" src="invoice.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<link rel="stylesheet" href="../../datepicker/jquery-ui.css">
<script src="../../datepicker/jquery-1.10.2.js"></script>
<script src="../../datepicker/jquery-ui.js"></script>

<link rel="stylesheet" href="../../css/SpryValidationTextField.css">
<script src="../../js/SpryValidationTextField.js"></script> 


<script type="text/javascript" src="../../js/selectize.js"></script>
<link rel='stylesheet' href='../../css/selectize.css'>
<link rel='stylesheet' href='../../css/selectize.default.css'>
<style type="text/css">
    .selectize-input {
      width: 100% !important;
      height: 62px !important;
    }
</style>

<link href="../../EasyAutocomplete-1.3.4/dist/easy-autocomplete.css" rel="stylesheet" type="text/css">
<!--<script src="../../EasyAutocomplete-1.3.4/lib/jquery-1.11.2.min.js"></script>-->
<script src="../../EasyAutocomplete-1.3.4/dist/jquery.easy-autocomplete.min.js" type="text/javascript" ></script>

<a href="index.php?cmd=list" class="btn green"><i class="fa fa-arrow-circle-left"></i> List</a> <br><br>
 <?php
 if(!empty($_REQUEST['customer_name']))
	{
		$whrstr .= "AND customers_id='".$_REQUEST['customer_name']."'";
	}
	if(!empty($_REQUEST['product']))
	{
		$whrstr .= "AND product_id='".$_REQUEST['product']."'";
	}
	if(!empty($_REQUEST['tech_users_id']))
	{
		$whrstr .= "AND tech_users_id='".$_REQUEST['tech_users_id']."'";
	}
	if(!empty($_REQUEST['date_of_product']))
	{
		$whrstr .= "AND date_of_product='".$_REQUEST['date_of_product']."'";
	}

	$rowsPerPage = 10;
	$pageNum = 1;
	if(isset($_REQUEST['page']))
	{
		$pageNum = $_REQUEST['page'];
	}
	$offset = ($pageNum - 1) * $rowsPerPage;  


		unset($info);
		unset($data);		  
	$info["table"] = "item_invoice LEFT JOIN invoice ON(item_invoice.invoice_id=invoice.id)";
	$info["fields"] = array("item_invoice.*,invoice.*"); 
	$info["where"]   = "1   $whrstr ORDER BY item_invoice.id DESC  LIMIT $offset, $rowsPerPage";
	//$info["debug"]   =	true;				
	
	$arr =  $db->select($info);
	
	$total = 0;
	for($i=0;$i<count($arr);$i++)
	{
		$total +=$arr[$i]['item_cost'];
	}
 
 ?>
  <div class="container"> 
	   <div class="portlet-body">	         
              <form name="frm_invoice" method="post"  enctype="multipart/form-data" onSubmit="return checkRequired();">			
                    <div class="row" style="background: #d0aaaa;color: #FFF;">
                       <h3>Search</h3>
                    </div>   
                         <div class="row" style="border:1px solid;">
                                 <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                     <label class="col-sm-12 col-md-3 control-label">Customer Name</label>
                                     </div>
                                    <div class="col-sm-6 col-md-3">
                                    <?php
                                    $info['table']    = "customers";
                                    $info['fields']   = array("*");   	   
                                    $info['where']    =  "1=1 ORDER BY customer_name ASC";
                                    $resusers  =  $db->select($info);
                                    ?>
                                    <input type="text" name="customer_name" id="customer_name"  value="<?=$_REQUEST['customer_name']?>">
                                   
                                       <script>
                                            $(document).ready(function() {
                                                $('#customer_name')
                                                            .selectize({
                                                                    plugins: ['remove_button'],
                                                                    persist: true,
                                                                    create: true,
                                                                    closeAfterSelect: true,
                                                                    maxItems: null,
                                                                    hideSelected: true,
                                                                    openOnFocus: true,
                                                                    closeAfterSelect: true,
                                                                    maxOptions: 100,
                                                                    selectOnTab: true,
                                                                    valueField: 'id',
                                                                    placeholder: 'Customer Name ...',
                                                                    labelField: 'title',
                                                                    searchField: 'title',
                                                                    onInitialize: function() {
                                                                        this.trigger('change', this.getValue(), true);
                                                                    },
                                                                    onChange: function(value, isOnInitialize) {
                                                                           
                                                                            if(value=="")
                                                                            {
                                                                                return;
                                                                            }
                                                                            
                                                                        $.ajax({  
                                                                          url: 'index.php?cmd=customer_detail&id='+value,
                                                                          success: function(data) {
                                                                                  var obj = eval(data);  
                                                                                  if(obj.length>0)
                                                                                  {
																					  
                                                                                  }
                                                                              }
                                                                            });
                                                                    },	
                                                                    options: [
                                                                               
                                                                                                                                          
                                                                            ],
                                                                            create: true
                                                                        }); 
                                                                        
                                                                        
                                                                        
                                                function load_customer_name()
                                                    {
                                                            var xhr; 
                                                        
                                                            searchbar = $('#customer_name');  
                                                            var $select = searchbar.selectize();
                                                            var control = $select[0].selectize;
                                                            //control.clear(); 
                                                            //control.clearOptions(); 
                                                           
                            
                                                            //$("#spinner3").html('<img src="../../images/indicator.gif" alt="Wait" />');               
                                                           
                                                            xhr && xhr.abort();
                                                                xhr = $.ajax({
                                                                    url: 'index.php?cmd=customer_name',
                                                                    success: function(results) {
                                                                           var data_source = eval(results);                                    
                                                                            for ( var i = 0 ; i < data_source.length ; i++ ) 
                                                                            {   
                                                                                control.addOption({
                                                                                                id: data_source[i].id,
                                                                                                title: data_source[i].customer_name,
                                                                                                url: ''
                                                                                            });
                                                                            }
                                                                           
                                                                           // $("#spinner3").html('');
                            
                                                                    },
                                                                    error: function() {
                                                                         callback();
                                                                    }
                                                                })
                                                    }
                            
                                               load_customer_name(); 
                                               
                                            });
                                         </script>   
                                </div>   
                                    <div class="col-sm-12 col-md-3">
                                    <label class="col-sm-12 col-md-3 control-label">product</label>
                                 </div>
                                    <div class="col-sm-12 col-md-3">
                                 <?php
                                    $info['table']    = "product";
                                    $info['fields']   = array("*");   	   
                                    $info['where']    =  "1=1 ORDER BY id DESC";
                                    $resproduct  =  $db->select($info);
                                ?>
                                <select  name="product" id="product_id" class="form-control-static">
                                    <option value="">--Select--</option>
                                    <?php
                                       foreach($resproduct as $key=>$each)
                                       { 
                                    ?>
                                      <option value="<?=$resproduct[$key]['id']?>" <?php if($resproduct[$key]['id']==$_REQUEST['product']){ echo "selected"; }?>><?=$resproduct[$key]['product_name']?></option>
                                    <?php
                                     }
                                    ?> 
                                </select>
                                </div>   
                                 </div>
                                 <div class="row">                             
                                     <div class="col-sm-12 col-md-3">
                                       <label class="col-sm-12 col-md-6 control-label">Tech Users</label>
                                    </div>       
                                     <div class="col-sm-6 col-md-3">
                                        <?php
                                        $info['table']    = "users";
                                        $info['fields']   = array("*");   	   
                                        $info['where']    =  "1=1 ORDER BY first_name ASC";
                                        $resusers  =  $db->select($info);
                                        ?>
                                        <input type="text" name="tech_users_id" id="tech_users_id"  value="<?=$_REQUEST['tech_users_id']?>">
                                       
                                           <script>
                                                $(document).ready(function() {
                                                    $('#tech_users_id')
                                                                .selectize({
                                                                        plugins: ['remove_button'],
                                                                        persist: false,
                                                                        create: true,
                                                                        closeAfterSelect: true,
                                                                        maxItems: null,
                                                                        hideSelected: true,
                                                                        openOnFocus: true,
                                                                        closeAfterSelect: true,
                                                                        maxOptions: 100,
                                                                        selectOnTab: true,
                                                                        valueField: 'id',
                                                                        placeholder: 'tech users ...',
                                                                        labelField: 'title',
                                                                        searchField: 'title',
                                                                        options: [
                                                                                    <?php
                                                                                    for($i=0;$i<count($resusers);$i++)
                                                                                     {
                                                                                    ?>
                                                                                     {id: '<?=$resusers[$i]['id']?>', title: '<?=$resusers[$i]['first_name']?> <?=$resusers[$i]['first_name']?>', url: ''},
                                                                                    <?php
                                                                                     }
                                                                                    ?> 
                                                                                                                                              
                                                                                ],
                                                                                create: true
                                                                            });             
                                                
                                                
                                                });
                                             </script>   
                                    </div>
                                     <div class="col-sm-12 col-md-3">
                                        <label class="col-sm-12 col-md-3 control-label">Date Of product</label>
                                    </div>
                                     <div class="col-sm-12 col-md-3">
                                       <input type="text" name="date_of_product" id="date_of_product"  value="<?=$_REQUEST['date_of_product']?>" class="datepicker form-control-static">
                                    </div>
                                 </div>
                                 
                          </div> 
                
                         <div class="row"> 
                            <div class="col-sm-6 col-md-6">
                            <input type="hidden" name="cmd" value="search">
                            <input type="submit" name="btn_submit" id="btn_submit" value="submit" class="btn green">                                        
                        </div>  
              </div>  
          
           </form>
		</div>
  </div>
  
    <?php
	   if($total>0)
	   {
	?>
       Total : <?=$total?>
    <?php	   
	   }
	?>
  		<div class="portlet-body">
				      <div class="table-responsive">	
				          <table class="table">
							<tr bgcolor="#ABCAE0">
                                <td>Customers</td>
                                <td>Date Of product</td>
                                <td>Tech Users</td>
                                <td>product</td>
                                <td>Item Cost</td>    
							</tr>
						 <?php
							
								for($i=0;$i<count($arr);$i++)
								{
								
								   $rowColor;
						
									if($i % 2 == 0)
									{
										
										$row="#C8C8C8";
									}
									else
									{
										
										$row="#FFFFFF";
									}
								
						 ?>
							<tr bgcolor="<?=$row?>" onmouseover=" this.style.background='#ECF5B6'; " onmouseout=" this.style.background='<?=$row?>'; ">
							   <td>
		                            <?php
									    unset($info2);        
										$info2['table']    = "customers";	
										$info2['fields']   = array("customer_name");	   	   
										$info2['where']    =  "1 AND id='".$arr[$i]['customers_id']."' LIMIT 0,1";
										$res2  =  $db->select($info2);
										echo $res2[0]['customer_name'];	
					                ?>
							   </td>
                               <td><?=$arr[$i]['date_of_product']?></td>
                               <td>
									<?php
                                        unset($info2);        
                                        $info2['table']    = "users";	
                                        $info2['fields']   = array("*");	   	   
                                        $info2['where']    =  "1 AND id='".$arr[$i]['tech_users_id']."' LIMIT 0,1";
                                        $res2  =  $db->select($info2);
                                        echo $res2[0]['first_name']." ".$res2[0]['last_name'];	
                                    ?>
                               </td>
			                   <td>
		                            <?php
									    unset($info2);        
										$info2['table']    = "product";	
										$info2['fields']   = array("product_name");	   	   
										$info2['where']    =  "1 AND id='".$arr[$i]['product_id']."' LIMIT 0,1";
										$res2  =  $db->select($info2);
										echo $res2[0]['product_name'];	
					                ?>
							   </td>
                              <td><?=$arr[$i]['item_cost']?></td>
							</tr>
						<?php
								  }
						?>
						
						<tr>
						   <td colspan="10" align="center">
							  <?php              
									  unset($info);
					
									   $info["table"] = "item_invoice LEFT JOIN invoice ON(item_invoice.invoice_id=invoice.id)";
									   $info["fields"] = array("count(*) as total_rows"); 
									   $info["where"]   = "1  $whrstr ORDER BY item_invoice.id DESC";
									  
									   $res  = $db->select($info);  
					
										$req = '&customers_id='.$_REQUEST['customer_name'].'&product_id='.$_REQUEST['product'].'&tech_users_id='.$_REQUEST['tech_users_id'].'&date_of_product='.$_REQUEST['date_of_product'];		
										$numrows = $res[0]['total_rows'];
										$maxPage = ceil($numrows/$rowsPerPage);
										$self = 'index.php?cmd=search&'.$req;
										$nav  = '';
										
										$start    = ceil($pageNum/5)*5-5+1;
										$end      = ceil($pageNum/5)*5;
										
										if($maxPage<$end)
										{
										  $end  = $maxPage;
										}
										
										for($page = $start; $page <= $end; $page++)
										//for($page = 1; $page <= $maxPage; $page++)
										{
											if ($page == $pageNum)
											{
												$nav .= "<li>$page</li>"; 
											}
											else
											{
												$nav .= "<li><a href=\"$self&&page=$page\" class=\"nav\">$page</a></li>";
											} 
										}
										if ($pageNum > 1)
										{
											$page  = $pageNum - 1;
											$prev  = "<li><a href=\"$self&&page=$page\" class=\"nav\">[Prev]</a></li>";
									
										   $first = "<li><a href=\"$self&&page=1\" class=\"nav\">[First Page]</a></li>";
										} 
										else
										{
											$prev  = '<li>&nbsp;</li>'; 
											$first = '<li>&nbsp;</li>'; 
										}
									
										if ($pageNum < $maxPage)
										{
											$page = $pageNum + 1;
											$next = "<li><a href=\"$self&&page=$page\" class=\"nav\">[Next]</a></li>";
									
											$last = "<li><a href=\"$self&&page=$maxPage\" class=\"nav\">[Last Page]</a></li>";
										} 
										else
										{
											$next = '<li>&nbsp;</li>'; 
											$last = '<li>&nbsp;</li>'; 
										}
										
										if($numrows>1)
										{
										  echo '<ul id="navlist">';
										   echo $first . $prev . $nav . $next . $last;
										  echo '</ul>';
										}
									?>     
						   </td>
						</tr>
						</table>
						</div>
					 </div>						
  
  
  <script>

	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '../../images/calendar.gif',
	});
	

	
	/*function autoFill(cmd,id)
	{
		 var options = {
				url: function(phrase) {
					return "index.php?cmd="+cmd;
				},
	
				getValue: "name",
			};
		$("#"+id).easyAutocomplete(options);
	}*/
//});	
</script>  	
 <script>
	/*$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '../../images/calendar.gif',
	});*/
	$('body').on('keydown', 'input, select, textarea', function(e) {
    var self = $(this)
      , form = self.parents('form:eq(0)')
      , focusable
      , next
      ;
    if (e.keyCode == 13) {
        focusable = form.find('input,a,select,button,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});
</script> 
 					
<?php
 //include("../template/footer.php");
?>
<style>

table {
    max-width: 100%;
    background-color: #fff;
   border-bottom-left-radius: 14px;
    border-bottom-right-radius: 14px;
}
</style>