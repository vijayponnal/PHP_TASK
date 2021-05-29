 <script src="js/pdfinv.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<?php
require('database.php');
include('functions.php');
if(isset($_GET['id'])  && $_GET['id']>0)
{

$id=get_safe_value($_GET['id']);
$order_details = getSalesOrderDetailsById($id);
$customer_id = $order_details['customer_id'];
$customer = getUserDetailsByid($customer_id);
$customer_name = $customer['name'];
$customer_email = $customer['email'];
$customer_mobile = $customer['mobile'];
$cmp = getcompanyDetails();


$html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <style type="text/css" rel="stylesheet" media="all">
 @media print {
    @page {
        size: auto;
    }
}
.table td, .table th {
    padding: .15rem;
        padding-top: 0.15rem;
        padding-right: 0.15rem;
        padding-bottom: 0.15rem;
        padding-left: 0.15rem;
    vertical-align: top;
}
</style>
</head>
<body>
<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
              <h6 class="m-0 font-weight-bold">Invoice</h6>
			  <a href="index.php" class="btn btn-success btn-sm text-right" title="Back">Back</a>			 
            </div>
<div>
<div class="container" id="invoice">
<h3>Basic Invoice Template</h3>
<table class="table">
<tr><td>
  <div class="col-md-6">
             <h4>Company Logo</h4>
			  <div>'.$cmp['cmp_name'].'</div>
			   <div>'.$cmp['cmp_email'].'</div>
			    <div>'.$cmp['cmp_mobile'].'</div>
				<div>'.$cmp['cmp_address'].'</div>
				</div></td>
				<td>
             <div class="col-md-6 text-right">
                 <h3 class="mb-0">INVOICE</h3>
                 <div>Date:'.$order_details['so_date'].'</div>
				 <div>invoice#:'.$order_details['invoice_number'].'</div>
             </div>
			 </td>
			 </tr>
			 </table>
			
         
<!--bill to ship to-->
<table class="table">
<tr><td>
       
                 <div class="col-sm-6">
                     <h5 class="mb-3"><u>Bill To</u></h5>
                     <div>'. $customer_name.'</div>
                     <div>'. $customer_email.'</div>
                     <div>'. $customer_mobile.'</div>
                    <div>'. $order_details['so_ship_to'].'</div>
                 </div></td>
				 <td>
                 <div class="col-sm-6 ">
                     <h5 class="mb-3"><u>Ship To</u></h5>
                     <div>'.$customer_name.'</div>
                     <div>'.$customer_email.'</div>
                     <div>'.$customer_mobile.'</div>
                    <div>'.$order_details['so_bill_to'].'</div>
                 </div>
				 </td>
				 </tr>
				 </table>
            
<!--end-->



<table class="table table-bordered">  
	<thead>
	<tr>
	<td colspan="2">Description</th>
	<td>TOTAL</th>
	</tr>
	</thead>
	<tbody>';
$lines = mysqli_query($con,"select so_line_item_description,so_line_total from sales_line where so_order_id='$id'");
		 while($row=mysqli_fetch_assoc($lines)){
			$html.='
			<tr>
			<td colspan="2">'.$row['so_line_item_description'].'</td>
			<td>'.$row['so_line_total'].'</td>
			</tr>
			<tr>';
		 }
$subtotal_lesss_disc=$order_details['so_total']-$order_details['so_discount'];
$html.='<tr>
	    <td style="border:0px;">Remarks/instructions </td><td style="border:0px;"> SUBTOTAL</td>
	     <td>'.$order_details['so_total'].'</td>
	</tr>
	
	<tr>
	    <td style="border:0px;"></td><td style="border:0px;"> DISCOUNT</td>
	     <td>'.$order_details['so_discount'].'</td>
	</tr>
	<tr>
	    <td style="border:0px;"></td><td style="border:0px;"> SUBTOTAL LESS DISCOUNT</td>
	     <td>'.$subtotal_lesss_disc.'</td>
	</tr>
	<tr>
	    <td style="border:0px;"></td><td style="border:0px;"> TAX RATE</td>
	     <td>0.00</td>
	</tr>
	<tr>
	    <td style="border:0px;"></td><td style="border:0px;"> TOTAL TAX</td>
	     <td>'.$order_details['so_tax'].'</td>
	</tr>
	<tr>
	    <td style="border:0px;"></td><td style="border:0px;"> SHIPPING/HANDELING</td>
	     <td>'.$order_details['so_ship_charges'].'</td>
	</tr>
	<tr>
	    <td style="border:0px;">Please make check payable to other company </td><td style="border:0px;"> OTHER</td>
	     <td>0.00</td>
	</tr>
	<tr>
	    <td style="border:0px;">THANK YOU </td><td style="border:0px;"> TOTAL</td>
	     <td>'.$order_details['so_total'].'</td>
	</tr>
	</tbody>
	</table>
	
	<p class="text-center">For queries consering please contact<br>Name address<br>www.google.com</p>
	
</div>
</body>
</html>';
echo $html;

}
else
{
	echo "No records";
}