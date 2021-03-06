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

- run composer install to get your dependencies in place. You should get CL and Guzzle installed in your vendor folder.
- Access this sample **index.php** file via your webserver
- If all goes well, you will receive a response with content similar to this:

  Number of books returned: 25<br>
  Title: Software Engineering<br>
  Author: Roger S. Pressman<br>
  Author: Roger Pressman<br>
  Title: Cloak and Dagger Net Force (Tom Clancy's Net Force #1)<br>
  Author: Tom Clancy<br>
  Author: Steve R. Pieczenik<br>
  Title: Information systems literacy<br>
  Author: Hossein Bidgoli<br>
  Title: IBM PC Apprentice<br>
  Author: Inc. Wordware Pub.<br>
  Author: Leonard Paul Kubiak<br>
  Title: IEEE standard for information technology<br>
  Author: Institute of Electrical and Electronics Engineers.<br>
  Author: IEEE<br>
  Author: Institute of Electrical &amp; Electronics En<br>
  
- Initially the App was configured to use cUrl as underlying or delegating httpclient
- You can try then changing the http client to use Guzzle instead, and then reload the App.
- You should still get the same result.

Remember that in order to switch to Guzzle as the client, all you need to do is change this line in index.php:<br>
_$config->addAppConfig('httpclient', 'curl')_ so it reads as follows:<br>
_$config->addAppConfig('httpclient', 'guzzle')_<br>
  

