## CodeLib Sample: CORS AND REST

### Description

This sample illustrates how you can easily provide CORS support in CodeLib. It also shows how simple it is in CL to put 
together a REST server.

##### CORS Support

CORS support can be as easy as adding a configuration entry to activate CORS support:

##### $clconfig->addAppConfig(CORS, true)

If nothing else is specified, the CORS check will happen, but it will be very permissive, as the default configuration will be used, which allows 
all origins, all headers and all methods.

In order to restrict the above, for let's say a specific Origin, you can specify that Origin in the CORS config setting as below:

##### $clconfig->setCors(['Access-Control-Allow-Origin' => ['http://example.com']])

Take a look at index.php in this sample to see this in action.

##### REST Server

In index.php you can see this line:

**->addPlugin('rest.*', 'RestPlugin')**

It adds the **RestPlugin** to the app, to handle any _URI_ or _flow key_ with 'rest' on it, like _rest/users_, _rest/user/1_, etc. This Plugin, 
which you can find in the plugin folder of the App, is a regular CL Plugin, with some minor additions:

- It extends **\cl\plugin\CLBasePlugin**, instead of directly implementing the **CLPlugin** interface.
- It then takes advantage of additional functionality provided by the CLBasePlugin, including mapping of http methods to 
Plugin functions. Notice that to achieve that, all that is required is to **override** the _protected function **mapHttpMethod()** : array_, 
  and return an associative array, with the http method as key and the Plugin function as value. That's it!

### Running this Sample

For the purpose of demonstrating this concept, this sample has been divided into a REST client and server.
The client is started as a local server running on port 8000 (using the provided startclient script), and it contains a form1.php file, 
which submits AJAX requests to the server (running on port 8087, and started using the provided startserver script).

You will see that if you run this sample, by going in your browser to http://localhost:8000/cl-samples/corstest/client/form1.php (or equivalent, 
depending on your installation of the samples), the CORS preflight mechanism will fail due to the request comming from a different origin.
You can easily make it succeed by simply changing the port in server/index.php:

In the line that reads: _**->setCors(['Access-Control-Allow-Origin' => ['http://localhost:8087']])**_

change the port from **8087** to **8000**. 
Alternatively, change the entry to allow all origins:
**->setCors(['Access-Control-Allow-Origin' => ['*']])**

Then run the client request again.

Once it gets past the CORS check, you should see form1.php displayed, which only shows one link to submit a GET request, 
and 2 buttons, one for a POST and one for a PUT request. Each of them will submit requests to the RestPlugin.

To view any response, you must look at the browser's console, as form1.php does not display any html response.
You should be able to see the JSON response logged to the console.






