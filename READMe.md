# PHP BOOK STORE API

> A very simple api to manage a book store.

## Quick Start

1. Clone the repo
2. CD to the project folder
3. Ensure you have docker installed on your mahcine. 
4. Open a terminal and navigate to the project folder. Type docker-compose up to start the server at the same time install the necessary images as described in the docker-compose.yml file.
5. Open http://localhost:8001 to import the database file book-store.sql located in the db folder.
6. Open Postman or any api testing tool of your choice.

## API Testing
1. To read books add http://localhost/api/books/index.php and change the request method to GET. The same applies to reading all carts and orders.
2. To update, the method should be PUT, and the url is http://localhost/api/books/update.php.
3. To delete, the method is DELETE and the link is http://localhost/api/books/delete.php
4. To read a single book details, method should be GET and the url is http://localhost/api/books/single.php?id=2
5. To create a new book, you have to set the method to POST and use the url http://localhost/api/books/create.php

NB: All this applies to carts and orders.

### Author

Baraka Mark Bright

### Version

1.0.0

### License

This project is licensed under the MIT License
