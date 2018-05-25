MySql 8.1 issue:
New MySQL 8.0.11 is using caching_sha2_password as default authentication method. I think that phpMyAdmin cannot understand this authentication method. You need to create user with one of the older authentication method, e.g. CREATE USER xyz@localhost IDENTIFIED WITH mysql_native_password BY 'passw0rd'
