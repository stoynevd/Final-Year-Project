Feature: Delete a Question
In order to delete a module question
As a lecturer
The lecturer needs to be able to remove any of the module questions

Scenario: Deleting a module question
Given The lecturer is logged in
And The lecturer has accessed the module in which he wants to remove a question
And The lecturer is on the Questions page
When The lecturer finds the question he wants to remove
And The lecturer presses the Delete action button
And The lecturer selects Yes on the pop-up dialog
Then The lecturer has now deleted the selected question
