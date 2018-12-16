# [School Administration System](https://onlineschooladministrationsystem.000webhostapp.com/)
#### PHP - MySQL

A multi-page web system that was developed as a service for a school which enables the management of students and courses. The service offers various permissions for the owner, manager and sales representatives.   
The project is written by using an MVC (Model View Controller) template and is kept on a local server. 

The project is written using:

  - HTML5 + CSS3
    - HTML5 Structure
    - Bootstrap design 
  - JavaScript
    - AJAX
  - PHP
    - MVC Structure
    - Routing
    - OO (Object Oriented)
    - Password encryption
    - File upload
  - MySQL
    - Design and create schema
    - Queries

#### Extras
- Each course has a name, description and an image.
- Each student has a name, phone, email and an image.
- Each administrator has a name, role, phone, email and a password
- All users must log into the system using an email and a password (a non-user cannot see the various pages without logging in). Once logged in, each user has their own individual permissions (according to their "role") regarding what pages to view and/ or what they may add, edit or delete.
- The school homepage (is reached upon logging in or by clicking on the link "School") presents a list of existing courses and a list of existing students (with the option to add, edit and delete according to the "role" of the user). The total number of students and courses are also presented on this page. 
- Upon clicking on a student, their detials (mentioned above) will be presented along with what courses the student is enrolled in. 
- Upon clicking on a course, the course's details (mentioned above) will be presented along with which students are enrolled in that course. 
- The administration page (upon clicking on "Administration") presents a list of the existing administrators in the system (with the option to add, edit and delete according to the "role" of the user). Only the "Owner" will be able to see their own details (please see further details below in section "Administration"). The total number of administrators is also presented on this page.
- Upon clicking on an administrator, their details (mentioned above) will be presented and open to be edited (according to the user's "role"). 
- All images that are uploaded to the system (administrators, students, and/ or courses) will be saved in a separate folder named "UserPics". In the event that a picture was not uploaded or chosen, a default "person" or "course" image will take its place until edited.  

##### Administration:
Types of roles in the system (and their permissions):
- Owner: 
  - There is only one owner and only he/ she can change their own details. 
  - The owner has all the different types of permissions that are allowed in the system.
- Manager:
  - The manager has all the types of permissions except for being able to change his own "role", deleting himself from the system, or viewing, nor changing, the owner's details.  
- Sales:
  - Cannot view the "Administration" link (nor page) and therefor is unable to change any of the administrators' details (of him or herself, manager, nor owner). 
  - Is able to change students' details including enrolling to, and removing from, a course.
  - Is not able to edit a course, but only view the course's details. 
    
##### Installation:
This project requires:
- An integrated development environment that allows applications to be developed from modules. I used [NetBeans](https://netbeans.org/)
- A cross-platform web server solution consisting of the Apache HTTP Server, MariaDB database (MySQL), and interpreters for scripts written in the PHP languages. I used [XAMPP](https://www.apachefriends.org/)
- Please upload file "someschool.sql" onto the MySQL database in order to view an already-in-use example of the project. Also be sure to view the API Documentation for the various existing log-in details and page routes. 


 
