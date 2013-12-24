README
=============

A small/sample application using SLIM Framework to set REST API including authentication. The application has 2 tables 

1. Users Table: To authenticate the Users
2. Properties Table: Contains Properties of User and will be accessed via REST Calls.

db_sql_dump contains the SQl Dump to create database.


Description of REST Calls which are covered in the Application

a) **Authenticate**: This is used to authenticate the User.

URL: **/authenticate**

HTTP Request Type: POST

Corresponding CURL Call: curl -H 'Content-type: application/json' -d '{"username":"PASS_USERNAME","password":"PASS_PASSWORD"}' -X POST http://localhost/authenticate

Response On Success: status = 200 and token (to be used in other calls)

Response on Failure: error Message


b) **Get All Properties**: This is used to get all properties of the authenticated user

URL: **/properties**

HTTP Request Type: GET

Corresponding CURL Call: curl -u token:e5bdc8135126961e3756b03cca68777d -X GET http://localhost/properties

Response On Success: status = 200 and data containg properties

Response on Failure: error Message


c) **GET Detail**: This is used to get the Property Detail of 1 Particular Property

URL: **/properties/{property_id}**

HTTP Request Type: GET

Corresponding CURL Call: curl -u token:e5bdc8135126961e3756b03cca68777d -X GET http://localhost/properties/1


Response On Success: status = 200 and data containg property detail

Response on Failure: error Message


d) **Add Property**: 

URL: **/properties**

HTTP Request Type: POST

Corresponding CURL Call: curl -u token:e5bdc8135126961e3756b03cca68777d -H 'Content-type: application/json' -d '{"name":"Property Name","description":"Property Description"}' -X POST http://localhost/properties


e) **Edit Property**


URL: **/properties/{property_id}**

HTTP Request Type: PUT

Corresponding CURL Call: curl -u token:e5bdc8135126961e3756b03cca68777d -H 'Content-type: application/json' -d '{"name":"Property Name","description":"Property Description"}' -X PUT http://localhost/properties/1

g) **Delete Property**

URL: **/properties/{property_id}**

HTTP Request Type: DELETE

Corresponding CURL Call: curl -u token:e5bdc8135126961e3756b03cca68777d -X DELETE http://localhost/properties/1


------------------------------------------------------------------
**Additionaly I have also included a CLASS SlimApiClass.php to access all the above REST API Calls.**
