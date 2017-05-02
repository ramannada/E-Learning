Feature: Verification Email

    Scenario: Verification Email
        When I GET url "api/active?token=4135579dfcfa23e4fabf82cd7c6a95a9"
        And I see the result