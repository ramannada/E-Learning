Feature: Verification Email

    Scenario: Verification Email
        When I GET url "active?token=5ea5b32f3fb4b6e2aa0e7c5e437a7d68"
        And I see the result