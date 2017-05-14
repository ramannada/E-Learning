<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\BehatContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class ResetPasswordContext implements Context
{
	public $featureContext;
	public $paramContext;

	 /** @BeforeScenario */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();
    
        $this->featureContext = $environment->getContext('FeatureContext');
        $this->paramContext = $environment->getContext('ParamContext');
    }

    /**
     * @Then I set reset password token to :token
     */
    public function setToken($token)
    {
    	$qb = $this->featureContext->getBuilder();
    	$qb->update('password_reset')
    	   ->set('token', ':token')
    	   ->where('user_id', ':user_id')
    	   ->setParameter(':token', $token)
    	   ->setParameter(':user_id', $this->paramContext->id)
    	   ->execute();
    }
}