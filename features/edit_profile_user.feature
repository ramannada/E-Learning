Feature: Update Profile User

	Scenario: Register New User
        When I POST url "api/register"
        And I fill "username" with "testbehat"
        And I fill "password" with "testbehat"
        And I fill "email" with "testbehat@gmail.com"
        And I fill "name" with "Test Behat"
        Then I store it

    Scenario: Active User Or Verifivcation Email
        When I active user with email "testbehat@gmail.com"

    Scenario: Login User
        When I POST url "api/login"
        And I fill "username" with "testbehat"
        And I fill "password" with "testbehat"
        Then I store it

    Scenario: Update Profile
    	Given token with username "testbehat"
    	When I PUT url "api/profile/edit" by "id"
    	And I fill "name" with "testbehatedit"
    	And I fill "email" with "testbehat@gmail.com"
    	Then I store it
    	And I delete user with email "testbehat@gmail.com"