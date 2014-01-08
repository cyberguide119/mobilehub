1. First install XAMPP or WAMP (Or you can copy the instance included in the WAMP folder here)

2. Copy and Paste the MobileHub folder located in to the www folder or htdocs folder.

3. Log in to your MySQL server instance using your credentials and import the db script included in this CD.

Once the everything is setup you still need to do some configurations before running the project.

4. Copy the /Server Configurations/conf/ to wamp/bin/apache/Apache2.4.4 (This folder contains the necessary certificates)

5. Import the certificated located in /Server Configurations/conf/ssl.crt in to your browser

6. Go to your WAMP MANAGER and enable the following modules:
	1. Apache -> Modules -> ssl_module
	2. Apache -> Modules -> socache_dbm_module
	3. Apache -> Modules -> socache_shmcb_module
	4. Apache -> Modules -> ssl_module
	5. PHP -> Extensions -> php_sockets
	6. Apache -> Modules -> rewrite_module

7. Download and install STunnel : https://www.stunnel.org/downloads/stunnel-4.56-installer.exe

8. Replace your apache/bin with /Server Configurations/apache/Apache2.4.4/bin

9. Add sendmail folder to the root of WAMP.

10. httpd.conf has been added in case.

MYSQL User
==========

username : mobilehub
password : intel@123