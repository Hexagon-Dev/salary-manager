# Salary Manager
This is CRUD system, it has permissions, roles, register, login, data validation.  
It uses JWT to authenticate.  
It has generated Swagger documentation available on `http://localhost/documentation`
## Installation
*  Make sure that you have docker installed.
*  Execute `docker-compose up`
*  Go to `http://localhost` and here you are.
## Permissions management
To create permissions run: `php artisan db:seed`  
It creates permissions called by table names and permissions called create, read, update, delete.  
Also, it creates 4 roles called: superadmin, admin, user and guest.  
Superadmin has all permissions. Guest has no permissions.  
For example to allow access to update skill table, give these permissions: 'update', 'skill'.
## Available permissions
*  create
*  read
*  update
*  delete
*  table_name
## Methods:
### Auth:
| Method | URI | Description |
|----------------|---------|----------------|
| **POST** | api/login | Get a JWT via given credentials. |
| **POST** | api/register | Register new user, responses with same data. |
### Tables:
| Method | URI | Description |
|----------------|---------|----------------|
| **GET** | api/table_name | Show entries |
| **POST** | api/table_name | Create new entry |
| **GET** | api/table_name/{variable} | Show certain entry |
| **PATCH** | api/table_name/{variable} | Update certain entry values |
| **DELETE** | api/table_name/{variable} | Remove certain entry |
