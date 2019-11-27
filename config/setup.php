#!/usr/bin/php
<?php
  include './database.php';

  try {
      $bdd = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "CREATE DATABASE IF NOT EXISTS `$DB_NAME`";
      $bdd->exec($sql);
      echo "Database created successfully<br/>";
  } catch(PDOException $e) {
      echo 'Connection failed: <br/> ' . $e->getMessage(). "<br/>";
      exit(-1);
  }

  try {
      $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(30) NOT NULL,
        `mail` VARCHAR(100) NOT NULL,
        `password` VARCHAR(256) NOT NULL,
        `flag`  VARCHAR(50)NOT NULL,
        `verified` VARCHAR(1) NOT NULL DEFAULT 'N',
        `prenom` VARCHAR(30) NOT NULL,
        `nom` VARCHAR(30) NOT NULL,
        `age` INT UNSIGNED,
        `genre` enum('Homme','Femme','Non renseigne') NOT NULL DEFAULT 'Non renseigne',
        `interet` enum('Homme','Femme', 'Homme et Femme') NOT NULL DEFAULT 'Homme et Femme',
        `bio` VARCHAR(256),
        `tag` VARCHAR(256),
        `localisation` VARCHAR(256),
        `popularite` INT UNSIGNED NOT NULL DEFAULT '0',
        `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
      )";
      $bdd->exec($sql);
      echo "Table users created successfully<br/>";
      } catch (PDOException $e) {
      echo "ERROR CREATING TABLE: ".$e->getMessage(). "<br/>";
      }

  try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `images` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `image` VARCHAR(256) NOT NULL,
      `flag`  VARCHAR(50)NOT NULL,
      `profile` INT UNSIGNED NOT NULL DEFAULT '0'
    )";
    $bdd->exec($sql);
    echo "Table images created successfully<br/>";
    } catch (PDOException $e) {
    echo "ERROR CREATING TABLE: ".$e->getMessage(). "<br/>";
    }

  try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `historique` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `profil` VARCHAR(50)NOT NULL,
      `visiteur` VARCHAR(50)NOT NULL,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";
    $bdd->exec($sql);
    echo "Table historique created successfully<br/>";
    } catch (PDOException $e) {
    echo "ERROR CREATING TABLE: ".$e->getMessage(). "<br/>";
    }

  try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `likes` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `liked` VARCHAR(50)NOT NULL,
      `likeur` VARCHAR(50)NOT NULL
    )";
    $bdd->exec($sql);
    echo "Table likes created successfully<br/>";
    } catch (PDOException $e) {
    echo "ERROR CREATING TABLE: ".$e->getMessage(). "<br/>";
    }

  try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `report` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `reported` VARCHAR(50)NOT NULL,
      `reporteur` VARCHAR(50)NOT NULL,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";
    $bdd->exec($sql);
    echo "Table report created successfully<br/>";
    } catch (PDOException $e) {
    echo "ERROR CREATING TABLE: ".$e->getMessage(). "<br/>";
    }

  try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `block` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `blocked` VARCHAR(50)NOT NULL,
      `blockeur` VARCHAR(50)NOT NULL,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";
    $bdd->exec($sql);
    echo "Table block created successfully<br/>";
    } catch (PDOException $e) {
    echo "ERROR CREATING TABLE: ".$e->getMessage(). "<br/>";
    }

  try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `chat_id` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `user1` VARCHAR(50)NOT NULL,
      `user2` VARCHAR(50)NOT NULL,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";
    $bdd->exec($sql);
    echo "Table chat_id created successfully<br/>";
    } catch (PDOException $e) {
    echo "ERROR CREATING TABLE: ".$e->getMessage(). "<br/>";
    }

  try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `chat_message` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `chat_id` INT NOT NULL,
      `flag` VARCHAR(50) NOT NULL,
      `message` LONGTEXT NOT NULL,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";
    $bdd->exec($sql);
    echo "Table chat_message created successfully<br/>";
    } catch (PDOException $e) {
    echo "ERROR CREATING TABLE: ".$e->getMessage(). "<br/>";
    }

  try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `notifications` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `flag` VARCHAR(50) NOT NULL,
      `type` VARCHAR(50) NOT NULL,
      `message` VARCHAR(150) NOT NULL,
      `user` VARCHAR(50) NOT NULL,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";
    $bdd->exec($sql);
    echo "Table notifications created successfully<br/>";
    } catch (PDOException $e) {
    echo "ERROR CREATING TABLE: ".$e->getMessage(). "<br/>";
    }
?>

