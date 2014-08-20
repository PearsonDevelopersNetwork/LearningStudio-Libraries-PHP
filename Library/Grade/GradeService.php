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

namespace Grade;
use Core as CoreLib;

/**
 * Grade Service API
 * An implementation of GradeService for handling the Grade Service API.
 * @author: Pradeep Patro <pradeep.patro@happiestminds.com>
 * @version: v1.0
 * @copyright: Pearson 2014
 * @package: Grade
 * @since: 23 Jun 2014
 */
class GradeService extends CoreLib\BasicService {
  /**
   * @ignore
   * Path Constants
   * @access private
   */
  private $PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES = '/courses/%s/gradebook/customCategories';
  private $PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_ = '/courses/%s/gradebook/customCategories/%s';
  private $PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_CUSTOMITEMS = '/courses/%s/gradebook/customCategories/%s/customItems';
  private $PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_CUSTOMITEMS_ = '/courses/%s/gradebook/customCategories/%s/customItems/%s';
  private $PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_CUSTOMITEMS_GRADEBOOKITEM = '/courses/%s/gradebook/customCategories/%s/customItems/%s/gradebookItem';
  private $PATH_COURSES_GRADEBOOKITEMS = '/courses/%s/gradebookItems';
  private $PATH_COURSES_GRADEBOOKITEMS_ = '/courses/%s/gradebookItems/%s';
  private $PATH_COURSES_GRADEBOOK__GRADEBOOKITEMS_ = '/courses/%s/gradebook/gradebookItems/%s';
  private $PATH_COURSES_GRADEBOOKITEMS_GRADES = '/courses/%s/gradebookItems/%s/grades';
  private $PATH_COURSES_GRADEBOOKITEMS_GRADES_ = '/courses/%s/gradebookItems/%s/grades/%s';
  private $PATH_USERS_COURSES_GRADEBOOKITEMS_GRADE = '/users/%s/courses/%s/gradebookItems/%s/grade';
  private $PATH_USERS_COURSES_USERGRADEBOOKITEMS = '/users/%s/courses/%s/userGradebookItems';
  private $PATH_USERS_COURSES_USERGRADEBOOKITEMS__EXPANDGRADE = '/users/%s/courses/%s/userGradebookItems?expand=grade';
  private $PATH_USERS_COURSES_USERGRADEBOOKITEMS__USESOURCEDOMAIN = '/users/%s/courses/%s/userGradebookItems?UseSourceDomain=true';
  private $PATH_USERS_COURSES_USERGRADEBOOKITEMS__USESOURCEDOMAIN_EXPANDGRADE = '/users/%s/courses/%s/userGradebookItems?UseSourceDomain=true&expand=grade';
  private $PATH_USERS_COURSES_GRADEBOOK__GRADEBOOKITEMS_GRADE = '/users/%s/courses/%s/gradebook/gradebookItems/%s/grade';
  private $PATH_USERS_COURSES_GRADEBOOK__GRADEBOOKITEMS_GRADE__USESOURCEDOMAIN = '/users/%s/courses/%s/gradebook/gradebookItems/%s/grade?UseSourceDomain=true';
  private $PATH_USERS_COURSES_GRADEBOOK__GRADEBOOKITEMS = '/users/%s/courses/%s/gradebook/gradebookItems';
  private $PATH_USERS_COURSES_COURSEGRADETODATE = '/users/%s/courses/%s/coursegradetodate';
  private $PATH_COURSES_GRADEBOOK__ROSTERCOURSEGRADESTODATE__STUDENTIDS_ = '/courses/%s/gradebook/rostercoursegradestodate?Student.ID=%s';
  private $PATH_COURSES_GRADEBOOK__ROSTERCOURSEGRADESTODATE__OFFSET_LIMIT_ = '/courses/%s/gradebook/rostercoursegradestodate?offset=%s&limit=%s';
  private $PATH_COURSES_GRADEBOOK__ROSTERCOURSEGRADESTODATE__STUDENTIDS_OFFSET_LIMIT_ = '/courses/%s/gradebook/rostercoursegradestodate?Student.ID=%s&offset=%s&limit=%s';
  private $PATH_USERS_COURSES_GRADEBOOK__USERGRADEBOOKITEMS = '/users/%s/courses/%s/gradebook/userGradebookItems';
  private $PATH_USERS_COURSES_GRADEBOOK__USERGRADEBOOKITEMS_ = '/users/%s/courses/%s/gradebook/userGradebookItems/%s';
  private $PATH_USERS_COURSES_GRADEBOOK__USERGRADEBOOKITEMS_EXPANDGRADE = '/users/%s/courses/%s/gradebook/userGradebookItems/%s?expand=grade';
  private $PATH_USERS_COURSES_GRADEBOOK__USERGRADEBOOKITEMSTOTAL = '/users/%s/courses/%s/gradebook/userGradebookItemsTotals';

  /**
   * @ignore
   */
  protected $HttpStatusCode = array('OK' => 200,
    'CREATED' => 201,
    'NO_CONTENT' => 204,
    'BAD_REQUEST' => 400,
    'FORBIDDEN' => 403,
    'NOT_FOUND' => 404,
    'INTERNAL_ERROR' => 500,
  );

	/**
	 * Provides name of service for identification purposes
	 * 
	 * @return Unique identifier for service
	 */
	protected function getServiceIdentifier() {
		return "LS-Library-Grade-PHP-V1";
	}
  /**
   * Create custom category and item with
   * POST /courses/{$courseId}/gradebook/customCategories
   * POST /courses/{$courseId}/gradebook/customCategories/{$customCategoryId}/customItems
   * using OAuth1 or OAuth2 as a teacher, teaching assistance or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $customCategory Custom category to create.
   * @param string $customItem Custom item to create.
   * @throws Exception If creation of gradebook category and item fails
   * @return object $response Response class object with details of status and content.
   */
  public function createCustomGradebookCategoryAndItem ($courseId, $customCategory, $customItem) {
    $response = $this->createCustomGradebookCategory($courseId, $customCategory);
    if ($response->isError()) {
      return $response;
    }
    $customCategoryObject = json_decode($response->getContent(), true);
    $customCategoryObject = $customCategoryObject['customCategory'];
    $customCategoryId = $customCategoryObject['guid'];
    $response = $this->createCustomGradebookItem($courseId, $customCategoryId, $customItem);
    if ($response->isError()) {
      return $response;
    }
    $customItemObject = json_decode($response->getContent(), true);
    $customItemObject = $customItemObject['customItem'];
    $wrapper = array('customCategory' => $customCategoryObject,
      'customItem' => $customItemObject
    );
    // Deep encoding of response
    $returnContent = json_encode($wrapper, true);
    $response->setContent($returnContent);
    return $response;
  }

  /**
   * Create custom gradebook category for a course with
   * POST /courses/{$courseId}/gradebook/customCategories
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $customCategory Custom category to create.
   * @return object $response Response class object with details of status and content.
   */
  public function createCustomGradebookCategory ($courseId, $customCategory) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES, $courseId);
    return parent::_doPost($relativeUrl, $customCategory);
  }

  /**
   * Update custom gradebook category for a course with
   * PUT /courses/{$courseId}/gradebook/customCategories/{$customCategoryId}
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $customCategoryId ID of the custom category.
   * @param string $customCategory Custom category to create.
   * @return object $response Response class object with details of status and content.
   */
  public function updateCustomGradebookCategory ($courseId, $customCategoryId, $customCategory) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_, $courseId, $customCategoryId);
    return parent::_doPut($relativeUrl, $customCategory);
  }

  /**
   * Delete custom gradebook category for a course with
   * DELETE /courses/{$courseId}/gradebook/customCategories/{$customCategoryId}
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $customCategoryId ID of the custom category.
   * @return object $response Response class object with details of status and content.
   */
  public function deleteCustomGradebookCategory ($courseId, $customCategoryId) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_, $courseId, $customCategoryId);
    return parent::_doDelete($relativeUrl);
  }

  /**
   * Get custom gradebook category for a course with
   * GET /courses/{$courseId}/gradebook/customCategories/{$customCategoryId}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $customCategoryId ID of the custom category.
   * @return object $response Response class object with details of status and content.
   */
  public function getCustomGradebookCategory ($courseId, $customCategoryId) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_, $courseId, $customCategoryId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Create custom gradebook item in a custom category for a course with
   * POST /courses/{$courseId}/gradebook/customCategories/{$customCategoryId}/customItems
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $customCategoryId ID of the custom category.
   * @param string $customItem Custom item to create.
   * @return object $response Response class object with details of status and content.
   */
  public function createCustomGradebookItem ($courseId, $customCategoryId, $customItem) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_CUSTOMITEMS, $courseId, $customCategoryId);
    return parent::_doPost($relativeUrl, $customItem);
  }

  /**
   * Delete custom gradebook item in a custom category for a course with
   * DELETE /courses/{$courseId}/gradebook/customCategories/{$customCategoryId}/customItems/{$customItemId}
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $customCategoryId ID of the custom category.
   * @param string $customItemId ID of the custom item.
   * @return object $response Response class object with details of status and content.
   */
  public function deleteCustomGradebookItem ($courseId, $customCategoryId, $customItemId) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_CUSTOMITEMS_, $courseId, $customCategoryId, $customItemId);
    return parent::_doDelete($relativeUrl);
  }

  /**
   * Get custom item in a custom gradebook category for a course with
   * GET /courses/{$courseId}/gradebook/customCategories/{$customCategoryId}/customItems/{$customItemId}
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $customCategoryId ID of the custom category.
   * @param string $customItemId ID of the custom item.
   * @return object $response Response class object with details of status and content.
   */
  public function getGradebookCustomItem ($courseId, $customCategoryId, $customItemId) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_CUSTOMITEMS_, $courseId, $customCategoryId, $customItemId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get custom gradebook item in a custom category for a course with
   * GET /courses/{$courseId}/gradebook/customCategories/{$customCategoryId}/customItems/{$customItemId}
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $customCategoryId ID of the custom category.
   * @param string $customItemId ID of the custom item.
   * @return object $response Response class object with details of status and content.
   */
  public function getCustomGradebookItem ($courseId, $customCategoryId, $customItemId) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_CUSTOMITEMS_GRADEBOOKITEM, $courseId, $customCategoryId, $customItemId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get gradebook items for a course with
   * GET /courses/{$courseId}/gradebookItems
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @return object $response Response class object with details of status and content.
   */
  public function getGradebookItems ($courseId) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOKITEMS, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get specific gradebook item for a course with
   * GET /courses/{$courseId}/gradebookItems/{$gradebookItemId}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @return object $response Response class object with details of status and content.
   */
  public function getGradebookItem ($courseId, $gradebookItemId) {
        $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOKITEMS_, $courseId, $gradebookItemId);
        return parent::_doGet($relativeUrl);
  }

  /**
   * Create specific gradebook item for a course with
   * POST /courses/{$courseId}/gradebook/gradebookItems/{$gradebookItemId}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param string $gradebookItem Details of gradebook item.
   * @return object $response Response class object with details of status and content.
   * @deprecated Not Working!!!
   */
  public function createGradebookItem ($courseId, $gradebookItemId, $gradebookItem) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__GRADEBOOKITEMS_, $courseId, $gradebookItemId);
    $extraHeaders = array('X-METHOD-OVERRIDE' => 'PUT');
    return parent::_doPost($relativeUrl, $gradebookItem, $extraHeaders);
  }

  /**
   * Update specific gradebook item for a course with
   * PUT /courses/{$courseId}/gradebook/gradebookItems/{$gradebookItemId}
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param string $gradebookItem Details of gradebook item.
   * @return object $response Response class object with details of status and content.
   */
  public function updateGradebookItem ($courseId, $gradebookItemId, $gradebookItem) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__GRADEBOOKITEMS_, $courseId, $gradebookItemId);
    return parent::_doPut($relativeUrl, $gradebookItem);
  }

  /**
   * Get grades for specific gradebook item in a course with
   * GET /courses/{$courseId}/gradebookItems/{$gradebookItemId}/grades
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param string|null $gradedStudentIds IDs of graded students. (semicolon separated)
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @param bool|null $expandUser Indicator of whether to expand user info.
   * @return object $response Response class object with details of status and content.
   */
  public function getGradebookItemGrades ($courseId, $gradebookItemId,
                                          $gradedStudentIds = NULL,
                                          $useSourceDomain = NULL,
                                          $expandUser = NULL) {
    if ($useSourceDomain != NULL) {
      return $this->_getGradebookItemGrades ($courseId, $gradebookItemId,
                                             $gradedStudentIds, $useSourceDomain,
                                             $expandUser);
    } else {
      $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOKITEMS_GRADES, $courseId, $gradebookItemId);
      return parent::_doGet($relativeUrl);
    }
  }

  /**
   * Get grades for specific gradebook item in a course using parameters with
   * GET /courses/{$courseId}/gradebookItems/{$gradebookItemId}/grades?gradedStudents={$gradedStudentIds}&useSourceDomains=true&expand=user
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param string|null $gradedStudentIds IDs of graded students. (semicolon separated)
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @param bool|null $expandUser Indicator of whether to expand user info.
   * @return object $response Response class object with details of status and content.
   */
  private function _getGradebookItemGrades ($courseId, $gradebookItemId,
                                            $gradedStudentIds, $useSourceDomain,
                                            $expandUser) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOKITEMS_GRADES, $courseId, $gradebookItemId);
    if ($gradedStudentIds != NULL && $useSourceDomain != NULL && $expandUser != NULL) {
      $relativeParamsArray = array();
      $relativeParamsArray['gradedStudents'] = $gradedStudentIds;

      if ($useSourceDomain) {
        $relativeParamsArray['UseSourceDomain'] = 'true';
      }

      if ($expandUser) {
        $relativeParamsArray['expand'] = 'user';
      }

      $relativeUrl .= '?'.http_build_query($relativeParamsArray);
    }
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get specific grade for an item in a course with
   * GET /courses/{$courseId}/gradebookItems/{$gradebookItemId}/grades/{$gradeId}
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param string|null $gradedStudentIds IDs of graded students. (semicolon separated)
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @param bool|null $expandUser Indicator of whether to expand user info.
   * @return object $response Response class object with details of status and content.
   */
  public function getGradebookItemGrade ($courseId, $gradebookItemId, $gradeId,
                                         $gradedStudentIds = NULL,
                                         $useSourceDomain = NULL,
                                         $expandUser = NULL) {
    if ($useSourceDomain != NULL) {
      return $this->_getGradebookItemGrade ($courseId, $gradebookItemId,
                                            $gradeId, $gradedStudentIds,
                                            $useSourceDomain, $expandUser);
    } else {
      $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOKITEMS_GRADES_, $courseId, $gradebookItemId, $gradeId);
      return parent::_doGet($relativeUrl);
    }
  }

  /**
   * Get specific grade for an item in a course with
   * GET /courses/{$courseId}/gradebookItems/{$gradebookItemId}/grades/{$gradeId}?gradedStudents={$gradedStudentIds}&useSourceDomains=true&expand=user
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access private
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param string|null $gradedStudentIds IDs of graded students. (semicolon separated)
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @param bool|null $expandUser Indicator of whether to expand user info.
   * @return object $response Response class object with details of status and content.
   */
  private function _getGradebookItemGrade ($courseId, $gradebookItemId, $gradeId,
                                           $gradedStudentIds, $useSourceDomain,
                                           $expandUser) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOKITEMS_GRADES_, $courseId, $gradebookItemId, $gradeId);
    $relativeParamsArray = array();
    if ($gradedStudentIds != NULL) {
      $relativeParamsArray['gradedStudents'] = $gradedStudentIds;
    }

    if ($useSourceDomain != NULL) {
      $relativeParamsArray['UseSourceDomain'] = 'true';
    }

    if ($expandUser != NULL) {
      $relativeParamsArray['expand'] = 'user';
    }

    if (!empty($relativeParamsArray)) {
      $relativeUrl .= '?'.http_build_query($relativeParamsArray);
    }

    return parent::_doGet($relativeUrl);
  }

  /**
   * Create user's grade for an item in a course with
   * POST /users/{$userId}/courses/{$courseId}/gradebookItems/{$gradebookItemId}/grade
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param string $grade Grade content to be created
   * @return object $response Response class object with details of status and content.
   */
  public function createGradebookItemGrade ($userId, $courseId, $gradebookItemId, $grade) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOKITEMS_GRADE, $userId, $courseId, $gradebookItemId);
    return parent::_doPost($relativeUrl, $grade);
  }
  
  /**
   * Update user's grade for an item in a course with
   * PUT /users/{$userId}/courses/{$courseId}/gradebookItems/{$gradebookItemId}/grade
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param string $grade Grade content to be created
   * @return object $response Response class object with details of status and content.
   */
  public function updateGradebookItemGrade ($userId, $courseId, $gradebookItemId, $grade) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOKITEMS_GRADE, $userId, $courseId, $gradebookItemId);
    return parent::_doPut($relativeUrl, $grade);
  }

  /**
   * Delete user's grade for an item in a course with
   * DELETE /users/{$userId}/courses/{$courseId}/gradebookItems/{$gradebookItemId}/grade
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param string $grade Grade content to be created
   * @return object $response Response class object with details of status and content.
   */
  public function deleteGradebookItemGrade ($userId, $courseId, $gradebookItemId) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOKITEMS_GRADE, $userId, $courseId, $gradebookItemId);
    return parent::_doDelete($relativeUrl);
  }

  /**
   * Get gradebook items for a user in a course with
   * GET /users/{userId}/courses/{courseId}/userGradebookItems
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @param bool|null $expandUser Indicator of whether to expand user info.
   * @return object $response Response class object with details of status and content.
   */
  public function getUserGradebookItems ($userId, $courseId,
                                         $useSourceDomain = NULL,
                                         $expandGrade = NULL) {
    if ($useSourceDomain != NULL) {
      return $this->_getUserGradebookItems($userId, $courseId, $useSourceDomain, $expandGrade);
    } else {
      $relativeUrl = sprintf($this->PATH_USERS_COURSES_USERGRADEBOOKITEMS, $userId, $courseId);
      return parent::_doGet($relativeUrl);
    }
  }

  /**
   * Get gradebook items for a user in a course with
   * GET /users/{$userId}/courses/{$courseId}/userGradebookItems
   * with optional useSourceDomain and expand parameters
   * using OAuth1 or OAuth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @param bool|null $expandUser Indicator of whether to expand user info.
   * @return object $response Response class object with details of status and content.
   */
  private function _getUserGradebookItems ($userId, $courseId, $useSourceDomain, $expandGrade) {
    $path = $this->PATH_USERS_COURSES_USERGRADEBOOKITEMS;
    if ($useSourceDomain != NULL || $expandGrade != NULL) {
      if ($useSourceDomain != NULL && $expandGrade != NULL) {
        $path = $this->PATH_USERS_COURSES_USERGRADEBOOKITEMS__USESOURCEDOMAIN_EXPANDGRADE;
      } else if ($useSourceDomain != NULL) {
        $path = $this->PATH_USERS_COURSES_USERGRADEBOOKITEMS__USESOURCEDOMAIN;
      } else {
        $path = $this->PATH_USERS_COURSES_USERGRADEBOOKITEMS__EXPANDGRADE;
      }
    }
    $relativeUrl = sprintf($path, $userId, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Create a user's grade for an item in a course with
   * POST /users/{$userId}/courses/{$courseId}/gradebook/gradebookItems/{$gradebookItemId}/grade
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @param bool|null $expandUser Indicator of whether to expand user info.
   * @return object $response Response class object with details of status and content.
   */
  public function createGrade ($userId, $courseId, $gradebookItemId, $grade) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOK__GRADEBOOKITEMS_GRADE, $userId, $courseId, $gradebookItemId);
    return parent::_doPost($relativeUrl, $grade);
  }

  /**
   * Update a user's grade for an item in a course with
   * PUT /users/{$userId}/courses/{$courseId}/gradebook/gradebookItems/{$gradebookItemId}/grade
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @param bool|null $expandUser Indicator of whether to expand user info.
   * @return object $response Response class object with details of status and content.
   */
  public function updateGrade ($userId, $courseId, $gradebookItemId, $grade) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOK__GRADEBOOKITEMS_GRADE, $userId, $courseId, $gradebookItemId);
    return parent::_doPut($relativeUrl, $grade);
  }

  /**
   * Delete a user's grade for an item in a course with
   * DELETE /users/{$userId}/courses/{$courseId}/gradebook/gradebookItems/{$gradebookItemId}/grade
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @param bool|null $expandUser Indicator of whether to expand user info.
   * @return object $response Response class object with details of status and content.
   */
  public function deleteGrade ($userId, $courseId, $gradebookItemId) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOK__GRADEBOOKITEMS_GRADE, $userId, $courseId, $gradebookItemId);
    return parent::_doDelete($relativeUrl);
  }

  /**
   * Get a user's grade for an item in a course with
   * GET /users/{$userId}/courses/{$courseId}/gradebook/gradebookItems/{$gradebookItemId}/grade
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param bool|null $useSourceDomain Indicator of whether to include domains in urls.
   * @return object $response Response class object with details of status and content.
   */
  public function getGrade ($userId, $courseId, $gradebookItemId, $useSourceDomain = NULL) {
    if ($useSourceDomain != NULL) {
      return $this->_getGrade($userId, $courseId, $gradebookItemId, $useSourceDomain);
    } else {
      $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOK__GRADEBOOKITEMS_GRADE, $userId, $courseId, $gradebookItemId);
      return parent::_doGet($relativeUrl);
    }
  }

  /**
   * Get a user's grade for an item in a course with override for useSourceDomain with
   * GET /users/{userId}/courses/{courseId}/gradebook/gradebookItems/{gradebookItemId}/grade
   * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator.
   * @access private
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param string $gradebookItemId ID of the gradebook item.
   * @param bool $useSourceDomain Indicator of whether to include domains in urls.
   * @return object $response Response class object with details of status and content.
   */
  private function _getGrade ($userId, $courseId, $gradebookItemId, $useSourceDomain) {
    $path = ($useSourceDomain != NULL)
            ? $this->PATH_USERS_COURSES_GRADEBOOK__GRADEBOOKITEMS_GRADE__USESOURCEDOMAIN
            : $this->PATH_USERS_COURSES_GRADEBOOK__GRADEBOOKITEMS_GRADE
            ;
    $relativeUrl = sprintf($path, $userId, $courseId, $gradebookItemId);
    return parent::_doGet($relativeUrl);
  }

	/**
	 * Get a user's grades for a course with
	 * GET /users/{userId}/courses/{courseId}/gradebook/userGradebookItems
	 * and getGrade(String userId, String courseId, String gradebookItemId, boolean useSourceDomain)
	 * using OAuth1 or OAuth2 as a teacher, teaching assistant or administrator
	 * 
	 * @param string $userId ID of the user
	 * @param string $courseId ID of the course
	 * @param boolean $useSourceDomain Indicator of whether to include domain in urls
	 * @return	Response object with details of status and content
	 * @throws IOException
	 */
  public function getGrades ($userId, $courseId,$useSourceDomain = NULL) {
	
	$response = $this->getCourseGradebookUserItems($userId,$courseId); 
    if ($response->isError()) {
      return $response;
    }

	$grades = array(); 
	
	$gradebookitems = json_decode($response->getContent(), true); 
		
	foreach($gradebookitems['userGradebookItems'] as $item){ 
		$gradebookItemId = $item['gradebookItem']['id']; 
		$gradeResponse = $this->getGrade($userId,$courseId,$gradebookItemId,$useSourceDomain); 
		if($gradeResponse->isError()){ 
			//grades for all items might not exist. That's ok. 
			if($gradeResponse->getStatusCode()==$this->HttpStatusCode['NOT_FOUND']){ 
				continue; 
			} 
			return $gradeResponse; 
		} 
		$grade = json_decode($gradeResponse->getContent(),true); 
		$grades[] = $grade['grade']; 
	} 
	
	$newGrades = array('grades'=>$grades); 
	$response->setContent(json_encode(array('grades'=>$grades))); 
	return $response; 
  }

  /**
   * Get a user's current grades for a course with
   * GET /users/{$userId}/courses/{$courseId}/coursegradetodate
   * using OAuth1 or Auth2 as a student, teacher, teaching assistant or administrator.
   * @access private
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @return object $response Response class object with details of status and content.
   */
  public function getCurrentGrade ($userId, $courseId) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_COURSEGRADETODATE, $userId, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get current grades for all students in a course with
   * GET /courses/{$courseId}/gradebook/rostercoursegradestodate?offset={$offset}&limit={$limit}
   * using OAuth1 or Auth2 as a teacher, teaching assistant or administrator.
   * @access public
   * @param string $courseId ID of course.
   * @param string|null $studentIds Comma-separated list of students to filter.
   * @param integer|null $offset Offset position
   * @param integer|null $limit Limitation on count of records.
   * @return object $response Response class object with details of status and content.
   */
  public function getCurrentGrades ($courseId, $studentIds = NULL, $offset = NULL, $limit = NULL) {
    if ($offset == NULL) {
      return $this->_getCurrentGradesWithoutOffset($courseId, $studentIds);
    } else if ($studentIds != NULL) {
      return $this->_getCurrentGrades($courseId, $studentIds, $offset, $limit);
    } else {
      $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__ROSTERCOURSEGRADESTODATE__OFFSET_LIMIT_, $courseId, (String)$offset, (String)$limit);
      return parent::_doGet($relativeUrl);
    }
  }

  /**
   * Get current grades for specific students in a course with
   * GET /courses/{$courseId}/gradebook/rostercoursegradestodate?Student.ID={$studentIds}&offset={$offset}&limit={$limit}
   * using OAuth1 or Auth2 as a teacher, teaching assistant or administrator.
   * @access private
   * @param string $courseId ID of course.
   * @param string $studentIds Comma-separated list of students to filter.
   * @param integer $offset Offset position
   * @param integer $limit Limitation on count of records.
   * @return object $response Response class object with details of status and content.
   */
  private function _getCurrentGrades ($courseId, $studentIds, $offset, $limit) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__ROSTERCOURSEGRADESTODATE__STUDENTIDS_OFFSET_LIMIT_, $courseId, $studentIds);
    return  parent::_doGet($relativeUrl);
  }

  /**
   * Get current grades for specific students in a course with
   * GET /courses/{courseId}/gradebook/rostercoursegradestodate?Student.ID={studentIds}
   * using OAuth1 or Auth2 as a teacher, teaching assistant or administrator.
   * @access private
   * @param string $courseId ID of course.
   * @param string $studentIds Comma-separated list of students to filter.
   * @return object $response Response class object with details of status and content.
   */
  private function _getCurrentGradesWithoutOffset ($courseId, $studentIds) {
    $relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__ROSTERCOURSEGRADESTODATE__STUDENTIDS_, $courseId, $studentIds);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get user gradebook items in a course gradebook with
   * GET /users/{$userId}/courses/{$courseId}/gradebook/userGradebookItems
   * using OAuth1 or Auth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of course.
   * @return object $response Response class object with details of status and content.
   */
  public function getCourseGradebookUserItems ($userId, $courseId) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOK__USERGRADEBOOKITEMS, $userId, $courseId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get user gradebook item in a course gradebook by user gradebook item id with
   * GET /users/{$userId}/courses/{$courseId}/gradebook/userGradebookItems/{$userGradebookItemId}
   * using OAuth1 or Auth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param string $userGradebookItemId concatenation of {$userId}-{$gradebookItemGuid}.
   * @param bool $expandGrade Flag of whether to expand grade data.
   * @return object $response Response class object with details of status and content.
   */
  public function getCourseGradebookUserItem ($userId, $courseId, $userGradebookItemId, $expandGrade = NULL) {
    if ($expandGrade != NULL && $expandGrade) {
      return $this->_getCourseGradebookUserItem ($userId, $courseId, $userGradebookItemId, $expandGrade);
    } else {
      $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOK__USERGRADEBOOKITEMS_, $userId, $courseId, $userGradebookItemId);
      return parent::_doGet($relativeUrl);
    }
  }

  /**
   * Get user gradebook item in a course gradebook by user gradebook item id with
   * GET /users/{$userId}/courses/{$courseId}/gradebook/userGradebookItems/{$userGradebookItem}
   * or GET /users/{$userId}/courses/{$courseId}/gradebook/userGradebookItems/{$userGradebookItem}?expandGrade=true
   * using OAuth1 or Auth2 as a student, teacher, teaching assistant or administrator.
   * @access private
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @param string $userGradebookItemId concatenation of {$userId}-{$gradebookItemGuid}.
   * @param bool $expandGrade Flag of whether to expand grade data.
   * @return object $response Response class object with details of status and content.
   */
  private function _getCourseGradebookUserItem ($userId, $courseId, $userGradebookItemId, $expandGrade) {
    $path = ($expandGrade)
            ? $this->PATH_USERS_COURSES_GRADEBOOK__USERGRADEBOOKITEMS_EXPANDGRADE
            : $this->PATH_USERS_COURSES_GRADEBOOK__USERGRADEBOOKITEMS_
            ;
    $relativeUrl = sprintf($path, $userId, $courseId, $userGradebookItemId);
    return parent::_doGet($relativeUrl);
  }

  /**
   * Get summary of points available to a student in a course with
   * GET /users/{$userId}/courses/{$courseId}/gradebook/userGradebookItemsTotals
   * using OAuth1 or Auth2 as a student, teacher, teaching assistant or administrator.
   * @access public
   * @param string $userId ID of the user.
   * @param string $courseId ID of the course.
   * @return object $response Response class object with details of status and content.
   */
  public function getTotalPointsAvailable ($userId, $courseId) {
    $relativeUrl = sprintf($this->PATH_USERS_COURSES_GRADEBOOK__USERGRADEBOOKITEMSTOTAL, $userId, $courseId);
    return parent::_doGet($relativeUrl);
  }

	/**
	 * Get custom categories in a course's gradebook with
	 * GET /courses/{courseId}/gradebook/customCategories
	 * using OAuth1 or Auth2 as a teacher, teaching assistant or administrator
	 * 
	 * @param $courseId ID of the course
	 * @return	Response object with details of status and content
	 * @throws Exception
	 */
	public function getCustomGradebookCategories($courseId){ 
		$relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES, $courseId); 
		return parent::_doGet($relativeUrl); 
	} 
	
	/**
	 * Get custom items in a custom category of a course's gradebook with
	 * GET /courses/{courseId}/gradebook/customCategories/{customCategoryId}/customItems
	 * using OAuth1 or Auth2 as a teacher, teaching assistant or administrator
	 * 
	 * @param $courseId	ID of the course
	 * @param $customCategoryId	ID of a custom category
	 * @return	Response object with details of status and content
	 * @throws IOException
	 */
	public function getCustomGradebookItems($courseId, $customCategoryId){ 
		$relativeUrl = sprintf($this->PATH_COURSES_GRADEBOOK__CUSTOMCATEGORIES_CUSTOMITEMS, $courseId, $customCategoryId); 
		return parent::_doGet($relativeUrl); 
	} 
}
