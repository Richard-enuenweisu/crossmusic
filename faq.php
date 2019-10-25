<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

include str_replace("\\","/",dirname(__FILE__).'/includes/search.php');  
include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">
	.card{
		background-color: #052d4a;
	}
	.btn-link{
		color: #afb8bc;
	}
	.card-body{
		color: #79909f;
	}
</style>
<div class="container py-3">
	<div class="row">		
	    <div class="col-md-8 pusher-3">
			<div class="row">
				<div class="col-sm-12 col-md-12">
				      <h1> Frequently Asked Questions </h1>
				      <p>
				      Click the FAQ label to toggle FAQ, answers to each questions are unvieled upon toggle. For more doubts or couldn't find answers to you questions, please contact us. our 24/7 FAQ team can't wait to serve you better.
				      </p>
				      <a href="contact.php" class="btn btn-primary">Contact Us</a>	    			
				</div>
			</div>
		    <div class="row pusher">
		        <div class="col-sm-12 col-md-12 mx-auto">
		        	<h3>Popular Questions</h3>
		            <div class="accordion" id="faqExample">
		                <div class="card">
		                    <div class="card-header p-2" id="headingOne">
		                        <h5 class="mb-0">
		                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
		                              Q: How Do i signup?
		                            </button>
		                          </h5>
		                    </div>

		                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqExample">
		                        <div class="card-body">
		                            <b>Answer:</b>Are you new to crossmusic? If so, to create an account click <a href="accont.php"><b>here.</b></a>
									If you already have an existing account login <a href="login.php"><b>here.</b></a> and toggle the switch to the right for artist.<br><br>
									Once you are in your account which is called your account dashboard, from there, you will choose to add album or single.
		                        </div>
		                    </div>
		                </div>
		                <div class="card">
		                    <div class="card-header p-2" id="headingTwo">
		                        <h5 class="mb-0">
		                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
		                          Q: Submitting a single or album
		                        </button>
		                      </h5>
		                    </div>
		                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqExample">
		                        <div class="card-body">
								Putting a single out ahead of an album release is a great way to promote your project!. however, you must keep this in mind:<br>
								No two music projects can have the same cover image, so it's important to pick unique art for your single. <br><br> 
								We ensure this standards because partner sites and search engines require the text on a cover image to match the metadata for the project with which it's associated. So your single can say the name of your single on the cover, and your album can say the name of your album, but your single shouldn't say the name of your album.
		                        </div>
		                    </div>
		                </div>
		                <div class="card">
		                    <div class="card-header p-2" id="headingThree">
		                        <h5 class="mb-0">
		                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
		                              Q. How do i update my project price?
		                            </button>
		                          </h5>
		                    </div>
		                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqExample">
		                        <div class="card-body">
		                            You can change the price your music is being sold for on crossmusic at any time within your account! Just follow these steps to do so:<br>

									Log into your Crossmusic account. 
									Click on the tab “Music Manager” on the dropdown, select the project to update - Singles/Albums
									Locate the release you want to edit, and click on the grey “edit” button.<br>
									You will then be brought to your project overview. Locate the price input field and update your price.<br> Click on the Edit Single/Album button to commit recent changes to the project.<br><br>
									Please note that our pricing are usually &#8358; 100 [150 | 200] for tracks and singles, and &#8358; 500 and above for albums. Always encourage your fans to buy your music project by following conventional pricing for both singles and albums.
								</div>
		                    </div>
		                </div>
		                <div class="card">
		                    <div class="card-header p-2" id="headingFour">
		                        <h5 class="mb-0">
		                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
		                              Q. How much do i get as an Affiliate Marketer?
		                            </button>
		                          </h5>
		                    </div>
		                    <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-parent="#faqExample">
		                        <div class="card-body">
		                            As an affiliate marketer, you only make money when a refered user visit and puchase a music project using your affiliate referer link. you get whooping 10% for each successful transaction, and you can cashout at the end of the month with a minimum of &#8358; 2000 Affiliate Account balance.
		                        </div>
		                    </div>
		                </div>
		            </div>

		        </div>
		    </div>	    			
		</div>
		<div class="col-md-4 d-lg-flex flex-column align-items-center justify-content-center">
			<img src="images/faq.png" style="width: 95%;">
		</div>
	</div>		
    <!--/row-->
</div>
<!--container-->
<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>