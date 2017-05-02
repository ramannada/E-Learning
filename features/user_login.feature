Feature: User Login

    Scenario: Login User
        When I POST url "api/login"
        And I fill "username" with "febirn"
        And I fill "password" with "febi123"
        Then I store it
        And I see the result