<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '846906395405118','1c4813b9ef8f0cd07f35d6ec3ad854b7' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://localhost/bkp2/teste/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;
      $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
      $_SESSION['TOKEN'] = '846906395405118|so7SwlM9XlVu933KdeBiu-0Dupc';
    /* ---- header location after session ----*/
  header("Location: index.php");
} else {
  $loginUrl = $helper->getLoginUrl();
 header("Location: ".$loginUrl);
}

// Cria a instancia da aplicacao, informando o appid e o secret
$facebook = new Facebook(array('appId'  => '846906395405118', 'secret' => '1c4813b9ef8f0cd07f35d6ec3ad854b7'));

// obtem o user_id, ou 0, caso esteja deslogado
$user = $facebook->getUser();

// verifica se usuario esta logado
if ($user) {
        // gera o access token extendido do usuario
        $facebook->setExtendedAccessToken();
        $access_token = $facebook->getAccessToken();

        // print do access token extendido
        var_dump($access_token);

} else {
    // usuario não logado, solicitar autenticação
    $loginUrl = $facebook->getLoginUrl();
    echo "<a href='$loginUrl'>Conectar no aplicativo</a><br />";
    echo "<strong><em>Voc&ecirc; n&atilde;o esta conectado..</em></strong>";
}
?>
