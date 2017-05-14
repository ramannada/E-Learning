Feature: Article

	Scenario: Register New User
        When I POST url "api/register"
        And I fill "username" with "testbehat"
        And I fill "password" with "testbehat"
        And I fill "email" with "testbehat@gmail.com"
        And I fill "name" with "Test Behat"
        Then I store it

    Scenario: Verification Email
        When I verify user with email "testbehat@gmail.com"

    Scenario: Login User
        When I POST url "api/login"
        And I fill "username" with "testbehat"
        And I fill "password" with "testbehat"
        Then I store it

    Scenario: Change Role to Admin Course
    	When my role change to admin course role

    Scenario: Create Article
    	Given token with username "testbehat"
    	When I POST url "api/admin/article/create"
    	And I fill "title" with "testbehat Article"
    	And I fill "content" with "testbehat Article content"
    	And I fill category with this:
    	| category |
    	| aa       |
    	| bb       |
    	Then I store it

    Scenario: Update Article
    	Given token with username "testbehat"
    	Given information about "articles" with "title" "testbehat Article"
    	When I PUT url "api/admin/article/edit" by column "title_slug"
    	And I fill "title" with "testbehat Article edit"
    	And I fill "content" with "testbehat Article content edit"
    	And I fill category with this:
    	| category |
    	| cc       |
    	| dd       |
    	Then I store it