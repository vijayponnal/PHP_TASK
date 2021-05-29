<?php
require('database.php');
include('functions.php');
if(isset($_GET['id'])  && $_GET['id']>0)
{
$id=get_safe_value($_GET['id']);
$res=mysqli_query($con,"select so_line_id,so_line_date,so_line_item_description,so_line_invcode,so_line_qty,so_line_price,	so_line_tax_rate,so_line_tax,so_line_discount,so_line_total from sales_line where so_order_id='$id'");
}
else
{
	redir("index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sales Lines Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body style="margin-top:20px;">
<div class="container">
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
              <h6 class="m-0 font-weight-bold">Orders Details</h6>
			  <a href="index.php" class="btn btn-success btn-sm text-right" title="Back">Back</a>			 
            </div>
            <div class="card-body">  
<?php
			  if(mysqli_num_rows($res)>0)
			  { ?>  
  <table class="table table-bordered">
   
    <thead>
      <tr>
        <th>Id</th>
        <th>Date</th>
        <th>Item Name</th>
		 <th>Invoce</th>
		  <th>Qty</th>
		  <th>Price</th>
		  <th>Discount</th>
		  <th>Total</th>
		  
      </tr>
    </thead>
    <tbody>
	<?php
      while($row=mysqli_fetch_assoc($res))
				  { ?>
                    <tr>
                      <td><?php echo $row['so_line_id'];?></td>
                      <td><?php echo $row['so_line_date'];?></td>
                      <td><?php echo $row['so_line_item_description'];?></td>
					  <td><?php echo $row['so_line_invcode'];?></td>
					  <td><?php echo $row['so_line_qty'];?></td>
					  <td><?php echo $row['so_line_price'];?></td>
					  <td><?php echo $row['so_line_discount'];?></td>
					  <td><?php echo $row['so_line_total'];?></td>
					  </tr>
				  <?php } ?>
    </tbody>
			  <?php }else{?>
			  <div class='text-danger'>Records not found</div>
			  <?php } ?>
  </table>
</div>
</div>
</div>
</body>
</html>
