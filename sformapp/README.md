## CodeLib Sample: Forms and Plugins

### Description

This sample demonstrates the following CL concepts:
- A CL App can be created purely programmatically
- Several Plugins can execute as part of the same CL flow (same user request)
- Plugins do not send output directly to the browser, but they can indicate what page (view) should be used for their
  response.
- An App can be configured in the way shown in other samples, or in the more traditional way of having a dedicated 
  config file with one or more array to store configuration settings.


#### Processing a Flow or user request with more than one Plugin

Take a look at the source code of index.php in this sample.
Notice the following 2 lines there:

**$app->addPlugin('*.*', 'WelcomePlugin')
     ->addPlugin('pg1', 'HappyTooPlugin')**

Those lines configure 2 Plugins for our App. One should execute with every request ('*.*'), while the other when the 'pg1' 
flow executes. Because that is the flow for the default page (see **->addElement('pg1', $page, true)**), it will execute 
when we run index.php in the browser.
So, whenever we open index.php in the browser, that request will result on each of our Plugins being called in the order 
they have been added to the App. The WelcomePlugin executes first, and adds a variable to the response. HappyTooPlugin 
executes next, receives the response from the previous Plugin execution, and adds its own contribution to the same 
variable (same key: 'span.value'). To avoid overriding its current value, it sets the last parameter of setVar (append) 
to true.

Notice in index.php, that we add a CLHtmlSpan (which translates to <span>) to each of our pages. By setting the key as 
'span.value', we tell the framework that this variable is aimed at that specific span.

#### Plugins can, in a simple way, set the correct page or view to output their response

Although Plugins do not send any output directly to the browser, they can indicate or override what page should be used 
to display their response. It is done simply by adding a 'page' variable or key to their reponse, with the declared page 
key as their value. To make this clearer, take a look at the following line in WelcomePlugin:

_$response->addVars(['span.value' => 'WelcomePlugin says: Welcome, '.$clrequest['userdata'].', I grant you access to the Welcoming Page! :-)', 'page' => 'pg2']);_

**addVars** allows you to add more than one variable to the response in a single step. To do that pass an associative array 
as parameter, in which each key represents a variable name, and the value is of course, the variable's value.
Notice how we set 'page' => 'pg2'. If you check in index.php, you will see that 'pg2' is the key we assigned to $page2.

#### Different ways of writing your App configuration

In previous samples you might have seen how usually we specify an App's configuration like this:
**$clconfig = new CLConfig();**
then adding specific configuration entries using the addAppConfig function
**$clconfig->addAppConfig(CSRFSTATUS, false)**

and finally adding the configuration to the App with ->setAppConfig($clconfig), or alternatively, adding the 
configuration to a deployment, and the deployment to the App:
**$app->setDeployment(new CLDeployment(CLDeployment::DEV, $clconfig), true)**

_When no configuration is added at all, a default CLConfig is automatically added to the App_.

In this sample we show you something else you can do, together with any of the above approaches, or instead of them:
If you create a _settings.php_ file inside a _settings_ folder under your App's root folder, the configuration entries 
defined there will be loaded and added to the App's CLConfig instance.
Configuration entries within this settings.php file must be added either to a **$settings** array or to a **$repositories** array, 
depending on whether you are configuring general App settings or one or more repositories.

Take a look at the **settings/settings.php** file of this sample for a concrete example.
You can confirm that they get loaded even if no configuration has been added to the App, like in this sample, by simply 
playing around with the settings.
For instance, try switching the _CSRFSTATUS_ between true and false, and each time refresh the page (index.php) in the browser.
Open _Developer Tools_ -> _Elements_ in Chrome, Edge or similar browser, or _Web Developer_ -> _Inspector_ in Mozilla Firefox, 
and expand the html for _index.php_
Whenever you run it with _CSRFSTATUS_ set to true, you should see the following field added to the form:
**<input name="cl_xsrf_id" value="igucASsSlw55WQF" type="hidden" class="clhtmlinput">**
The same field should disappear from the form if you switch off the CSRFSTATUS setting.

### Running this Sample

- Access this sample **index.php** file via your webserver
- If all goes well, you will see a welcoming message and a form for you to enter your name.
- If you enter a name and submit the form, you should receive a different welcoming message from each Plugin.


