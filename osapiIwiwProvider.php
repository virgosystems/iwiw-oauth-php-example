<?php
/**
 * Predefined osapi provider for IWIW
 *
 */
class osapiIwiwProvider extends osapiProvider {

 /**
  * 
  * @param  $baseURL the url of iwiw, can be sandbox.iwiw.hu, approval.iwiw.hu or iwiw.hu
  * @param osapiHttpProvider $httpProvider custom provider if neeeded
  */
  public function __construct($baseURL = 'http://iwiw.hu', $baseApiURL = 'http://api.iwiw.hu', osapiHttpProvider $httpProvider = null) {
  	parent::__construct(
  	$baseApiURL.'/social/oauth/requestToken',
  	$baseURL.'/pages/auth/authorize.jsp' ,
  	$baseApiURL.'/social/oauth/accessToken',
  	$baseApiURL.'/social/connect/rest',
    '',
    'IWIW', 
  	true,
  	$httpProvider
  	);
  }
  
  
 /**
  * message type fix: iwiw supports only notification type messages
  *
  * @param  $request
  * @param  $method
  * @param  $url
  * @param  $headers
  * @param  $signer
  */ 
 public function preRequestProcess(osapiRequest &$request, &$method, &$url, &$headers, osapiAuth &$signer) {
    if ($request && $request->id == 'createMessage' && $request->params && $request->params['message']) {
    	$request->params['message']->type = 'notification';
    }
  }
}
