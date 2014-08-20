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

namespace Auth\Request;

/**
 * Auth Service Request
 * Class with getter & setter method for OAuth2 Assertion & Password attributes
 * @author: Pradeep Patro <pradeep.patro@happiestminds.com>
 * @version: v1.0
 * @copyright: Pearson 2014
 * @package: Auth
 * @since: 12th Jun 2014
 */
class OAuth2Request{

  private $headers;
  private $accessToken;
  private $refreshToken;
  private $expiresInSeconds;
  private $creationTime;

  /**
   * Accessor method for the header values for an OAuth request
   * @access public
   * @return mixed $header KVP header values
   */
  public function getHeaders () {
    return $this->headers;
  }

  /**
   * Mutator method for the headers for the OAuth2 Request
   * @access public
   * @param mixed $headers KVP header values
   */
  public function setHeaders ($headers) {
    $this->headers = $headers;
  }

  /**
   * Accessor method for access token for request
   * @access public
   * @return string $accessToken Access token value
   */
  public function getAccessToken () {
    return $this->accessToken;
  }

  /**
   * Mutator method for access token for request
   * @access public
   * @param string $accessToken Access token value
   */
  public function setAccessToken ($accessToken) {
    $this->accessToken = $accessToken;
  }

  /**
   * Accessor method for refresh token for request
   * @access public
   * @return string $refreshToken Refresh token for request
   */
  public function getRefreshToken () {
    return $this->refreshToken;
  }

  /**
   * Mutator method for refresh token for request
   * @access public
   * @param string $refreshToken Refresh token for request
   */
  public function setRefreshToken ($refreshToken) {
    $this->refreshToken = $refreshToken;
  }

  /**
   * Accessor method for seconds until expiration
   * @access public
   * @return integer $expiresInSeconds Seconds until expiration
   */
  public function getExpiresInSeconds () {
    return $this->expiresInSeconds;
  }

  /**
   * Mutator method fors seconds until expiration
   * @access public
   * @param integer $expiresInSeconds Seconds until expiration
   */
  public function setExpiresInSeconds ($expiresInSeconds) {
    $this->expiresInSeconds = $expiresInSeconds;
  }

  /**
   * Accessor method for Creation time of request
   * @access public
   * @return integer $creationTime Seconds since epoch
   */
  public function getCreationTime () {
    return $this->creationTime;
  }

  /**
   * Mutator method for creation time of request
   * @access public
   * @param integer $creationTime Seconds since epoch
   */
  public function setCreationTime ($creationTime) {
    $this->creationTime = $creationTime;
  }

  /**
   * Accessor method for expiration time of request
   * @access public
   * @return integer Seconds since epoch
   */
  public function getExpirationTime () {
    if($this->creationTime == NULL || $this->expiresInSeconds == NULL) {
      return NULL;
    }
    return $this->creationTime + $this->expiresInSeconds;
  }
}
