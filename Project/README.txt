Our project is implemented in PHP using the MySQL DBMS provided by the school. Namely, puccini.cs.lth.se.

The connection data is contained within the mysql_connect_data.inc.php file.

If the database needs to be reset to it's original state, it is simply to run the setupDB.sql file in the MySQL client.
For example, one issues the folowing command:

$ source setupDB.sql

This file removes the tables if they already exist and recreates them. After creating the tables some initial data is
inserted in all the tables. This data is of course consistent with the key constraints.

To test the client program one can start the PHP development web server from inside the phproot directory.
The following commands illustrates this:

$ cd phproot
$ php -S localhost:8080

This will start the web server on the current machine using port 8080. Thus it is simply to open any web browser and
browse to localhost:8080. From there it is possible to test our client program.

For directions to use the client program we refer to the user manual written in the report.