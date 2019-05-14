Feature: Delete an Exam
In order to delete an Exam
As a lecturer
The lecturer needs to be able to remove any of the exams

Scenario: Deleting an Exam
Given The lecturer is logged in
And The lecturer has accessed the module in which he wants to remove an exam
And The lecturer is on the Exams page
When The lecturer finds the exam he wants to remove
And The lecturer presses the Delete action button
And The lecturer selects Yes on the pop-up dialog
Then The lecturer has now deleted the selected exam
