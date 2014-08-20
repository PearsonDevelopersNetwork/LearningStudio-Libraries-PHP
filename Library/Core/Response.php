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

/**
 * Core Response API
 * Setting the reponse for the API Calls
 * @author: Pradeep Patro <pradeep.patro@happiestminds.com>
 * @version: v1.0
 * @copyright: Pearson 2014
 * @package: Core
 * @since: 4th Jun 2014
 */
class Response {

  protected $method;
  protected $url;
  protected $content;
  protected $content_type;
  protected $is_binary;
  protected $status_code;
  protected $binaryContent;
  protected $status_message;
  protected $headers;

  /**
   * Accessor for methods
   * Get Method GET / POST / PUT / DELETE
   * @access public
   * @return string $this->method Returns the previously set method
   */
  public function getMethod () {
    return $this->method;
  }

  /**
   * Mutator for methods
   * Set Method GET / POST / PUT / DELETE
   * @access public
   * @return string $method Type of method
   */
  public function setMethod ($method) {
    $this->method = $method;
  }

  /**
   * Accessor for Headers
   * @access public
   * @return object $this->headers Response headers
   */
  public function getHeaders () {
    return $this->headers;
  }

  /**
   * Mutator for Headers
   * set all headers for the current request
   * @access public
   * @param object $headers
   */
  public function setHeaders ($headers) {
    $this->headers= $headers;
  }

  /**
   * Accessor for Url
   * @access public
   * @return $url : current url requested for
   */
  public function getUrl () {
    return $this->url;
  }

  /**
   * Mutator for Url
   * set the url for current request
   * @access public
   * @param string $url Url for current request
   */
  public function setUrl ($url) {
    $this->url = $url;
  }

  /**
   * Accessor for Content
   * @access public
   * @return $this->content Get the Output Content from API response
   */
  public function getContent () {
    return $this->content;
  }

  /**
   * Mutator for Content
   * Set the Output Content from API response
   * @access public
   * @param mixed $content Binary content from response
   */
  public function setContent ($content) {
    $this->is_binary = false;
    $this->content = $content;
  }

  /**
   * Accessor for content type
   * Get the Content Type as JSON/XML
   * @access public
   * @return string $content_type JSON / XML
   */
  public function getContentType () {
    return $this->content_type;
  }

  /**
   * Mutator for content type
   * Set the Content Type as JSON/XML
   * @access public
   * @param string $content_type JSON / XML
   */
  public function setContentType ($content_type) {
    $this->content_type = $content_type;
  }

  /**
   * Check the Content as Binary
   * @access public
   * @return boolean $is_binary indicator of binary content
   */
  public function isBinary () {
    return $this->is_binary;
  }

  /**
   * Indicates whether the content is binary. If so, it has been base64 encoded.
   * @access public
   * @return boolean $is_binary indicator of binary content
   */
  public function isBinaryContent () {
    return $this->is_binary;
  }

  /**
   * Accessor method for the binary content
   * @access public
   * @return $binaryContent	Binary content
   */
  public function getBinaryContent () {
    return $this->binaryContent;
  }

  /**
   * Mutator method for the binary content
   * @access public
   * @param boolean $binaryContent indicator of binaryContent
   */
  public function setBinaryContent ($binaryContent) {
    $this->is_binary = true;
    $this->binaryContent = $binaryContent;
  }

  /**
   * Accessor for Response code
   * Get the respnse code from the API
   */
  public function getStatusCode () {
    return $this->status_code;
  }

  /**
   * Mutator for Response Code
   * Set the respnse code from the API
   * @access public
   * @param integer $status_code Status Code of the response
   */
  public function setStatusCode ($status_code) {
    $this->status_code = $status_code;
  }

  /**
   * Accessor for status message
   * Get the Status Message from the API
   * @access public
   * @return string $status_message Status message
   */
  public function getStatusMessage () {
    return $this->status_message;
  }

  /**
   * Mutator for status message
   * Set the Status Message from the API
   * @access public
   * @param string $status_message Status message
   */
  public function setStatusMessage ($status_message) {
    $this->status_message = $status_message;
  }

  /**
   * Check the Respone Error from the API
   * @access public
   * @return boolean true/false
   */
  public function isError () {
    return ($this->status_code < 200 or $this->status_code >=300);
  }
}
