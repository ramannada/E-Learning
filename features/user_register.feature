Feature: Register User

    Scenario: Register User New Users
        When I POST url "api/register"
        And I fill "name" with "febirn"
        And I fill "username" with "febirn"
        And I fill "email" with "febirn@gmail.com"
        And I fill "password" with "febirn"
        Then I store it
        And I see the result