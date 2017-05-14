Feature: Reset Password
    
    Scenario: Register New User
        When I POST url "api/register"
        And I fill "username" with "testbehat"
        And I fill "password" with "testbehat"
        And I fill "email" with "testbehat@gmail.com"
        And I fill "name" with "Test Behat"
        Then I store it

    Scenario: Verification Email
        When I verify user with email "testbehat@gmail.com"

    Scenario: Request Reset Password
    	When I POST url "api/password_reset"
    	And I fill "email" with "testbehat@gmail.com"
    	Then I store it

    Scenario: ReNew Password
    	Given information about user with username "testbehat"
    	And I set reset password token to "resetpassword"
    	When I PUT url "api/renew_password" with param:
    	| token 	   |
    	| resetpassword|
    	And I fill "password" with "testrenewbehat"
    	And I fill "retype_password" with "testrenewbehat"
    	Then I store it

   	Scenario: Delete New User
        When I delete user with username "testbehat"

