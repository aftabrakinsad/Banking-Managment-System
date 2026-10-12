-- Unified schema for all modules (Admin, Manager, Employee, User).
-- Reconstructed from the queries in the code; the original course dumps were incomplete
-- and the three modules used three different databases.
SET NAMES utf8mb4;

-- ---------- Admin module ----------
CREATE TABLE staticadmin (
  admin_id   INT AUTO_INCREMENT PRIMARY KEY,
  uname      VARCHAR(50)  NOT NULL UNIQUE,
  pass       VARCHAR(255) NOT NULL,
  email      VARCHAR(100) NOT NULL UNIQUE,
  code       VARCHAR(50)  NOT NULL DEFAULT '',
  accountno  INT NULL
);

CREATE TABLE applicantofadmin (
  applicant_serial INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(100) NOT NULL, lname VARCHAR(100) NOT NULL,
  uname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL,
  nid BIGINT NOT NULL, phone VARCHAR(30) NOT NULL,
  password VARCHAR(255) NOT NULL, cpassword VARCHAR(255) NOT NULL DEFAULT '',
  picture VARCHAR(255) NOT NULL DEFAULT '', cv VARCHAR(255) NOT NULL DEFAULT '',
  UNIQUE (email), UNIQUE (nid)
);

CREATE TABLE admin_back_up LIKE applicantofadmin;

CREATE TABLE details_table_for_selected_admins (
  serial INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(100) NOT NULL, lname VARCHAR(100) NOT NULL,
  uname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL,
  nid BIGINT NOT NULL, phone VARCHAR(30) NOT NULL,
  salary INT NOT NULL DEFAULT 0,
  pin INT NULL,
  accountno INT NULL,
  UNIQUE (email), UNIQUE (nid)
);

CREATE TABLE admin_account_number (
  serial INT AUTO_INCREMENT PRIMARY KEY,
  uname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL,
  nid BIGINT NOT NULL, accountno INT NULL,
  UNIQUE (nid)
);

CREATE TABLE addedemployee (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(100) NOT NULL, lname VARCHAR(100) NOT NULL,
  uname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL,
  nid BIGINT NOT NULL, phone VARCHAR(30) NOT NULL,
  password VARCHAR(255) NOT NULL, cpassword VARCHAR(255) NOT NULL DEFAULT '',
  picture VARCHAR(255) NOT NULL DEFAULT '', cv VARCHAR(255) NOT NULL DEFAULT ''
);

CREATE TABLE new_user (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(100) NOT NULL, lname VARCHAR(100) NOT NULL,
  uname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL,
  nid BIGINT NOT NULL, phone VARCHAR(30) NOT NULL,
  accountno INT NOT NULL, pin INT NOT NULL,
  password VARCHAR(255) NOT NULL, cpassword VARCHAR(255) NOT NULL DEFAULT ''
);

CREATE TABLE `user` (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(100) NOT NULL, lname VARCHAR(100) NOT NULL,
  uname VARCHAR(100) NOT NULL UNIQUE, email VARCHAR(100) NOT NULL UNIQUE,
  nid BIGINT NOT NULL, phone VARCHAR(30) NOT NULL,
  accountno INT NOT NULL UNIQUE, pin INT NOT NULL,
  password VARCHAR(255) NOT NULL, cpassword VARCHAR(255) NOT NULL DEFAULT '',
  picture VARCHAR(255) NOT NULL DEFAULT ''
);

CREATE TABLE news (
  news_id INT AUTO_INCREMENT PRIMARY KEY,
  tittle VARCHAR(100) NOT NULL,
  news_body VARCHAR(500) NOT NULL,
  created DATETIME NOT NULL
);

-- Admin + Employee transfers write here (legacy: one running balance, no per-account lookup)
CREATE TABLE passbook (
  trans_id INT AUTO_INCREMENT PRIMARY KEY,
  trans_date DATETIME NOT NULL,
  remarks VARCHAR(256) NOT NULL,
  debit INT NOT NULL, credit INT NOT NULL, balance INT NOT NULL,
  accountno INT NOT NULL,
  INDEX (accountno)
);
CREATE TABLE prebookfunds LIKE passbook;

-- ---------- Manager module ----------
CREATE TABLE manager (
  id INT AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(100), lastname VARCHAR(100), gender VARCHAR(20), age INT,
  fathersname VARCHAR(100), mothersname VARCHAR(100),
  username VARCHAR(100) NOT NULL UNIQUE, pass VARCHAR(255) NOT NULL,
  email VARCHAR(100) UNIQUE, presentaddress TEXT,
  nid BIGINT UNIQUE, phone VARCHAR(30),
  cvpath VARCHAR(255), imgpath VARCHAR(255),
  doj DATE, salary INT,
  accountno INT NULL,
  activeStatus VARCHAR(20) NULL,
  fund DECIMAL(14,2) NOT NULL DEFAULT 0
);
CREATE TABLE applicationofmanager LIKE manager;

CREATE TABLE `transaction` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  senderaccount INT NOT NULL, receveraccount INT NOT NULL,
  balancetransfered DECIMAL(14,2) NOT NULL,
  `Date` DATETIME NOT NULL
);

CREATE TABLE managernews (
  news_id INT AUTO_INCREMENT PRIMARY KEY,
  tittle VARCHAR(100) NOT NULL,
  news_body VARCHAR(500) NOT NULL,
  created DATETIME NOT NULL,
  sender VARCHAR(100)
);

-- ---------- Employee module ----------
CREATE TABLE registrationofemployee (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(100) NOT NULL, lname VARCHAR(100) NOT NULL,
  Username VARCHAR(100) NOT NULL, Email VARCHAR(100) NOT NULL,
  NID BIGINT NOT NULL, Phone VARCHAR(30) NOT NULL,
  Password VARCHAR(255) NOT NULL, cpassword VARCHAR(255) NOT NULL DEFAULT '',
  gender VARCHAR(20), picture VARCHAR(255) NOT NULL DEFAULT '', cv VARCHAR(255) NOT NULL DEFAULT ''
);

CREATE TABLE employeelogin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  code VARCHAR(50) NOT NULL DEFAULT ''
);

CREATE TABLE employee (
  id INT AUTO_INCREMENT PRIMARY KEY,
  FirsName VARCHAR(100), LastName VARCHAR(100),
  Username VARCHAR(100), Password VARCHAR(255), ConfirmPassword VARCHAR(255),
  Email VARCHAR(100), NID BIGINT, Phone VARCHAR(30),
  `Date` DATE, Street VARCHAR(100), City VARCHAR(100), Postal VARCHAR(20),
  gender VARCHAR(20),
  manager VARCHAR(100) NULL
);

CREATE TABLE query_user (
  query_id INT AUTO_INCREMENT PRIMARY KEY,
  query_title VARCHAR(100) NOT NULL,
  query_body VARCHAR(500) NOT NULL,
  created DATETIME NOT NULL
);
