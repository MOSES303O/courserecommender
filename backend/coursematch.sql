-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema coursematch
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema coursematch
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `coursematch` DEFAULT CHARACTER SET utf8 ;
USE `coursematch` ;

-- -----------------------------------------------------
-- Table `coursematch`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coursematch`.`user` (
  `email` VARCHAR(20) NOT NULL,
  `jina` CHAR(20) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `session` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`email`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `coursematch`.`coursedetail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coursematch`.`coursedetail` (
  `courseid` VARCHAR(50) NOT NULL,
  `cname` VARCHAR(100) NOT NULL,
  `clusterpoints` VARCHAR(255) NOT NULL,
  `detail` VARCHAR(255) NOT NULL,
  CONSTRAINT `course_fk`
    FOREIGN KEY (`courseid`)
    REFERENCES `coursematch`.`universitycourses` (`courseid`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `coursematch`.`selection`
-- -----------------------------------------------------

 CREATE TABLE IF NOT EXISTS `coursematch`.`selection` ( 
  `courseid` VARCHAR(50) NOT NULL,
  `email` VARCHAR(20) NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  CONSTRAINT `email_fk`
    FOREIGN KEY (`email`)
    REFERENCES `coursematch`.`user` (`email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `courseid_fkk`
    FOREIGN KEY (`courseid`)
    REFERENCES `coursematch`.`universitycourses` (`courseid`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `coursematch`.`universitylist`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coursematch`.`universitylist` (
  `name` CHAR(200) NOT NULL,
  `detail` VARCHAR(255) NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`name`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `coursematch`.`schooldetail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coursematch`.`schooldetail` (
  `school_name` CHAR(200) NOT NULL,
  `school` VARCHAR(200) NOT NULL,
  `courseid` VARCHAR(50) NOT NULL,
  CONSTRAINT `school_name_fk`
    FOREIGN KEY (`school_name`)
    REFERENCES `coursematch`.`universitylist` (`name`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `courseid_fk`
    FOREIGN KEY (`courseid`)
    REFERENCES `coursematch`.`universitycourses` (`courseid`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `coursematch`.`universitycourses`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `coursematch`.`universitycourses` (
  `id` int not null AUTO_INCREMENT,
  `courseid` VARCHAR(50) NOT NULL,
  `name` CHAR(200) NOT NULL,
  PRIMARY KEY (`courseid`),
  CONSTRAINT `university_name_fk`
    FOREIGN KEY (`name`)
    REFERENCES `coursematch`.`universitylist` (`name`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
