<?php 

spl_autoload_register(function ($class_name) {
    include 'Models/'.$class_name . '.php';
});


	
	foreach ($products as $product) {
		var_dump($product->category());
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?php
	//Show server responses 
	if(isset($_GET['e'])){
		switch ($_GET['e']) {
			case '422': ?>

				<div class="alert alert-danger alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<strong>Error!</strong> Please upload a valid JSON order.
				</div>
			<?php
			break;
			case '400': ?>

				<div class="alert alert-danger alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<strong>Error!</strong> JSON file is not readable.
				</div>
			<?php 
			break;
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
	} ?>


	<div class="container">
		<div class="row">
			<form action="discounts.php" method="post" enctype='multipart/form-data'>
				<div class="col-xs-12">
					<input type="file" name="file" id="json_file">
					<p id="errorMsg" class="text-danger" style="display: none">File is not a valid JSON!</p>
				</div>
				<div>
				<p>Order ID: <span id="orderID"></span></p>
				<p>customer: <span id="customer"></span></p>



				<select name="" id="">
					<option value="1">Product</option>
				</select>

				<select name="" id="">
					<option value="">Quantity</option>
				</select>
				<button>Add to Order</button>
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
					     
					      
					    </tbody>
					  </table>
				</div>
				<input type="submit">
			</form>
		</div>
	</div>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){

    function deleteRow()
    {
        row.closest('tr').remove();


    }

    /***************** Get Info from Json file *************/
    $("#json_file").on("change", function (changeEvent) {
    	$('.table td').remove();
    	$('#errorMsg').hide();

        for (var i = 0; i < changeEvent.target.files.length; ++i) {
            (function (file) {
                var loader = new FileReader();
                loader.onload = function (loadEvent) {
                    if (loadEvent.target.readyState != 2)
                        return;
                    if (loadEvent.target.error) {
                        alert("Error while reading file " + file.name + ": " + loadEvent.target.error);
                        return;
                    }
                    //console.log(loadEvent.target.result);

                    var json = loadEvent.target.result;
                    if (/^[\],:{}\s]*$/.test(json.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                       
                        try {
                            json = $.parseJSON(json);
                            id = json['id'];
                            order = json['items'];
                        } catch (err) {
                            console.log(err.message);
                        }
                        	
                        	$('#orderID').html(json.id);
                        	$('#customer').html(json['customer-id']);

                        	$.each(json.items, function(i,item){
					        	$.getJSON("Data/products.json",function(data){
							        $.each(data, function(i,product){
							    		if(product['id'] == item['product-id']){
							    			content = '<tr>';
											content += '<td>' + product['id'] + '</td>';
											content += '<td>' + product['description'] + '</td>';
											content += '<td>' + product['category'] + '</td>';
											content += '<td>' + product['id'] + '</td>';
											content += '<td>' + item.quantity + '</td>';
											content += '<td>' + item.total + '</td>';
											content += '<td><button type="button" class="btn btn-danger btn-xs" onclick ="deleteRow()">DELETE</button></td>';
											content += '<tr/>';
											$(content).appendTo("#posts");
							    		}  		
							        });
							    }); 
					        });

                      
                   
                    } else {
                        $("#errorMsg").show();
                    }
                };

                loader.readAsText(file);
            })(changeEvent.target.files[i]);
        }
    });

});
</script>
</body>
</html>