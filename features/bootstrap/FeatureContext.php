<?php

use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\DBAL\Driver\PDOMySql\Driver;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    private $_client;
    private $_parameters = [];
    private $_request;
    protected $_response;
    public $_body;
    protected $paramContext;
    public $db;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(array $parameters)
    {
        $this->_parameters = $parameters;
        $this->_client = new Client(['base_uri' => $this->_parameters['base_url']]);
    }

     /** @BeforeScenario */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->paramContext = $environment->getContext('ParamContext');
    }

    public function setDb()
    {
        $setting['url'] = 'mysql://root:root@db/e-learning'; 
        
        $config = new \Doctrine\DBAL\Configuration();

        $connect = \Doctrine\DBAL\DriverManager::getConnection($setting,
        $config);

        $this->db = $connect;
    }

    public function getBuilder()
    {
        $this->setDb();
        return $this->db->createQueryBuilder();
    }

    /**
     * @When I GET url :url
     */
    public function iGetUrl($url)
    {
        $this->_response = $this->_client->request('GET', $url, ['headers' => $headers]);
    }

    /**
     * @When I GET url :url with param:
     */
    public function iGetUrlInParam($url, TableNode $table)
    {
        foreach ($table as $key => $value) {
            $options['query'] = $value;
        }
        $this->_response = $this->_client->request('GET', $url, $options);
    }

    /**
     * @When I GET url :url by column :column
     */
    public function iGetUrlByColumn($url, $column)
    {
        $column = explode(',', $column);

        foreach ($column as $key => $value) {
            $columns[$value] = $this->paramContext->{$value};
        }

        $url = $url. '/'. implode('/', $columns);

        $this->_response = $this->_client->request('GET', $url);
    }

    /**
     * @When I GET url :url by column :column and with param:
     */
    public function iGetUrlByColumnAndWithParam($url, $column, TableNode $table)
    {
        $column = explode(',', $column);

        foreach ($column as $key => $value) {
            $columns[$value] = $this->paramContext->{$value};
        }

        $url = $url. '/'. implode('/', $columns);

        foreach ($table as $key => $value) {
            $options['query'] = $value;
        }

        $this->_response = $this->_client->request('GET', $url, $options);
    }

    /**
     * @When I POST url :url
     */
    public function iPostUrl($url)
    {
        $this->_request = [
            'method'=> 'POST',
            'url'   => $url,
        ];
    }

    /**
     * @When I POST url :url with param:
     */
    public function iPostUrlWithParam($url, TableNode $table = null)
    {
        foreach ($table as $key => $value) {
            $options['query'] = $value;
        }
        $this->_request = [
            'method'=> 'POST',
            'url'   => $url,
            'query' => $options['query'],
        ];
    }

    /**
     * @When I POST url :url by column :column
     */
    public function iPostUrlByColumn($url, $column)
    {
        $column = explode(',', $column);

        foreach ($column as $key => $value) {
            $columns[$value] = $this->paramContext->{$value};
        }

        $url = $url. '/'. implode('/', $columns);

        $this->_request = [
            'method'=> 'POST',
            'url'   => $url,
        ];
    }

    /**
     * @When I POST url :url by column :column and with param:
     */
    public function iPostUrlByColumnAndWithParam($url, $column, TableNode $table)
    {
        $column = explode(',', $column);

        foreach ($column as $key => $value) {
            $columns[$value] = $this->paramContext->{$value};
        }

        $url = $url. '/'. implode('/', $columns);

        foreach ($table as $key => $value) {
            $options['query'] = $value;
        }

        $this->_request = [
            'method'=> 'POST',
            'url'   => $url,
            'query' => $options['query'],
        ];
    }

    /**
     * @When I PUT url :url
     */
    public function iPutUrl($url)
    {
        $this->_request = [
            'method'=> 'PUT',
            'url'   => $url,
        ];
    }

    /**
     * @When I PUT url :url with param:
     */
    public function iPutUrlWithParam($url, TableNode $table = null)
    {
        foreach ($table as $key => $value) {
            $options['query'] = $value;
        }
        $this->_request = [
            'method'=> 'PUT',
            'url'   => $url,
            'query' => $options['query'],
        ];
    }

    /**
     * @When I PUT url :url by column :column
     */
    public function iPutUrlByColumn($url, $column)
    {
        $column = explode(',', $column);

        foreach ($column as $key => $value) {
            $columns[$value] = $this->paramContext->{$value};
        }

        $url = $url. '/'. implode('/', $columns);

        $this->_request = [
            'method'=> 'PUT',
            'url'   => $url,
        ];
    }

    /**
     * @When I PUT url :url by column :column and with param:
     */
    public function iPutUrlByColumnAndWithParam($url, $column, TableNode $table)
    {
        $column = explode(',', $column);

        foreach ($column as $key => $value) {
            $columns[$value] = $this->paramContext->{$value};
        }

        $url = $url. '/'. implode('/', $columns);

        foreach ($table as $key => $value) {
            $options['query'] = $value;
        }

        $this->_request = [
            'method'=> 'PUT',
            'url'   => $url,
            'query' => $options['query'],
        ];
    }

    /**
     * @When I DELETE url :url
     */
    public function iDeleteUrl($url)
    {
        $this->_request = [
            'method'=> 'DELETE',
            'url'   => $url,
        ];
    }

    /**
     * @When I DELETE url :url with param:
     */
    public function iDeleteUrlWithParam($url, TableNode $table = null)
    {
        foreach ($table as $key => $value) {
            $options['query'] = $value;
        }
        $this->_request = [
            'method'=> 'DELETE',
            'url'   => $url,
            'query' => $options['query'],
        ];
    }

    /**
     * @When I DELETE url :url by column :column
     */
    public function iDeleteUrlByColumn($url, $column)
    {
        $column = explode(',', $column);

        foreach ($column as $key => $value) {
            $columns[$value] = $this->paramContext->{$value};
        }

        $url = $url. '/'. implode('/', $columns);

        $this->_request = [
            'method'=> 'DELETE',
            'url'   => $url,
        ];
    }

    /**
     * @When I DELETE url :url by column :column and with param:
     */
    public function iDeleteUrlByColumnAndWithParam($url, $column, TableNode $table)
    {
        $column = explode(',', $column);

        foreach ($column as $key => $value) {
            $columns[$value] = $this->paramContext->{$value};
        }

        $url = $url. '/'. implode('/', $columns);

        foreach ($table as $key => $value) {
            $options['query'] = $value;
        }

        $this->_request = [
            'method'=> 'DELETE',
            'url'   => $url,
            'query' => $options['query'],
        ];
    }
    /**
     * @When I fill :name with :value
     */
    public function iFillWith($name, $value)
    {
        if ($value == 'random_username') {
            $value = md5(openssl_random_pseudo_bytes(12));
        } elseif ($value == 'random_email') {
            $value = md5(openssl_random_pseudo_bytes(12)). '@gmail.com';
        }
        $this->_body[$name] = $value;
    }
    /**
     * @Then I store it
     */
    public function iStoreIt()
    {
        try {
            $headers = [
                'Content-Type'  => 'application/json',
                'Authorization' => $this->tokenContext->token,
            ];
            $body = json_encode($this->_body);

            $this->_response = $this->_client
                                    ->request($this->_request['method'], $this->_request['url'], ['headers' => $headers, 'query' => $this->_request['query'], 'json' => $this->_body]);
        } catch (Exception $exception) {
            $this->getException($exception);
        }
    }

    /**
     * @Then I see the result
     */
    public function iSeeTheResult()
    {
        echo $this->_response->getBody();
    }

    /**
     * @getException Error
     */
    public function getException($exception)
    {
        $getResponse = $exception->getResponse();

        $data =  json_decode($getResponse->getBody()->getContents());
 
        if (!($data->status == 200)) {
            if (!empty($data->data)) {
                throw new Exception($data->data);
            } else {
                throw new Exception($data->message);
            }
        }
    }

    /**
     * @When I active user with email :email
     */
    public function iActiveUserWithEmail($email)
    {
        $this->dbConnect()->query("UPDATE users SET is_active = 1 where email = '$email'");
    }

     /**
     * @When I delete user with email :email
     */
    public function iDeleteUserWithEmail($email)
    {
        $this->dbConnect()->query("DELETE FROM users where email = '$email'");
    }

    /**
     * @When I delete token
     */
    public function iDeleteTokenPasswordReset()
    {
        $this->dbConnect()->query("DELETE FROM password_reset");
    }
}