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

namespace Content;
use Core as CoreLib;

/**
 * Content Service API
 * An implementation of ContentService for handling the Content Service API.
 * @author: Pradeep Patro <pradeep.patro@happiestminds.com>
 * @version: v1.0
 * @copyright: Pearson 2014
 * @package: Content
 * @since: 2 Jul 2014
 */
class ContentService extends CoreLib\BasicService {
  /**
   * @ignore
   * Path Constants
   * @access private
   */
  private $PATH_COURSES_ITEMS = '/courses/%s/items';
  private $PATH_COURSES_ITEMS_ = '/courses/%s/items/%s';
  private $PATH_COURSES_ITEMSHIERARCHY = "/courses/%s/itemHierarchy";
  private $PATH_COURSES_ITEMSHIERARCHY__EXPAND_ = "/courses/%s/itemHierarchy?expand=%s";
  private $PATH_USERS_COURSES_ITEMSHIERARCHY = "/users/%s/courses/%s/itemHierarchy";
  private $PATH_USERS_COURSES_ITEMSHIERARCHY__EXPAND_ = "/users/%s/courses/%s/itemHierarchy?expand=%s";
  private $PATH_USERS_COURSES_ITEMS = "/users/%s/courses/%s/items";
  private $PATH_COURSES_TEXTMULTIMEDIAS = '/courses/%s/textMultimedias';
  private $PATH_COURSES_TEXTMULTIMEDIAS__CONTENTPATH_ = '/courses/%s/textMultimedias/%s/%s';
  private $PATH_COURSES_TEXTMULTIMEDIAS__CONTENTPATH__USESOURCEDOMAIN = '/courses/%s/textMultimedias/%s/%s?useSourceDomain=true';
  private $PATH_COURSES_TEXTMULTIMEDIAS_ = '/courses/%s/textMultimedias/%s';
  private $PATH_COURSES_MSOFFICEDOCUMENTS = '/courses/%s/msOfficeDocuments';
  private $PATH_COURSES_MSOFFICEDOCUMENTS_ = '/courses/%s/msOfficeDocuments/%s';
  private $PATH_COURSES_MSOFFICEDOCUMENTS_ORIGINALDOCUMENT = '/courses/%s/msOfficeDocuments/%s/originalDocument';
  private $PATH_COURSES_MSOFFICEDOCUMENTS_CONTENT_ = '/courses/%s/msOfficeDocuments/%s/content/%s';
  private $PATH_COURSES_WEBCONTENTUPLOADS = '/courses/%s/webContentUploads';
  private $PATH_COURSES_WEBCONTENTUPLOADS_ = '/courses/%s/webContentUploads/%s';
  private $PATH_COURSES_WEBCONTENTUPLOADS_ORIGINALDOCUMENT = '/courses/%s/webContentUploads/%s/originalDocument';
  private $PATH_COURSES_WEBCONTENTUPLOADS_CONTENT_ = '/courses/%s/webContentUploads/%s/content/%s';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSEHIEARCHY = '/courses/%s/threadedDiscussions/%s/topics/%s/responseHierarchy';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEHIEARCHY = '/courses/%s/threadedDiscussions/%s/topics/%s/responses/%s/responseHierarchy';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_USERVIEWRESPONSES_USERVIEWRESPONSES = '/users/%s/courses/%s/threadedDiscussions/%s/topics/%s/userviewresponses/%s/userviewresponses';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_USERVIEWRESPONSES_USERVIEWRESPONSES__DEPTH = '/users/%s/courses/%s/threadedDiscussions/%s/topics/%s/userviewresponses/%s/userviewresponses?depth=%s';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_USERVIEWRESPONSES = '/users/%s/courses/%s/threadedDiscussions/%s/topics/%s/userviewresponses';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_USERVIEWRESPONSES__DEPTH = '/users/%s/courses/%s/threadedDiscussions/%s/topics/%s/userviewresponses?depth=%s';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSECOUNTS = '/users/%s/courses/%s/threadedDiscussions/%s/topics/%s/responses/%s/responseCounts';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSECOUNTS__DEPTH = '/users/%s/courses/%s/threadedDiscussions/%s/topics/%s/responses/%s/responseCounts?depth=%s';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSECOUNTS = '/users/%s/courses/%s/threadedDiscussions/%s/topics/%s/responseCounts';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSECOUNTS__DEPTH = '/users/%s/courses/%s/threadedDiscussions/%s/topics/%s/responseCounts?depth=%s';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEBRANCH = '/courses/%s/threadedDiscussions/%s/topics/%s/responses/%s/responseBranch';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEAUTHOR = '/courses/%s/threadedDiscussions/%s/topics/%s/responses/%s/responseAuthor';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEANDAUTHORCOMPS = '/courses/%s/threadeddiscussions/%s/topics/%s/responses/%s/responseAndAuthorComps';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEANDAUTHORCOMPS__DEPTH = '/courses/%s/threadedDiscussions/%s/topics/%s/responses/%s/responseAndAuthorComps?depth=%s';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSEANDAUTHORCOMPS = '/courses/%s/threadedDiscussions/%s/topics/%s/responseAndAuthorComps';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSEANDAUTHORCOMPS__DEPTH = '/courses/%s/threadedDiscussions/%s/topics/%s/responseAndAuthorComps?depth=%s';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS__LASTRESPONSE = '/users/%s/courses/%s/threadedDiscussions/lastResponse';
  private $PATH_COURSES_THREADEDDISCUSSIONS = '/courses/%s/threadedDiscussions';
  private $PATH_COURSES_THREADEDDISCUSSIONS__USESOURCEDOMAIN = '/courses/%s/threadedDiscussions?UseSourceDomain=true';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS = '/courses/%s/threadedDiscussions/%s/topics';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS__USESOURCEDOMAIN = '/courses/%s/threadedDiscussions/%s/topics?UseSourceDomain=true';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_ = '/courses/%s/threadedDiscussions/%s/topics/%s';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_USESOURCEDOMAIN = '/courses/%s/threadedDiscussions/%s/topics/%s?UseSourceDomain=true';
  private $PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSE_READSTATUS = '/users/%s/courses/%s/threadedDiscussions/%s/topics/%s/responses/%s/readStatus';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSES = '/courses/%s/threadedDiscussions/%s/topics/%s/responses/%s/responses';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_ = '/courses/%s/threadedDiscussions/%s/topics/%s/responses/%s';
  private $PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES = '/courses/%s/threadedDiscussions/%s/topics/%s/responses';

	/**
	 * Provides name of service for identification purposes
	 * 
	 * @return Unique identifier for service
	 */
	protected function getServiceIdentifier() {
		return "LS-Library-Content-PHP-V1";
	}
	
	
  /**
   * Get items for a course with
   * GET /courses/{$courseId}/items
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @return object Response object with details of status and content.
   */
  public function getItems ($courseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_ITEMS, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get a specific item for a course with
   * GET /courses/{$courseId}/items/{$itemId}
   * using OAuth1 or OAuth2.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $itemId ID of the item
   * @return object Response object with details of status and content.
   */
  public function getItem ($courseId, $itemId) {
    $relativeUrl = sprintf($this->PATH_COURSES_ITEMS_, $courseId, $itemId);
    return parent::_doGet($relativeUrl);
  }

	/**
	 * Get item hierarchy for a course with
	 * Get /courses/{courseId}/itemHierarchy?expand=item,item.access,item.schedule,item.group
	 * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator
	 * 
	 * @param $courseId	ID of the course
	 * @param $expandItems comma separated list of items to expand from: item,item.access,item.schedule,item.group
	 * @return	Response object with details of status and content
	 * @throws Exception
	 */
	
	public function getItemHierarchy($courseId, $expandItems = null ){ 
		
		if(is_null($expandItems)){ 
			$relativeUrl = sprintf($this->PATH_COURSES_ITEMSHIERARCHY,$courseId); 
		} else { 
			$relativeUrl = sprintf($this->PATH_COURSES_ITEMSHIERARCHY__EXPAND_, $courseId, $expandItems); 
		} 
		
		return parent::_doGet($relativeUrl); 
		
	} 
	
	/**
	 * Get item hierarchy for a course with
	 * Get /users/{userId}/courses/{courseId}/itemHierarchy?expand=item,item.access,item.schedule,item.group
	 * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or administrator
	 * 
	 * @param userId	ID of the user
	 * @param courseId	ID of the course
	 * @param $expandItems comma separated list of items to expand from: item,item.access,item.schedule,item.group
	 * @return	Response object with details of status and content
	 * @throws Exception
	 */

	public function getUserItemHierarchy($userId, $courseId, $expandItems = null ){ 
		
		if(is_null($expandItems)){ 
			$relativeUrl = sprintf($this->PATH_USERS_COURSES_ITEMSHIERARCHY,$userId,$courseId); 
		} else { 
			$relativeUrl = sprintf($this->PATH_USERS_COURSES_ITEMSHIERARCHY__EXPAND_, $courseId, $expandItems); 
		} 
		
		return parent::_doGet($relativeUrl); 
		
	} 
	
	/**
	 * Get items for a course with
	 * Get /courses/{courseId}/items
	 * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or administrator
	 * 
	 * @param $userId	ID of the user
	 * @param $courseId	ID of the course
	 * @return	Response object with details of status and content
	 * @throws IOException
	 */

	public function getUserItems($userId, $courseId){ 
		$relativeUrl = sprintf($this->PATH_USERS_COURSES_ITEMS, $userId, $courseId); 
		return parent::_doGet($relativeUrl); 
	} 


  /**
   * Get links details from a specific item for a course with
   * GET /courses/{$courseId}/items/{$itemId}
   * using OAuth2 as a student, teacher or teaching assistant.
   * Example JSON structure: (Multimedia item): 
   *   { "details": 
   *      { "access": {...}, 
   *        "schedule": {...}, 
   *        "self": {...},
   *        "selfType": "textMultimedias"
   *      }
   *   }
   * @access public
   * @param string $courseId ID of the course.
   * @param string $itemId ID of the item.
   * @return object Response object with details of status and content.
   */
  public function getItemLinkDetails ($courseId, $itemId) {
    $response = self::getItem($courseId, $itemId);
    if ($response->isError()) {
      return $response;
    }
    $courseItemsJson = $response->getContent();
    $jsonData = json_decode($courseItemsJson, true);
    $items = $jsonData['items'];
    $detail = array();
    if ($items != NULL && count($items) > 0) {
      foreach ($items as $item) {
        $links = $item['links'];
        foreach ($links as $link) {
          $relativeUrl = $this->_getRelativePath($link['href']);
          $response = parent::_doGet($relativeUrl);
          if ($response->isError()){
            return $response;
          }
          $linkElement = json_decode($response->getContent(), true);
          $title = array_key_exists('title', $link) ? $link['title'] : NULL;
          if ($title == NULL) {
            if ($linkElement != NULL && count($linkElement) > 0) {
              foreach ($linkElement as $key => $value) {
                $detail['self'] = $value;
                $detail['selfType'] = $key;
                break;
              }
            }
          } else {
            $linkElement = $linkElement[$title];
            $detail[$title] = $linkElement;
          }
        }
      }
      $detailWrapper = array('details'=> $detail);
      $response->setContent(json_encode($detailWrapper, true));
    } else {
      throw new \Exception('Unexpected condition in library: No items');
    }
    return $response;
  }

  /**
   * Get text multimedias by course with
   * GET /courses/{$courseId}/textMultimedias
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access public
   * @param string $courseId ID of the course.
   * @return object Response object with details of status and content.
   */
  public function getTextMultimedias ($courseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_TEXTMULTIMEDIAS, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get specific text multimedia content by course with
   * GET /courses/{$courseId}/textMultimedias
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $textMediaId ID of the text media.
   * @return object Response object with details of status and content.
   */
  public function getTextMultimedia ($courseId, $textMediaId) {
    $relativeUrl = sprintf($this->PATH_COURSES_TEXTMULTIMEDIAS_, $courseId, $textMediaId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get specific text multimedia content by course with UseSourceDomain parameter with
   * GET /courses/{$courseId}/textMultimedias and
   * GET /courses/{$courseId}/textMultimedias?UseSourceDomain=true
   * using OAuth2 as a student, teacher or teaching assistant
   * @param string $courseId ID of the course.
   * @param string $itemId ID of the item.
   * @param string $contentPath Path of content.
   * @param boolean|null $useSourceDomain Indicator of whether to include domain in urls.
   * @return object Response object with details of status and content.
   */
  public function getTextMultimediasContent ($courseId, $textMediaId, $contentPath = NULL, $useSourceDomain = NULL) {
	
	if(is_null($contentPath)){ 
		$response = $this->getTextMultimedia($courseId, $textMediaId); 
		if($response->isError()){ 
			return $response; 
		} 
		
		$json = json_decode($response->getContent(),true); 
		print_r($json);  
		$contentUrl = $json['textMultimedias'][0]['contentUrl']; 
	} else { 
      $contentUrl = sprintf($this->PATH_COURSES_TEXTMULTIMEDIAS__CONTENTPATH_, $courseId, $textMediaId, $contentPath);
	} 
	if($useSourceDomain){ 
		$contentUrl.="?useSourceDomain=true";
	} 
	
	$relativeUrl = $this->_getRelativePath($contentUrl); 
	echo $relativeUrl; 
	return parent::_doGet($relativeUrl); 
	    // 
	    // if ($useSourceDomain != NULL) {
	    //   return $this->_getTextMultimediasContent($courseId, $textMediaId, $contentPath, $useSourceDomain);
	    // } else {
	    //   $relativeUrl = sprintf($this->PATH_COURSES_TEXTMULTIMEDIAS__CONTENTPATH_, $courseId, $textMediaId, $contentPath);
	    //   return parent::_doGet($relativeUrl);
	    // }
  }

  /**
   * Get specific text multimedia content by course with UseSourceDomain parameter with
   * GET /courses/{$courseId}/textMultimedias and
   * GET /courses/{$courseId}/textMultimedias?UseSourceDomain=true
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access private
   * @param string $courseId ID of the course
   * @param string $itemId ID of the item.
   * @param string $contentPath Path of content.
   * @param boolean $useSourceDomain Indicator of whether to include domain in urls.
   * @return object Response object with details of status and content.
   */
  private function _getTextMultimediasContent ($courseId, $textMediaId, $contentPath, $useSourceDomain) {
    $path = ($useSourceDomain == true)
            ? $this->PATH_COURSES_TEXTMULTIMEDIAS__CONTENTPATH_
            : $this->PATH_COURSES_TEXTMULTIMEDIAS__CONTENTPATH_USESOURCEDOMAIN;
    $relativeUrl = sprintf($path, $courseId, $textMediaId, $contentPath);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get all MS Office documents in a course with
   * GET /courses/{$courseId}/msOfficeDocuments
   * using OAuth2 as a student, teacher or teaching assistant.
   * @param string $courseId ID of the course.
   * @return object Response object with details of status and content.
   */
  public function getMsOfficeDocuments ($courseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_MSOFFICEDOCUMENTS, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get a specific MS Office document in a course with
   * GET /courses/{$courseId}/msOfficeDocuments/{$msOfficeDocumentId}
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $msOfficeDocumentId ID of the ms office document.
   * @return object Response object with details of status and content.
   */
  public function getMsOfficeDocument ($courseId, $msOfficeDocumentId) {
    $relativeUrl = sprintf($this->PATH_COURSES_MSOFFICEDOCUMENTS_, $courseId, $msOfficeDocumentId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get content for a specific MS Office Document in a course with
   * GET /courses/{$courseId}/msOfficeDocuments/{$msOfficeDocumentId} and
   * GET /courses/{$courseId}/msOfficeDocuments/{$msOfficeDocumentId}/content/{contentPath}
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $msOfficeDocumentId ID of the ms office document.
   * @param string|null $contentPath Path of the content.
   * @return object Response object with details of status and content.
   */
  public function getMsOfficeDocumentContent ($courseId, $msOfficeDocumentId, $contentPath = NULL) {
    if ($contentPath != NULL) {
      return $this->_getMsOfficeDocumentContent($courseId, $msOfficeDocumentId, $contentPath);
    }
    $response = self::getMsOfficeDocument($courseId, $msOfficeDocumentId);
    if ($response->isError()) {
      return $response;
    }
    $jsonData = json_decode($response->getContent(), true);
    $jsonData = $jsonData['msOfficeDocuments'][0];
    $contentUrl = $jsonData['contentUrl'];
    $relativeUrl = $this->_getRelativePath($contentUrl);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get content for a specific MS Office Document in a course with
   * GET /courses/{$courseId}/msOfficeDocuments/{$msOfficeDocumentId} and
   * GET /courses/{$courseId}/msOfficeDocuments/{$msOfficeDocumentId}/content/{$contentPath}
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $msOfficeDocumentId ID of the ms office document.
   * @param string $contentPath Path of the content.
   * @return object Response object with details of status and content.
   */
  private function _getMsOfficeDocumentContent ($courseId, $msOfficeDocumentId, $contentPath) {
    $relativeUrl = sprintf($this->PATH_COURSES_MSOFFICEDOCUMENTS_CONTENT_, $courseId, $msOfficeDocumentId, $contentPath);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get the original of a specific MS Office document in a course with
   * GET /courses/{$courseId}/msOfficeDocuments/{$msOfficeDocumentId}/originalDocument
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $msOfficeDocumentId ID of the ms office document.
   * @return object Response object with details of status and content.
   */
  public function getMsOfficeDocumentOriginal ($courseId, $msOfficeDocumentId) {
    $relativeUrl = sprintf($this->PATH_COURSES_MSOFFICEDOCUMENTS_ORIGINALDOCUMENT, $courseId, $msOfficeDocumentId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get all web content uploads in a course with
   * GET /courses/{$courseId}/webContentUploads
   * using OAuth2 as a student, teacher or teaching assistant
   * @access public
   * @param string $courseId ID of the course.
   * @return object Response object with details of status and content.
   */
  public function getWebContentUploads ($courseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_WEBCONTENTUPLOADS, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get a specific MS Office document in a course with
   * GET /courses/{$courseId}/webContentUploads/{$webContentUploadId}
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $webContentUploadId ID of the ms office document.
   * @return object Response object with details of status and content.
   */
  public function getWebContentUpload ($courseId, $webContentUploadId) {
    $relativeUrl = sprintf($this->PATH_COURSES_WEBCONTENTUPLOADS_, $courseId, $webContentUploadId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get a specific MS Office document in a course with
   * GET /courses/{$courseId}/webContentUploads/{$webContentUploadId}
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $webContentUploadId ID of the ms office document.
   * @return object Response object with details of status and content.
   */
  public function getWebContentUploadOriginal ($courseId, $webContentUploadId) {
    $relativeUrl = sprintf($this->PATH_COURSES_WEBCONTENTUPLOADS_ORIGINALDOCUMENT, $courseId, $webContentUploadId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get content for a specific Web Content Upload in a course with
   * GET /courses/{$courseId}/webContentUpload/{$webContentUploadId} and
   * GET /courses/{$courseId}/webContentUpload/{$webContentUploadId}/content/{contentPath}
   * using OAuth2 as a student, teacher or teaching assistant.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $webContentUploadId ID of the web content upload.
   * @param string|null $contentPath Path of the content.
   * @return object Response object with details of status and content.
   */
  public function getWebContentUploadContent ($courseId, $webContentUploadId, $contentPath = NULL) {
    if ($contentPath != NULL) {
      return $this->_getWebContentUploadContent($courseId, $webContentUploadId, $contentPath);
    }
    $response = self::getWebContentUpload($courseId, $webContentUploadId);
    if ($response->isError()) {
      return $response;
    }
    $jsonData = json_decode($response->getContent(), true);
    $jsonData = $jsonData['webContentUploads'][0];
    $contentUrl = $jsonData['contentUrl'];
    $relativeUrl = $this->_getRelativePath($contentUrl);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get content for a specific Web Content Upload in a course with
   * GET /courses/{$courseId}/webContentUpload/{$webContentUploadId} and
   * GET /courses/{$courseId}/webContentUpload/{$webContentUploadId}/content/{contentPath}
   * using OAuth2 as a student, teacher or teaching assistant.
   * @param string $courseId ID of the course.
   * @param string $webContentUploadId ID of the web content upload.
   * @param string $contentPath Path of the content.
   * @return object Response object with details of status and content.
   */
  private function _getWebContentUploadContent ($courseId, $webContentUploadId, $contentPath) {
    $relativeUrl = sprintf($this->PATH_COURSES_WEBCONTENTUPLOADS_CONTENT_, $courseId, $webContentUploadId, $contentPath);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get hierarchy of a discussion thread response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/responseHierarchy
   * using OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the response.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionResponseHierarchy ($courseId, $threadId, $topicId, $responseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEHIEARCHY, $courseId, $threadId, $topicId, $responseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get all user's view statuses of a discussion thread response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/userviewresponses/{$responseId}/userviewresponses
   * using OAuth2 as a student.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the response.
   * @param integer|null $depth Number of levels to traverse.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionUserViewResponses ($userId, $courseId, $threadId, $topicId, $responseId, $depth = NULL) {
    if ($depth != NULL) {
      return $this->_getThreadedDiscussionUserViewResponses($userId, $courseId, $threadId, $topicId, $responseId, $depth);
    }
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_USERVIEWRESPONSES_USERVIEWRESPONSES,
                           $userId, $courseId, $threadId, $topicId, $responseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get all user's view statuses of a discussion thread response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/userviewresponses/{$responseId}/userviewresponses?depth={$depth}
   * using OAuth2 as a student.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the response.
   * @param integer $depth Number of levels to traverse.
   * @return object Response object with details of status and content.
   */
  private function _getThreadedDiscussionUserViewResponses ($userId, $courseId, $threadId, $topicId, $responseId, $depth) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_USERVIEWRESPONSES_USERVIEWRESPONSES__DEPTH,
                           $userId, $courseId, $threadId, $topicId, $responseId, $depth);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get all user's view statuses of a discussion thread topic with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/userviewresponses
   * using OAuth2 as a student.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param integer|null $depth Number of levels to traverse.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionTopicUserViewResponses ($userId, $courseId, $threadId, $topicId, $depth = NULL) {
    if ($depth != NULL) {
      return $this->_getThreadedDiscussionTopicUserViewResponses($userId, $courseId, $threadId, $topicId, $depth);
    }
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_USERVIEWRESPONSES, $userId, $courseId, $threadId, $topicId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get all user's view statuses of a discussion thread topic with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/userviewresponses?depth={$depth}
   * using OAuth2 as a student.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param int $depth Number of levels to traverse
   * @return object Response object with details of status and content.
   */
  private function _getThreadedDiscussionTopicUserViewResponses ($userId, $courseId, $threadId, $topicId, $depth) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_USERVIEWRESPONSES__DEPTH, $userId, $courseId, $threadId, $topicId, $depth);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get hierarchy of a discussion thread topic with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responseHierarchy
   * using OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the response.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionTopicHierarchy ($courseId, $threadId, $topicId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSEHIEARCHY, $courseId, $threadId, $topicId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get count of responses for a specific response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/responseCounts
   * using OAuth1 or OAuth2 as a student.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the response.
   * @param integer|null $depth Number of levels to traverse.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionResponseCount ($userId, $courseId, $threadId, $topicId, $responseId, $depth = NULL) {
    if ($depth != NULL) {
      return $this->_getThreadedDiscussionResponseCount($userId, $courseId, $threadId, $topicId, $responseId, $depth);
    }
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSECOUNTS, $userId, $courseId, $threadId, $topicId, $responseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get count of responses for a specific response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/responseCounts?depth={$depth}
   * using OAuth1 or OAuth2 as a student.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the $response.
   * @param integer $depth Number of levels to traverse.
   * @return object Response object with details of status and content.
   */
  private function _getThreadedDiscussionResponseCount ($userId, $courseId, $threadId, $topicId, $responseId, $depth) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSECOUNTS__DEPTH,
                           $userId, $courseId, $threadId, $topicId, $responseId, $depth);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get count of responses for a specific topic with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responseCounts
   * using OAuth1 or OAuth2 as a student.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param integer|null $depth Number of levels to traverse.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionTopicResponseCount ($userId, $courseId, $threadId, $topicId, $depth = NULL) {
    if ($depth != NULL) {
      return $this->_getThreadedDiscussionTopicResponseCount($userId, $courseId, $threadId, $topicId, $depth);
    }
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSECOUNTS, $userId, $courseId, $threadId, $topicId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get count of responses for a specific topic with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responseCounts?depth={$depth}
   * using OAuth1 or OAuth2 as a student.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param integer $depth Number of levels to traverse.
   * @return object Response object with details of status and content.
   */
  private function _getThreadedDiscussionTopicResponseCount ($userId, $courseId, $threadId, $topicId, $depth) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSECOUNTS__DEPTH, $userId, $courseId, $threadId, $topicId, $depth);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get branch hierarchy to a discussion thread response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/responseBranch
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the response
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionResponseBranch ($courseId, $threadId, $topicId, $responseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEBRANCH, $courseId, $threadId, $topicId, $responseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get author of a discussion thread response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/responseAuthor
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic
   * @param string $responseId ID of the response.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionResponseAuthor ($courseId, $threadId, $topicId, $responseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEAUTHOR, $courseId, $threadId, $topicId, $responseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get response and author composite of a discussion thread response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/responseAndAuthorComps
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the response.
   * @param integer|null $depth Number of levels to traverse.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionResponseAndAuthorComposite ($courseId, $threadId, $topicId, $responseId, $depth = NULL) {
    if ($depth != NULL) {
      return $this->_getThreadedDiscussionResponseAndAuthorComposite($courseId, $threadId, $topicId, $responseId, $depth);
    }
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEANDAUTHORCOMPS, $courseId, $threadId, $topicId, $responseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get response and author composite for a discussion thread response at a specified depth with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/responseAndAuthorComps?depth={depth}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the response.
   * @param integer $depth Max depth to traverse.
   * @return object Response object with details of status and content.
   */
  private function _getThreadedDiscussionResponseAndAuthorComposite ($courseId, $threadId, $topicId, $responseId, $depth) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSEANDAUTHORCOMPS__DEPTH, $courseId, $threadId, $topicId, $responseId, $depth);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get response and author composite for a discussion thread topic with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responseAndAuthorComps/{$responseId}/responseAndAuthorComps
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param integer|null $depth Number of levels to traverse.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionTopicResponseAndAuthorComposite ($courseId, $threadId, $topicId, $depth = NULL) {
    if ($depth != NULL) {
      return $this->_getThreadedDiscussionTopicResponseAndAuthorComposite($courseId, $threadId, $topicId, $depth);
    }
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSEANDAUTHORCOMPS, $courseId, $threadId, $topicId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get response and author composite of a discussion thread topic at a specified depth with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responseAndAuthorComps/{$responseId}/responseAndAuthorComps?depth={depth}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param integer $depth Max depth to traverse
   * @return object Response object with details of status and content.
   */
  private function _getThreadedDiscussionTopicResponseAndAuthorComposite ($courseId, $threadId, $topicId, $depth) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSEANDAUTHORCOMPS__DEPTH, $courseId, $threadId, $topicId, $depth);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get a user's last threaded discussion response in a course with
   * GET /users/{$userId}/courses/{$courseId}/threadeddiscussions/lastResponse
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @return object Response object with details of status and content.
   */
  public function getLastThreadedDiscussionResponse ($userId, $courseId) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS__LASTRESPONSE, $userId, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get threaded dicussions for a course with
   * GET /courses/{$courseId}/threadeddiscussions
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param boolean|null $useSourceDomain Indicator of whether to use the source domain in links.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussions ($courseId, $useSourceDomain = NULL) {
    if ($useSourceDomain == true) {
      return $this->_getThreadedDiscussions($courseId);
    }
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get threaded dicussions for a course with
   * GET /courses/{$courseId}/threadeddiscussions?UseSourceDomain={useSourceDomain}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access private
   * @param string $courseId ID of the course.
   * @return object Response object with details of status and content.
   */
  private function _getThreadedDiscussions ($courseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS__USESOURCEDOMAIN, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get threaded dicussion topics for a course with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param boolean|null $useSourceDomain Indicator of whether to use the source domain in links.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionTopics ($courseId, $threadId, $useSourceDomain = NULL) {
    if ($useSourceDomain == true) {
      return $this->_getThreadedDiscussionTopics($courseId, $threadId);
    }
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS, $courseId, $threadId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get threaded dicussion topics for a course with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics?UseSourceDomain={useSourceDomain}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @return object Response object with details of status and content.
   */
  private function _getThreadedDiscussionTopics ($courseId, $threadId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS__USESOURCEDOMAIN, $courseId, $threadId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get threaded dicussion topics for a course with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param boolean|null $useSourceDomain Indicator of whether to use the source domain in links.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionTopic ($courseId, $threadId, $topicId, $useSourceDomain = NULL) {
    if ($useSourceDomain == true) {
      return $this->_getThreadedDiscussionTopic($courseId, $threadId, $topicId);
    }
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_, $courseId, $threadId, $topicId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get threaded dicussion topics for a course with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}?UseSourceDomain={useSourceDomain}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param boolean $useSourceDomain Indicator of whether to use the source domain in links.
   * @return object Response object with details of status and content.
   */
  private function _getThreadedDiscussionTopic ($courseId, $threadId, $topicId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_USESOURCEDOMAIN, $courseId, $threadId, $topicId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get read status of a user's discussion thread response with
   * GET /users/{$userId}/courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/readStatus
   * using OAuth1 or OAuth2 as a student.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the $response.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionResponseReadStatus ($userId, $courseId, $threadId, $topicId, $responseId) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSE_READSTATUS, $userId, $courseId, $threadId, $topicId, $responseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get read status of a user's discussion thread response with
   * PUT /users/{$userId}/courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/readStatus
   * using OAuth1 or OAuth2 as a student.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the $response.
   * @param string $readStatus Read status Message.
   * @return object Response object with details of status and content.
   */
  public function updateThreadedDiscussionResponseReadStatus ($userId, $courseId, $threadId, $topicId, $responseId, $readStatus) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSE_READSTATUS,
                           $userId, $courseId, $threadId, $topicId, $responseId);
    return parent::_doPut($relativeUrl, $readStatus);
  }

  /**
   * Get responses to a specific discussion thread response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/responses
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the response.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionResponses ($courseId, $threadId, $topicId, $responseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSES, $courseId, $threadId, $topicId, $responseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Create a $response to a specific discussion thread response with
   * POST /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}/responses
   * using OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string|null $responseId ID of the $response.
   * @param string|null $responseMessage Response message to create.
   * @return object Response object with details of status and content.
   */
  public function createThreadedDiscussionResponse ($courseId, $threadId, $topicId, $responseId = NULL, $responseMessage = "") {
    if ($responseId == NULL) {
      return $this->_createThreadedDiscussionResponse($courseId, $threadId, $topicId, $responseMessage);
    }
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_RESPONSES, $courseId, $threadId, $topicId, $responseId);
    return parent::_doPost($relativeUrl, $responseMessage);
  }

  /**
   * Create a response to a specific discussion thread topic with
   * POST /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses
   * using OAuth2 as a student, teacher, teaching assistant or admin.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseMessage Response message to create.
   * @return object Response object with details of status and content.
   */
  private function _createThreadedDiscussionResponse ($courseId, $threadId, $topicId, $responseMessage) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES, $courseId, $threadId, $topicId);
    return parent::_doPost($relativeUrl, $responseMessage);
  }

  /**
   * Update a response to a specific discussion thread response with
   * PUT /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}
   * using OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseID ID of the $response.
   * @param string $responseMessage Response message to create.
   * @return object Response object with details of status and content.
   */
  public function updateThreadedDiscussionResponse ($courseId, $threadId, $topicId, $responseId, $responseMessage) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_, $courseId, $threadId, $topicId, $responseId);
    return parent::_doPut($relativeUrl, $responseMessage);
  }

  /**
   * Get a specific discussion thread response with
   * GET /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}
   * using OAuth2 as a student, teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseId ID of the $response.
   * @param string $responseMessage Response message to create.
   * @return object Response object with details of status and content.
   */
  public function getThreadedDiscussionResponse ($courseId, $threadId, $topicId, $responseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_, $courseId, $threadId, $topicId, $responseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Delete a specific discussion thread response with
   * DELETE /courses/{$courseId}/threadeddiscussions/{$threadId}/topics/{$topicId}/responses/{$responseId}
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or admin.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $threadId ID of the thread.
   * @param string $topicId ID of the topic.
   * @param string $responseID ID of the $response.
   * @param string $responseMessage Response message to create.
   * @return object Response object with details of status and content.
   */
  public function deleteThreadedDiscussionResponse ($courseId, $threadId, $topicId, $responseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_THREADEDDISCUSSIONS_TOPICS_RESPONSES_, $courseId, $threadId, $topicId, $responseId);
    return parent::_doDelete($relativeUrl);
  }

	/**
	 * Get content for a specific item in a course with
	 * getItem(courseId, itemId)
	 * by following the links to the item itself
	 * and next to the contentUrl
	 * using OAuth1 or OAuth2 as a student, teacher, or teaching assistant
	 * 
	 * @param $courseId	ID of the course
	 * @param $itemId	ID of the item
	 * @return	Response object with details of status and content
	 * @throws IOException
	 */

  public function getItemContent($courseId, $itemId){ 
	$response = $this->getItem($courseId,$itemId); 
	if($response->isError()){
		return $response; 
	} 
	
	$courseItemsJson = $response->getContent(); 
	$json = json_decode($courseItemsJson,true); 
	$item = $json['items'][0];
	$links = $item['links']; 

	foreach($links as $link){ 
		//rel on link varies, so identify self by missing title
		if(!isset($link['title'])){ 
			$relativeUrl = $this->_getRelativePath($link['href']); 
			$response = parent::_doGet($relativeUrl); 
			if($response->isError()){ 
				return $response; 
			} 
			$json = json_decode($response->getContent(),true); 
			$keys = array_keys($json); 
			$itemKey = $keys[0]; 
			$contentUrl = $json[$itemKey][0]['contentUrl']; 
			$relativeUrl = $this->_getRelativePath($contentUrl); 
			$response = parent::_doGet($relativeUrl); 
			return $response; 
		} 
	} 
	
	// should never get here
	throw new \Exception("No item content path found"); 
	
	
  } 



  /**
   * @ignore
   */
  private function _getRelativePath ($url) {
    $relativeUrl = "";
    $uriArray = parse_url($url);
    if (array_key_exists('path', $uriArray)) {
      $relativeUrl .= $uriArray['path'];
    }
    if (array_key_exists('query', $uriArray)) {
      $relativeUrl .= '?' . $uriArray['query'];
    }
    if (array_key_exists('fragment', $uriArray)) {
      $relativeUrl .= '#' . $uriArray['fragment'];
    }
    return $relativeUrl;
  }
}
