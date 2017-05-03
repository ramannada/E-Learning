<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\BehatContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class TokenContext implements Context
{
    public $token;
    public $id;
    private $featureContext;

     /** @BeforeScenario */
   public function gatherContexts(BeforeScenarioScope $scope)
   {
       $environment = $scope->getEnvironment();
   
       $this->featureContext = $environment->getContext('FeatureContext');
   }

   /**
    * @Given the token :token
    */
   public function setToken($token)
   {
       $this->token = $token;
   }

   /**
    * @Given token with username :username
    */
   public function setTokenByUsername($username)
   {
       $query = $this->featureContext->dbConnect()->prepare("SELECT user_token.token, users.id FROM users JOIN user_token ON users.id = user_token.user_id where users.username = :username");
       // $query = $this->featureContext->dbConnect()->query("SELECT * FROM users");
       $stmt = $query->bindParam(':username', $username);
       $stmt = $query->execute();
       $row = $query->fetch();

       $this->token = $row['token'];
       $this->id = $row['id'];
   }
}