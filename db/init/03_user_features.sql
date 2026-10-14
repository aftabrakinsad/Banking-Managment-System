-- Customer portal extras
CREATE TABLE beneficiaries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  nickname VARCHAR(60) NOT NULL,
  accountno INT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (user_id, accountno),
  FOREIGN KEY (user_id) REFERENCES `user`(user_id) ON DELETE CASCADE
);

CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  message VARCHAR(255) NOT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (user_id, is_read),
  FOREIGN KEY (user_id) REFERENCES `user`(user_id) ON DELETE CASCADE
);

-- Opening balances + a little history for the demo customers
INSERT INTO passbook (trans_date,remarks,debit,credit,balance,accountno) VALUES
 (NOW() - INTERVAL 20 DAY,'Opening deposit',0,50000,50000,3000001),
 (NOW() - INTERVAL 12 DAY,'Salary credit',0,25000,75000,3000001),
 (NOW() - INTERVAL 5 DAY,'Sent to: Riley Customer, AC/No: 3000002',3000,0,72000,3000001),
 (NOW() - INTERVAL 20 DAY,'Opening deposit',0,20000,20000,3000002),
 (NOW() - INTERVAL 5 DAY,'Received from: Casey Customer, AC/No: 3000001',0,3000,23000,3000002);
INSERT INTO beneficiaries (user_id,nickname,accountno) VALUES (1,'Riley',3000002);
INSERT INTO notifications (user_id,message) VALUES (2,'You received 3000 from Casey Customer (AC/No: 3000001)');

INSERT INTO customer_requests (user_id,type,subject,message,status) VALUES
  (1,'statement','Statement for last quarter','Please prepare a printed statement for the last three months. I need it for a visa application.','open'),
  (2,'profile_update','Phone number changed','My new phone number is +8801711111111. Please update it on my account.','open');
INSERT INTO customer_requests (user_id,type,subject,message,status,response,handled_by,updated_at) VALUES
  (1,'pin_help','Forgot my PIN','I cannot remember my transfer PIN.','resolved','Your PIN was reset in branch. Please change it from Security after signing in.','employee',NOW());
