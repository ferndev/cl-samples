## CodeLib Sample: REDIS CONNECT

### Description

This sample shows how to easily connect to Redis from Codelib.

It requires a connection to a Redis server. If you do not have one, take a look at the <a href="https://redis.io/">Redis website</a>, 
for information about how to install and run Redis. One simple way, if you have Docker installed, is to launch a Redis Docker container, 
which you can do, for instance, like this: docker run -p 6379:6379 redis:alpine

Once Redis is running you can try the App, which is a simple contacts app. When the app loads in your web browser, you 
will see a form for you to enter one contact. Complete and press Save to submit the form, and your contact will be saved to Redis.
Add a few more contacts, and then press on the link shown below the form to View your contacts. You should see a list with your 
contacts, and their contacts details. 


#### Configuring the App to connect to your Redis Server

Take a look at index.php for this App. It is a conventional Codelib App, which should be familiar if you have taken a look 
at other Codelib samples.
The important line for us there is a simple one:

->setActiveClRepository(CLREDIS)

The above line tells Codelib to use the provided Redis repository as the Active repository for the App. If your Redis server 
is running in your local host, and using the conventional 6379 port, that line is all you might need. Otherwise, you can uncomment 
the line above that, which allows you to specify repository connection details.

Notice that behind the scenes, the Redis repo uses an existing open source library to handle Redis connections and commands:
Predis (see https://github.com/predis/predis).

The app has a composer.json file which already references predis as a dependency, so if you use composer install you will quickly 
have Predis installed for you. Alternatively you can manually add predis to the vendor folder of the App. Read more about 
Predis in the link above, for further installation information.

#### The Plugin

Take a look at the RedisConnPlugin in the plugin folder of the App so you understand how it works. Essentially:

- It is a simple REST server. Whenever the form is submitted, the **postData** method executes, and whenever there is a Get request, 
the **getData** method executes.
- The Redis repository is automatically injected to the Plugin by Codelib, so it is ready for use via the **activeRepo** field.
- Like any other Codelib repository (for instance MySql, Postgres, Mongodb, etc), entities are used to pass data around.
- So, the postData converts the request into an entity, and calls the create method of the repository, after successfully 
  establishing a connection.
- The repository stores the entity in Redis.  
- Notice that when the entity is prepared by the prepareEntity method of the Plugin, it also uses the entity to convey an 
additional request to the repository: the name of this entity must also be added to the usercontacts list. It does that by 
  adding this entry to the entity: $entity->setField('list', 'usercontacts');
- The above relates to the way Redis works: keys are evrything, values mean nothing (or almost nothing). So the keys must be 
used to create some sort of references or relationships. In this case, we store each contact in its own structure, but keep 
  a separate list with the contacts names.
- The **getData** method, uses the above logic to retrieve first the list of contacts (contacts names), and then the contact details 
  for each contact.
- Finally, notice how **getData** tells **Codelib** what page to use to display its response (the list). See the _pg2_ parameter passed to
  _prepareResponse_, inside that method.
  
#### The View

- If you go back to index.php, you can see that _pg2_ is the key for the 2nd Page we add: _$page2_. That page is defined towards the 
beginning of the file, and specifies setLookandFeel('listcontacts.php'). So, it is this _listcontacts.php_ the one responsible for 
  showing the list of contacts.
- Likewise _$page1_ sets is laf or look and feel as setLookandFeel('newcontact.php'). It is _newcontact.php_ the file which displays the 
contact form. Because _$page1_ is set as the default page for the app (->addElement('pg1',$page1, true)), we see the contact form when 
  we first go to the App home page, ie, index.php without any other parameter.

### Running this Sample

- Access this sample **index.php** file via your webserver. 
- If all goes well, you will see a header and below the header a contact form.
- Use the form to enter information about one of your contacts.
- Repeat this process a few times.
- Then press the link below the form to view your list of contacts.







