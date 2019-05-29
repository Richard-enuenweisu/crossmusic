<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>

<style type="text/css">
.shopping-cart{
	padding-bottom: 50px;
	/*font-family: 'Montserrat', sans-serif;*/
}
.shopping-cart.dark{
	/*background-color: #1b5a8436;*/
	/*background-color: #f6f6f6;*/
}
.shopping-cart .content{
	box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
	background-color: #1b5a8436;
}
.cart-page-heading{
	text-align: center;
}
.shopping-cart .items{
	margin: auto;
}
.shopping-cart .items .product{
	padding: 15px;
	padding-bottom: 20px;
}
.shopping-cart .items .product .info{
	padding-top: 0px;
	text-align: center;
}
.shopping-cart .items .product .info .product-name{
	font-weight: 600;
}
.shopping-cart .items .product .info .product-name .product-info{
	font-size: 14px;
	margin-top: 15px;
}
.shopping-cart .items .product .info .product-name .product-info .value{
	font-weight: 400;
}
.shopping-cart .items .product .info .quantity .quantity-input{
    margin: auto;
    width: 80px;
}
.shopping-cart .items .product .info .price{
	/*margin-top: 15px;*/
    font-weight: bold;
    font-size: 22px;
 }
.shopping-cart .summary{
	border-top: 2px solid #dc3545;
    background-color: #f7fbff;
    height: 100%;
    padding: 30px;
}
.shopping-cart .summary h3{
	text-align: center;
	font-size: 1.3em;
	font-weight: 600;
	padding-top: 20px;
	padding-bottom: 20px;
}
.shopping-cart .summary .summary-item:not(:last-of-type){
	padding-bottom: 10px;
	padding-top: 10px;
	border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.shopping-cart .summary .text{
	font-size: 1em;
	font-weight: 600;
}
.shopping-cart .summary .price{
	font-size: 1em;
	float: right;
}
.shopping-cart .summary button{
	margin-top: 20px;
}
@media (min-width: 768px) {
	.shopping-cart .items .product .info {
	text-align: left; 
	}
	.shopping-cart .items .product .info .price {
		font-weight: bold;
		font-size: 22px;
		top: 17px; 
	}
	.shopping-cart .items .product .info .quantity {
		text-align: center; 
	}
	.shopping-cart .items .product .info .quantity .quantity-input {
		padding: 4px 10px;
		text-align: center; 
	}
}
	
</style>

	<section class="shopping-cart dark ">
		<div class="container">
	    <div class="cart-page-heading pusher-3">
	      <h2>Shopping Cart</h2>
	      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in, mattis vitae leo.</p>
	    </div>
	    <div class="content pusher">
				<div class="row">
					<div class="col-md-12 col-lg-8">
						<div class="items">
		 				<div class="product">		 					
		 					<div class="row">
			 					<div class="col-md-3">
			 						<img class="img-fluid" src="images/free.png">
			 					</div>
			 					<div class="col-md-8">
			 						<div class="info">
				 						<div class="row">
					 						<div class="col-md-8 product-name">
					 							<div class="product-name">
						 							<a href="#">Church on fire By Kike Mudigha ft Nathaniel Basey</a>
						 							<div class="product-info">
						 								<span>Singles</span>
							 						</div>
							 					</div>
					 						</div>
					 						<div class="col-md-2 price">
					 							<span>&#8358;150</span>
					 						</div>
					 						<div class="col-md-2 price text-center">
					 							<a href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					 						</div>					 						
					 					</div>
					 				</div>
			 					</div>
			 				</div>
		 				</div>
		 				<div class="product">		 					
		 					<div class="row">
			 					<div class="col-md-3">
			 						<img class="img-fluid" src="images/free.png">
			 					</div>
			 					<div class="col-md-8">
			 						<div class="info">
				 						<div class="row">
					 						<div class="col-md-8 product-name">
					 							<div class="product-name">
						 							<a href="#">Church on fire By Kike Mudigha ft Nathaniel Basey</a>
						 							<div class="product-info">
						 								<span>Singles</span>
							 						</div>
							 					</div>
					 						</div>
					 						<div class="col-md-2 price">
					 							<span>&#8358;150</span>
					 						</div>
					 						<div class="col-md-2 price text-center">
					 							<a href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					 						</div>					 						
					 					</div>
					 				</div>
			 					</div>
			 				</div>
		 				</div>
		 				<div class="product">		 					
		 					<div class="row">
			 					<div class="col-md-3">
			 						<img class="img-fluid" src="images/free.png">
			 					</div>
			 					<div class="col-md-8">
			 						<div class="info">
				 						<div class="row">
					 						<div class="col-md-8 product-name">
					 							<div class="product-name">
						 							<a href="#">Church on fire By Kike Mudigha ft Nathaniel Basey</a>
						 							<div class="product-info">
						 								<span>Singles</span>
							 						</div>
							 					</div>
					 						</div>
					 						<div class="col-md-2 price">
					 							<span>&#8358;150</span>
					 						</div>
					 						<div class="col-md-2 price text-center">
					 							<a href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					 						</div>					 						
					 					</div>
					 				</div>
			 					</div>
			 				</div>
		 				</div>		 						 					 						 						 				
		 			</div>
	 			</div>
	 			<div class="col-md-12 col-lg-4">
	 				<div class="summary">
	 					<button type="button" class="btn btn-outline-secondary btn-xs btn-block">Empty Cart</button>
	 					<h3>Summary</h3>
	 					<div class="summary-item"><span class="text">Quantity</span><span class="price">4</span></div>
	 					<div class="summary-item"><span class="text">Discount</span><span class="price">$0</span></div>
	 					<div class="summary-item"><span class="text">Total</span><span class="price">$480</span></div>
	 					<button type="button" class="btn btn-custom btn-lg btn-block">Checkout</button>
		 			</div>
	 			</div>
				</div> 
			</div>
		</div>
	</section>	

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>