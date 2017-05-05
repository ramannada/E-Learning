Feature: User Register And Login
    
    Scenario: Reset Password
        When I POST url "api/password_reset"
        And I fill "email" with "testbehat@gmail.com"
        Then I store it

    Scenario: Delete Token Password Reset
        When I delete token