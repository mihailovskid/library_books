-- Active: 1695418280864@@127.0.0.1@3306@library

CREATE TABLE
    users(
        id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50),
        password VARCHAR(100),
        is_admin BOOLEAN DEFAULT 0,
        deleted_at TIMESTAMP DEFAULT NULL
    );

CREATE TABLE
    categories(
        id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(250),
        deleted_at TIMESTAMP DEFAULT NULL
    );

CREATE TABLE
    authors (
        id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        biography VARCHAR(250) NOT NULL,
        deleted_at TIMESTAMP DEFAULT NULL
    );

CREATE TABLE
    books(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(250) NOT NULL,
        author_id INT NOT NULL,
        year_published INT NOT NULL,
        pages INT NOT NULL,
        img_url VARCHAR(255) NOT NULL,
        category_id INT NOT NULL,
        deleted_at TIMESTAMP DEFAULT NULL,
        Foreign Key (author_id) REFERENCES authors(id),
        Foreign Key (category_id) REFERENCES categories(id)
    );

CREATE TABLE
    comments(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        book_id INT NOT NULL,
        comment VARCHAR(255),
        status INT,
        deleted_at TIMESTAMP DEFAULT NULL,
        Foreign Key (user_id) REFERENCES users(id),
        Foreign Key (book_id) REFERENCES books(id)
    );

CREATE TABLE
    notes(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        book_id INT NOT NULL,
        note VARCHAR(255),
        deleted_at TIMESTAMP DEFAULT NULL,
        Foreign Key (user_id) REFERENCES users(id),
        Foreign Key (book_id) REFERENCES books(id)
    );