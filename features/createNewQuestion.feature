Feature: Create new Open Answer module question
In order to create a new module question
As a lecturer
The lecturer needs to be able to add a new question

Scenario: Creating the question
Given The lecturer is logged in
And The lecturer is on New Question page
When The lecturer selects the Module he would like to create a question for
And The lecturer selects the type of the question
And The lecturer fills in the question text
And The lecturer presses the Create Question button
Then The lecturer has now added a new question and redirected to the Module’s question page
