Feature: Create new Exam with random questions
In order to create a new exam with random questions
As a lecturer
The lecturer needs to be able to create a new exam

Scenario: Creating the exam
Given The lecturer is logged in
And The lecturer is on New Exam page
When The lecturer selects the Module he would like to create an exam for
And The lecturer selects the number of sections
And The lecturer fills in the exam name
And The lecturer fills in the exam length
And The lecturer checks the Random Questions checkbox
And The lecturer fills in the names of the Sections
And The lecturer fills in the number of questions for each Section
And The lecturer presses the Create Exam button
Then The lecturer has now added a new exam paper and is redirected to the Exam‘s page
