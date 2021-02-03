## CodeLib Sample: Simple Http Client

### Description

This sample demonstrates how to use the Http Client to connect to an external API from within a CL Plugin in your App.
In this sample, you will find one Plugin called _HttpClientPlugin_, located in the _plugin_ folder of the App.
This Plugin is configured in index.php so that it is called when the default page is called.

The Plugin class receives the HttpClient via dependency injection, because the Plugin implements the CLInjectable interface, 
and specifies the httpclient as its required dependency.

#### Configuring the Http Client

The _CLHttpClient_ interface and its simple implementation: _CLSimpleHttpClient_, are known to the framework, and can 
easily be injected into any Plugin, as it happens in this one. 
However, in order to operate, _CLSimpleHttpClient_ delegates the actual network calls to one of two supported well known http 
libraries: _cUrl_ and _Guzzle_, depending on which one is available in your server or installed in your App.
Once your preferred library is installed, you add one configuration entry to let CL know which one to use. Notice how we do that 
in index.php:

**$config->addAppConfig('httpclient', 'curl');** // here we let CL know we are using cUrl. Instead we could have configured it like this:

                                             // $config->addAppConfig('httpclient', 'guzzle');

Once this is done, CL is ready to start serving your http client requests. Take a look at the run method of the Plugin to 
understand what we do there:

**$response = $this->httpclient->get(
(new \cl\web\CLBasicHttpClientRequest('https://openlibrary.org/subjects/programming.json?limit=25'))
->addHeader('Accept', 'application/json')
);**

Above, we use our client to make a get call to one specific open api: the openlibrary api, and we request a list of 25 titles 
related to programming.
If successful, the response will include a json payload, which we then parse, and generate our final output using part of 
the data received. Follow the Plugin code to see those additional details.

### Running this Sample

- Access this sample **index.php** file via your webserver
- If all goes well, you will receive a response with content similar to this:
  Number of books returned: 25
  Title: Software Engineering
  Author: Roger S. Pressman
  Author: Roger Pressman
  Title: Cloak and Dagger Net Force (Tom Clancy's Net Force #1)
  Author: Tom Clancy
  Author: Steve R. Pieczenik
  Title: Information systems literacy
  Author: Hossein Bidgoli
  Title: IBM PC Apprentice
  Author: Inc. Wordware Pub.
  Author: Leonard Paul Kubiak
  Title: IEEE standard for information technology
  Author: Institute of Electrical and Electronics Engineers.
  Author: IEEE
  Author: Institute of Electrical & Electronics En
  ...
  

