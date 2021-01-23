## CodeLib Sample: LAF and Plugin

### Description

The purpose of this sample is to demonstrate how to use a **look and feel (LAF)** on a CL App, and to have variables, created by a 
Plugin, displayed when the look and feel is rendered. A LAF consists of one or more php files with your html code, links to 
your CSS and Javascript files, etc. A LAF can also contain specific PHP variables, which will have their value updated when the App 
runs. 
**Look and feels must be installed in the lookandfeel/html folder of the App**. If the LAF depends on other files, 
such as CSS or JS files, those can be added in subfolders of lookandfeel such as lookandfeel/css and lookandfeel/js, or another convenient location 
within your App. Take a look, for instance, at 'stylish.php' within the lookandfeel folder of this app.

You install a look and feel by creating a page programmatically (new CLHtmlPage), and adding the LAF to it using its 
**setLookandFeel** method.

You can see this in the _index.php_ file of this sample:

##### $page1 = new CLHtmlPage(null, '');
##### $page1->setLookandFeel('stylish.php') // the extension is optional, it is fine like this too: 
##### $page1->setLookandFeel('stylish')     // but a default .php extension will be added by CL in this case. If you do not want that to happen pass null as  a 2nd parameter to this method

If the look and feel you wish to add contains more than one file, for instance, because you want to load a header, content, and 
footer file, you can pass an array with the names of those files to the **setLookandFeel** method, and each look and feel file 
will be loaded in that order.
Lastly, you can choose to instead pass the name of a folder (relative to the _lookandfeel_ folder of your App). If you pass the 
name of a folder, then CL will expect to find a _config.php_ file within that folder. The config.php file must contain an array 
with the names of the files in your look and feel (like in the previous option, when you pass an array to the method). 

Another variant, is to add child controls to this page, and add a look and feel, if you wish, to each control too. That is 
another way of creating a composite html page.

Notice how, in this sample, $page1 gets a child control added to it, with its own LAF, and how a variable (cltitle) is 
also added to the child control, like this:

**->addElement((new CLHtmlCtrl(''))->setLookandFeel('about.php')->setVars(<br>
                    array('cltitle' => 'Code-lib and Stylish Portfolio work well together :-)'))
); // closing parenthesis for addElement**

Later on, the page is added to our App using the **addElement** method of the App. 
The App itself is also created programmatically:

**$app = new CLHtmlApp();**

A Plugin is also added to the App and linked to the Application event: _CLHtmlApp::BEFORE_RENDER_, which always executes 
before a page is rendered. So, this Plugin will always execute:

#### $app->addPlugin(CLHtmlApp::BEFORE_RENDER, 'SimplePlugin');

The added Plugin is truly very simple, as all it does is to add variables to its response. In the Plugin source code, 
take a look at the line containing:

##### $this->pluginResponse->addVars(...

Because the Plugin overrides variables that were initially set to a different value in index.php, when you execute the 
App, the value set by the Plugin will be the value displayed in the look and feel.

_Plugins are also able to change the current page (the page that would be used to render the response), as well as the look and feel 
of the current page._
In order to do that, _Plugins_ can include a _page_ var, or a _laf_ var in their response.

For instance, a _Plugin_ could do the following to reset the look and feel of the current page (without having to know what 
that page is) so that it uses the files defined in the array:

**$this->pluginResponse->addVars(['laf' => ['startBootstrapTheme.php', $laf, 'footer.php']]);**

### Running this Sample

- Access this sample **index.php** file via your webserver
- If all goes well, you will see a page with a nice look and feel, as well as a heading: "Page title replaced by Plugin".
  That heading was set by the Plugin.
- Scroll down and you should see the second value set by the Plugin: "SimplePlugin says: Codelib works nicely with the 
  Stylish portfolio Bootstrap template".
  That 2nd value updates a variable in about.php, which was set in index.php, as the LAF of the child control added 
  to the page. 
- So, when the App renders its output, it sends to the browser, both, the content of stylish.php and about.php, with 
  variables updated.  

