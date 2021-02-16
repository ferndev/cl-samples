## CodeLib Sample: Database Migrations

### Description

This sample demonstrates:
- How to use the **Schema Migrations** functionality provided by Code-lib.<br>
Other unrelated features shown in this sample include:<br>
- Changing the default flow key or route key, which defaults to 'clkey'. In this sample it is set to 'timeline' (see index.php).
- Configuring Plugins to respond not only to a specific flow or route, but to a specific http method as well.

#### Schema Migration

As your application evolves, it is likely you will make changes to your database schema to accommodate changes in 
requirements or improvements. On occasions, you might want to rollback to a previous version. If a team is working on a 
project, each team member must have the correct version of the schema and code in their local environment as well. Schema migration 
helps with all of that.

**Codelib** offers its own unique way of managing schema migration, and this sample serves the purpose of illustrating how it works.
Let's start with some relevant conventions and definitions:
- All data related to schema migration must be in the _schema_ folder of your App.
- A migration consists of a migration definition file, stored in the schema folder, which is a _json_ file with extension _.cl_, 
as well as one or more _.sql_ files with the actual queries to create or modify your database tables.
- There is a convention to follow when naming migration definition files: migration.<version>.cl, where <version> is a number 
  according to the migration version the particular file represents. For instance: migration.1.cl for the first migration, 
  migration.2.cl for the 2nd migration, etc.
- A migration is executed by Codelib's MigrationTool. This tool can be started, while in development mode only, using a specific URL.
You can specify which migration to run, or you can let the tool decide.
- Apart from .sql migration files, you can include a reverse.sql file with the statements to reverse the migration, if necessary.
If reversing requires several files, then you can instead list them in the migration definition file.

Let's take a look at the sample to make sense of the above details
This sample provides a simple user interface to type an Article. The article, once submitted, gets stored on a MySql database.
That is basically it, no other fancy functionality, but it is enough to illustrate the need for schema migration.
The App shows 3 phases in the evolution of the App, which is supposed to represent simple changes in requirements, and their 
impact on the way data is stored. So, in real life there would be one user interface (form), and one Plugin to receive and 
store the data, which would change as time passes. Here, those changes along time, are represented as separate interfaces and Plugins.

_Phase 1:_ A simple interface allows the user to enter a title, description, and article content. There is a Phase1Plugin, which 
receives the Article and knows how to store it.

_Phase 2:_ In this phase, it is decided that just storing the article is not enough. The publication date is now also required.
So, a **pubdate** field is added to the user interface, so the person entering the article can add when the article was first published.
That change must be matched with a change of the schema, so that the publication date can be persisted.

_Phase 3:_ It is decided that the **pubdate** field should rather be called **datepublished**, and that a field for the original **author**'s name 
should be added. These changes also impact both, the user interface and the database schema.

### Running this Sample

- Open index.php and update **CL_DIR** to the location of Codelib in your computer, either its absolute location, or its location
  relative to your App's folder.
- Also in index.php, update the **setRepoConnDetails** with the correct db connection details for your MySql installation.  
- Access this sample **index.php** file via your webserver

When you run the App for the first time, and submit the form with some content on it, it will fail with an error, as the 
database has not been created yet. At this point, you need to run the first migration.

You can **run the first migration** by accessing this App in your web browser, but **instead of just index.php**, go to 
**index.php?timeline=tooling/migrate**

tooling/migrate triggers the execution of the CL Migration Tool. When the tool runs the first time, it detects that no migration 
has run yet, so it runs the first migration. Look at the schema folder of this sample, you will see 3 migration definitions, 
with extension **.cl**, one for each of the required migrations (as described before), as well as 3 folders: phase1, phase2 
and phase3, each containing the actual .sql to run for the specific migration to complete.

A CL migration definition is just a json file with details regarding the migration, including the database name, whether to 
create the db or not, the path (relative to the schema folder), to the files for the specific migration, the list of files to 
migrate, optionally, the db connection details, among other fields.
Look at any of the .cl files in this sample to familiarize yourself with them.

The first migration, migration.1.cl, creates the database and the article table, whereas the other 2 migrations just make changes 
to the article table.

After you run each migration, look at the database server using phpmyadmin or other tool, to confirm that the database, and 
the table have been created, and the appropriate changes are reflected.
Once all the migrations have run, try reversing the last ran migration by triggering the tool with:
**index.php?timeline=tooling/migrate/reverse**
Confirm looking at the database that it has been reversed back to the previous migration.








