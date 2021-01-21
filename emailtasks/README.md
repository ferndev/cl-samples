## CodeLib Sample: Email Service

### Description

This sample demonstrates the following CL concepts:
- Configuring 3rd party email libraries
- Using the emailService to send emails from a Plugin
- Using Code-lib via composer
- Unit testing a Cl Plugin  
  (This readme is shorter than usual so far, but together with comments in the sample, you can make sense of the concepts 
  listed above)


#### Configuring 3rd party libraries

3rd party libraries are added to the vendor folder of your CL App. You can do that via composer, as in this sample, or 
you can directly add them there, and CL should be able to find your library classes.
Look at the composer.json file of this sample and notice how 4 libraries are included there.

After installing composer in your computer, if not already installed, you can then run:

composer install to let composer download and install your dependencies in the vendor folder for you.

#### Emailing with the email service

First notice that we have added 2 well known 3rd party email libraries to this sample.
We can activate one or the other by choosing the desired one in our configuration. Look in index.php for the following line:

**->setEmailConfig([EMAIL_LIB => 'phpmailer', MAIL_HOST => 'localhost'])**

Above, we are configuring phpmailer as our email library.


#### Using Code-lib via composer

This is as simple as adding Code-lib as a dependency to your composer.json, as in this sample, and then defining CL_DIR in 
your index.php to point to the Code-lib library that will be inside the vendor folder once you run composer install.
See index.php of this sample. Notice in particular this line:

**define('CL_DIR', BASE_DIR.'/vendor/ferndev/codelib/src'.DIRECTORY_SEPARATOR);**

#### Unit testing a Cl Plugin

- First, notice that among the libraries added to composer.json, we included PHPUnit.
- Then, take a look at test/MailTaskPluginTest.php in this sample. 
- Notice that setUp defines constants, prepares data required by the Plugin, and gets an instance of the Plugin class.
- It uses a CL Test Helper class to make this easy.

### Running this Sample

- Access this sample **index.php** file via your webserver
- If all goes well, you will see a form for you to enter a few tasks to be emailed to a list of fictitious assignees.
- For emails to actually be sent you will have to make the adminEmail in index.php a real email address, as well as the 
recipients emails in plugin/AssignedUsers.php


