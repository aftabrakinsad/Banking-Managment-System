-- Demo data. Every demo account's password is: Demo@1234 (plain text for now; hashing is a later phase).
INSERT INTO staticadmin (uname, pass, email, accountno) VALUES ('admin', 'Demo@1234', 'admin@example.com', 1000001);
INSERT INTO details_table_for_selected_admins (fname,lname,uname,email,nid,phone,salary,pin,accountno)
  VALUES ('Alex','Admin','admin','admin@example.com',10000001,'+8801700000001',90000,1234,1000001);
INSERT INTO admin_account_number (uname,email,nid,accountno) VALUES ('admin','admin@example.com',10000001,1000001);

INSERT INTO manager (firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary,accountno,activeStatus,fund)
  VALUES ('Morgan','Manager','Other',35,'N/A','N/A','manager','Demo@1234','manager@example.com','Dhaka',10000002,'+8801700000002','','','2022-01-10',70000,2000001,'active',50000);

INSERT INTO registrationofemployee (fname,lname,Username,Email,NID,Phone,Password,cpassword,gender)
  VALUES ('Eli','Employee','employee','employee@example.com',10000003,'+8801700000003','Demo@1234','Demo@1234','Other');
INSERT INTO employeelogin (username,password,email) VALUES ('employee','Demo@1234','employee@example.com');

INSERT INTO `user` (fname,lname,uname,email,nid,phone,accountno,pin,password,cpassword)
  VALUES ('Casey','Customer','casey','casey@example.com',10000004,'+8801700000004',3000001,1111,'Demo@1234','Demo@1234'),
         ('Riley','Customer','riley','riley@example.com',10000005,'+8801700000005',3000002,2222,'Demo@1234','Demo@1234');

INSERT INTO news (tittle,news_body,created) VALUES ('Welcome to Banking Management System','This is a demo banking system built for portfolio purposes.',NOW());
INSERT INTO passbook (trans_date,remarks,debit,credit,balance,accountno) VALUES
  (NOW(),'Opening balance',0,100000,100000,1000001);
INSERT INTO prebookfunds (trans_date,remarks,debit,credit,balance,accountno) VALUES
  (NOW(),'Opening balance',0,100000,100000,1000001);
