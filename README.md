
# Task RESTful API Documentation
Create a new symfony setup for the api using `symfony create-project symfony/skeleton tasks` and then first configure the database you will use either postgre, mysql or sqlite in the .env file, afterwards install the necessary symfony libraries to use to accomplish the task. This API provides functionalities to manage tasks with attributes id, title, description, duedate and status through CRUD operations (Create, Read, Update, Delete). And you then test the endpoints using a tool like postman.

```
composer require "lexik/jwt-authentication-bundle"
symbfony make:user
symfony make:entity Task
```
configure the security.yaml file and set up user using this link [https://www.(binaryboxtuts.com/php-tutorials/symfony-6-json-web-tokenjwt-authentication/)]

### User Registeration, Login and Token generation - ✔</br>

The task api endpoints are all secured by Json Web Token Authentication (JWT) that requires a new user to register and after registration and sign in. After sign in the user is assigned a web token to access the task api endpoints.
On registration a success message with code 200 ok should be returned to the user as seen in the image linked below

![Screenshot (27)](https://github.com/AMooka/Tasks-API/assets/158544515/ff11fc70-eef3-4846-8d18-51dab16bff37)

and then when user signs in using the the registration details they used, the a token to access the api is generated as seen in this image

![Screenshot (28)](https://github.com/AMooka/Tasks-API/assets/158544515/69b0ec3c-3f73-467e-8f7f-45a6666d4413), 
this generated token is used to access the task api endpoints by parsing it the request parameter.

## The task endpoint</br>
Has the base Base URL: http://localhost:8000</br>
Each object contains the following properties:</br>
  ▪ id (integer): Unique identifier for the task that is autogenerated.</br>
  ▪ title (string): Title of the task.</br>
  ▪ dueDate (datetime): Date and time for task execution</br>
  ▪ description (string): description of the task.</br>
  ▪ completed (string): status of the task</br>


### 1. GET /api/tasks - ✔</br>

This endpoint retrieves all data from the database</br>
  • Description: Retrieve all tasks.</br>
  • Method: GET</br>
  • Authentication: secured by jwt</br>
  • Response Format: JSON</br>
  • Response:
  An array of objects representing all tasks.
  • Example Response 

  ![Screenshot (33)](https://github.com/AMooka/Tasks-API/assets/158544515/89399ec8-65e3-4ea9-99d9-ef83105c6cd5)

  Error Handling </br>
     Status code: 200 (Ok) – returned when request is successful. </br>
     Status code: 400 (Bad Request) - If the request is malformed or invalid.</br>
     Status code: 500 (Internal Server Error) - If there's an unexpected error during retrieval.</br>
  
### 2. GET /api/tasks/{id} - ✔

  • Description: Retrieve a single task by its ID.</br>
  • Method: GET</br>
  • Authentication: Secured with JWT</br>
  • Path Parameter:
    {id} (integer): The ID of the task to retrieve.</br>
  • Response Format: JSON</br>
  • Response:
    o An object representing the requested task with the same properties as in the GET /api/tasks response (id, title, description, completed, duedate).
    o If the task with the provided ID is not found, a it will return message task not</br>
  found.
  • Example Response (Success) 

  ![Screenshot (34)](https://github.com/AMooka/Tasks-API/assets/158544515/5012d44b-0bf9-400c-bee9-0ad654cdad32)

  **Error Handling:**
    o Status code: 400 (Bad Request) - If the provided ID is invalid.
    o Status code: 404 (Not Found) - If the task with the provided ID is not found.
    o Status code: 500 (Internal Server Error) - If there's an unexpected error during retrieval.
    o The response will include a JSON object with an "error" property containing a message describing the issue.

### 3. POST /api/tasks - X

• Description: Create a new task. </br>
• Method: POST
• Authentication: Secured with JWT
• Request Format: JSON
• Request Body:
o title (string): Required. Title of the new task. (Must not be empty)o description (string): Optional. Description of the new task.
o Status ([‘pending’, ‘completed’, ’to do’])
• Response Format: JSON
• Response:
o On success, the response will include the ID of the newly created task.
  • Example Request: Returns error with response error code 400
  ```
      {
      "errors": []
      }
```
  **Error Handling:**</br>
    o Status code: 400 (Bad Request)</br>
    o Status code: 500 (Internal Server Error) - If there's an unexpected error during creation.</br>
    o The response will include a JSON object with an "error" property containing a message describing the issue.</br>

### 4. PUT /api/tasks/{id} - X 

    • Description: Update an existing task.
    • Method: PUT 
    • Authentication: JWT secured
  Return response with an error below
      {
      "errors": []
      }
  **Error Handling:**</br>
      o Status code: 200 (Ok) – returned when request is successful</br>
      o Status code: 400 (Bad Request) - If the request is malformed or invalid.</br>
      o Status code: 500 (Internal Server Error) - If there's an unexpected error during retrieval.</br>
      
### 5. DELETE /api/tasks/{id} - ✔</br>

  • Description: Delete an existing task.</br>
  • Method: DELETE</br>
  • Authentication: Secured with JWTReturn response after task is deleted</br>
  image showing successful deletion for example task 1 in used in this task api 

  ![Screenshot (35)](https://github.com/AMooka/Tasks-API/assets/158544515/2b95675c-ce8a-48f8-9069-fdf33855617c)
  ```
    {
    "message": "Task deleted successfully"
    }
  ```
meaning task was deleted successfully
  **Error Handling**</br>
    o Status code: 200 (Ok) – returned when request is successful </br>
    o Status code: 400 (Bad Request) - If the request is malformed or invalid.</br>
    o Status code: 500 (Internal Server Error)</br>

The actions marked with `x` show some error, and a solution is welcome for the error to be fixed on mainly two actions > POST and > PUT for adding new task and editing already existing tasks, the generated tasks above where added directly to the table to test the GET http method, that works absolutely well  

  

  






