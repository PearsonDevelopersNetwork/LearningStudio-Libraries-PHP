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

namespace Core;
use Core as CoreResp;

/**
 * Core Service API
 * Base functionality of all services
 * @abstract
 * @author: Pradeep Patro <pradeep.patro@happiestminds.com>
 * @version: v1.0
 * @copyright: Pearson 2014
 * @package: Core
 * @since: 4th Jun 2014
 */
abstract class AbstractService {
  /**
   * @ignore
   */
  private static $API_DOMAIN = "https://api.learningstudio.com";
  private $PATH_SYSTEMDATETIME = "/systemDateTime";

  protected $_auth = NULL;
  public $_uri = NULL;
  public $oauthServiceFactory;
  public $oauthHeaders = array();
  public $dataFormat;
  public $dateFormat = 'D M d H:i:s Y';

  /**
   * @ignore The format that data is accepted and returned
   */
  public $DataFormat = array('json'=> 'json',
    'xml'=> 'xml'
  );

  /**
   * @ignore The Authenticaion Type
   */
  protected $AuthMethod = array('OAUTH1_SIGNATURE'=> 'OAUTH1_SIGNATURE',
    'OAUTH2_ASSERTION'=> 'OAUTH2_ASSERTION',
    'OAUTH2_PASSWORD'=> 'OAUTH2_PASSWORD'
  );

  /**
   * @ignore The HTTP Methods
   */
  protected $_httpMethods = array('GET'=> 'GET',
    'POST'=> 'POST',
    'PUT'=> 'PUT',
    'DELETE'=> 'DELETE'
  );

  /**
   * @ignore The HTTP Status/Response codes
   */
  public $_httpCode = array('OK'=> 200,
    'CREATED'=> 201,
    'NO_CONTENT'=> 204,
    'BAD_REQUEST'=> 400,
    'FORBIDDEN'=> 403,
    'NOT_FOUND'=> 404,
    'INTERNAL_ERROR'=> 500,
  );

  private $authMethod;
  private $username;
  private $password;
  private $currentOAuthRequest;
  private $oauthRequest;

  /**
   * Constructs an AbstractService
   * @access public
   * @param object $oauthServiceFactory Authentication Configuration
   */
  public function __construct ($oauthServiceFactory) {
    $this->oauthServiceFactory = $oauthServiceFactory;
    // Default Data Format as JSON
    $this->dataFormat = $this->DataFormat['json'];
  }

  /**
   * Return the Currernt Authenticaion
   * @access public
   * @return object $this->_auth Returns current authentication
   */
  public function getAuth () {
    return $this->_auth;
  }

  /**
   * @ignore Return the URI
   */
  public function _getUri () {
    return $this->_uri;
  }

  /**
   * GET Method
   * @access public
   * @param string $relativeUrl request url
   * @param string|null $body body for the request
   * @param array|null $extraHeaders Extra headers for request
   * @return object $response Response class object with details of status and content.
   */
  public function _doGet ($relativeUrl, $body = NULL, $extraHeaders = array()) {
    return $this->_doMethod('GET', $relativeUrl, $body, $extraHeaders);
  }

  /**
   * POST Method
   * @access public
   * @param string $relativeUrl request url
   * @param string|null $body body for the request
   * @param array|null $extraHeaders Extra headers for request
   * @return object $response Response class object with details of status and content.
   */
  public function _doPost ($relativeUrl, $body = NULL, $extraHeaders = array()) {
    return $this->_doMethod('POST', $relativeUrl, $body, $extraHeaders);
  }

  /**
   * PUT Method
   * @access public
   * @param string $relativeUrl request url
   * @param string|null $body body for the request
   * @param array|null $extraHeaders Extra headers for request
   * @return object $response Response class object with details of status and content.
   */
  public function _doPut ($relativeUrl, $body = NULL, $extraHeaders = array()) {
    return $this->_doMethod('PUT', $relativeUrl, $body, $extraHeaders);
  }

  /**
   * DELTE Method
   * @access public
   * @param string $relativeUrl request url
   * @param string|null $body body for the request
   * @param array|null $extraHeaders Extra headers for request
   * @return object $response Response class object with details of status and content.
   */
  public function _doDelete ($relativeUrl, $body = NULL, $extraHeaders = array()) {
    return $this->_doMethod('DELETE', $relativeUrl, $body, $extraHeaders);
  }

  /**
   * Common Method for all the METHODS like GET, POST, PUT and DELETE
   * @access public
   * @param string $relativeUrl request url
   * @param string|null $body body for the request
   * @param array|null $extraHeaders Extra headers for request
   * @return object $response Response class object with details of status and content.
   */
  public function _doMethod ($method, $relativeUrl, $body = NULL, $extraHeaders = NULL) {
    $httpUrl = '';
    $apiRoute = $relativeUrl;
    $httpResponseObject = NULL;
    $httpCode = 0;

    if ($body == NULL) {
      $body = "";
    }
    // Checking data format if JSON or XML
    if ($this->dataFormat == 'xml') {
      $queryString = "";
      $queryStringIndex = strpos($relativeUrl, '?');

      if ($queryStringIndex !== false) {
        $queryString = substr($relativeUrl, $queryStringIndex);
        $relativeUrl = substr($relativeUrl, 0, $queryStringIndex);
      }

      $compareUrl = strtolower($relativeUrl);

      if (!strrpos($compareUrl, ".xml")) {
        $relativeUrl .= ".xml";
      }

      if ($queryStringIndex != -1) {
        $relativeUrl .= $queryString;
      }

      $relativeUrl = self::$API_DOMAIN.$relativeUrl;
      $httpUrl = $relativeUrl;
    } else {
      $httpUrl = self::$API_DOMAIN.$relativeUrl;
    }

    $this->oauthHeaders = self::getOAuthHeaders($method, $httpUrl, $body, $apiRoute);
    if ($extraHeaders != NULL) {
      foreach ($extraHeaders as $key => $value) {
        array_push($this->oauthHeaders, $key.": ".$value);
      }
    }

    $httpRequestObject = curl_init();
    $httpRequestHeaders = $this->oauthHeaders;
    if ($method == 'POST' || $method == 'PUT') {
      @curl_setopt($httpRequestObject, CURLOPT_POSTFIELDS, $body);
      $contentLength = strlen($body);
      if ($this->dataFormat == 'xml') {
        array_push($httpRequestHeaders, "Content-Type: application/xml");
      } else {
        array_push($httpRequestHeaders, "Content-Type: application/json");
      }
      array_push($httpRequestHeaders, "Content-length: ".$contentLength);
    }

    array_push($httpRequestHeaders, "User-Agent: ".$this->getServiceIdentifier());

    @curl_setopt($httpRequestObject, CURLOPT_URL, $httpUrl);
    @curl_setopt($httpRequestObject, CURLOPT_RETURNTRANSFER, true);
    @curl_setopt($httpRequestObject, CURLOPT_CUSTOMREQUEST, $method);
    @curl_setopt($httpRequestObject, CURLOPT_HTTPHEADER, $httpRequestHeaders);
    @curl_setopt($httpRequestObject, CURLOPT_SSL_VERIFYPEER, false);

    try {
      $httpResponseObject = curl_exec($httpRequestObject);
      // Test if there was a cURL problem (request didn't go through)
      if (!$httpResponseObject) {
        $curlError = curl_error($httpRequestObject);
        if ($curlError) {
          throw new \Exception("There was a problem making the API Call. cURL problem: ".$curlError);
        }
      }

      $info = curl_getinfo($httpRequestObject);
      $httpCode = curl_getinfo($httpRequestObject, CURLINFO_HTTP_CODE);

      $responseDat = new CoreResp\Response();
      $responseDat->setMethod($method);
      $responseDat->setUrl($relativeUrl);

      if (strpos($info['content_type'], 'json') > 0) {
        $contentType = "json";
      } else if (strpos($info['content_type'], 'xml') > 0) {
        $contentType = "xml";
      } else {
        $contentType = $info['content_type'];
      }
      //if ($method == 'POST' || $method == 'PUT') {
      $responseDat->setContentType($contentType);
      if ( (substr($contentType,0,5)!='text/') && ($contentType != 'xml') && ($contentType != 'json') ) {
        if (strlen(trim($httpResponseObject)) == 0) {
          $tempByte = array(1, chr(1));
          $responseDat->setBinaryContent($tempByte);
        } else {
          $responseDat->setBinaryContent(base64_decode($httpResponseObject));
        }
      } else {
        $responseDat->setContent($httpResponseObject);
      }
      //}

      $responseDat->setStatusCode($httpCode);
      $responseDat->setStatusMessage($httpResponseObject);
      $responseDat->setHeaders(array($this->oauthHeaders));
      return $responseDat;
    } catch (\Exception $e) {
      throw new \Exception ($e->getMessage());
    }
    if ($httpResponseObject) {
      curl_close($httpRequestObject);
    }
  }

  /**
   * Get the System Date time
   * @access public
   * @return string $response return system date and time
   */
  public function getSystemDateTime () {
    return $this->_doGet($this->PATH_SYSTEMDATETIME);
  }

  /**
   * Get the System Date time in milli seconds
   * @access public
   * @return string
   */
  public function getSystemDateTimeMillis () {
    $response = $this->getSystemDateTime();

    $timeValue = NULL;
    $dateFormat = NULL;

    if ($this->dataFormat == $this->DataFormat['xml']) {
      $jsonResponse = json_decode($response->getContent(),true);
      $timeValue =  $jsonResponse['systemDateTime']['value'];
    } else {
      $jsonResponse = json_decode($response->getContent(),true);
      $timeValue =  $jsonResponse['systemDateTime']['value'];
    }
    date_default_timezone_set('UTC');
    $seconds = strtotime($timeValue);
    return date($this->dateFormat, $seconds);
  }

  /**
   * Get the headers
   * @access public
   * @param string $method GET/POST/PUT/DELETE method
   * @param string $url request url
   * @param string $body body for the request
   * @param string $apiRoute
   * @return object $this->oauthHeaders Authenticated Headers for a user type
   */
  public function getOAuthHeaders ($method, $url, $body, $apiRoute) {
    $defAuthMethod = $this->authMethod;

    if ($defAuthMethod == $this->AuthMethod['OAUTH1_SIGNATURE']) {
      $service = $this->oauthServiceFactory->build($defAuthMethod);

      $this->oauthRequest = $service->generateOAuth1Request($method, $url, $body, $apiRoute);
      $this->oauthHeaders = array($this->oauthRequest->getHeaders());
    } else {
      if ($this->currentOAuthRequest != NULL) {
        $currentMillis = round(microtime(true) * 1000);

        if ($currentMillis >= $this->currentOAuthRequest->getExpirationTime()) {
          error_log('Method: getOAuthHeaders From Abstract Service class ...Previous OAuth2 headers have expired');

          if ($defAuthMethod == $this->AuthMethod['OAUTH2_PASSWORD']) {
            error_log('Method: getOAuthHeaders From Abstract Service class ... Refreshing OAuth2 token');

            $service = $this->oauthServiceFactory->build($defAuthMethod);

            $refreshRequest = $service->currentOAuthRequest;
            $this->currentOAuthRequest = NULL;  // forget the previous oauth2 request

            // attempt to use the refresh token
            try {
              $oauthService = $this->oauthServiceFactory->build('OAUTH2_PASSWORD');
              $this->currentOAuthRequest = $oauthService->refreshOAuth2PasswordRequest($refreshRequest);
            }
            catch(\Exception $e) {
              error_log('Method: getOAuthHeaders From Abstract Service class ...Failed to refresh oauth2 token');
            }
          }
          else {
            $this->currentOAuthRequest = NULL; // forget the previous oauth2 request
          }
        }
      }

      if ($this->currentOAuthRequest != NULL) {
        $oauthHeaders = $this->currentOAuthRequest->getHeaders(); // use the current headers
        $this->oauthHeaders = array($oauthHeaders);
      } else {
        if ($defAuthMethod == $this->AuthMethod['OAUTH2_ASSERTION']) {
          $service = $this->oauthServiceFactory->build($defAuthMethod);
          $this->oauthRequest = $service->generateOAuth2AssertionRequest($this->username);
          $oauthHeaders = $this->oauthRequest->getHeaders();
          $this->oauthHeaders = array($oauthHeaders);
        } else if ($defAuthMethod==$this->AuthMethod['OAUTH2_PASSWORD']) {
          $service = $this->oauthServiceFactory->build($defAuthMethod);
          $this->oauthRequest = $service->generateOAuth2PasswordRequest($this->username,$this->password);
          $oauthHeaders = $this->oauthRequest->getHeaders();
          $this->oauthHeaders = array($oauthHeaders);
        }
      }
    }
    
    $this->currentOAuthRequest = $this->oauthRequest; // save the new oauth request
    return $this->oauthHeaders;
  }

  /**
   * Get DataFormat preferred by operations
   * @access public
   * @return DataFormat
   */
  public function getPreferredFormat () {
    return $this->dataFormat;
  }

  /**
   * Set DataFormat preferred by operations
   * @access public
   * @param string $dataFormat Data Format xml|json to be sent
   * @return null
   */
  public function setPreferredFormat ($dataFormat) {
    $this->dataFormat = $dataFormat;
  }

  /**
   * Makes all future request use OAuth1 security
   * @access public
   * @return null
   */
  public function useOAuth1 () {
    $this->authMethod = $this->AuthMethod['OAUTH1_SIGNATURE'];
    $this->username = NULL;
    $this->password = NULL;
    $this->currentOAuthRequest = NULL;
  }

  /**
   * Makes all future request use OAuth2 Assertion security
   * @access public
   * @return null
   */
  public function useOAuth2 ($userName, $password = NULL) {
    $this->username = $userName;
    $this->currentOAuthRequest = NULL;

    if ($password == NULL) {
      $this->authMethod = $this->AuthMethod['OAUTH2_ASSERTION'];
      $this->password = NULL;
    } else {
      $this->authMethod = $this->AuthMethod['OAUTH2_PASSWORD'];
      $this->password = $password;
    }
  }

  /**
   * unset all the variables
   * @access public
   * @return null
   */
  public function destroy() {
    $this->username = NULL;
    $this->password = NULL;
    $this->dataFormat = NULL;
    $this->authMethod = NULL;
    $this->oauthServiceFactory = NULL;
    $this->currentOAuthRequest = NULL;
  }
}
