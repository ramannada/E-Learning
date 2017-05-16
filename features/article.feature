Feature: Article

	Scenario: Register New User
        When I "POST" in "api/register"
        And I fill post with this:
        | username  | password  | email               | name       |
        | testbehat | testbehat | testbehat@gmail.com | Test Behat |
        Then I store it

    Scenario: Verification Email
        When I verify user with email "testbehat@gmail.com"

    Scenario: Login User
        When I "POST" in "api/login"
        And I fill post with this:
        | username  | password  |
        | testbehat | testbehat |
        Then I store it

    Scenario: Change Role to Admin Course
        Given information about "users" by "username" "testbehat"
    	When my role change to "Admin Courses" role

    