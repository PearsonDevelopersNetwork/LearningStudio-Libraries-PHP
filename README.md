# The Learning Studio Libraries

The LearningStudio Libraries make working with the RESTful Course APIs easier. There are five libraries in all - two for basic functionality and three that streamline our more complex and common domains. 

The full documentation is available in the \Documentation folder of this package. The main user guide describes the various functionality and use cases, but you can also skip straight to the auto-generated documentation if you prefer provided in the Documentation. 

## Getting Help 

Please use the PDN Developer Community at https://community.pdn.pearson.com


## Pre-Requisites 

These libraries are designed only as wrappers for the RESTful APIs. They make using the APIs easier, but will simply return the response from the API (i.e., a JSON payload). You should be sure to read the API documentation and background information for LearningStudio while using these libraries. Here are some key places to start:

 * [LearningStudio Introduction](http://pdn.pearson.com/learningstudio/learningstudio-introduction)
 * [LearningStudio Data Structure & API Info](http://pdn.pearson.com/learningstudio/general-api-information)
 * [API Reference](http://pdn.pearson.com/api_resources/778)


## Keys

For all API requests, you'll need a set of API keys. The Application ID identifies your application, and you should have a different one for every application you develop. The Token Key Moniker, Shared Secret, and Client String control access to the LearningStudio campus you're integrating with. Every new campus you integrate with will require a new TKM, Secret and Client String, but you'll use the same Application ID.

You can get keys for the Sandbox Campus through the PDN portal. Here's more information:

 * [How to Get Keys](http://pdn.pearson.com/learningstudio/get-a-key)
 * [Introduction to Multitenancy](http://pdn.pearson.com/learningstudio/get-a-key)
 * [About the Sandbox Campus](http://pdn.pearson.com/learningstudio/sandbox-campus)


## The Libraries 

### Authentication
LearningStudio uses OAuth 1.0a and OAuth 2 schemes for securing access to the APIs; both schemes can feel difficult at first, so this library streamlines the work of creating a signature for a request (OAuth 1) or generating a token for a user (OAuth 2). The Core library uses this library to generate the necessary authentication for the request.

### Core 
A generic all-purpose library that allows you to call any RESTful endpoint for LearningStudio. Core works natively with Authentication, so in using this library you simply provide your API keys, specify an OAuth type, and if necessary a username or password. Core takes care of generating the appropriate authentication for the request. The Exams, Grades, and Content libraries use Core.

### Exams
The exams system is one of our more complex set of APIs, so this library provides a variety of functions mapped to the APIs, plus helper functions for streamlining some operations. If you are building an application that provides an alternative way for students to take exams (i.e. a mobile application), this is the library you'll want to use.

### Grades
Interacting with the LearningStudio Gradebook is the most common reason people use LearningStudio APIs. This library makes working with the gradebook APIs a little bit easier.

### Content & Threads
LearningStudio content is split between several different domains and API paths, depending on the type of content. This library brings all those different types together into a single interface.


(c) 2014 Pearson Education Inc. Released under the Apache 2.0 License.