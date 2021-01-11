## CodeLib Sample: Hello from Plugin

### Description

One of the main extension points offered by Code-lib in order to add functionality to an App is the creation of Plugins.
Plugins are simple to create and use, extend a specific, straightforward interface, and use certain conventions so that 
you can quickly start working on your App and not on the framework.
This sample illustrates how to create a simple Plugin for your Application to handle user requests.
Plugins, by convention are located in the **plugin** folder of your App, although it is possible to configure the App to 
use a different folder, like **controller** or **service**, or other, if so you prefer.
In this sample, you will find one Plugin called _HelloPlugin_, located in the _plugin_ folder of the App.
If you inspect this file, you will notice that: 

- the Plugin declares a class with the same name as its file name.
- the Plugin implements the **\cl\contract\CLPlugin** (instead, Plugins can extend the CLBasePlugin class, which already implements this interface, and provides other useful functionality. More about this in other samples)
- the Plugin receives a **CLServiceRequest** object which includes the request, session and other objects that the Plugin might need.
- the Plugin also receives a **CLResponse** object, which it will use to add the result of its own processing.

Other important information about Plugins, which you will see in other samples, includes the next few lines:
- plugins **should not echo or print** any information directly to the browser, pages and look and feels do that.
  Plugins, however, can direct their output to specific controls or specific fields within a page, and can indicate what 
  page to use to render the response.  
- plugins can receive other dependencies via **dependency injection**, using a mechanism provided by CL.
- plugins can receive **repositories** as dependencies, and in that way, communicate with data stores.

Once a Plugin is created, in order to use it, it must be added to the App instance, via the addPlugin method of the App. 
This is a simple example:

#### $app->addPlugin('user.*', 'UserPlugin');

The above code tells Code-lib or CL, to add the UserPlugin, and to use it to handle any user request. Examples of such 
requests would be: user/login, user/register, etc. 
These kind of **requests**, which trigger one or another functionality, **are passed to CL either as part of an URI**, **or 
via a special variable, which by default is called "clkey"** but is configurable. A clkey can be included as a hidden field 
in forms to indicate what "flow" should be activated to handle the submitted form.

### Running this Sample

- Access this sample **index.php** file via your webserver
- If all goes well, you will see one line of text: "Hello, World! I am a Plugin" produced by the Plugin.
- The page title, ie, <head><title>..., will also be set to: My Plugin Page Title

