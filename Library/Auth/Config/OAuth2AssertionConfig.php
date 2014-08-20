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

namespace Auth\Config;

/**
 * Auth Service Config
 * OAuth 2 Assertion Config functionality to store and retrieve applicationId,
 * applicationName, clientString, consumerKey, consumerSecret, requestUrl, userName
 * @author: Pradeep Patro <pradeep.patro@happiestminds.com>
 * @version: v1.0
 * @copyright: Pearson 2014
 * @package: Auth
 * @since: 12th Jun 2014
 */
class OAuth2AssertionConfig {

  private $applicationId;
  private $applicationName;
  private $clientString;
  private $consumerKey;
  private $consumerSecret;
  private $userName;

  /**
   * Accessor method for application id
   * @access public
   * @return string $applicationId ID for Application
   */
  public function getApplicationId () {
    return $this->applicationId;
  }

  /**
   * Mutator method for application id
   * @access public
   * @param string $applicationId application id value to be set
   */
  public function setApplicationId ($applicationId) {
    $this->applicationId = $applicationId;
  }

  /**
   * Accessor method for application name
   * @access public
   * @return string $applicationName Name for Application
   */
  public function getApplicationName () {
    return $this->applicationName;
  }

  /**
   * Mutator method for application name
   * @access public
   * @param string $applicationName application name value to be set
   */
  public function setApplicationName ($applicationName) {
    $this->applicationName = $applicationName;
  }

  /**
   * Accessor method for client String
   * @access public
   * @return string $clientString Client String Value
   */
  public function getClientString () {
    return $this->clientString;
  }

  /**
   * Mutator method for client String
   * @access public
   * @param string $clientString Client String value to be set
   */
  public function setClientString ($clientString) {
    $this->clientString = $clientString;
  }

  /**
   * Accessor method for consumer key
   * @access public
   * @return string $consumerKey Consumer Key
   */
  public function getConsumerKey () {
    return $this->consumerKey;
  }

  /**
   * Mutator method for consumer key
   * @access public
   * @param string $consumerKey consumer key to be set
   */
  public function setConsumerKey ($consumerKey) {
    $this->consumerKey = $consumerKey;
  }

  /**
   * Accessor method for consumer secret
   * @access public
   * @return string $consumerSecret Consumer secret 
   */
  public function getConsumerSecret () {
    return $this->consumerSecret;
  }

  /**
   * Mutator method for consumer secret
   * @access public
   * @param string $consumerSecret consumer secret value to be set
   */
  public function setConsumerSecret ($consumerSecret) {
    $this->consumerSecret = $consumerSecret;
  }

  /**
   * Accessor method for user name
   * @access public
   * @return string $userName User name
   */
  public function getUserName () {
    return $this->userName;
  }

  /**
   * Mutator method for user name
   * @access public
   * @param string $userName user name to be set
   */
  public function setUserName ($userName) {
    $this->userName = $userName;
  }
}
