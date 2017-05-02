Feature: User Register And Login

    Scenario: Register New User
        When I POST url "api/register"
        And I fill "username" with "febirn"
        And I fill "password" with "febirn"
        And I fill "email" with "febirn@gmail.com"
        And I fill "name" with "Febi Adrian"
        Then I store it

    Scenario: Active User Or Verifivcation Email
        When I active user with email "febirn@gmail.com"

    Scenario: Login User
        When I POST url "api/login"
        And I fill "username" with "febirn"
        And I fill "password" with "febirn"
        Then I store it

    Scenario: Delete New User
        When I delete user with email "febirn@gmail.com"