-- Demo data. Every demo account's password is: Demo@1234 (stored as bcrypt hashes).
INSERT INTO staticadmin (uname, pass, email)
  VALUES ('admin', '$6$Xk3pQ9rT$Mr5binMbFgMTupU0RpzOHxHEAsfWPhZudPfCm7AUsnAGoUOzUS8/nANti4EpaVSSBw.mpWHGsPpWeZrzN/dtJ/', 'admin@example.com');

-- Approved manager
INSERT INTO manager (firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary,accountno,activeStatus,fund)
  VALUES ('Morgan','Manager','Other',35,'N/A','N/A','manager','$2y$10$uIlwBvDHmsqCDm6WeJU8x.klzcgPkBvjWIOP5Z4tq.nrBMI2bA2rS','manager@example.com','Dhaka',10000002,'+8801700000002','','','2022-01-10',70000,2000001,'active',50000);

-- Approved employee (application + login + staff record)
INSERT INTO registrationofemployee (fname,lname,Username,Email,NID,Phone,Password,cpassword,gender,status,reviewed_at)
  VALUES ('Eli','Employee','employee','employee@example.com',10000003,'+8801700000003','','','Other','approved',NOW());
INSERT INTO employeelogin (username,password,email) VALUES ('employee','$2y$10$uIlwBvDHmsqCDm6WeJU8x.klzcgPkBvjWIOP5Z4tq.nrBMI2bA2rS','employee@example.com');
INSERT INTO employee (FirsName,LastName,Username,Password,ConfirmPassword,Email,NID,Phone,gender,manager)
  VALUES ('Eli','Employee','employee','','','employee@example.com',10000003,'+8801700000003','Other','manager');

-- Pending applications for the admin to review
INSERT INTO applicationofmanager (firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary,fund)
  VALUES ('Taylor','Applicant','Other',31,'N/A','N/A','taylor','$2y$10$uIlwBvDHmsqCDm6WeJU8x.klzcgPkBvjWIOP5Z4tq.nrBMI2bA2rS','taylor@example.com','Chattogram',10000006,'+8801700000006','','','2026-01-05',65000,0);
INSERT INTO registrationofemployee (fname,lname,Username,Email,NID,Phone,Password,cpassword,gender)
  VALUES ('Jamie','Joiner','jamie','jamie@example.com',10000007,'+8801700000007','$2y$10$uIlwBvDHmsqCDm6WeJU8x.klzcgPkBvjWIOP5Z4tq.nrBMI2bA2rS','','Other');

-- Customers (accounts are created by admin/employee in the real flow)
INSERT INTO `user` (fname,lname,uname,email,nid,phone,accountno,pin,password,cpassword)
  VALUES ('Casey','Customer','casey','casey@example.com',10000004,'+8801700000004',3000001,'$2y$10$nQRcUQCTcAYj1vlAqzfxnOiQ6uPB0IK8cPoMS/sn29OVprCFgW/4.','$2y$10$uIlwBvDHmsqCDm6WeJU8x.klzcgPkBvjWIOP5Z4tq.nrBMI2bA2rS',''),
         ('Riley','Customer','riley','riley@example.com',10000005,'+8801700000005',3000002,'$2y$10$8MncYJUhQx1Sd6tVFjsaf.1JbcQ.CZAJUL51V7yfOXSkk11yGWY2O','$2y$10$uIlwBvDHmsqCDm6WeJU8x.klzcgPkBvjWIOP5Z4tq.nrBMI2bA2rS','');

INSERT INTO news (tittle,news_body,created,audience) VALUES
  ('Welcome to Banking Management System','This is a demo banking system built as an academic course project.',NOW(),'all'),
  ('Branch hours updated','Counters now close at 5 pm on weekdays.',NOW(),'customer'),
  ('Staff meeting Sunday','All managers: quarterly review at 10 am.',NOW(),'manager'),
  ('New query workflow','Employees: log customer queries from the Queries page.',NOW(),'employee');

INSERT INTO tasks (title,details,assignee_role,assignee_username,due_date)
  VALUES ('Review weekly transfer report','Check unusual transfers over 100,000.','manager','manager',CURDATE() + INTERVAL 5 DAY),
         ('Update customer contact details','Call back customers with outdated phone numbers.','employee','employee',CURDATE() + INTERVAL 3 DAY);

INSERT INTO activity_log (actor_role,actor,action,detail,ip) VALUES
  ('system','seed','database_initialised','Demo data loaded','');
