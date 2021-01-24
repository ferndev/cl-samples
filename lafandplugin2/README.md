## CodeLib Sample: LAF config - activating as array or folder from Plugin

### Description

This sample demonstrates in a simple way the following concepts:
- Look and feels can be defined as individual files, or a group of files.
- Look and feels can be stored in their own subfolder within the lookandfeel folder.
- When setting Look and feels, it is possible to specify only the folder name of the look and feel (if defined within a 
  subfolder of _lookandfeel_), or an array containing the list of files to load. If a folder name is specified, then that 
  folder should also contain a _config.php_ file that defines the look and feel.
- A look and feel can be set, or activated, by calling the _setLookandFeel_ function of a CL Page or other CL control, or by 
using a _laf_ variable in a Plugin.
  
#### Making sense of this sample

First look at the _index.php_ file of this sample:

Notice how it sets the look and feel of the page as: **$page1->setLookandFeel('red_laf')**
If you look in the sample you will realize that _red_laf_ is the name of a folder within the _lookandfeel_ folder of this sample.
If you look inside that folder, you will see a _config.php_ together with a few other files.

If you take a look at that config.php file, you will see that it simply retuns the following array:

##### return ['stylish.php', 'content.php', 'footer.php'];

This configuration informs the framework that in order to correctly set this look and feel, each of the files in the array 
must be loaded, in that order.

Notice that we also configure a Plugin to handle events or flows including the pattern: background.*, which would work for 
flows such as background/red or anything after background.

##### ->addPlugin('background.*', 'BgColorPlugin')

Now, take a look at the Plugin BgColorPlugin inside the plugin folder.

Notice in particular that this Plugin retuns a response with a laf variable, like this:

##### $this->pluginResponse->addVars(['laf' => $laf]); // in this way, the Plugin tells CL what look and feel to use

And, if you look above that line, you will see that the value of $laf, depends on certain conditions, and it can take the form 
of a string: _red_laf_, which we already know if the name of a look and feel folder, or it can be an array, which explicitly 
defines the files to be used by a look and feel.

### Running this Sample

- Access this sample via your webserver by pointing to the location, within your server, of index.php. 
- If all goes well, you will see a page with a yellow heading and a red content section below the header.
- That first time, the chosen lookandfeel is the one configured in index.php: red_laf, which makes the background red in 
  the content section, as the Plugin didn't execute.   
- Now add a query string so that the last part of the URL looks like: _index.php?clkey=background/blue_
- Because the flow is now background/blue, the Plugin executes, and it identifies its _$color_ variable as _blue_.  
- So, when the App renders its output, it will use the files within blue_laf as lookandfeel. (notice that this line sets 
  the folder name of the look and feel: **$lafFolder = strtolower($color).'_laf';**) 
- For blue and green, the Plugin specifies the $laf as an array (follow the code and confirm that, as an exercise).
- For red, the Plugin simply specifies the name of the folder, without any content, no array is passed. However, because 
  the red_laf folder has a config.php file, the framework is able to correctly load the lookandfeel. 
- Try changing the query string to index.php?clkey=background/green or index.php?clkey=background/red, and you will see 
  how the content section turns to those colors as an indication that the correct lookandfeel has been loaded.
- If you specify any other color, the default color set in the Plugin will be used.


  


