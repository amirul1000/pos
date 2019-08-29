<?php
 include("../template/header.php");
?>
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
  <div class="container"> <!--portlet box blue">-->
      <div class="row">
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
      </div>
	   <div class="portlet-body">	         
              <form name="frm_invoice" method="post"  enctype="multipart/form-data" onSubmit="return checkRequired();">			
                    <div class="row" style="background: #d0aaaa;color: #FFF;">
                       <h3>CUSTOMER</h3>
                    </div>   
                         <div class="row" style="border:1px solid;">
                                 <div class="row">
                                     <div class="col-sm-6 col-md-3">
                                   <label class="col-sm-12 col-md-3 control-label">Customer Name</label>
                                  </div>
                                     <div class="col-sm-6 col-md-3">
                                    <input type="text" name="customer_name" id="customer_name"  value="<?=$customer_name?>">
                                   
                                       <script>
                                            $(document).ready(function() {
                                                $('#customer_name')
                                                            .selectize({
                                                                    plugins: ['remove_button'],
                                                                    persist: true,
                                                                    create: true,
                                                                    closeAfterSelect: true,
                                                                    maxItems: 1,
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
                                                                                $("#customer_name_2").val(value);
                                                                                $("#address").val('');
                                                                                $("#city").val('');
																				$("#state").val('');
																				$("#zip").val('');
                                                                                $("#contact").val('');
                                                                                $("#customers_id").val('');
                                                                    
                                                                                return;
                                                                            }
                                                                            else
                                                                            {
                                                                              $("#customer_name_2").val(value); 
																			  $("#address").focus();	
                                                                            }
                                                                            
                                                                        $.ajax({  
                                                                          url: 'index.php?cmd=customer_detail&id='+value,
                                                                          success: function(data) {
                                                                                  var obj = eval(data);  
                                                                                  if(obj.length>0)
                                                                                  {
                                                                                      $("#customer_name_2").val(obj[0].customer_name);
                                                                                      $("#address").val(obj[0].address);
                                                                                      $("#city").val(obj[0].city);
																					  $("#state").val(obj[0].state);
																					  $("#zip").val(obj[0].zip);
                                                                                      $("#contact").val(obj[0].contact);
                                                                                      $("#customers_id").val(obj[0].id);
                                                                                      
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
                                                                    url: 'index.php?cmd=customer',
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
                                 
                                     <div class="col-sm-6 col-md-3">
                                        <label class="col-sm-12 col-md-3 control-label">Address</label>
                                     </div>
                                     <div class="col-sm-6 col-md-3">  
                                        <input type="text" name="address" id="address"  value="<?=$address?>" class="form-control-static">
                                        <script>
                                          var options = {
                                                    url: function(phrase) {
                                                        return "index.php?cmd=address";
                                                    },
                                        
                                                    getValue: "name",
                                                };
                                            $("#address").easyAutocomplete(options);
                                       </script>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-6 col-md-3">
                                        <label class="col-sm-12 col-md-3 control-label">City</label>
                                      </div>
                                      <div class="col-sm-6 col-md-3">  
                                        <input type="text" name="city" id="city"  value="<?=$city?>" class="form-control-static">
                                        <script>
                                          var options = {
                                                    url: function(phrase) {
                                                        return "index.php?cmd=city";
                                                    },
                                        
                                                    getValue: "name",
                                                };
                                            $("#city").easyAutocomplete(options);
                                       </script>
                                     </div>
                                     <div class="col-sm-6 col-md-3">
                                    <label class="col-sm-12 col-md-3 control-label">State</label>
                                  </div>
                                     <div class="col-sm-6 col-md-3">  
                                    <input type="text" name="state" id="state"  value="<?=$state?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=state";
												},
									
												getValue: "name",
											};
										$("#state").easyAutocomplete(options);
                                   </script>
                                 </div>
                             </div> 
                                 <div class="row">
                                   <div class="col-sm-6 col-md-3">
                                    <label class="col-sm-12 col-md-3 control-label">Zip</label>
                                  </div>
                                   <div class="col-sm-6 col-md-3">  
                                    <input type="text" name="zip" id="zip"  value="<?=$zip?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=zip";
												},
									
												getValue: "name",
											};
										$("#zip").easyAutocomplete(options);
                                   </script>
                                 </div>                              
                                   <div class="col-sm-6 col-md-3">
                                    <label class="col-sm-12 col-md-3 control-label">Contact</label>
                                 </div>   
                                   <div class="col-sm-6 col-md-3">
                                    <input type="text" name="contact" id="contact"  value="<?=$contact?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=contact";
												},
									
												getValue: "name",
											};
										$("#contact").easyAutocomplete(options);
                                   </script>
                                 </div>
                                </div>
                          </div>  
                   <br>
                  <div class="row" style="background: #d0aaaa;color: #FFF;">
                       <h3>ITEMS</h3>
                  </div>    
                    <div id="item">
                         <?php
						    for($i=0;$i<count($arr_item_invoice);$i++)
							  {
								$str .= '<div class="row" style="border:1px solid;">
									 <div class="col-sm-12 col-md-6">
										<label class="col-sm-12 col-md-3 control-label">Product</label>
									 </div>
									 <div class="col-sm-12 col-md-6">
									 <input name="product_id[]" id="product_id_0" onChange="setCost(this.value,this.id);" value="'.$arr_item_invoice[$i]['product_id'].'" style="width:100%;"  class="product form-control-static">
										   
									 </div>
									 <div class="col-sm-12 col-md-6">
										<label class="col-sm-12 col-md-3 control-label">Item Cost</label>
									  </div>
									 <div class="col-sm-12 col-md-6"> 
										<input type="text" name="item_cost[]" id="item_cost_0"  value="'.$arr_item_invoice[$i]['item_cost'].'" class="form-control-static" readonly>
									 </div>
									 <div class="col-sm-12 col-md-6">
										<label class="col-sm-12 col-md-3 control-label">Quantity</label>
									  </div>
									 <div class="col-sm-12 col-md-6"> 
										<input type="text" name="item_quantity[]" id="item_quantity_0"  value="'.$arr_item_invoice[$i]['item_quantity'].'"  onBlur="setItemTotal(this.value,this.id);" class="form-control-static">
									 </div>
									 <div class="col-sm-12 col-md-6">
										<label class="col-sm-12 col-md-3 control-label">Item Total</label>
									  </div>
									 <div class="col-sm-12 col-md-6"> 
										<input type="text" name="item_total[]" id="item_total_0"  value="'.$arr_item_invoice[$i]['item_total'].'" class="form-control-static" readonly>
									 </div>
									 </div>';  
							  }
							  echo $str;
						 ?>
                    </div> 
                <div id="item_more">
                
                </div>    
               <button name="btn_submit" id="btn_submit" onClick="addMore(event);" class="btn red">Add More</button>                 
                 <br><br>
                  <div class="row" style="background: #d0aaaa;color: #FFF;">
                       <h3>GENERAL INFO</h3>
                  </div>      
                  <div class="panel"> 
                      <div class="row" style="border:1px solid;"> 
                        <div class="row"> 
                            <div class="col-sm-12 col-md-6">
                                <label class="col-sm-12 col-md-6 control-label">Date Of product</label>
                            </div>
                            <div class="col-sm-12 col-md-6">
                               <input type="text" name="date_of_product" id="date_of_product"  value="<?=$date_of_product?>" class="datepicker form-control-static">
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-sm-12 col-md-6">
                              <label class="col-sm-12 col-md-6 control-label">Description</label>
                            </div>
                            <div class="col-sm-6 col-md-6">
                              <textarea name="description" id="description"  class="form-control-static" style="width:200px;height:100px;"><?=$description?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                               <label class="col-sm-12 col-md-6 control-label">Internal Notes Tech</label>
                            </div>          
                            <div class="col-sm-12 col-md-6">
                              <textarea name="internal_notes_tech" id="internal_notes_tech"  class="form-control-static" style="width:200px;height:100px;"><?=$internal_notes_tech?></textarea>
                            </div>
                        </div>                                            
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                               <label class="col-sm-12 col-md-3 control-label">Total Cost</label>
                            </div>          
                            <div class="col-sm-12 col-md-6">
                               <input type="text" name="total_cost" id="total_cost"  value="<?=$total_cost?>" class="form-control-static">
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                              <label class="col-sm-12 col-md-3 control-label">Amount Paid</label>
                            </div>          
                            <div class="col-sm-12 col-md-6">
                              <input type="text" name="amount_paid" id="amount_paid"  value="<?=$amount_paid?>" class="form-control-static">
                            </div> 
                        </div>
                        
                        </div>   
                   </div> 
                 <div class="row"> 
                    <div class="col-sm-6 col-md-6">
                    <input type="hidden" name="cmd" value="add">
                    <input type="hidden" name="customer_name_2" id="customer_name_2" value="<?=$customer_name_2?>">
                    <input type="hidden" name="customers_id" id="customers_id" value="<?=$customers_id?>">	
                    <input type="hidden" name="id" value="<?=$Id?>">			
                    <input type="submit" name="btn_submit" id="btn_submit" value="submit" class="btn green">                                        
                </div>  
              </div>  
          
           </form>
		</div>
  </div>
  <!---Item Template--->
  <div id="item_template" style="display:none;">
       
  </div>
   
  <script>
        var current = 0;
		<?php
		if(count($arr_item_invoice))
		{
		?>
			var current = <?=count($arr_item_invoice)-1?>;
		<?php
		}
		?>
        var str_item = function(){/* <div class="row" style="border:1px solid;">
						 <div class="col-sm-12 col-md-6">
							<label class="col-sm-12 col-md-3 control-label">Product</label>
						 </div>
						 <div class="col-sm-12 col-md-6">
						 <input name="product_id[]" id="product_id_0" onChange="setCost(this.value,this.id);" style="width:100%;"  class="product form-control-static">
							   
						 </div>
						 <div class="col-sm-12 col-md-6">
							<label class="col-sm-12 col-md-3 control-label">Item Cost</label>
						  </div>
						 <div class="col-sm-12 col-md-6"> 
							<input type="text" name="item_cost[]" id="item_cost_0"  value="" class="form-control-static" readonly>
						 </div>
						 <div class="col-sm-12 col-md-6">
							<label class="col-sm-12 col-md-3 control-label">Quantity</label>
						  </div>
						 <div class="col-sm-12 col-md-6"> 
							<input type="text" name="item_quantity[]" id="item_quantity_0"  value="1"  onBlur="setItemTotal(this.value,this.id);" class="form-control-static">
						 </div>
						 <div class="col-sm-12 col-md-6">
							<label class="col-sm-12 col-md-3 control-label">Item Total</label>
						  </div>
						 <div class="col-sm-12 col-md-6"> 
							<input type="text" name="item_total[]" id="item_total_0"  value="" class="form-control-static" readonly>
						 </div>
						 
			  </div>*/}.toString().slice(14,-3);
  
	        <?php
			   if(empty($Id))
			   {
			?>	
			   $("#item").html(str_item);
	       <?php
			   }			  
		    ?>	   
   
     function addMore(e)
	 {
		e.preventDefault();
		var item = str_item;		
		current = parseInt(current) + 1;
		item = item.replace(/product_id_0/gi, "product_id_"+current);
		item = item.replace(/item_quantity_0/gi, "item_quantity_"+current);
		item = item.replace(/item_cost_0/gi, "item_cost_"+current);
		item = item.replace(/item_total_0/gi, "item_total_"+current);
		$("#item_more").append(item);
		$("#product_id_"+current)
				.selectize({
						plugins: ['remove_button'],
						persist: true,
						create: true,
						closeAfterSelect: true,
						maxItems: 1,
						hideSelected: true,
						openOnFocus: true,
						closeAfterSelect: true,
						maxOptions: 100,
						selectOnTab: true,
						valueField: 'id',
						placeholder: 'Product Name ...',
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
								else
								{
								    console.log(this);
								}
								
							$.ajax({  
							  url: 'index.php?cmd=product_detail&id='+value,
							  success: function(data) {
									  var obj = eval(data);  
									  if(obj.length>0)
									  {
										  $("#item_cost_"+counter).val(obj[0].cost);
										  $("#item_total_"+counter).val(obj[0].cost);
										  
									  }
								  }
								});
						},	
						options: [
									<?php
									for($i=0;$i<count($arrproduct);$i++)
									 {
									?>
									 {id: '<?=$arrproduct[$i]['id']?>', title: '<?=$arrproduct[$i]['product_name']?>', url: ''},
									<?php
									 }
									?> 														  
								],
								create: true
							});
		
		 return false;
	 }
	 
	
//$(document).ready(function() {	
	function setCost(value,id)
	{
		index = id.replace("product_id_","");
		$.ajax({  
			  url: 'index.php?cmd=product_detail&id='+value,
			  success: function(data) {
					  var obj = eval(data);  
					  if(obj.length>0)
					  {
						  $("#item_cost_"+index).val(obj[0].cost);
						  $("#item_total_"+index).val(obj[0].cost);
					  }
					  //////////update cost/////////////
					  update_cost();
				  }
				});
	}
	/*
	   setItemTotal
	*/
	function setItemTotal(value,id)
	{
		index = id.replace("item_quantity_","");
		
		cost = $("#item_cost_"+index).val();
		quantity = $("#item_quantity_"+index).val();
		$("#item_total_"+index).val(parseFloat(cost)*parseFloat(quantity));
		
		//////////update cost/////////////
		update_cost();
				 
	}
	
	function showProductDeatils(id)
	{
		index = id.replace("product_id_","");
		$.ajax({  
			  url: 'index.php?cmd=productdetail&id='+id,
			  success: function(data) {
					  var obj = eval(data);  
					  if(obj.length>0)
					  {
						  
						  
					  }
				  }
				});
	}
	
	//////////update cost/////////////
	function update_cost()
	{
	   total_cost = 0.0;	
	   for(i=0;i<=current;i++)
	   {
		   if($("#item_cost_"+i).val()=='' || $("#item_cost_"+i).val()==undefined)
		   {
			   continue;
		   }
		   total_cost = parseFloat(total_cost) + parseFloat($("#item_cost_"+i).val())*parseFloat($("#item_quantity_"+i).val());
	   
				  
		  $("#total_cost").val(total_cost);
		  $("#amount_paid").val(total_cost);
	  }
	}
	
	
	$('.product')
				.selectize({
						plugins: ['remove_button'],
						persist: true,
						create: true,
						closeAfterSelect: true,
						maxItems: 1,
						hideSelected: true,
						openOnFocus: true,
						closeAfterSelect: true,
						maxOptions: 100,
						selectOnTab: true,
						valueField: 'id',
						placeholder: 'Product Name ...',
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
								else
								{
								    console.log(this);
								}
								
							$.ajax({  
							  url: 'index.php?cmd=product_detail&id='+value,
							  success: function(data) {
									  var obj = eval(data);  
									  if(obj.length>0)
									  {
										  $("#item_cost_"+counter).val(obj[0].cost);
										  $("#item_total_"+counter).val(obj[0].cost);
										  
									  }
								  }
								});
						   
						},	
						options: [
									<?php
									for($i=0;$i<count($arrproduct);$i++)
									 {
									?>
									 {id: '<?=$arrproduct[$i]['id']?>', title: '<?=$arrproduct[$i]['product_name']?>', url: ''},
									<?php
									 }
									?> 														  
								],
								create: true
							}); 
			
$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '../../images/calendar.gif',
	});
	
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