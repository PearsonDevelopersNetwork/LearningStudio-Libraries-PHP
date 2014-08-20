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

use Auth\Request as OAuth2Request;
use CryptLib;

/**
 * Auth Service API
 * Class which expose method to generate the OAUTH2 Assertion Service
 * @author: Pradeep Patro <pradeep.patro@happiestminds.com>
 * @version: v1.0
 * @copyright: Pearson 2014
 * @package: Auth
 * @since: 12th Jun 2014
 */
class OAuth2AssertionService {
  CONST API_DOMAIN = "https://api.learningstudio.com";
  public $configuration;
  public $oAuthVariables = array();
  private $grantType = "assertion";
  private $assertionType = "urn:ecollege:names:moauth:1.0:assertion";

  /**
   * Constructor to create an object of @see OAuth2AssertionService.
   * @access public
   * @param object $configuration an object of @see OAuth2AssertionConfig is passed as an input parameter
   */
  public function __construct ($configuration) {
    $this->configuration = $configuration;
  }

  /**
   * Method which generates an OAuth2 assertion request.
   * @param string $userName username of the request
   * @return mixed oauthRequest returns an object @see OAuth2Request with populated token values.
   */
  public function generateOAuth2AssertionRequest ($userName) {
    $application_id = $this->configuration->getApplicationId();
    $application_name = $this->configuration->getApplicationName();
    $key_moniker = $this->configuration->getConsumerKey();
    $client_string = $this->configuration->getClientString();
    $secret_key = $this->configuration->getConsumerSecret();

    //Instantiate the CMAC-generating class
    require_once dirname(__FILE__) . '/Library/CryptLib/bootstrap.php';
    $eCMAC = new CryptLib\MAC\Implementation\ECollegeCMAC;
    $timestamp = str_replace('+00:00','Z', gmdate('c')); //This format is important
    //Set up variables needed to make the request of the API
    $url = self::API_DOMAIN . "/token";
    $grantType = "assertion";
    $assertionType = "urn:ecollege:names:moauth:1.0:assertion";

    //Assemble the Assertion string following this pattern (see documentation for details)
    $assertion = $application_name . "|" . $key_moniker . "|" . $application_id . "|" . $client_string . "|" . $userName . "|" . $timestamp;
    // Now get the CMAC hash of the assertion (the signature)
    try {
      //Pass Assertion and Key to the generate method.
      //This assumes the Assertion string has NOT been binary encoded. This method will pack() the
      //string for you, hash it, and then bin2hex it.
      $cmac = $eCMAC->generateECollegeCMAC($assertion,$secret_key);
      //$cmac is now equal to something like 989d5631fc2a4cd831ba84e6c7d39478
    } catch(\Exception $e) {
      throw new \Exception ($e->getMessage());
    }
    //Append the signature hash to the Assertion
    $assertion .= '|'.$cmac;
    //Set up the body of the POST request
    $post_fields = http_build_query(array("grant_type" => $grantType,
        "assertion_type" => $assertionType,
        "assertion" => $assertion
      )
    );
    $creationTime = round(microtime(true) * 1000);
    // 	Use cURL to make the request
    $httpResponseObject = NULL;
    $httpRequestObject = curl_init();
    curl_setopt($httpRequestObject, CURLOPT_URL, $url);
    curl_setopt($httpRequestObject, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($httpRequestObject, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($httpRequestObject, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($httpRequestObject, CURLOPT_SSL_VERIFYPEER, false);

    try {
      // Execute & get variables
      $httpResponseObject = curl_exec($httpRequestObject);
      if (!$httpResponseObject) {
        $curlError = curl_error($httpRequestObject);
        if ($curlError) {
          throw new \Exception("There was a problem making the API Call. cURL problem: $curlError");
        }
      }
      $http_code = curl_getinfo($httpRequestObject, CURLINFO_HTTP_CODE);
      if (intval($http_code / 100) >= 4) {
        $decoded_response = json_decode($httpResponseObject);
        $msg = (is_object($decoded_response) && isset($decoded_response->error->message)) ? $decoded_response->error->message : "No message reported.";
        throw new \Exception("The API Server responded with ".$http_code.". Message was: $msg");
        // Else you have a successful response.
      } else {
        $decoded_response = json_decode($httpResponseObject);
        $access_token = $decoded_response->access_token;
        $expires_in = $decoded_response->expires_in; // seconds
      }
    } catch(\Exception $e) {
      throw new \Exception ($e->getMessage());
    }
    if ($httpResponseObject != NULL) {
      curl_close($httpRequestObject);
    }

    $oauthRequest = new OAuth2Request\OAuth2Request();
    $oauthRequest->setAccessToken($access_token);
    $oauthRequest->setExpiresInSeconds($expires_in);
    $oauthRequest->setCreationTime($creationTime);
    $oauth_http_header = "X-Authorization: Access_Token access_token=" . $access_token;
    $oauthRequest->setHeaders($oauth_http_header);
    return $oauthRequest;
  }
}
