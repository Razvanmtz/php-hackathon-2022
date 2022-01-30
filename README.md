# PHP Hackathon
This document has the purpose of summarizing the main functionalities your application managed to achieve from a technical perspective. Feel free to extend this template to meet your needs and also choose any approach you want for documenting your solution.

## Problem statement
*Congratulations, you have been chosen to handle the new client that has just signed up with us.  You are part of the software engineering team that has to build a solution for the new client’s business.
Now let’s see what this business is about: the client’s idea is to build a health center platform (the building is already there) that allows the booking of sport programmes (pilates, kangoo jumps), from here referred to simply as programmes. The main difference from her competitors is that she wants to make them accessible through other applications that already have a user base, such as maybe Facebook, Strava, Suunto or any custom application that wants to encourage their users to practice sport. This means they need to be able to integrate our client’s product into their own.
The team has decided that the best solution would be a REST API that could be integrated by those other platforms and that the application does not need a dedicated frontend (no html, css, yeeey!). After an initial discussion with the client, you know that the main responsibility of the API is to allow users to register to an existing programme and allow admins to create and delete programmes.
When creating programmes, admins need to provide a time interval (starting date and time and ending date and time), a maximum number of allowed participants (users that have registered to the programme) and a room in which the programme will take place.
Programmes need to be assigned a room within the health center. Each room can facilitate one or more programme types. The list of rooms and programme types can be fixed, with no possibility to add rooms or new types in the system. The api does not need to support CRUD operations on them.
All the programmes in the health center need to fully fit inside the daily schedule. This means that the same room cannot be used at the same time for separate programmes (a.k.a two programmes cannot use the same room at the same time). Also the same user cannot register to more than one programme in the same time interval (if kangoo jumps takes place from 10 to 12, she cannot participate in pilates from 11 to 13) even if the programmes are in different rooms. You also need to make sure that a user does not register to programmes that exceed the number of allowed maximum users.
Authentication is not an issue. It’s not required for users, as they can be registered into the system only with the (valid!) CNP. A list of admins can be hardcoded in the system and each can have a random string token that they would need to send as a request header in order for the application to know that specific request was made by an admin and the api was not abused by a bad actor. (for the purpose of this exercise, we won’t focus on security, but be aware this is a bad solution, do not try in production!)
You have estimated it takes 4 weeks to build this solution. You have 3 days. Good luck!*

## Technical documentation
### Data and Domain model
In this section, please describe the main entities you managed to identify, the relationships between them and how you mapped them in the database.

We have 3 main entities: Programmes, Users and Rooms.
Relationships:
Each individual programme <strong>has to be</strong> linked to one single room and <strong>can be</strong> linked to as many users as it's participant limit allows.
Each individual user can be linked to as many programmes as needed.
Each room can be linked to as many programmes as needed.

For the Database we have 4 separate tables:
1. Programmes: This contains all individual programmes on separate rows with the following columns: id, type, start_date, end_date, participant_limit, room_number
2. Rooms: This contains all individual rooms on separate rows with the following columns: id, allowed_types
3. Users: This contains all individual users on separate rows with the following columns: id, created_on
4. Registrations: This contains all individual registrations on separate rows with the following columns: id, user_id, programme_id, registration_date

### Application architecture
In this section, please provide a brief overview of the design of your application and highlight the main components and the interaction between them.

In order for the API to function properly we have 3 available requests, each from it's own user friendly path (programme/create , programme/delete, programme/register_user). Each of these scripts make use of the Classes available from the /classes folder (3 available classes: Programme, User and Room) in order to create objects and use the methods available to validate the data and insert it into, or delete it from, the database.

For example: to create a new programme the Programme class is used to insert the new programme into the database as well as validate it beforehand (such as checking that there are no other programmes running the same room during the same timeslot), and the Room class is used to make sure the programme is being scheduled in a room that allows that type of programmes and that said room actually exists.

###  Implementation
##### Functionalities
For each of the following functionalities, please tick the box if you implemented it and describe its input and output in your application:

[x] Brew coffee \
Input: Beans \
Output: Coffee \

[x] Drink coffee \
Input: Coffee \
Output: Code \

[x] Create programme functionality \
Input: Array of data for the new programme with the parameters: 'programme_type', 'start_date', 'end_date', 'participant_limit', 'room_number'. \
Output: Either an error message or the ID of the new programme on success. \

[x] Delete programme functionality \
Input: The ID of the programme we want to delete. \
Output: Either an error message or the ID of the deleted programme on success. \

[x] Register user to programme functionality 
Input: The ID of the user (CNP) and the ID of the programme we want to register them to. \
Output: Either an error message or the ID of the user and the ID of the programme on success. \

Note: All outputs are JSON objects. \

##### Business rules
Please highlight all the validations and mechanisms you identified as necessary in order to avoid inconsistent states and apply the business logic in your application.

The first check made is for the authentication code sent through the header to validate the request came from an admin.
The second check will validate that the request is the expected one, which is a POST request.

After these general validations, each request will go through diferent validations depending on the action performed:

1. Create Programme:
Date validation (the start date must be before the end date)
General value validation (all expected values must be sent, no value should be empty)
Room exists (make sure the requested room actually exists before creating the programme)
Room allows programme type (make sure the programme type is one of the available ones for the requested room)
Room already booked (make sure there is no other programme running in the request room during the same timeslot)

2. Delete Programme:
Programme exists (make sure the programme actually exists before trying to remove it)
This action will also delete all registrations linked to this programme.

3. Register User:
Programme exists (make sure the programme actually exists before trying to register users to it)
Programme not full (make sure the programme participant limit has not been reached)
User ID (CNP) is valid (make sure the correct format is used and the CNP is a possible valid CNP)
User not already registered (make sure the user is not already registered to a different programme in the same timeslot)
This action will search the Users table for an existing user by ID (CNP), if no user found it will add it to the table and then register the user to the programme.


##### 3rd party libraries (if applicable)
Please give a brief review of the 3rd party libraries you used and how/ why you've integrated them into your project.

##### Environment
Please fill in the following table with the technologies you used in order to work at your application. Feel free to add more rows if you want us to know about anything else you used.
| Name | Choice |
| ------ | ------ |
| Operating system (OS) | Windows 10 |
| Database  | 10.4.22 MariaDB & MySQL Workbench |
| Web server| Apache |
| PHP | 8.1 |
| Code Editor | Sublime |

### Testing
In this section, please list the steps and/ or tools you've used in order to test the behaviour of your solution.

I used the testing scripts available in the /tests folder to test and debug all possible request.

## Feedback
In this section, please let us know what is your opinion about this experience and how we can improve it:

1. Have you ever been involved in a similar experience? If so, how was this one different?
Nope.

2. Do you think this type of selection process is suitable for you?
Yes, it's much more interesting than a multiple choice technical test.

3. What's your opinion about the complexity of the requirements?
The complexity is adequate for the alloted time.

4. What did you enjoy the most?
When everything worked together without any issues.

5. What was the most challenging part of this anti hackathon?
Making the perfect CNP validation (which it isn't but it gets the job done).

6. Do you think the time limit was suitable for the requirements?
Definitely.

7. Did you find the resources you were sent on your email useful?
Yes.

8. Is there anything you would like to improve to your current implementation?
Cleaning up the code a bit and maybe adding more functionality (ex: instructors for programmes).

9. What would you change regarding this anti hackathon?
Nothing.
