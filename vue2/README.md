## CodeLib Sample: Simple Vue App with CL Backend - User registration, Login and Dashboard

### Description

This sample illustrates the following CL concepts:
- How you can easily create applications using VueJs for the frontend and Code-lib for the backend.
The App is defined in the usual CL way, while the entry point into Vue is defined as the look and feel (LAF) for the App.
- How to connect to a CL MySql repository from a CL Plugin.
- How to easily extend Plugins from another Plugin and chain their execution, so you can reuse or enhance your code.

#### Backend

Take a look at index.php. It is a regular CL App, with a custom look and feel, which happens to be the entry point into 
a Vue App. Notice that this is not a VueJs App created in the usual Node JS way, it is created only using plain html, 
javascript, and the CL framework. But of course, you can connect a CL backend, or a set of CL services, to any frontend, 
including a Node Js based Vue App, a frontend created with any hybrid mobile framework, or a true native 
mobile application. 

The App makes use of a Plugin called **UserPlugin**, which, as you will see, extends a CL provided Plugin: **CLUserPlugin**.
The UserPlugin is configured to handle user related events, such as _user/login_, etc, via the _'user.*'_ flow key.

##### Configuring the MySql Store

In order to run successfully, this sample needs to connect to a MySql database. This is what is needed to achieve that:
- Step 1 is to (manually for now) create the required db and user table, using the provided _user.sql_ script (find it 
  in the root of this sample). If successful, you should now have a _database_ with an _user_ table.
- Update the **setRepoConnDetails** function call, in _index.php_, with the correct _server, user, password and db name_, for 
  your installation.  

CL uses repositories as the interface between a data store, which is where your data is kept, and the framework, or more
specifically, CL Plugins. A CL repository must implement one of the 2 interfaces provided by CL to connect to stores: the
\cl\contract\CLRepository for SQL and No SQL databases, and the \cl\contract\CLCacheRepository in order to connect to a
Cache.
Take a look at the repository provided by the framework to connect to MySql (cl\store\mysql\CLMySqlRepository), as well
as the cl\store\cache\CLMemCacheRepository repository provided to connect to Memcache(d), for examples of implementation.

##### Connecting to MySql

The UserPlugin in this sample, delegates its user handling tasks to the **CLUserPlugin**. Let's see how this CL provided 
Plugin, is able to connect to MySql. Find this parent Plugin in the _cl\plugin_ folder of the _CL Framework_, and look at its 
source code.
Notice the **$activeRepo** private variable, and the fact that this plugin implements the **CLInjectable** interface.
So, this Plugin informs CL that it requires the currently active repository, which for this sample happens to be the 
MySql repository. However, notice that the Plugin is unaware of which one is the active one, and it doesn't care. 
The framework then, will use the Plugin's **setActiveRepo** function to inject the active repository.
Assuming that the repo was successfully injected, you can now look at the _register_ and _login_ methods to understand how 
the repo is used to connect to a MySql db.
Specifically look at how the first call is to **connect** to the store, and if successful, other functions such as **count**, 
**create**, and **read** will be used to count, save or retrieve data.
Notice that the repository passes around data, bidirectionally, in the form of _entities_. An **Entity** then _represents an 
object that can be stored and retrieved from a store via a repository interface_.
Because this Plugin extends the **\cl\plugin\CLBasePlugin**, instead of directly implementing the **CLPlugin** interface, 
it can make use of functions provided by its base class, such as requestToEntity (called inside the requestToUserEntity 
function), to easily populate an Entity from the submitted Request.

##### Plugin call chain

Notice how easy it is to achieve a call chain between the parent and child Plugin, on one hand because of inheritance, 
but also because Plugins do not send output to the browser but instead return a CLResponse object. Look at this line in 
the UserPlugin source code:

$response = parent::run($this->pluginResponse);

with just the above line we trigger the execution of the parent functionality, and we collect whatever it had to offer 
as response to the user request in the $response object.
We can now check any value there, and make our Plugin behave in one way or another depending on the results of the 
previous Plugin execution.

#### Frontend

The Frontend is a _Vue_ App in plain html, javascript, and with CL style php in the backend. For instance, the entry point 
into the frontend is via **$app->setLookandFeel('vue')**; in _index.php_.

So, when the App runs first time, and the response is sent to the browser, it is the Vue App code what will be sent. 
Take a look at **lookandfeel/html/vue.php** so you can understand how it works. It is very much a regular html page, with 
custom html tags, such as v-app, v-content, v-container, etc, because the sample takes advantage of the _Vuetify_ library. 
Take a look at _https://v15.vuetifyjs.com/en/components/_ for more information about Vuetify components.

In the header of the html page you can see included stylesheets, and at the bottom, several javascript files are included 
in order to provide the required functionality. Among those are js files for _VueJs_, _Vuetify_, related VueJs libraries, and 
the last 7 are files specific to our sample.

The last included file, **app.js**, is the one that creates our Vue App, the Vue store to manage our state (variables we 
maintain and pass around), and a function to communicate with the backend.

Next take a look at **router.js**, which creates the routes for our Vue frontend. Because the root route ('/') points to our 
**Login** component, this will be the component displayed when the App runs, ie, when you go to index.php via the browser.

Next take a look at our **Login** and **Register** components, which are responsible for the login and registration form, 
submitting the form, and handling the response.

While there, take a look at the **submit**() method, and notice how we indicate there the CL flow that our form is aimed at, 
with index.php/user/register and index.php/user/login.  

As you can see, with just a bit of explanation, it all becomes very straightforward.

### Running this Sample

- Create the database needed for this sample.
- Update index.php with the db connection details as explained above.
- Access this sample index.php file via your webserver
- You should see a Login screen. Press on the Register link, at the bottom of the Login screen, to create a new account.
- After successful registration, try to login using the Login screen.
- If Login is successful you should see a simple Dashboard with a welcome message and a simple data report.
- Build on that if you want to :-)

_Notice that all our samples can be used and modified in any way, for personal or commercial use, whether your project is 
open source or not_.






