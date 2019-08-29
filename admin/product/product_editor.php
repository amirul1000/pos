<?php
 include("../template/header.php");
?>
<script language="javascript" src="product.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<link rel="stylesheet" href="../../datepicker/jquery-ui.css">
<script src="../../datepicker/jquery-1.10.2.js"></script>
<script src="../../datepicker/jquery-ui.js"></script>


<a href="index.php?cmd=list" class="btn green"><i class="fa fa-arrow-circle-left"></i> List</a> <br><br>
  <div class="portlet box blue">
      <div class="portlet-title">
          <div class="caption"><i class="fa fa-globe"></i><b><?=ucwords(str_replace("_"," ","product"))?></b>
          </div>
          <div class="tools">
              <a href="javascript:;" class="reload"></a>
              <a href="javascript:;" class="remove"></a>
          </div>
      </div>
	   <div class="portlet-body">
		         <div class="table-responsive">	
	                <table class="table">
							 <tr>
							  <td>  

								 <form name="frm_product" method="post"  enctype="multipart/form-data" onSubmit="return checkRequired();">			
								  <div class="portlet-body">
						         <div class="table-responsive">	
					                <table class="table">
										 <tr>
						 <td>Product Name</td>
						 <td>
						    <input type="text" name="product_name" id="product_name"  value="<?=$product_name?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Cost</td>
						 <td>
						    <input type="text" name="cost" id="cost"  value="<?=$cost?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Product Code</td>
						 <td>
						    <input type="text" name="product_code" id="product_code"  value="<?=$product_code?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Bar Code</td>
						 <td>
						    <input type="text" name="bar_code" id="bar_code"  value="<?=$bar_code?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Brand</td>
						 <td>
						    <input type="text" name="brand" id="brand"  value="<?=$brand?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>File Picture</td>
						 <td><input type="file" name="file_picture" id="file_picture"  value="<?=$file_picture?>" class="form-control-static">
						 </td>
				     </tr>
										 <tr> 
											 <td align="right"></td>
											 <td>
												<input type="hidden" name="cmd" value="add">
												<input type="hidden" name="id" value="<?=$Id?>">			
												<input type="submit" name="btn_submit" id="btn_submit" value="submit" class="btn red">
											 </td>     
										 </tr>
										</table>
										</div>
										</div>
								</form>
							  </td>
							 </tr>
							</table>
			      </div>
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
</script>  			
<?php
 include("../template/footer.php");
?>

