# Brainster Project: Library Books 

I used HTML, CSS, Bootstrap, JavaScript, Ajax, PHP and DataBase for this website

# Main
This website contains a main page that displays all the books, The main page consists of a navigation bar with a logo that on click takes you to the main page, on the right side there are two buttons for user registration and user login, while viewing on books, the navigation is always displayed at the top of the screen.
Above the books there are filters that initially show all the books, after selecting a certain category we can show the books by category.
At the bottom of the page there is a footer that displays a random quote and the name of the aftor on every refresh of the page, with Ajax I have made an API call from where it displays the quotes.

# Book
When clicking on a book, it takes us to another page where it opens the book and displays information about it, at the bottom of the book there are comments about the book that can only be written by logged in users and can be read by all users if the given comments are approved by an administrator , each logged-in user can leave one comment for each book, if I have not left a comment, a field will be displayed where he can write his comment, after leaving the comment, the field will not be available for him to write a second comment.
Only logged in users can write notes in the Notes field and only they can read them, they can edit and delete them for each book separately.

# Form
When a user wants to register, he must enter a username that has not already been used once and he must write the password in both fields, then he is redirected to a page where he can log in, a button has been added so that he can check the password before clicking login if it is spelled correctly.
After login, it redirects him to the main page where he can see all the books.

#Admin
In the admin panel we have 4 categories:
- Authors
- Categories
- Books
- Comments

Only an admin user can access here, in the author category we fill the database with authors, we can change their information and delete authors.
In the categories field, we also add categories for the books and can change or delete them.
In the book menu, we review all the books that are in the database, in the field for adding a new book, all fields are mandatory, where in the Author and Category fields, we must choose one of the existing ones.
In the comment field, it initially displays the newly written comments from users who are waiting for the administrator to approve them and display them for all users, if the administrator rejects any of the comments, it will not be displayed to the rest of the users except for the user who has it once the comment is written, in the filter field the administrator can display all comments that are pending, approved or rejected.
Rejected comments can be approved by the admin before the comment is deleted by the user who left the same comment, there is also a field to view all comments.
The admin also has the option to delete comments.
If the admin goes to the main page where all the books are displayed, he has the possibility to return to the admin panel with the link that is shown in the nav bar in the upper right corner only for Admin users.

# DataBase
For the created database, an ER diagram and code was created with which the database was created, a Soft deleting column was created for all the tables, with this column, when deleting any information from the website, it will not be visible on the page, but it will be there in the database stored in the deleted_at column with the date and time when the information was deleted with the possibility to return it again only by accessing the database where it should be returned to a NULL value.
During registration, users will always have a value of 0 in the is_admin column, in order to make a user an admin, the value of a user in the is_admin field can be changed to 1 only by accessing the database.

# Authentication & Validation
Protection has been made with PHP so that it is not possible to access the admin panel via a link as long as the user does not have admin access and is not logged in. If a non-logged user tries to access the admin panel via a link, it will always redirect him to the login page.
PHP validations have been made on all input fields, a hash password has been used during user registration so that the password of any user cannot be easily found out, validations have also been made so that the database cannot be filled with empty fields.

# Made by: Darko Mihailovski FS13