<?php
namespace sirJuni\Framework\Components;

require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\Components\Request;
use Google\Client;
use Google\Service\Oauth2;

class OAuth2 {
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
        $client = new Client();
        $client->setAuthConfig('secret.json');
        $client->addScope($final_scope);
        $client->setRedirectUri($redirect_uri);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setIncludeGrantedScopes(true);

        // check if we received code
        if (!$request->queryData('code')) {
            $auth_url = $client->createAuthUrl();
            header("location: " . $auth_url);
        }
        else {
            $client->authenticate($request->queryData('code'));
            $access_token =$client->getAccessToken();
            $client->setAccessToken($access_token);
        
            $oauth2 = new Oauth2($client);
            $$this->userInfo = $oauth2->userinfo->get();

        }

    }

    public function getUserInfo() {
        $email = $this->userInfo->getEmail();
        $username = $this->userInfo->getName();

        return [
            'email' => $email,
            'username' => $username
        ];
    }
}

?>