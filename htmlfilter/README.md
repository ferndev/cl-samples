## CodeLib Sample: Using the Html Filter

### Description

This sample demonstrates the following CL concepts:
- Using the CL Html Filter to convert special chars (such as ", or <) to entities and/or to remove html and php tags 
  included in either a request (for instance in certain fields in a post) or in a response.
- The alternative App configuration (via settings.php) shown in a previous sample is used here as well.
- We create, programmatically, an empty configuration, which will be automatically filled with the external settings/settings.php.
- We create a DEV deployment, and because of that, our Logging is automatically set to debug, so we will see a debug file 
  entry in the logs folder.
- When our DEV deployment is added to the App, so is our initially empty config, which was added to the deployment.

### Running this Sample

- Access this sample **index.php** file via your webserver
- If all goes well, you will see a form for you to enter some data. Try entering some html tags and special characters.
- If you submit the form, you should receive as feedback the filtered version of your input data.
- Initially, both, FILTER_SPECIAL_CHARS (which converts special chars to html entities) and FILTER_REMOVE_TAGS 
  (which removes html and PHP tags) are set to true, so you should see any tag, such as <mytag> removed, and double 
  quotes (") converted to &quot;
- Try switching one, or the other off, by setting the value to false in settings.php.   


