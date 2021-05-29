<?php
require('database.php');
include('functions.php');
if(isset($_POST['submit']))
{
	
	if($_POST['customer_id']!='' && $_POST['qty']!='' && $_POST['price']!='')
	{
			$customer_id  = get_safe_value($_POST['customer_id']);
			$cust = getUserDetailsByid($customer_id);
			$ship_to=$cust['ship_to_address'];
			$bill_to=$cust['bill_to_address'];
			$qty=$_POST['qty'];
			$price=$_POST['price'];
			$total=$_POST['total'];
			$description=$_POST['description'];
			//create sales order
			$created_date = date('Y-m-d H:i:s');
			$date = date('Y-m-d');
			//so_net,so_tax,so_total,so_discount
			$sql_so="insert into sales_order(so_date,so_ship_charges,customer_id,so_ship_to,so_bill_to,	so_created_date_time,invoice_number,so_status) values('$date','0','$customer_id','$ship_to','$bill_to','$created_date','0','1')";
			mysqli_query($con,$sql_so);
			$so_order_id= mysqli_insert_id($con);
			//lines insert
			$count=count($qty);
			
			for($i=0;$i<$count;$i++)
			{
				$qty_v =$qty[$i];
				
				$price_v=$price[$i];
				$total_v=$total[$i];
				$description_v=$description[$i];
				$sql_line="insert into sales_line(so_order_id,so_line_date,so_line_item_description,so_line_invcode,so_line_qty	,so_line_price,so_line_tax_rate,so_line_tax,so_line_discount,so_line_total,so_line_status) values('$so_order_id','$date','$description_v','$description_v','$qty_v','$price_v','0','0','0','$total_v','1')";
				mysqli_query($con,$sql_line);
				
			}
			$update_sql = mysqli_query($con,"select sum(so_line_tax)as so_line_tax,sum(so_line_total)as so_line_total,sum(so_line_discount)as so_line_discount from sales_line where so_order_id='$so_order_id'");
			$row = mysqli_fetch_assoc($update_sql);
			 $so_tax= $row['so_line_tax'];
			 $so_total= $row['so_line_total'];
			 $so_discount= $row['so_line_discount'];
			 mysqli_query($con,"update sales_order set so_net='$so_total',so_tax='$so_tax',so_total='$so_total',so_discount='$so_discount' where so_order_id='$so_order_id'");
			redir("index.php");
	}
	else
	{
		echo "<script>alert('Enter Required fields');</script>";
	}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Sales Order</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type = "text/javascript" language = "javascript">
$(document).ready(function() {
	var maxField = 50;
		var x = 1; 	
	$('.add_button').click(function(){
			var add_more=$('#add_more').val();
			add_more++;
			$('#add_more').val(add_more);
			var htmldata = '<div class=\"form-group mb-2\">	<input type="text" name="description[]" placeholder="Item" class="form-control" required><input type="text" id="q-'+add_more+'" name="qty[]" onchange="qtyonchange(this.value,this.id);" placeholder="qry"class="form-control numberonly" required><input type="text" name="price[]" id="p-'+add_more+'" placeholder="Price" onchange="priceonchange(this.value,this.id);" class="form-control numberonly" required><input type="text" id="t-'+add_more+'" name="total[]" placeholder="Total" readonly class="form-control amount">&nbsp;<input class=\"btn btn-danger btn-sm remove_button\" type=\"button\" id=\"Remove\"  value=\"Remove\" /></div>'; //New input fieldhtml 
		if(x < maxField){ 
			x++;
			$('.field_wrapper').append(htmldata); 	
		}
		else
		{
			alert("Max fields 100 reached");
		}	
		});
	$('.field_wrapper').on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		var add_more=$('#add_more').val();
			add_more--;
			$('#add_more').val(add_more);
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
  
});
 

$(document).on('keypress', function(e) {
    $('.numberonly').keypress(function (e) {    
    
                var charCode = (e.which) ? e.which : event.keyCode    
    
                if (String.fromCharCode(charCode).match(/[^0-9\.]/g))    
    
                    return false;                        
    
            });  
});

 
 function validateOrder()
		{
			var cid = $("#customer_id").val();			
			if(cid=='0')
			{
				alert("Select customer");
				return false;
			}
		}   
      
function priceonchange(price,id){
      var idv = id.split("-");
	  var i = idv['1'];
	  var q = $('#q-'+i).val();
	  if(q>0)
	  {
		  var t=q*price;
		  $('#t-'+i).val(t);
	  }
	  var total_c=$('#add_more').val();
	   var sum=0;
 
        $('.amount').each(function(){
        sum+=Number($(this).val());
        });

        $('#total').val(sum);
	
}
function qtyonchange(qty,id){
	var idv = id.split("-");
	  var i = idv['1'];
	  var p = $('#p-'+i).val();
	  if(p>0)
	  {
		  var t=qty*p;
		  $('#t-'+i).val(t);
	  }
	
}
</script>
</head>
<body style="margin-top:20px;">
<div class="container">
 <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
              <h6 class="m-0 font-weight-bold">Create Order</h6>
			  	  <a href="index.php" class="btn btn-success btn-sm text-right" title="Back">Back</a>			 
            </div>
            <div class="card-body">  
 <form method="post" action="" class="form-inline"  onsubmit="return validateOrder();" >
  <input type="hidden" id="add_more" value="1"/>
  <div class='col-md-6'>
 <div class="form-group mb-2">
 <label>Customer</label>
  <select name="customer_id" class="form-control" id="customer_id"required>
			   <option value="0">--Select Customer--</option>
			   <?php 
			   $sql = mysqli_query($con,"select id,name from customers order by name asc");
			   if(mysqli_num_rows($sql)>0)
			   {
				   while($c_row = mysqli_fetch_assoc($sql))
				   {
					   
					   echo "<option value='".$c_row['id']."'>".$c_row['name']."</option>";
				   }
			   }?>
			   </select>
 </div>
 </div>
 <div class='col-md-6'>
  <div class="form-group mb-2 ml-3">
 <label>Total</label><input type="text" value="0" id="total" class="form-control ml-3" readonly>&nbsp;
 <button type="submit" name="submit" class="btn btn-success">Save Order</button>
 </div>
 </div>
 
 </br>
	<div class="field_wrapper">
		<div class="form-group mb-2">
		<input type="text" name="description[]" placeholder="Item" class="form-control" required>
			<input type="text" id="q-1" name="qty[]" placeholder="qty"class="form-control numberonly" onchange="qtyonchange(this.value,this.id);" required>
			<input type="text" id="p-1" name="price[]" placeholder="Price" onchange="priceonchange(this.value,this.id);" class="form-control numberonly" required>
			<input type="text" id="t-1" name="total[]" placeholder="Total" readonly class="form-control amount">
			
			&nbsp;<button type="button" id="add" class="btn btn-success add_button" value="Add"> Add More</button>

		</div>
	</div>&nbsp;
	<br>
	</form>
	
		
		</div>
	</div>
	</div>
	</body>
</body>
</html>
