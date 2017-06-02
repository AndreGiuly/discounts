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
	} ?>




</div>
	<div class="container">
<h1>Discount Application</h1>
<hr>

		<div class="row">
			<form action="discounts.php" method="post" enctype='multipart/form-data'>
				<div class="col-xs-12" style="padding: 20px">
					<input type="file" name="file" id="json_file">
					<p id="errorMsg" class="text-danger" style="display: none">File is not a valid JSON!</p>
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
					     
					      
					    </tbody>

					  </table>
					  <p id="discountMsgs" style="border: 2px solid yellow;"></p>
					  <p id="total" style="display: none">Total: <span id="totalPrice">0</span> €</p>
				</div>
				<input class="btn btn-success" type="submit" id="submitOrder" value="CHECK TOTAL">
				<input class="btn btn-primary" style="display:none" id="back" value="INSERT NEW ORDER">
				<p id="submitMsg" style="display: none"></p>
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

	var orderItems = new Array();

	$.getJSON("Data/products.json",function(data){
        	content = '';
        $.each(data, function(i,product){
        	content += '<option value=' + product.id+'>' + product.description + '</option>';
        });

        $(content).appendTo("#products");
    });

	//We need to be able to remove a product from the order
	$(document).on('click', 'button.removebutton', function () { 
	    productID = $(this).closest('tr').find('.productID').text();
	    quantity  = $(this).closest('tr').find('.qtt').text();
	    price     = parseFloat($(this).closest('tr').find('.price').text());
		
	

		$.each(orderItems, function(i,item){
			console.log(productID);
			if(item.id == productID){
				index = i
			}
			
    	});	
		orderItems.splice(index,1);

    	

		totalPrice = parseFloat($('#totalPrice').html());
		newTotal = (totalPrice-price).toFixed(2);
		$('#totalPrice').html(newTotal);


	    $(this).closest('tr').remove();
	    
	    return false;
	});


	function addItem(id,quantity){
    	
    	$.getJSON("Data/products.json",function(data){
    		
    		totalPrice = parseFloat($('#totalPrice').html());
	        
	        $.each(data, function(i,product){

	    		if(product['id'] == id){

	    			price = (product['price']*quantity).toFixed(2);
	    			totalPrice += parseFloat(price);    		

	    			content = '<tr>';
					content += '<td class="productID">' + product['id'] + '</td>';
					content += '<td>' + product['description'] + '</td>';
					content += '<td>' + product['category'] + '</td>';
					content += '<td>' + product['price'] + '€</td>';
					content += '<td class="qtt">' + quantity + '</td>';
					
					content += '<td class="price">' + price + '€</td>';
					content += '<td><button type="button" class="btn btn-danger btn-xs removebutton">DELETE</button></td>';
					content += '<tr/>';
					$(content).appendTo("#posts");

					product['quantity'] = quantity;
					
				    orderItems.push(product);
					

				}
					    		

	        });
	        
	        $('#totalPrice').html(totalPrice.toFixed(2));
	    }); 
 
	}

	$('#submitOrder').click(function(e){
		e.preventDefault();

		if($('#json_file').val() == ""){
			$('#submitMsg').html('Upload a JSON order!').addClass('text-danger').fadeIn();
			return false;
		}

		

		id = $('#orderID').html();
		customer = $('#customer').html();
		total = $('#totalPrice').html();

		if(orderItems.length > 0) {
			$('#submitMsg').hide();
			
			buildJsonOrder(id,customer,orderItems,total);
			$('#submitOrder').hide();
			$('#back').fadeIn();
		} else {
			$('#submitMsg').html('Upload a JSON order!').addClass('text-danger').fadeIn();
	
		}
	});

	$('#back').click(function(){
		location.reload();
	});

	function buildJsonOrder(id,customer,items,total){
			

	    var json_order = new Object();
	    	json_order.id = id;
	    	json_order['customer-id'] = customer;
	    	json_order.items = items;
	    	json_order.total = total;


	    var order = JSON.parse(JSON.stringify(json_order));

        $.ajax({

            type: 'POST',
            url: 'discounts.php',
            data: order,
            dataType: 'JSON',

            success: function (response) {  

            	msgs = new Array;

            	$.each(response, function(i,item){

            		msgs.push(item.msg);
            	});
            	content = $('#discountMsgs').html();

            	$.each(msgs, function(i,msg){
            		if(msg != null){
			            	content += msg + '<br>';
			            }
            		
            	});
            	
            	$('#discountMsgs').html(content);
            	
            	total = response.total;
           		
            	//$('#discountMsgs').html(msg);
            	$('#totalPrice').html(total);
            	$('#total').fadeIn();
			
            },

            error: function (response) {
                console.log(response);
            }

        });
	    


	}

	//add product to the order
	$('#addorder-btn').click(function(e){
		e.preventDefault();
		productID = $('#products').val();
		quantity = $('#qtt').val();
		
		if(productID != 0 && quantity > 0){
			addItem(productID,quantity);
		} else {
			
			alert('Check your inputs.');
		}
	})
	  


	//get Json uploaded info
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

                    var json = loadEvent.target.result;
                    if (/^[\],:{}\s]*$/.test(json.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                       
                        try {
                            json = $.parseJSON(json);
                            id = json['id'];
                            order = json['items'];

                        } catch (err) {
                            console.log(err.message);
                        	$('#submitMsg').html('Error loading order!').addClass('text-danger').fadeIn();
                        }
                        	
                        	$('#orderID').html(json.id);
                        	$('#customer').html(json['customer-id']);
        	             	$('#submitMsg').html('Order loaded!').addClass('text-success').fadeIn();
                        	$.each(json.items, function(i,item){
                        		addItem(item['product-id'],item['quantity']);
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