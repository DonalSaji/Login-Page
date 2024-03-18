Login Page Project:

This login page project utilizes PHP, HTML, CSS, and JavaScript to create a secure authentication system with user registration functionality. The project includes the following components:

1. **HTML Login Page (`index.html`)**:
   - The main interface where users can either sign in or sign up for an account.
   - It consists of two sections: sign-in and sign-up forms, toggled by clicking the "Sign Up" or "Sign In" buttons.
   - The sign-in form requires users to input their email and password.
   - The sign-up form requires users to input their name, email, password, and confirm password.
   - Form validation is performed using HTML5 attributes such as `required` for mandatory fields.

2. **CSS Styles (`css.css`)**:
   - Provides styling to enhance the visual appearance of the login page.
   - Implements responsive design to ensure the page is displayed properly on different devices.

3. **JavaScript (`script.js`)**:
   - Enables the toggling functionality between sign-in and sign-up forms.
   - Performs password match validation when signing up.

4. **PHP Backend (`login.php`)**:
   - Handles form submissions and interacts with the database.
   - Utilizes MySQLi extension for MySQL database connectivity and operations.
   - Contains code to validate user credentials during login and create new user accounts during registration.
   - Implements password encryption using PHP's `password_hash()` function to securely store user passwords.
   - Alerts users with appropriate messages in case of errors, such as incorrect login credentials or mismatched passwords.
   - Redirects users to a welcome page upon successful login.

5. **Database Setup**:
   - Database Name: `login`
   - Table Name: `user`
   - Table Fields:
     - `id`: Unique identifier for each user (auto-incremented).
     - `name`: User's full name.
     - `email`: User's email address (unique).
     - `password`: Encrypted password using `password_hash()` function.

**Working of the Project**:
- When a user accesses the login page, they are presented with options to sign in or sign up.
- If the user chooses to sign in, they must enter their email and password. Upon submission, the PHP backend verifies the credentials against the database.
- If the user chooses to sign up, they must provide their name, email, and desired password. The PHP backend validates the input data, checks for password match, and inserts the new user record into the database after encrypting the password.
- If there are any errors during login or registration (e.g., invalid credentials, duplicate email), appropriate alert messages are displayed to the user.
- Upon successful login, the user is redirected to a welcome page where they can access their account-specific features.
  
Overall, this project demonstrates a basic yet functional login system with user registration capabilities, providing a foundation for building more sophisticated web applications with secure authentication mechanisms.
