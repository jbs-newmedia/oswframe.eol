<?php
/**
 * TokenHandler.php
 *
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */

/**
 * Http handler that returns the csrf request token.
 *
 * @package MOXMAN_Handlers
 */
class MOXMAN_Handlers_TokenHandler implements MOXMAN_Http_IHandler {
	/**
	 * Process a request using the specified context.
	 *
	 * @param MOXMAN_Http_Context $httpContext Context instance to pass to use for the handler.
	 */
	public function processRequest(MOXMAN_Http_Context $httpContext) {
		$request = $httpContext->getRequest();
		$response = $httpContext->getResponse();

		$response->disableCache();
		$response->setHeader('Content-type', 'application/json');

		if ($request->getMethod() != 'POST') {
			throw new MOXMAN_Exception("Not a HTTP post request.");
		}

		$response->sendJson((object) array(
			"token" => MOXMAN_Http_Csrf::createToken(MOXMAN::getConfig()->get('general.license'))
		));
	}
}

?>