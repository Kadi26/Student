CREATE DATABASE student_management;

USE student_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Courses Table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_name VARCHAR(255) NOT NULL,
    course_code VARCHAR(50) NOT NULL UNIQUE,
    semester VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Assignments Table
CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('Pending', 'Completed', 'Overdue') DEFAULT 'Pending',
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Grades Table
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT NOT NULL,
    assignment_id INT NOT NULL,
    grade VARCHAR(10) NOT NULL,
    remarks TEXT
);


CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    semester ENUM('Fall', 'Spring', 'Summer') NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE responses (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT(6) UNSIGNED NOT NULL,
    student_id int,
    file_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


create table messages (
    id int(6) unsigned auto_increment primary key,
     subject varchar(100) not null,
    message text not null,
    created_at timestamp default current_timestamp
);

ALTER TABLE `users` ADD `User_Role` VARCHAR(50) NOT NULL DEFAULT 'user' AFTER `password`;