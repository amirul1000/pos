<table class="table">
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