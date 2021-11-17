# Salary Manager
## Methods:
### Auth:
| Method | URI | Description |
|----------------|---------|----------------|
| **POST** | api/auth/login | Get a JWT via given credentials. |
| **POST** | api/auth/logout | Log the user out (Invalidate the token). |
| **POST** | api/auth/me | Get the authenticated User. |
| **POST** | api/auth/refresh | Refresh a token. |
### Tables:
| Method | URI | Description |
|----------------|---------|----------------|
| **GET** | api/table_name | Show entries |
| **POST** | api/table_name | Create new entry |
| **GET** | api/table_name/{user} | Show certain entry |
| **PUT** | api/table_name/{user} | Update certain entry values |
| **DELETE** | api/table_name/{user} | Remove certain entry |
