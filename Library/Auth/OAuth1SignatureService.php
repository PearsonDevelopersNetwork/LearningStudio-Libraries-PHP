<?php
/*
 * LearningStudio RESTful API Libraries 
 * These libraries make it easier to use the LearningStudio Course APIs.
 * Full Documentation is provided with the library. 
 * 
 * Need Help or Have Questions? 
 * Please use the PDN Developer Community at https://community.pdn.pearson.com
 *
 * @category   LearningStudio Course APIs
 * @author     Wes Williams <wes.williams@pearson.com>
 * @author     Pearson Developer Services Team <apisupport@pearson.com>
 * @copyright  2014 Pearson Education Inc.
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache 2.0
 * @version    1.0
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Auth;

use Auth\Request as OAuth1Request;
use CryptLib;

/**
 * Auth Service API
 * OAuth1 class which exposes method for generating OAuth1 Signature,
 * @author: Pradeep Patro <pradeep.patro@happiestminds.com>
 * @version: v1.0
 * @copyright: Pearson 2014
 * @package: Auth
 * @since: 12th Jun 2014
 */
class OAuth1SignatureService {
  CONST SIGNATURE_METHOD = "CMAC-AES";

  public $configuration;
  public $oAuthVariables = array();

  /**
   * Constructor for constructing an object of OAuth1SignatureService,
   * an object of @see OAuth1SignatureConfig needs to be passed as a parameter
   * @access public
   * @param object $configuration
   */
  public function __construct ($configuration) {
    $this->configuration = $configuration;
  }

  /**
   * Generate the Headers for OAUTH1 Request
   * @access public
   * @param string $method method of the request
   * @param string|null $url the URL of the request
   * @param string|null $body body of the request
   * @param string|null $api_route the  request URI
   * @return object $oauthRequest returns the @see OAuth1Request with populated OAuth1 headers set
   */
  public function generateOAuth1Request ($method, $url = NULL, $body = NULL, $api_route = NULL) {
    $oAuthVariables['application_id'] = $this->configuration->getApplicationId();
    $oAuthVariables['oauth_consumer_key'] = $this->configuration->getConsumerKey();
    $consumerSecret = $this->configuration->getConsumerSecret();
    $request_url = $url;
	if(empty($api_route)) $api_route = $url; 
    $oAuthVariables['oauth_nonce'] = self::getNonce();
    $oAuthVariables['oauth_signature_method'] = 'CMAC-AES';
    $oAuthVariables['oauth_timestamp'] = self::getTimestamp();
    $signature = self::generateSignature($method, $oAuthVariables, $body, $consumerSecret, $request_url, $api_route);
    $oAuthVariables['oauth_signature'] = $signature;
    list($url, $queryString) = array_pad(explode('?', $api_route, 2), 2, null);
    $header_vars = array('realm'=>$url);
    $header_vars = array_merge($header_vars, $oAuthVariables);
    $header_vars['oauth_signature'] = $signature;
    $header_parts = array();
    foreach ($header_vars as $k => $v) {
      $v = ($k=='realm') ? $v : urlencode($v);
      $header_parts[] = $k . '="' . $v . '"';
    }
    $oauthRequest = new OAuth1Request\OAuth1Request();
    $oauthRequest->setSignature($signature);
    $oauth_http_header = "X-Authorization: OAuth " . implode(',', $header_parts);
    $oauthRequest->setHeaders($oauth_http_header);
    return $oauthRequest;
  }

  /*
   * Generates a random nonce
   * @access private
   * @return string A unique identifier for the request
   */
  private function getNonce () {
    return md5(microtime());
  }

  /*
   * Generates an integer representing the number of seconds since the unix
   * epoch using the date/time the request is issued
   * @access private
   * @return integer A timestamp for the request
   */
  private function getTimestamp () {
    return time();
  }

  /**
   * Generate the Signature for OAUTH1 Request
   * @access protected
   * @param string $method HTTP methods
   * @param array $oAuthVariables Application Configuration array
   * @param string|null $post_body Curl Request Body
   * @param string $secret Consumer Secret key
   * @param string $request_url Curl Request URL
   * @param string $api_route API route.
   * @return string $signature OAUTH1 Signature
   */
  protected function generateSignature ($method, $oAuthVariables, $post_body=null, $secret, $request_url, $api_route) {
    require_once dirname(__FILE__) . '/Library/CryptLib/bootstrap.php';
    $encodable = array();
    if (($method == 'DELETE') || ($method == 'PUT')) {
      $api_route = $api_route;
    } else if($this->configuration->getApiRoute() != '') {
      $api_route = $this->configuration->getApiRoute();
    }
    list($encodingUrl, $queryString) = array_pad(explode('?', $api_route, 2), 2, null);
    $signable_string = $method . '&' . urlencode($encodingUrl) . '&';
    $StringParts = $oAuthVariables;
    if ($method=='POST' || $method=='PUT') {
      $StringParts['body'] = urlencode(base64_encode($post_body));
    }
    foreach ($StringParts as $key => $value) {
      $encodable[$key] = $value;
    }
    $queryStringArray = array();
    if (strlen($queryString) > 0) {
      if (strpos($queryString, "&")) {
        $queryStringSplitedArray = explode("&", $queryString);
      } else {
        $queryStringSplitedArray[] = $queryString;
      }
      foreach ($queryStringSplitedArray as $queryStringSplited) {
        list($queryKey, $queryValue) = explode("=", $queryStringSplited);
        $queryStringArray[$queryKey] = $queryValue;
      }
    }
    if (!empty($queryStringArray)) {
      foreach ($queryStringArray as $key => $value) {
        $encodable[$key] = $value;
      }
    }

    uksort($encodable, 'strcasecmp');
    $signable_string .= urlencode(http_build_query($encodable));
    // Get a Signature for the string. Signature is a CMAC-AES hash.
    $CMACEngine = new CryptLib\MAC\Implementation\CMAC;
    $packed_string = '';
    $stringlength = strlen($signable_string);
    for ($i = 0; $i < $stringlength; $i++) {
      $packed_string .= pack("c", ord(substr($signable_string, $i, 1)));
    }
    $binary_cmac = $CMACEngine->generate($packed_string, $secret);
    $signature = base64_encode($binary_cmac);
    return $signature;
  }
}
