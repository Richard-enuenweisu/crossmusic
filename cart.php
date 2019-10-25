<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/includes/cartscript.php');

	

  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>


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
					<?php 

				if(isset($_SESSION["cart_item"])){
				    $total_quantity = 0;
				    $total_price = 0;
				    @$quantity = count($_SESSION["cart_item"]);
					foreach ($_SESSION["cart_item"] as $prod){							
					        @$item_price += $prod["price"];
					       	
							?>							
		 				<div class="product">		 					
		 					<div class="row">
			 					<div class="col-md-3">
			 						<img class="img-fluid" src="<?=$prod["image"]; ?>">
			 					</div>
			 					<div class="col-md-8">
			 						<div class="info">
				 						<div class="row">
					 						<div class="col-md-8 product-name">
					 							<div class="product-name">
						 							<a href="#"><?=$prod["title"]; ?></a>
						 							<div class="product-info">
						 								<span><?=$prod["category"]; ?></span>
							 						</div>
							 					</div>
					 						</div>
					 						<div class="col-md-2 price">
					 							<span>&#8358; <?=$prod["price"];?></span>
					 						</div>
					 						<div class="col-md-2 price text-center">					 							
					 							<a href="cart.php?prod_title=<?=$prod['title']?>&category=<?=$prod['category']?>&action=remove"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					 						</div>					 						
					 					</div>
					 				</div>
			 					</div>
			 				</div>
		 				</div>
							<?php
							// var_dump($item['title']);
							// $total_price += float($item["price"]);
						}
					} else {
					?>
					<div class="text-center pusher-3"><h2>Your Cart is Empty</h2></div>
					<?php } ?>							 				
		 			</div>
	 			</div>
	 			<div class="col-md-12 col-lg-4">
	 				<div class="summary">
	 					<a href="cart.php?title=<?=$prod['title']?>&category=<?=$prod['category']?>&action=empty" class="btn btn-outline-secondary btn-xs btn-block">Empty Cart</a>
	 					<h3>Summary</h3>
	 					<div class="summary-item"><span class="text">Quantity</span><span class="price"><?=(isset($quantity))?$quantity:'0'?></span></div>
	 					<div class="summary-item"><span class="text">Discount</span><span class="price">&#8358; 0</span></div>
	 					<div class="summary-item"><span class="text">Total</span><span class="price">&#8358; <?=(isset($item_price))?$item_price:'0'?>.00</span></div>
	 					<?php if(isset($item_price) && !empty($item_price)){?>
                            <script src="https://js.paystack.co/v1/inline.js"></script>                            				
	 						<button type="button" class="btn btn-custom btn-lg btn-block" onclick="payWithPayStack(<?=$item_price?>)">Checkout</button>
	 					<?php }?>
		 			</div>
	 			</div>
				</div> 
			</div>
		</div>
	</section>	

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/paystack.php');  
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>