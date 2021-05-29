<?php
require('database.php');
include('functions.php');
$res=mysqli_query($con,"select so_order_id,so_date,so_net,so_tax,so_total from sales_order");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>List of orders</title>
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
              <h6 class="m-0 font-weight-bold">Orders List</h6>
			  <a href="create_order.php" class="btn btn-success btn-sm text-right" title="Create Order">Create Order</a>			 
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
        <th>Net</th>
		 <th>Tax</th>
		  <th>Total</th>
		  <th>Action</th>
		  
      </tr>
    </thead>
    <tbody>
	<?php
      while($row=mysqli_fetch_assoc($res))
				  { ?>
                    <tr>
                      <td><a href="orders_details.php?id=<?php echo $row['so_order_id'];?>"><?php echo $row['so_order_id'];?></a></td>
                      <td><?php echo $row['so_date'];?></td>
                      <td><?php echo $row['so_net'];?></td>
					  <td><?php echo $row['so_tax'];?></td>
					  <td><?php echo $row['so_total'];?></td>
					   <td><a href="template.php?id=<?php echo $row['so_order_id'];?>">Download Invoice</a></td>
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
