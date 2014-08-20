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

require_once dirname(__FILE__) . '/SplClassLoader.php';

$classLoader = new SplClassLoader('Auth', dirname(__FILE__));
$classLoader->register();

$classLoaderCore = new SplClassLoader('Core', dirname(__FILE__));
$classLoaderCore->register();

$classLoaderGrade = new SplClassLoader('Grade', dirname(__FILE__));
$classLoaderGrade->register();

$classLoaderExams = new SplClassLoader('Exams', dirname(__FILE__));
$classLoaderExams->register();

$classLoaderContent = new SplClassLoader('Content', dirname(__FILE__));
$classLoaderContent->register();

$classLoaderHelloWorld = new SplClassLoader('HelloWorld', dirname(__FILE__));
$classLoaderHelloWorld->register();
