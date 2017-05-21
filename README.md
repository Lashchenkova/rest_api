# REST API phone_book (php, jquery)

1.	Import sql dump (*phone_book*) with one table "users". Host name, username, password and db name are in *api/lib/Database.php*.
2.	Entry *index.html*.

Directory Lib has classes:

**Database** – connection to db (singleton).
 
**API** – url validation, rest.
 
**Users** – CRUD for users_table with methods:
 
* find – 

      GET /api/users/ - return all users
         
      GET /api/users/search/JohnDoe - search by name,
* update – 

      PUT /api/users/13 - update user by id, 
* delete – 

      DELETE /api/users/13 - delete user by id, 
* add – 

      POST /api/users - create new user, 
