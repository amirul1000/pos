<?php
 include("../template/header.php");
?>
<script language="javascript" src="users.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<link rel="stylesheet" href="../../datepicker/jquery-ui.css">
<script src="../../datepicker/jquery-1.10.2.js"></script>
<script src="../../datepicker/jquery-ui.js"></script>


<a href="index.php?cmd=list" class="btn green"><i class="fa fa-arrow-circle-left"></i> List</a> <br><br>
  <div class="portlet box blue">
      <div class="portlet-title">
          <div class="caption"><i class="fa fa-globe"></i><b><?=ucwords(str_replace("_"," ","users"))?></b>
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

								 <form name="frm_users" method="post"  enctype="multipart/form-data" onSubmit="return checkRequired();">			
								  <div class="portlet-body">
						         <div class="table-responsive">	
					                <table class="table">
										 <tr>
						 <td>Email</td>
						 <td>
						    <input type="text" name="email" id="email"  value="<?=$email?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Password</td>
						 <td>
						    <input type="text" name="password" id="password"  value="" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Title</td>
						 <td>
						    <input type="text" name="title" id="title"  value="<?=$title?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>First Name</td>
						 <td>
						    <input type="text" name="first_name" id="first_name"  value="<?=$first_name?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Last Name</td>
						 <td>
						    <input type="text" name="last_name" id="last_name"  value="<?=$last_name?>" class="form-control-static">
						 </td>
				     </tr>
                     <tr>
						 <td>File Picture</td>
						 <td><input type="file" name="file_picture" id="file_picture"  value="<?=$file_picture?>" class="form-control-static">
						 </td>
				     </tr>
                    <tr>
						 <td>Address</td>
						 <td>
						    <input type="text" name="address" id="address"  value="<?=$address?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>City</td>
						 <td>
						    <input type="text" name="city" id="city"  value="<?=$city?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>State</td>
						 <td>
						    <input type="text" name="state" id="state"  value="<?=$state?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Zip</td>
						 <td>
						    <input type="text" name="zip" id="zip"  value="<?=$zip?>" class="form-control-static">
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

