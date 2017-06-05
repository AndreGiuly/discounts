<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ORDER</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<?php
	//Show server responses 
	if(isset($_GET['e'])){
		switch ($_GET['e']) {

			case '405': ?>

				<div class="alert alert-danger alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<strong>Error!</strong> Please submit the form correctly.
				</div>
			<?php 
			break;
			default: ?>
				
				<div class="alert alert-success alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<strong>Great!</strong> JSON order was uploaded correctly.
				</div>

			<?php
			break;
		}
	} 
?>


</div>

<div class="container">
	<h1>Discount Application</h1>
	<hr>
	<div class="row">
		<form action="discounts.php" method="post" enctype='multipart/form-data'>
			<div class="col-xs-12" style="padding: 20px">
				<input type="file" name="file" id="json_file">
				<p id="errorMsg" class="text-danger" style="display: none">File is not a valid JSON!</p>
				<p id="submitMsg" style="display: none"></p>

			</div>
			<div>
				<p><strong>Order ID: </strong><span id="orderID"></span></p>
				<p><strong>customer: </strong><span id="customer"></span></p>

				<select name="" id="products">
					<option value="0">Select Product</option>
				</select>

				<input type="number" id="qtt" placeholder="quantity">
				<button id="addorder-btn">Add to Order</button>
				<h3>Order Items:</h3>
				<table class="table table-condensed">
					<thead>
						<tr>
							<th>Product</th>
							<th>Description</th>
							<th>Category</th>
							<th>Unit Price</th>
							<th>Qtt</th>
							<th>Total</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="posts">
						<?php //Items Table ?>
					</tbody>

				</table>
				<p id="discountMsgs" style="border: 2px solid yellow;"></p>
				<p id="total" style="display: none">Total: <span id="totalPrice">0</span> €</p>
			</div>
			<input class="btn btn-success" type="submit" id="submitOrder" value="CHECK TOTAL">
			<input class="btn btn-primary" style="display:none" id="back" value="INSERT NEW ORDER">
		</form>
	</div>
</div>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="script/discount.js"></script>
</body>
</html>