# Spoodler REST API Documentation

This is the REST API documentation for the Spoodler project. It provides information about the available endpoints, request and response formats, and authentication methods.

---

## Base URL

```
https://spoodler:8443
```

---

## Security

This API uses **self-signed certificates** for HTTPS connections to ensure secure communication. Since the certificate is self-signed, clients may need to manually accept the certificate when making requests.

Make sure to configure your HTTP client (e.g., Postman, cURL, or browser) to trust the self-signed certificate to avoid SSL/TLS errors.

---

## Response Format

All responses follow this structure:

- **Success Response:**

```json
{
  "data": {response_data},
  "message": ""
}
```

- **Error Response:**

```json
{
  "data": [],
  "message": "<error_message>"
}
```

---

## Authentication

This API uses **JWT tokens** for authentication to protect all `/api` routes except for:

- `POST /api/users/login`
- `POST /api/users/register`

### How to Authenticate

1. **Obtain a JWT Token**

   - Send a `POST` request to `/api/users/login` with valid user credentials.
   - A token is returned in the response body under `data.token`.

2. **Include the Token in Requests**
   - Add the token in the `Authorization` header for all protected routes:
     ```
     Authorization: Bearer <JWT_TOKEN>
     ```

### Possible Responses for Authentication Errors

Protected routes can return the following responses if authentication fails:

- **401 Unauthorized** – When authentication fails due to:

  - Missing Authorization header:
    ```json
    {
      "data": [],
      "message": "Missing Authorization header"
    }
    ```
  - Invalid Authorization header format:
    ```json
    {
      "data": [],
      "message": "Invalid Authorization header format"
    }
    ```
  - Token is invalid or expired:
    ```json
    {
      "data": [],
      "message": "Unauthorized"
    }
    ```

---

# Endpoints

---

## Users

### 1. Register a New User

**Endpoint:**

```
POST /users/register
```

**Description:**  
Registers a new user.

**Request Body:**

```json
{
  "email": "user@example.com",
  "password": "your_password"
}
```

**Response:**

- **201 Created**

```json
{
  "data": {
    "email": "user@example.com"
  },
  "message": ""
}
```

- **400 Bad Request** – If the input is invalid:

  - Invalid field format:

    ```json
    {
      "data": [],
      "message": "email must be a valid email address"
    }
    ```

  - Missing required fields:

    ```json
    {
      "data": [],
      "message": "Parameter 'email' is required."
    }
    ```

  - If email is already registered:

    ```json
    {
      "data": [],
      "message": "Email already registered"
    }
    ```

- **500 Internal Server Error** – If registration fails:

```json
{
  "data": [],
  "message": "Could not register user"
}
```

---

### 2. Login User

**Endpoint:**

```
POST /users/login
```

**Description:**  
Authenticates a user and returns a JWT token for authorized access to protected routes.

**Request Body:**

```json
{
  "email": "user@example.com",
  "password": "your_password"
}
```

**Response:**

- **200 OK** – If authentication is successful:

```json
{
  "data": {
    "email": "user@example.com",
    "token": "<JWT_TOKEN>"
  },
  "message": ""
}
```

- **400 Bad Request** – If the input is invalid:

  - Invalid field format:

    ```json
    {
      "data": [],
      "message": "email must be a valid email address"
    }
    ```

  - Missing required fields:

    ```json
    {
      "data": [],
      "message": "Parameter 'email' is required."
    }
    ```

- **401 Unauthorized** – If authentication fails:

  ```json
  {
    "data": [],
    "message": "Invalid email or password"
  }
  ```

- **404 Not Found** – If the user is not found:

  ```json
  {
    "data": [],
    "message": "User not found"
  }
  ```

- **500 Internal Server Error** – If there is an issue generating the JWT token or another server error:

```json
{
  "data": [],
  "message": "Internal server error"
}
```

---

### 3. Get Current User Info

**Endpoint:**

```
GET /users/getme
```

**Description:**  
Fetches information about the currently authenticated user.

**Headers:**

```
Authorization: Bearer <JWT_TOKEN>
```

**Response:**

- **200 OK** – If the request is successful and the user is authenticated:

```json
{
  "data": {
    "email": "user@example.com"
  },
  "message": ""
}
```

- **401 Unauthorized** – If the user is not authenticated (e.g., no user ID in token):

```json
{
  "data": [],
  "message": "Not authenticated"
}
```

- **404 Not Found** – If the user ID in the token does not correspond to any user:

```json
{
  "data": [],
  "message": "User not found"
}
```

- **500 Internal Server Error** – If an unexpected server error occurs:

```json
{
  "data": [],
  "message": "Internal server error"
}
```

---

## Errors

### 1. Get All Errors

**Endpoint:**

```
GET /errors
```

**Description:**  
Fetches all logged errors.

**Headers:**

```
Authorization: Bearer <JWT_TOKEN>
```

**Response:**

- **200 OK**

```json
{
  "data": [
    {
      "id": 1,
      "message": "Error message",
      "file": "example.php",
      "description": "Detailed error description",
      "created_at": "2025-02-01 10:00:00"
    },
    {
      "id": 2,
      "message": "Another error",
      "file": "example2.php",
      "description": "Detailed error description",
      "created_at": "2025-02-02 11:00:00"
    }
  ],
  "message": ""
}
```

- **500 Internal Server Error** – If an unexpected server error occurs:

```json
{
  "data": [],
  "message": "Internal server error"
}
```

---

### 2. Get Error by ID

**Endpoint:**

```
GET /errors/{id}
```

**Description:**  
Fetches details of a specific error by its ID.

**Headers:**

```
Authorization: Bearer <JWT_TOKEN>
```

**Path Parameters:**

- `id` – The ID of the error to retrieve.

**Response:**

- **200 OK**

```json
{
  "data": {
    "id": 1,
    "message": "Error message",
    "file": "example.php",
    "description": "Detailed error description",
    "created_at": "2025-02-01 10:00:00"
  },
  "message": ""
}
```

- **400 Bad Request** – If the ID is not a valid integer:

```json
{
  "data": [],
  "message": "id must be an integer: id='abc'"
}
```

- **404 Not Found** – If the error ID does not exist:

```json
{
  "data": [],
  "message": "Error not found"
}
```

- **500 Internal Server Error** – If an unexpected server error occurs:

```json
{
  "data": [],
  "message": "Internal server error"
}
```

---

### 3. Get Error Advice

**Endpoint:**

```
GET /errors/{id}/advice
```

**Description:**  
Fetches AI advice for resolving a specific error by its ID.

**Headers:**

```
Authorization: Bearer <JWT_TOKEN>
```

**Path Parameters:**

- `id` – The ID of the error for which to get advice.

**Response:**

- **200 OK**

```json
{
  "data": {
    "advice": "Try restarting the server"
  },
  "message": ""
}
```

- **400 Bad Request** – If the ID is not a valid integer:

```json
{
  "data": [],
  "message": "id must be an integer: id='abc'"
}
```

- **404 Not Found** – If the error ID does not exist:

```json
{
  "data": [],
  "message": "Error not found"
}
```

- **500 Internal Server Error** – If an unexpected server error occurs:

```json
{
  "data": [],
  "message": "Internal server error"
}
```
