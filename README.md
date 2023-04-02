# vico-ratings
This project to make ratings for vico's project 

Before begin there are some important notes:
1- Under testDataBase folder you have two dump for two databases main and main test, they includes the data and schema, 
these database need to be added before statr working on APIs.

Api's list :
-Client API's includes "get all clients" and "create new client"
          - Get all clients : method : GET , url: {baseUrl}/clients 
             response example : [
                                          {
                                              "id": 1,
                                              "firstName": "Maysarah",
                                              "lastName": "Abu Eloun",
                                              "userName": "maysarah",
                                              "created": "2018-02-21T12:00:00+03:00"
                                          },
                                          {
                                              "id": 2,
                                              "firstName": "Maysarano",
                                              "lastName": "Adriano",
                                              "userName": "medo",
                                              "created": "2023-03-30T14:13:56+03:00"
                                          },
                                ]

        -Create new client : method : POST , url: {baseUrl}/clients 
          request example : {
                                  "first_name": "Maysarah",
                                  "last_name": "Abu Eloun",
                                  "username": "maysarah_2",
                                  "password": "test1"
                              } 
    
-Vico API's includes "get all vicos" and "create new vico" 
          - Get all vicos : method : GET , url: {baseUrl}/vicos 
             response example : [ 
                                          {
                                              "id": 1,
                                              "name": "leonardo",
                                              "created": "2023-03-30T14:57:47+03:00"
                                          },
                                          {
                                              "id": 2,
                                              "name": "kww",
                                              "created": "2023-03-30T15:13:43+03:00"
                                          },
                                ]
           -Create new vico : method : POST , url: {baseUrl}/vicos 
                    request example : {
                                          "name": "Maysarah",
                                      } 
    
 -Project API's includes "get all projects" and "create new project" 
          - Get all vicos : method : GET , url: {baseUrl}/projects 
             response example :[
                            {
                                "id": 1,
                                "title": "test",
                                "creatorId": {
                                    "id": 1,
                                    "firstName": "Maysarah",
                                    "lastName": "Abu Eloun",
                                    "userName": "maysarah",
                                    "password": "test1",
                                    "created": "2018-02-21T12:00:00+03:00",
                                    "__isCloning": false
                                },
                                "vicoId": {
                                    "id": 1,
                                    "name": "leonardo",
                                    "created": "2023-03-30T14:57:47+03:00",
                                    "__isCloning": false
                                },
                                "created": "2018-02-21T12:00:00+03:00"
                            }
                            ]
        -Create new project : method : POST , url: {baseUrl}/project 
            request example : {
                                  "creator_id": "12",
                                  "vico_id": "4",
                                  "title": "maysarah_test"
                              }
                              
  -Rating types API's includes "get all rating types" , "create new rating type" and "delete rating type" 
          - Get all vicos : method : GET , url: {baseUrl}/rating-types 
             response example :[
                                  {
                                      "id": 3,
                                      "code": "OVERALL",
                                      "display": "Overall Satisfaction",
                                      "created": "2023-03-30T23:04:44+03:00"
                                  },
                                  {
                                      "id": 4,
                                      "code": "COMM",
                                      "display": "Communication",
                                      "created": "2023-03-30T23:06:31+03:00"
                                  },
                                  {
                                      "id": 5,
                                      "code": "QOW",
                                      "display": "Quality Of Work",
                                      "created": "2023-03-30T23:08:03+03:00"
                                  },
                            ]
                            
        -Create new rating type : method : POST , url: {baseUrl}/rating-types
            request example : {
                                "code": "OVERALL",
                                "display": "Overall Satisfaction"
                               }

        -Delete rating type : method : DELETE , url: {baseUrl}/rating-types 
            request example : {
                                "code": "OVERALL",
                              }                  

Project Rating API's includes "get all project and their ratings" , "create new rating for the project" and update "project ratings"
          - Get all project and their ratings: method : GET , url: {baseUrl}/ /project-ratings
             response example : [
                                   {
                              "id": 2,
                              "projectId": {
                                  "id": 1,
                                  "title": "test",
                                  "creatorId": {
                                      "id": 1,
                                      "firstName": "Maysarah",
                                      "lastName": "Abu Eloun",
                                      "userName": "maysarah",
                                      "password": "test1",
                                      "created": "2018-02-21T12:00:00+03:00",
                                      "__isCloning": false
                                  },
                                  "vicoId": {
                                      "id": 1,
                                      "name": "leonardo",
                                      "created": "2023-03-30T14:57:47+03:00",
                                      "__isCloning": false
                                  },
                                  "created": "2018-02-21T12:00:00+03:00",
                                  "__isCloning": false
                              },
                              "ratingTypeId": {
                                  "id": 4,
                                  "code": "COMM",
                                  "display": "Communication",
                                  "created": "2023-03-30T23:06:31+03:00",
                                  "__isCloning": false
                              },
                              "clientNote": "new test",
                              "rating": 5,
                              "created": "2023-03-30T06:20:43+03:00",
                              "updated": "2023-03-30T06:20:43+03:00"
                              }]
                            
        -Create new project rating : method : POST , url: {baseUrl}//project-ratings
            request example : {
                                  "project_id": 3,
                                  "project_ratings": [
                                                        {
                                                            "rating_type_code": "OVERALL",
                                                            "rating": 4,
                                                            "client_note": "this is a new test from up"
                                                        },
                                                        {
                                                            "rating_type_code": "QOW",
                                                            "rating": 3
                                                        },
                                                        {
                                                            "rating_type_code": "COMM",
                                                            "rating": 5
                                                        }
                                                    ]
                              }
        -Update existing project rating : method : PUT , url: {baseUrl}/project-ratings/{project_id}
            request example : {
                                  "project_ratings": [
                                                        {
                                                            "rating_type_code": "OVERALL",
                                                            "rating": 4,
                                                            "client_note": "this is a new test from up"
                                                        },
                                                        {
                                                            "rating_type_code": "QOW",
                                                            "rating": 3
                                                        },
                                                        {
                                                            "rating_type_code": "COMM",
                                                            "rating": 5
                                                        }
                                                    ]
                              }                      
