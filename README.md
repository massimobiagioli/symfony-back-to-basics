## Symfony Back to Basics
A Symfony 6 web application with Vertical Slice Architecture.

### Prerequisites

* PHP 8.2
* Composer

### Installation

1. Clone the repo

 
2. Install Composer packages
   ```sh 
   composer install
   ```
   
3. Start docker containers
   ```sh
   make up
   ```
   
4. Run database migrations
   ```sh
    make migrate
    ```
   
5. Run database fixtures
   ```sh
   make fixtures
   ```
 
6. Start local server
   ```sh
   make start-local
   ```

7. Open swagger documentation
   ```sh
   http://localhost:8000/api/doc
   ```

### Use Cases

* [x] Create a new user
* [x] Login
* [x] Get User Info
* [x] Create new device
* [x] Find all devices
* [x] Find device by id
* [x] Update device
* [x] Delete device
* [x] Activate device
* [x] Deactivate device
