<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>KERATON 2016 TALLY</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="tally.css">
	</head>

	<body>
		<div class="header">
			<div class="isauw">
				<img src="logo_isauw_16 copy.png" alt="isauw" />
			</div>
			<div class="keraton">
				<img src="Keraton logo.png" alt="logo" />
			</div>
			<h1>
				Tally System
			</h1>
		</div>	

		<div class="container">
			<h1>
				VENDOR
				<br>
				<hr>
			</h1>
				<div class="menu row">
					<form class="row" id="orderForm">
						<div class="trans col-md-8">
							<div class="product col-md-6" data-price="5.00">
								<div class="item col-md-6" id="item1">
									Item 1
								</div>

								<div class="col-md-3">
									<input type="number" min="0" class="form-control" id="quantity">
								</div>
							</div>

							<div class="product col-md-6" data-price="2.50">
								<div class="item col-md-6" id="item2">
									Item 2
								</div>

								<div class="col-md-3">
									<input type="number" min="0" class="form-control" id="quantity">
								</div>
							</div>

							<div class="product col-md-6" data-price="10.00">
								<div class="item col-md-6" id="item3">
									Item 3
								</div>

								<div class="col-md-3">
									<input type="number" min="0" class="form-control" id="quantity">
								</div>
							</div>

							<div class="product col-md-6" data-price="10.00">
								<div class="item col-md-6" id="item4">
									Item 4
								</div>

								<div class="col-md-3">
									<input type="number" min="0" class="form-control" id="quantity">
								</div>
							</div>

							<div class="col-md-12">
								<br>
							</div>

							<div class="form-group row">
								<label for="comment" class="col-md-2 form-control-label">Comment</label>
								<div class="col-md-11">
									<input type="text" class="form-control" id="comment">
								</div>
							</div>

						<div class="prevTrans">
							<br>
							<br>
							Previous Transactions:
							<hr>
							<div class="tran row">
								<div class="transNum col-md-2">1000</div>
								<ul class="items col-md-8">
									<li>item1 (note)</li>
									<li>item2</li>
								</ul>
								<div class="totalPrice col-md-2">$100.00</div>
							</div>

							<div class="tran row">
								<div class="transNum col-md-2">999</div>
								<ul class="items col-md-8">
									<li>item1</li>
									<li>item2</li>
								</ul>
								<div class="totalPrice col-md-2">$150.00</div>
							</div>
						</div>
					</div>

					<div class="receipt col-md-4">
						Transaction #:
						<hr>
						<div class="transactions">
						</div>
						<br>
						<div class="final"></div>
							<div class="form-group" style="text-align:center;">
	                                <input type="submit" class="btn btn-lg" value="ORDER">
	                        </div>
						</div>
					</form>
				</div>
			</div>
	</body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript">
$(document).ready(function (){
//Update total when quantity changes
	$(".product #quantity").change(function() {
	    updateTotal();
	});

// unit price
   $('.product p').each(function() {
       var $price = $(this).parents("div").data('price');
      $(this).before($price);
    });

    $('#orderForm').submit(function(e) {	
    	var date = new Date();
    	var hour = date.getHours();
    	if(hour<10) {
                hour = "0"+hour;
        }
        var min = date.getMinutes();
        if(m<10) {
                min = "0"+min;
        }
        var sec = date.getSeconds();
        if(sec<10) {
                sec = "0"+sec;
        }
        var checkoutTime = hour+':'+min+":"+sec;
        var message = "";
    	$(".product").each(function() {
        	var quantity = $('#quantity', this).val();
    		if(quantity > 0){
    			var name = $('.item', this).html();
    			message += name + " " + quantity +"\n";
    		}
    	});
    	message += $('.final').html();
        var formData = {
        	item: message;
        	time: checkoutTime;
        	comment: $('#comment').val();
        }
        e.preventDefault();
        var comm = '\n'+$('#comment').val();
        if(confirm(message+comm+'\n'+OK?)){
        	$.ajax({
        		url:'tally.php',
        		type: 'POST',
        		data: formData
        	}).success(function(msg)){
        		if(msg = 'success'){
        			$('#orderForm')[0].reset();
        		} else {
        			alert(msg +"SOMETHING WENT WRONG CALL FOR ASSISTANCE");
        		}
        	}).fail(function() {
        		alert("error: server not available");
        	});
        }
    });
});

var updateTotal = function() {
 
       var sum = 0;
       var receipt = '';
    //Add each product price to total
    $(".product").each(function() {
        var price = $(this).data('price');
        var quantity = $('#quantity', this).val();

   
        //Total for one product
        var subtotal = price*quantity;
        //Round to 2 decimal places.
        sum += subtotal;
        subtotal = subtotal.toFixed(2);  

        if(quantity > 0){
        	var name = $('.item', this).html();
        	receipt += '<div class="order row"><div class="quant col-md-1">'+quantity+'</div><div class="name col-md-8">'+name+'</div><div class="price col-md-2">'+subtotal+'</div></div>';
        }
        $('.transactions').html(receipt);

    });
    
    $('.final').html('Total: ' + sum.toFixed(2));

};


</script>
</html>