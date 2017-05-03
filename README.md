> Note: This project's a bit old now :) However, you are free to branch it out and commit PRs

MobileHub Question Answering System
=====================

What is MobileHub?
------------------

MobileHub is a question answering system (something like Stack Overflow) built on top of CodeIgniter platform. The project contains both client and server side solution.

This project was developed to practice MVC (Model-View-Controller) design pattern. The client side was developed purely using Javascript and the server side was implemented using Codeigniter (PHP) framework. MySQL was used for persistence and OpenSSL was integrated in order to perform secure transactions throughout the entire site.

For more information and screenshots, refer my blog:
https://medium.com/@sahan91/mobilehub-question-answering-system-feaeb75f5085

Tech
-------

### Client Side 

 - jQuery was used to handle the client side logic including, rendering of  UI elements, communicating with the REST API of the web application, validations and UI animations.   - Twitter  Bootstrap  JavaScript  plugin  was  used  to  handle  several  UI  components  such  as  modals,  dialog boxes, tabs, breadcrumbs etc. 
  - Twitter  Bootstrap  CSS  framework  was  used  to  stylise  the  application  along  with  Font  Awesome,  Google fonts API to apply fonts and glyph icons. Several client  side  validations  have  been carried  out  using  the bootstrap  max-length  plugin  and  a plugin called Form validator which was written on top of jQuery. 
 - DataTable jQuery plugin was used to display data in the admin panel. 
 - Morris.Js and Raphaël.Js was used to create the charts of the admin panel dashboard.

### Server Side
 - Apache  Web  Server  (version  2.4.4)  was  chosen  as  the  backend  server  software  because  of  its  openness which  results  in  much  more  easier  configurations  when  compared  with  other server  side  software. Moreover,   Apache   Web   Server   provides   SSL/TLS   support   which   was   harnessed  to   implement  the functional requirements of MobileHub.
  - MySQL  Database  Server  (version  5.6.12)  was  used  for  the  persistent  storage  layer  of  the  application. MySQL  is  a  popular  relational  database  management  system  because  of  its  ease  of  use,  scalability,  high performance  and  robustness.  In  addition,  with the  help  of  the  phpMyAdmin  web interface,  it  is  easy  to configure  and  perform  transactions  such  as  managing  several  databases,  mapping  relationships  of  the tables, choosing indexes for columns etc.
  - PHP (version 5.4.12) was used as the server side scripting language which caters as the  backbone for the CodeIgniter framework.
  - OpenSSL  (version  1.0.1)  was  used  in  combination  with  the  Apache  Web  Server to  support  SSL  and  TLS transactions  over  the  HTTPS  protocol. OpenSSL  is  used  worldwide  because  it  is  a  robust,  open  source, support  for  SSL  v2/v3  TLS  v1  and  its  support  for  general  purpose  cryptography  libraries  for  creating  SSL certificates etc.
  - Additionally, Sendmail  (version  8.14.7),  an  email  routing  software  which  supports  many  mail  transfer methods  such  as  SMTP,  in  conjunction  with STunnel  (version  4.56)  an  open  source  software  used  as  a TLS/SSL  tunnelling  service,  were  used  to  configure  the  email  sending  capabilities  (from  the  localhost)  of the web application.



Installation
--------------
1. First install XAMPP or WAMP (Or you can copy the instance included in the WAMP folder here)
2. Copy and Paste the MobileHub folder located in to the www folder or htdocs folder.
3. Log in to your MySQL server instance using your credentials and import the db script included in this repo
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

Author
----
Sahan Serasinghe - [lk.linkedin.com/in/sahanserasinghe] | [@sahan91]

Version
----

1.0

License
----

MIT

**Free Software, Hell Yeah!**

[lk.linkedin.com/in/sahanserasinghe]:http://lk.linkedin.com/in/sahanserasinghe
[@sahan91]:https://twitter.com/sahan91
[jQuery]:http://jquery.com/
[ng-flow]:https://github.com/flowjs/ng-flow
[Twitter Bootstrap]: http://getbootstrap.com/
