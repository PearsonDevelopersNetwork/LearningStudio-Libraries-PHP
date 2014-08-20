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

use Auth\Config as OAuth1Config;
use Auth\Config as OAuth2Config;
use Auth as OAuth1Signature;
use Auth as OAuth2Assertion;

/**
 * This is a factory class which can be used for building objects of OAuth (OAuth1.0 or OAuth2.0). This class exposes
 * a build method which is used for creating respective OAuth objects.
 * @author: Pradeep Patro <pradeep.patro@happiestminds.com>
 * @version: v1.0
 * @copyright: Pearson 2014
 * @package: Auth
 * @since: 12th Jun 2014
 */
class OAuthServiceFactory {
  public $configuration;
  public $oauth1SignatureService;
  public $oauth2AssertionService;
  public $oauth2PasswordService;

  /**
   * Constructor which accepts an object of OAuthConfig with pre-populated required values of application_id, secret_key etc.
   * @param $configuration Object of OAuthConfig with populated values
   */
  public function __construct ($configuration) {
    $this->configuration = $configuration;
  }

  /**
   * Method which builds and returns an object of OAuth based on the name parameter passed,
   * the name parameter needs to be one of the following.
   * OAUTH1_SIGNATURE -> returns an object of OAuth1 (@see OAuth1SignatureService)
   * OAUTH2_ASSERTION -> returns an object of OAuth2 assertion (@see OAuth2AssertionService)
   * OAUTH2_PASSWORD -> returns an object of OAuth2 password (@see OAuth2PasswordService)
   * @access public
   * @param string $name needs to be one of the OAUTH1_SIGNATURE|OAUTH2_ASSERTION|OAUTH2_PASSWORD
   * @return object OAuth1SignatureService|OAuth2AssertionService|OAuth2PasswordService
   * returns one of the OAuth objects based on the passed name input parameter.
   */
  public function build ($name) {
    if ($name == "OAUTH1_SIGNATURE") {
      $config = new OAuth1Config\OAuth1SignatureConfig();
      $configuration = $this->configuration;
      $config->setApplicationId($configuration->getApplicationId());
      $config->setConsumerKey($configuration->getConsumerKey());
      $config->setConsumerSecret($configuration->getConsumerSecret());
      $config->setUrl($configuration->getUrl());
      $config->setApiRoute($configuration->getApiRoute());
      $config->setConsumerKey($configuration->getConsumerKey());
      $config->setConsumerSecret($configuration->getConsumerSecret());
      $this->oauth1SignatureService = new OAuth1Signature\OAuth1SignatureService($config);
      return $this->oauth1SignatureService;
    } else if ($name == "OAUTH2_ASSERTION") {
      $config = new OAuth2Config\OAuth2AssertionConfig();
      $configuration = $this->configuration;
      $config->setApplicationId($configuration->getApplicationId());
      $config->setApplicationName($configuration->getApplicationName());
      $config->setClientString($configuration->getClientString());
      $config->setConsumerKey($configuration->getConsumerKey());
      $config->setConsumerSecret($configuration->getConsumerSecret());
      $config->setUserName($configuration->getUserName());
      $this->oauth2AssertionService = new OAuth2Assertion\OAuth2AssertionService($config);
      return $this->oauth2AssertionService;
    } else if ($name == "OAUTH2_PASSWORD") {
      $config = new OAuth2Config\OAuth2PasswordConfig();
      $configuration = $this->configuration;
      $config->setApplicationId($configuration->getApplicationId());
      $config->setClientString($configuration->getClientString());
      $this->oauth2PasswordService = new OAuth2Assertion\OAuth2PasswordService($config);
      return $this->oauth2PasswordService;
    }
  }
}
