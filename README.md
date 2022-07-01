# ROOM BOOKING

A Simple Room Scheduler system that is handling the booking and scheduled on the rooms within the system.

## Features
* You can ensure that the system won't have booking conflicts
* A Portal to view all the scheduled rooms with dates
* Search the room number or the name of person who booked the room
* Sorting of records is available on the Booking Lists

## Tech

I've used a number of open source projects/packages to build and manage this App:

* [Laravel](https://laravel.com/) - The PHP Framework for Web Artisans
* [Laravel Passport](https://laravel.com/docs/9.x/passport) - Provides a full OAuth2 server implementation for your Laravel application
* [Vue](https://vuejs.org/) - The Progressive JavaScript Framework
* [Virtual Studio Code](https://code.visualstudio.com/) - Flexible IDE from Microsoft.
* [Composer](https://getcomposer.org/) - A Dependency Manager for PHP
* [NPM](https://www.npmjs.com/) - A Dependency Manager for Javascript
* [Postman](https://www.postman.com/) - API Tool for sending any types of request
* [Docker](https://www.docker.com/) - OS-level virtualization to deliver software in packages called containers
* [Docker Compose](https://docs.docker.com/compose/) - Compose is a tool for defining and running multi-container Docker applications
* [NGINX](https://www.nginx.com/) -  Open source software for web serving, reverse proxying, caching, load balancing, media streaming, and more.
* [PHPUnit](https://phpunit.de/) - Testing framework for PHP and comes with Laravel Framework
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) - Ensures that the best practices are being followed

## Requirements

This project used the following tools for development:

* v16.15.1 of Node.js
* v8.1.7 of PHP
* v2.1.3 of Composer
* v20.10.17, build 100c701 of Docker
* v1.29.2, build 5becea4c of Docker Compose

## Installation

The following tools or apps are required for **local installation**:
* [Docker](https://www.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/)

#### Steps
**Pull** or **Clone** the repository in your local machine and run the following commands in the CLI.

```sh
$ cd room-booking
$ sh setup.sh
```

The Setup automatically install everything inside the Docker Containers, thanks to Docker Compose, and we just need to wait until it's done.

Once it's ready, we can now send request on 

| Server | Endpoint |
| ------ | ------ |
| FRONTEND | http://localhost |
| BACKEND | http://localhost/api |

## Coding Standard and Design Pattern
Room Booking implements [PSR-12](https://www.php-fig.org/psr/psr-12/) Coding Standard and follows the **Repository Design Pattern and Clean Architecture** for the Backend Server.

While, **Constructor and Async Await Design Pattern** is used for the Frontend Server

Here are some links to get you started with **Design Patterns** mentioned above:

https://asperbrothers.com/blog/implement-repository-pattern-in-laravel/  
https://webdevetc.com/blog/the-repository-pattern-in-php-and-laravel/
https://www.imaginarycloud.com/blog/async-javascript-patterns-guide/
https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html

## License

MIT

**Free Software**
