Pathology Lab System
============================


A pathology lab reporting system, which can be used to publish medical test result reports to patients.

Functional Specifications

Create a pathology lab reporting web application where medical test result reports can be published to the
patients:

Operator users should be able to log in to the system to perform following privileged tasks. Patients
cannot access these pages.
Reports CRUD (Multiple tests and results in each report)
Patients CRUD (including pass code)
Lab sends a text message to the patient with a pass code to log in (out of scope).
Patient user could log in using his name (auto complete field) and pass code sent to him. And then can
do the following

Display list of his reports
Display a report details as a page
Export a report as PDF
Mail a report as PDF


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

•	PHP 5.5.9
•	Apache/2.4.7
o	url rewriting
•	Composer for installing dependencies
•	PhpStorm IDE (First time used heard it’s good).
•	VMware to host deployment server in Ubuntu server 14.04.
•	Putty to interact with server.
•	Adminer web interface to MySQL server.
•	Visio for creating diagram
•	MySQL  5.5.43
•	MySQL workbench
•	Yii 2.0.4 (I had experience in Yii 1 point something while back took risk with Yii 2 at least could learn something new)
o	Database migration for version dB not used as accordingly as per time shortage.
o	Gii to scaffold CRUD code.
o	Yii 2-mpdf for pdf generation
o	Yii 2 swiftmailer for email.
o	Yii 2 html templating
o	Yii 2 widgets for grid page and detail page.
o	Http cache header to Cache static content. Yii even caches pages through files.
•	Bootstrap for boiler plate front end code.
•	JQuery although not used much



INSTALLATION
------------

Installation instructions:

1) vendor library is not provided so have to install through composer
	composer install
	or  composer update

2) Create symbolic link to to a folder in apache htdocs
	ln -s 'fullpath to source code web folder' 'fullpath to destination folder somewhere in htdocs/html/'  (NOTE apache 2.2 and above host files in html folder)

3) Update file config/db with respective db settings

4) Grate write access to runtime folder in root
	chmod 777 -R runtime/

5) Run migration by command ./yii migrate
	If it doesnt work grate it permission to execute i.e chmod 755 yii
	If migration failed you can always use the sql dump to provided to get the database.

6) Done just browse to the path

Assumption and Missing Requirement:

1) I did integrated yii2 swiftmailer briefly tests it i had no errors but didnt got any email in inbox post probability configuration issue.

2) Patient user could log in using his name (auto complete field). This weird requirement as why should patient be able to see other name in auto complete. Proper way would have been that 
email with url of patient login page should have been sent.


FeedBack:

1) Assignment duration is less and deliverables are more, keep in mind the quality required i think ample time needs to be given so that candidate can have time to 
spend time in planning and designing better solution.

~~~


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.

Also check and edit the other files in the `config/` directory to customize your application.
