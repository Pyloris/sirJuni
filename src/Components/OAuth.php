<?php
namespace sirJuni\Framework\Components;

require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\Components\Request;
use Google\Client;
use Google\Service\Oauth2;

class OAuth {
    private $client;
    public function __construct($secret_json, $redirect_uri, $scopes) {
        $request = new Request();

        $google_api = "https://www.googleapis.com/auth/";

        $access_scopes = [];
        // create a scope using $scopes
        foreach($scopes as $scope) {
            $access_scopes[] = $google_api . $scope; 
        }

        $final_scope = implode(' ', $access_scopes);

        // create client instance
        $this->client = new Client();
        $this->client->setAuthConfig($secret_json);
        $this->client->addScope($final_scope);
        $this->client->setRedirectUri($redirect_uri);
        $this->client->setAccessType('offline');     // should return a refresh token too.
        $this->client->setPrompt('consent');
        $this->client->setIncludeGrantedScopes(true);

        // check if we received code
        if (!$request->queryData('code')) {
            $auth_url = $this->client->createAuthUrl();
            header("location: " . $auth_url);
        }
        else {
            $this->client->authenticate($request->queryData('code'));
            $access_token =$this->client->getAccessToken();
            $this->client->setAccessToken($access_token);
        }

    }

    public function getUserInfo() {
        // get oauth2 instance
        $oauth2 = new Oauth2($this->client);
        $this->userInfo = $oauth2->userinfo->get();

        // get the user details
        $email = $this->userInfo->getEmail();
        $username = $this->userInfo->getName();

        return [
            'email' => $email,
            'username' => $username
        ];
    }
}

?>