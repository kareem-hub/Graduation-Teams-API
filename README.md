
# Laravel Team Management API


[![Status](https://img.shields.io/badge/status-active-success.svg)]() 

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

## Overview
This Laravel-based API provides a comprehensive set of features for managing teams

### ERD
![image](https://github.com/kareemaladawy/laravel-team-management-API/assets/62149929/96b29253-c64f-4ca5-8dd9-ea0caf51e0b3)


## Features
- Create, view, update, and remove teams
- Login, register, and logout

## Installation
To install the API, clone this repository to your local machine and run the following commands:

``composer install``

``php artisan key:generate``

``php artisan migrate``

## Usage
Once the API is installed, you can start using it by sending HTTP requests to the following endpoints:

#### Make sure to specify API version before every request

```
 /api/v1
```

| Endpoint  | Method   | Description                |
| :-------- | :------- | :------------------------- |
| `/teams?type={type}`  | `GET` | View available teams with the specified type |
| `/teams`  | `POST` | Create a new team |
| `/teams/{team}`  | `GET` | View a specific team |
| `/teams/{team}`  | `PUT` | Update a specific team |
| `/teams/{team}`  | `DELETE` | Remove a specific team |


## Authors

- [@kareemalaadwy](https://www.github.com/kareemalaadwy)


## Contributing

Contributions are always welcome!


