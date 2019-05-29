

-- accounttbl sql
CREATE TABLE `cross`.`accounttbl` 
( `id` INT NOT NULL AUTO_INCREMENT , `fname` VARCHAR(255) NOT NULL , `lname` VARCHAR(255) NOT NULL , 
	`phone` VARCHAR(50) NOT NULL , `company_name` VARCHAR(255) NOT NULL , `address_1` VARCHAR(255) NOT NULL , 
	`address_2` VARCHAR(255) NOT NULL , `city` VARCHAR(150) NOT NULL , `state` 
	VARCHAR(150) NOT NULL , `zip` VARCHAR(50) NOT NULL , `acct_type` VARCHAR(50) NOT NULL , 
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) 
ENGINE = InnoDB;

-- userttbl
CREATE TABLE `cross`.`usertbl` 
( `id` INT NOT NULL AUTO_INCREMENT , `fname` VARCHAR(255) NOT NULL , `lname` VARCHAR(255) NOT NULL ,
 `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , `last_login` TIMESTAMP NOT NULL , 
 `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) 
ENGINE = InnoDB;              

-- artist login TABLE
CREATE TABLE `cross`.`artisttbl` 
( `id` INT NOT NULL AUTO_INCREMENT , `account_id` INT NOT NULL , `email` VARCHAR(255) NOT NULL , 
	`password` VARCHAR(255) NOT NULL , `last_login` TIMESTAMP NOT NULL , 
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), INDEX (`account_id`)) 
ENGINE = InnoDB;

-- bankdetails TABLE
CREATE TABLE `cross`.`banktbl` 
( `id` INT NOT NULL AUTO_INCREMENT , `account_id` INT NOT NULL , `bank_name` VARCHAR(150) NOT NULL , 
	`bank_account` VARCHAR(255) NOT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	PRIMARY KEY (`id`), INDEX (`account_id`)) 
ENGINE = InnoDB;


-- block_accttbl
CREATE TABLE `cross`.`block_accttbl` 
( `id` INT NOT NULL , `account_id` INT NOT NULL , `block` VARCHAR(50) NOT NULL , 
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ) 
ENGINE = InnoDB;

--block user table
CREATE TABLE `cross`.`block_usertbl` 
( `id` INT NOT NULL , `user_id` INT NOT NULL , `block` VARCHAR(50) NOT NULL , 
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ) 
ENGINE = InnoDB;

-- account transaction table
	CREATE TABLE `acct_transactiontbl` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `account_id` int(11) NOT NULL,
 `active` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `amount` decimal(10,2) NOT NULL,
 `trans_ref` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
 `Due_date` datetime NOT NULL,
 `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci