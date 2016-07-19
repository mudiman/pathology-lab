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
