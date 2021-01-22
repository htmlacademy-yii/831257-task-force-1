-- MySQL Script generated by MySQL Workbench
-- Сб 09 янв 2021 00:13:35
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema task_force
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema task_force
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `task_force` DEFAULT CHARACTER SET utf8 ;
USE `task_force` ;

-- -----------------------------------------------------
-- Table `task_force`.`cities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`cities` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `city` VARCHAR(70) NULL,
  `latitude` VARCHAR(15) NULL,
  `longitude` VARCHAR(15) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
COMMENT = 'city coordinates';


-- -----------------------------------------------------
-- Table `task_force`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(320) NOT NULL,
  `login` VARCHAR(70) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `date_add` DATETIME NULL,
  `city_id` INT UNSIGNED NOT NULL,
  `avatar` VARCHAR(70) NULL DEFAULT NULL,
  `birthday` DATETIME NULL DEFAULT NULL,
  `about_me` TEXT NULL DEFAULT NULL,
  `phone` VARCHAR(11) NULL DEFAULT NULL,
  `skype` VARCHAR(45) NULL DEFAULT NULL,
  `telegram` VARCHAR(45) NULL DEFAULT NULL,
  `raiting` DECIMAL UNSIGNED NULL DEFAULT NULL,
  `last_activity` DATETIME NULL DEFAULT NULL,
  `is_builder` TINYINT(1) NULL DEFAULT 0,
  `new_message` TINYINT(1) NULL DEFAULT 1,
  `task_actions` TINYINT(1) NULL DEFAULT 1,
  `new_review` TINYINT(1) NULL DEFAULT 1,
  `show_my_contacts` TINYINT(1) NULL DEFAULT 1,
  `show_my_profile` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_users_cities_idx` (`city_id` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  CONSTRAINT `fk_users_cities`
    FOREIGN KEY (`city_id`)
    REFERENCES `task_force`.`cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `task_force`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(70) NULL,
  `icon` VARCHAR(70) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
COMMENT = 'work categories';


-- -----------------------------------------------------
-- Table `task_force`.`photos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`photos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(70) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_photos_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_photos_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `task_force`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'photos of works';


-- -----------------------------------------------------
-- Table `task_force`.`tasks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`tasks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_add` DATETIME NULL,
  `customer_id` INT UNSIGNED NOT NULL,
  `builder_id` INT UNSIGNED NULL DEFAULT NULL,
  `job` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `address` VARCHAR(255) NULL,
  `cities_id` INT UNSIGNED NOT NULL,
  `latitude` VARCHAR(15) NULL DEFAULT NULL,
  `longitude` VARCHAR(15) NULL DEFAULT NULL,
  `budget` INT UNSIGNED NULL DEFAULT 0,
  `date_expire` DATETIME NULL DEFAULT NULL,
  `review` TEXT NULL,
  `quality` TINYINT UNSIGNED NULL DEFAULT 0,
  `status` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tasks_users1_idx` (`customer_id` ASC),
  INDEX `fk_tasks_users2_idx` (`builder_id` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_tasks_categories_idx` (`category_id` ASC),
  CONSTRAINT `fk_tasks_users1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `task_force`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tasks_users2`
    FOREIGN KEY (`builder_id`)
    REFERENCES `task_force`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tasks_categories`
    FOREIGN KEY (`category_id`)
    REFERENCES `task_force`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `task_force`.`files`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`files` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_files_tasks_idx` (`task_id` ASC),
  CONSTRAINT `fk_files_tasks`
    FOREIGN KEY (`task_id`)
    REFERENCES `task_force`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'files for tasks';


-- -----------------------------------------------------
-- Table `task_force`.`responses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`responses` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_add` DATETIME NULL,
  `task_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `cost` INT UNSIGNED NULL DEFAULT 0,
  `comment` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_responses_tasks_idx` (`task_id` ASC),
  INDEX `fk_responses_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_responses_tasks`
    FOREIGN KEY (`task_id`)
    REFERENCES `task_force`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_responses_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `task_force`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Jobs responses';


-- -----------------------------------------------------
-- Table `task_force`.`favorites`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`favorites` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id_customer` INT UNSIGNED NOT NULL,
  `user_id_builder` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_favorites_users1_idx` (`user_id_customer` ASC),
  INDEX `fk_favorites_users2_idx` (`user_id_builder` ASC),
  CONSTRAINT `fk_favorites_users1`
    FOREIGN KEY (`user_id_customer`)
    REFERENCES `task_force`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_favorites_users2`
    FOREIGN KEY (`user_id_builder`)
    REFERENCES `task_force`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `task_force`.`messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`messages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `date_add` DATETIME NULL,
  `message` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_messages_tasks_idx` (`task_id` ASC),
  INDEX `fk_messages_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_messages_tasks`
    FOREIGN KEY (`task_id`)
    REFERENCES `task_force`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `task_force`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `task_force`.`opinions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `task_force`.`opinions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `task_id` INT UNSIGNED NOT NULL,
  `review_author_id` INT UNSIGNED NOT NULL,
  `date_add` DATETIME NULL,
  `rating` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `description` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_opinions_users1_idx` (`user_id` ASC),
  INDEX `fk_opinions_tasks_idx` (`task_id` ASC),
  INDEX `fk_opinions_users2_idx` (`review_author_id` ASC),
  CONSTRAINT `fk_opinions_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `task_force`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_opinions_tasks`
    FOREIGN KEY (`task_id`)
    REFERENCES `task_force`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_opinions_users2`
    FOREIGN KEY (`review_author_id`)
    REFERENCES `task_force`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
