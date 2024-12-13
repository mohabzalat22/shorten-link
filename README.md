
## Roadmap.sh Project
Link
- https://roadmap.sh/projects/url-shortening-service

# API Documentation
# Installation Guide

## Prerequisites
Before you begin, ensure you have the following installed:
- PHP 8.0+ 
- Composer
- Laravel 8.x or higher
- A database (e.g., MySQL, PostgreSQL, SQLite)
- Node.js and npm (for front-end assets, if required)

## Steps to Install

1. **Clone the Repository**
   ```bash
   git clone https://github.com/mohabzalat22/shorten-link.git
   ```

2. **Composer Install**
   ```bash
   composer install
   ```

2. **Run the Api**
   ```bash
   php artisan serve
   ```

## Authentication Routes

### `POST /auth/login`
- **Description**: Logs in a user and returns an authentication token.
- **Request Body**: 
  - `email`: User's email address.
  - `password`: User's password.
- **Response**: 
  - **200 OK**: Token issued successfully.
  - **400 Bad Request**: Invalid credentials.

### `POST /auth/logout`
- **Description**: Logs out the authenticated user.
- **Request Body**: None
- **Response**:
  - **200 OK**: Successfully logged out.
  - **401 Unauthorized**: User is not authenticated.

### `POST /auth/refresh`
- **Description**: Refreshes the authentication token.
- **Request Body**: None
- **Response**:
  - **200 OK**: Successfully refreshed token.
  - **401 Unauthorized**: User is not authenticated.

### `POST /auth/register`
- **Description**: Registers a new user.
- **Request Body**:
  - `email`: User's email address.
  - `password`: User's password.
- **Response**:
  - **201 Created**: User successfully registered.
  - **400 Bad Request**: Invalid input.

### `GET /auth/me`
- **Description**: Fetches the authenticated user's profile.
- **Request Body**: None
- **Response**:
  - **200 OK**: Returns user profile data.
  - **401 Unauthorized**: User is not authenticated.

---

## Shorten Link Routes (Authenticated)

### `GET /v1/shorten/redirect/{url}`
- **Description**: Redirects to the original URL associated with the shortened URL.
- **Parameters**:
  - `url`: The shortened URL.
- **Response**:
  - **302 Found**: Redirects to the original URL.
  - **404 Not Found**: Shortened URL not found.

### `POST /v1/shorten`
- **Description**: Creates a new shortened link for the authenticated user.
- **Request Body**:
  - `url`: The original URL to shorten.
- **Response**:
  - **201 Created**: Shortened URL generated successfully.
  - **400 Bad Request**: Invalid URL.

### `PUT /v1/shorten/{url}`
- **Description**: Updates the existing shortened link.
- **Parameters**:
  - `url`: The existing shortened URL.
- **Request Body**:
  - `url`: The new URL to associate with the shortened URL.
- **Response**:
  - **200 OK**: Shortened URL updated successfully.
  - **400 Bad Request**: Invalid URL or already exists.
  - **404 Not Found**: Shortened URL not found.

### `DELETE /v1/shorten/{url}`
- **Description**: Deletes the specified shortened URL.
- **Parameters**:
  - `url`: The shortened URL to delete.
- **Response**:
  - **204 No Content**: Shortened URL deleted successfully.
  - **404 Not Found**: Shortened URL not found.

### `GET /v1/shorten/{url}`
- **Description**: Retrieves the original URL associated with the shortened URL.
- **Parameters**:
  - `url`: The shortened URL.
- **Response**:
  - **200 OK**: Returns the original URL.
  - **404 Not Found**: Shortened URL not found.

### `GET /v1/shorten/{url}/stats`
- **Description**: Retrieves the statistics for the specified shortened URL.
- **Parameters**:
  - `url`: The shortened URL.
- **Response**:
  - **200 OK**: Returns statistics (e.g., access count) for the URL.
  - **404 Not Found**: Shortened URL not found.

---

## Notes
- All routes in the `/v1/shorten` group require authentication via the `auth:api` middleware.
- Run `php artisan serve` to run the api
