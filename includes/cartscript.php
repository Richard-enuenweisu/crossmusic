<?php
if(!empty($_GET["action"])) {
	@$prod_title = $_GET['prod_title'];
	@$item_category = $_GET['category'];
	switch($_GET["action"]) {
		case "add":
			if (!empty($prod_title) && $item_category == 'tracks') {
				# code...
				$prod_query = $pdo->prepare("SELECT * FROM trackstbl WHERE title=:title");
	   			$prod_query->execute([':title' => $prod_title]);
	   			$fetchItems = $prod_query->fetch(PDO::FETCH_ASSOC);
	   			// unset($_SESSION["cart_item"]);

				$myItems = array($fetchItems['id']=>array('id'=>$fetchItems["id"],'title'=>$fetchItems["title"], 'price'=>$fetchItems["price"], 'image'=> $fetchItems['image'], 'category'=>$item_category));
				// var_dump($myItems);

				if(!empty($_SESSION["cart_item"])) {
					if(in_array($fetchItems['title'],array_keys($_SESSION["cart_item"]))) {
						foreach($_SESSION["cart_item"] as $k => $v) {
							foreach ($v as $g_title) {
								if($fetchItems['title'] == $g_title) {
									if(empty($_SESSION["cart_item"][$k]["price"])) {
										// $_SESSION["cart_item"][$k]["price"] = $myItems['price'];
									}
									// $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
								}								
							}
						}
					} else {
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$myItems);
					}
				} else {
					$_SESSION["cart_item"] = $myItems;
				}				
			}
			if (!empty($prod_title) && $item_category == 'singles') {
				# code...
				$prod_query = $pdo->prepare("SELECT * FROM singlestbl WHERE title=:title");
	   			$prod_query->execute([':title' => $prod_title]);
	   			$fetchItems = $prod_query->fetch(PDO::FETCH_ASSOC);
	   			// unset($_SESSION["cart_item"]);

				$myItems = array($fetchItems['id']=>array('title'=>$fetchItems["title"], 'price'=>$fetchItems["price"], 'image'=> $fetchItems['image'], 'category'=>$item_category));
				// var_dump($myItems);

				if(!empty($_SESSION["cart_item"])) {
					if(in_array($fetchItems['title'],array_keys($_SESSION["cart_item"]))) {
						foreach($_SESSION["cart_item"] as $k => $v) {
							foreach ($v as $g_title) {
								if($fetchItems['title'] == $g_title) {
									if(empty($_SESSION["cart_item"][$k])) {
										// $_SESSION["cart_item"][$k]["price"] = $myItems['price'];
									}
									// $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
								}								
							}
						}
					} else {
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$myItems);
					}
				} else {
					$_SESSION["cart_item"] = $myItems;
				}				
			}	
			if (!empty($prod_title) && $item_category == 'albums') {
				# code...
				$prod_query = $pdo->prepare("SELECT * FROM albumstbl WHERE title=:title");
	   			$prod_query->execute([':title' => $prod_title]);
	   			$fetchItems = $prod_query->fetch(PDO::FETCH_ASSOC);
	   			// unset($_SESSION["cart_item"]);

				$myItems = array($fetchItems['id']=>array('title'=>$fetchItems["title"], 'price'=>$fetchItems["price"], 'image'=> $fetchItems['image'], 'category'=>$item_category));
				// var_dump($myItems);

				if(!empty($_SESSION["cart_item"])) {
					if(in_array($fetchItems['title'],array_keys($_SESSION["cart_item"]))) {
						foreach($_SESSION["cart_item"] as $k => $v) {
							foreach ($v as $g_title) {
								if($fetchItems['title'] == $g_title) {
									if(empty($_SESSION["cart_item"][$k])) {
										// $_SESSION["cart_item"][$k]["price"] = $myItems['price'];
									}
									// $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
								}								
							}
						}
					} else {
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$myItems);
					}
				} else {
					$_SESSION["cart_item"] = $myItems;
				}				
			}						
		break;
		case "remove":
			$del_title = trim($_GET["prod_title"]);
			if(!empty($_SESSION["cart_item"]) && $del_title == $_GET["prod_title"]) {
				foreach($_SESSION["cart_item"] as $k => $v) {
					foreach ($v as $prod) {
						# code...					
						if($del_title == $prod){
							// var_dump($prod);
							// var_dump($_SESSION["cart_item"][$k]);
							unset($_SESSION["cart_item"][$k]);
						}
						if(empty($_SESSION["cart_item"])){
							unset($_SESSION["cart_item"]);
						}						
					}
				}
			}
		break;
		case "empty":
			unset($_SESSION["cart_item"]);
		break;	
}    

	if (isset($_SESSION["cart_item"])) {
		foreach ($_SESSION["cart_item"] as $items){							
	       	@$quantity = $quantity + 1;
	    }
    }

    // if (isset($_SESSION["cart_item"])) {
    // 	var_dump($_SESSION["cart_item"]["price"]);   
}

        // foreach ($_SESSION["cart_item"] as $name => $values) {
            
        //     echo $name;
        //     foreach ($values as $value) {
        //     	# code...
        //     	$value = $value;
        //     	echo '<br>'. $value.'<br>';
        //     }
        // }
?>