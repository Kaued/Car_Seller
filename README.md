# Car_Seller

Car_Seller is an API built using Laravel, designed for facilitating car sales. It provides endpoints and functionalities to manage the sales of cars, including various operations related to the sales process.

## Features

- **Car Sales Management**: Provides API endpoints for managing car sales, including creation, updating, and deletion of sales data.
- **Database Setup**: Requires the execution of the included `Script.sql` file to set up the necessary database structure. The project is configured to use PostgreSQL as its database management system.

## Setup and Installation

To set up and run the Car_Seller project, follow these steps:

1. Clone this repository.
2. Ensure you have PHP, Composer, and Laravel installed on your machine.
3. Set up a PostgreSQL database.
4. Execute the `Script.sql` file included in the project to create the necessary tables and structure within the PostgreSQL database.
5. Update the `.env` file with your PostgreSQL database configuration details.
6. Install project dependencies using Composer:
    ```bash
    composer install
    ```
7. Serve the application:
    ```bash
    php artisan serve
    ```

The API will be accessible on your local server.

## Endpoints

The project includes various endpoints for interacting with the car sales API. Refer to the API documentation or code comments for details about available endpoints and their functionalities.

## Technologies Used

- **Backend Framework**: Laravel (specific version used in your project).
- **Database**: PostgreSQL

