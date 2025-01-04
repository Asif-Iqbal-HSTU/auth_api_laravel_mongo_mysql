# User Auth API project with Laravel, MySQL and MongoDB.

## About Project

API to create user with credentials and profile data. And to login with credentials and introducing JWT token.


## Prerequisites
Make sure `mongo-php-driver` is set.  

If not, go to [this link](https://github.com/mongodb/mongo-php-driver/releases) and download Asset according to your PHP version and your PC's configuration.   

For example, if your PC is 64 bit and you are using PHP version 8.3 non-thread-safe, then you can download `php_mongodb-1.20.1-8.3-nts-vs16-x64_86.zip`. Then extract it and copy the `php_mongodb.dll` file and paste it to your PC's `php\ext` folder.  

And on the `php.ini`, please make sure if `extension=php_mongodb.dll` is added or not. If not, please include it first.

## Project Cloning

```bash
$ git clone https://github.com/Asif-Iqbal-HSTU/auth_api_laravel_mongo_mysql.git
```

## Install Packages

```bash
# Go to Directory
$ cd auth_api_laravel_mongo_mysql

# installing dependencies
$ composer install

# installing dependencies 
$ npm install
```

## JWT Package

```bash
# Publish Vendor
$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

# Secret key Generate
$ php artisan jwt:secret
```

## Set Up Database Connections:

```bash
# copy .env on windows
$ copy .env.example .env

# copy .env on Linux
$ cp .env.example .env

# Generate key
$ php artisan key:generate

# MySQL Configuration on .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

DB_CONNECTION_MONGODB=mongodb
DB_URI=mongodb://localhost:27017

# Run migrations
$ php artisan migrate
```

## Update `config/database.php`
Add the following lines to configure MongoDB: under 'connections' add the 'mongodb' configuration
```bash

'connections' => [
    'mongodb' => [
        'driver' => 'mongodb',
        'dsn' => env('DB_URI'),
        'database' => 'user_auth_system',
    ],
],
```

## Update `config/auth.php`
Check the config/auth.php file to ensure the driver for the api guard is set to jwt:
```bash
'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

## Run the server

```bash
# Run Server
$ php artisan serve
```

## API Endpoint

Here are two api endpoints '/api/create-user' and '/api/login'.   
For both API, the Headers should include:
```bash
{
  "Content-Type": "application/json",
  "Accept": "application/json"
}
```

### **Create User**
Creates a new user and stores data in MySQL and MongoDB.   
Go to Postman and set "POST" route method.

```bash
# POST API
http://127.0.0.1:8000/api/create-user
```


#### Demo data
Use the following JSON to test the API.

```bash
{
  "username": "testuser",
  "role": "admin",
  "password": "password123",
  "profile": {
    "name": "John Doe",
    "email": "johndoe@example.com",
    "address": "123 Main Street, City, Country"
  }
}
```

#### Expected Response (Success)
If everything is configured correctly, you should receive a response similar to this:

```bash
{
  "success": true,
  "message": "User created successfully",
  "user_id": 1
}
```

#### Possible Error Responses
1. Validation Error:

```bash
{
  "message": "The given data was invalid.",
  "errors": {
    "username": ["The username has already been taken."]
  }
}

```

2. Database Connection Error:

```bash
{
  "message": "The given data was invalid.",
  "errors": {
    "username": ["The username has already been taken."]
  }
}

```
---
### **Login**
Checks Username and password. Authenticates if the credentials are matched. It also introduces a JWT token.  
Go to Postman and set "POST" route method.

```bash
# POST API
http://127.0.0.1:8000/api/login
```


#### Demo data
Use the following JSON to test the API.

```bash
{
  "username": "testuser",
  "password": "password123"
}

```

#### Expected Response (Success)
If everything is configured correctly, you should receive a response similar to this:

```bash
{
  "success": true,
  "message": "Login successful",
  "data": {
    "id": 1,
    "username": "testuser",
    "role": "admin",
    "profile": {
      "name": "John Doe",
      "email": "johndoe@example.com",
      "address": "123 Main Street, City, Country"
    }
  },
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}

```

#### **Possible Error Responses**
1. Invalid Username:

```bash
{
  "success": false,
  "message": "Invalid username or password"
}

```

2. Invalid Password:

```bash
{
  "success": false,
  "message": "Invalid username or password"
}
```

3. Validation Error:

```bash
{
  "message": "The given data was invalid.",
  "errors": {
    "username": ["The username field is required."],
    "password": ["The password field is required."]
  }
}

```

4. JWT Token Generation Error

```bash
{
  "success": false,
  "message": "Could not generate token"
}

```


---

### **Testing**
- **Verify `/api/create-user`**:
  - Ensure a new user is created in MySQL and the corresponding profile is stored in MongoDB.
- **Verify `/api/login`**:
  - Test with valid and invalid credentials to ensure proper validation.

## Stay in touch
- Author - [Asif Iqbal](https://www.linkedin.com/in/md-asif-iqbal-624310155/)
- WhatsApp - [+8801725215111](https://api.whatsapp.com/send/?phone=8801725215111)
- Email- asif.iqbal.hstu@gmail.com

