## CodeLib Sample: SIMPLER REST

### Description

This sample illustrates another, simpler, way to create a REST server in CodeLib. It also shows how to create inline Plugins.

#### REST Support

In a previous sample: CORS and REST (cl-samples/cors-rest/), we saw a simple to implement REST client and server.
In this sample we learn that CodeLib provides an abstract REST server, which you can easily extend in your own Plugin, and 
just implement 4 provided abstract methods which match the post, put, get and delete http methods.
So, depending on what http method your request uses, one of your 4 implemented methods will be called.

#### Inline Plugin

In all previous samples, you could see that CL Plugins are classes implemented in files with the same name as the class, 
and stored within the plugin folder of your App.
While that is the recommended and best way to define your Plugins, in this sample, we show you how you can create your 
Plugin class on the fly, while adding the Plugin to your App, in index.php.

Open index.php for this App, and search for ->addPlugin. You will see how we add a Plugin to handle the 'rest.*' flow or route, 
but instead of adding a Plugin name, we actually define the Plugin class there.

In this case, our Plugin class extends \cl\plugin\CLRestPlugin and all we have to do is to provide an implementation for 
each of the 4 abstract methods defined in that base class.

Plugins defined in an inline way, require an init method. If your Plugin extends CLBasePlugin or any Plugin provided by 
Code-lib, the init method is already created for you. If you are only implementing the CLPlugin interface, then you must 
manually add the init method for the inline or anonymous way to work.

### Running this Sample

- Access this sample **index.php/rest/** file via your webserver. Notice the /rest/ after index.php. This is to trigger the 
  execution of the REST Plugin for this get request.
- If all goes well, you will see a page with some information, including a one line response, above an horizontal line.
- You will also see an empty form which upon submission will test a post request to our simple REST server.
- The server will also log, in the logs folder of the App, what kind of request it receives.






