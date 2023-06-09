# Email Service

This is an API for the email service built to complete the final project of the Microservice Architecture course.

Prerequisites:

- Node.js (tested with v19.9.0)
- MongoDB (tested with v1.9.1)

Notes:

- Pact files (located in ./pacts/) are ignored in the .gitignore file.
- In our development environment on Windows, we encountered an issue where we couldn't install the Pact package when running npm install. However, it works fine on Linux.
- We acknowledge that some of the tests are not ideal and represent an anti-pattern, specifically the reversed pyramid test. This is because the endpoint test covers most of the test cases that should have been handled in our unit tests at the service layer. At that time, we mistakenly believed that since the application was small, we could perform a feature test that would also cover all the possibilities of unit tests, without realizing that this approach was an anti-pattern.

Please make sure you have the required prerequisites installed and set up the .env file before running the application.
