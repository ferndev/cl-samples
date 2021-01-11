## CodeLib Sample: Hello from Plugin in sub Folder

### Description

This sample builds upon the **helloplugin sample**, so it would be best to first run and understand that sample.
As you have learnt CL Plugins provide a simple way to extend the framework, and easily create functionality for your App. 
This sample shows that CL Plugins can be declared as a single file directly in the plugin folder, or they can be created 
within a subfolder with the same name as the Plugin. This sub folder would be directly located inside the plugin folder.

In this sample you will also learn how a Plugin can use dependency injection to inject a dependency. 

#### Understanding the source code

First take a look at index.php. You will see 2 Plugins added to the App in this way:

**->addPlugin('page', 'HelloPlugin', 'run', null)** // this Plugin will always be called first

**->addPlugin('page', 'OtherPlugin', 'run', null)**

Both Plugins are added to the page flow, which is also the flow used by the default page, so they will run when index.php 
executes without any parameters.

##### Plugins location

You will find **OtherPlugin.php** directly in the plugin folder, while **HelloPlugin** is located inside 
**plugin/helloplugin/HelloPlugin.php**.

So, you can create your Plugins directly in the plugin folder or within their own folder relative to the plugin folder.

The convention is, **if you create a Plugin in its own folder, this folder should have the same name as the Plugin, but 
in lowercase letters**.

##### Dependency Injection

Notice how each of these Plugins implements a 2nd interface: **CLInjectable**. This interface contains one single method, and 
indicates to CL that it needs one or more dependencies to be injected.
The method provided by this interface is **dependsOn()**, which you can see implemented at the bottom of each Plugin.
It returns an array of **CLDependency** objects, one per required dependency.

Notice how each of these Plugins require one and the same dependency: **pluginDependency**. 
Notice too, that **HelloPlugin** indicates the key or name of this dependency, as well as its class to put it in context for 
the framework.
After that, CL already knows about this dependency, so the second Plugin: **OtherPlugin**, only needs to specify the dependency key.

_Dependencies that are known to CL can be requested by key. Certain dependencies, such as specific repositories, active 
repository, email library, and other, are always known to CL._


### Running this Sample

- Access this sample **index.php** file via your webserver
- You should see output displayed in the browser, coming from each of the 2 configured Plugins.


