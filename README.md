## Overview

[ThemeStripe](http://themestripe.com) SimeLine theme.

## Installation ##

- Clone source code from the git repository.
- Navigate to the working folder that has been cloned, run `php composer install` to download dependencies.
- Import **mysqldump.sql.gz** from the **_extras/** directory to your database.
- Chage the value of RewriteBase rule in .htaccess file to match with your site configuration.
- Open **your_site/install.php** in the web browser and follow the installation. 


## FAQs ##

Q: I installed but could not see sample data on the site?
A: Clean your database, import **mysqldump.sql.gz** again then run `dev/build?flush=all`

Q: I re-imported database, but I could not login to CMS?
A: Try to login with following information:

- Username: admin@themestripe.com
- Password: Admin123
