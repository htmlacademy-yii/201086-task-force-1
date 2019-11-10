CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
  
  USE taskforce;

  CREATE TABLE categories (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(128) NOT NULL
  );
  
  CREATE TABLE response_task (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `response` VARCHAR(128) NOT NULL,
    `task_id` INT NOT NULL,
  );
  
  
  CREATE TABLE users (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `creation_time` DATETIME DEFAULT NOW() NOT NULL,
  `name` VARCHAR(128) NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `location_id` INT NULL,
  `birthday` DATETIME NULL,  
  `contact_details` TEXT NULL,
  `category_id` VARCHAR(128) NULL,
  `password` VARCHAR(128) NOT NULL,
  `phone` VARCHAR(128) NULL,
  `skype` VARCHAR(128) NULL,
  `another_messenger` VARCHAR(128) NULL, 
  `file_id`  VARCHAR(128) NULL,    
  `avatar`  VARCHAR(128) NULL,
  `task_id` VARCHAR(128) NULL,
  `email_on` BINARY NOT NULL  
  );
  
  CREATE TABLE reviews (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL,
    `reviewer_id` INT NULL,
    `assessment` INT NULL,
    `task_id` INT NULL,
    `review_text` TEXT NULL
  );

  CREATE TABLE task (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `creation_time` DATETIME DEFAULT NOW() NOT NULL,
    `name` VARCHAR(128) NOT NULL,
    `category_id` INT NOT NULL,
    `description` TEXT NULL,
    `location_id` INT NULL,
    `budget` INT NULL,
    `deadline` DATETIME NOT NULL,
    `file_id`  VARCHAR(128) NULL,
    `author_id` INT NOT NULL,
    `executor_id` INT NULL,
    `correspondence`VARCHAR(128) NULL,
    `status_task` VARCHAR(128) NULL  
  );
  
  CREATE TABLE correspondence (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `task_id` INT NOT NULL,
    `writer_id` INT NOT NULL,
    `text` TEXT NOT NULL,
    `message_time` DATETIME NOT NULL,
    `viewed` BINARY NOT NULL 
  );
  
    CREATE TABLE locations (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `city` VARCHAR(128) NOT NULL
  );
  
  CREATE TABLE file (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `path` VARCHAR(128) NOT NULL,
    `user_id` INT NOT NULL,
    `task_id` INT NULL
  );