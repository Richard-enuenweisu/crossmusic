<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

$stmt = $pdo->prepare('SELECT * FROM pricingtbl WHERE id = :id ');
$stmt->execute([':id'=>1]);
$price = $stmt->fetch(PDO::FETCH_ASSOC); 

$amount = $price['price'];
$amount = number_format($amount,2);


include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">

</style>
	<div class="container">
		<div class="row pusher-3">
			<div class="price-header">
		        <h1>Sell your music and grow your fans.</h1>
		        <p>
		        crossmusic gives you a <b>one-time payment</b> account setup to sell your music and get you going.
		        <br>
		        You get whopping 70% while we keep only 30% per unit sold on mycrossmusic.com. You set the price and keep the rest. So if you set your price at &#8358;150, you’ll get paid &#8358;105 per song!.
				</p>			
				<a href="faq.php" class="btn btn-custom">See FAQ about price stipulations</a>
			</div>
		</div>
		<div class="row custom-pricing push">
			<div class="col-md-6" style="padding: 0px;">
				<div class="price-category myactive">
					<span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white shadow-sm">Business</span>
		            <div class="bg-transparent card-header pt-4 border-0">
		                <h1 class="h1 font-weight-normal text-primary text-center mb-0" data-pricing-value="45">&#8358;<span class="price"><?=$amount?></span></h1>
		            </div>				
					<div class="pricing-description">
                        <ul class="list-unstyled">
                            <li class="pl-3 pr-3"><i class="fa fa-check"></i>
                            Unlimited song uploads</li>
                            <li class="pl-3 pr-3"><i class="fa fa-check">
                            </i>
                            80% per unit sold</li>
                            <li class="pl-3 pr-3"><i class="fa fa-check">
                            </i>
                            Affiliate Email Notifications</li>
                            <li class="pl-3 pr-3"><i class="fa fa-check">
                            </i>
                            Keep 100% song royalty & copyrights
                        	</li>
                            <li class="pl-3 pr-3"><i class="fa fa-check"></i>
                            Customer Support
                        	</li>
                        </ul>
                    </div>
					<a href="account.php" class="btn btn-custom">Create Account</a>
					<div class="push">
						<img class="payment-img" src="images/cross-payment-2.png">
					</div>									
				</div>		
			</div>
			<div class="col-md-6" style="padding: 0px;">
				<div class="price-category">
					<span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white shadow-sm">Free</span>
		            <div class="bg-transparent card-header pt-4 border-0">
		                <h1 class="h1 font-weight-normal text-primary text-center mb-0" data-pricing-value="45">&#8358;<span class="price">0.00</span></h1>
		            </div>				
					<div class="pricing-description">
                        <ul class="list-unstyled">
                            <li class="pl-3 pr-3"><i class="fa fa-check"></i>
                            Unlimited song uploads</li>
                            <li class="pl-3 pr-3"><i class="fa fa-check">
                            </i>
                            Free for dowload</li>
                            <li class="pl-3 pr-3"><i class="fa fa-check"></i>
                            Keep 100% song royalty & copyrights
                            </li>                           
                        	<li class="pl-3 pr-3"><i class="fa fa-check"></i>                            	
                            Customer Support
                        	</li>                            
                        </ul>
                    </div>
					<a href="account.php" class="btn btn-custom">Create Account</a>
					<div class="push">
						<img class="payment-img" src="images/cross-payment-2.png">
					</div>                    					
				</div>		
			</div>				
		</div>
	</div>
<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>