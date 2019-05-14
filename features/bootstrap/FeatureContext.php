<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
/**
* Defines application features from the specific context.
*/
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    /**
    * Initializes context.
    *
    * Every scenario gets its own context instance.
    * You can also pass arbitrary arguments to the
    * context constructor through behat.yml.
    */
    public function __construct() {
    }

    /**
    * @Given The lecturer is logged in as :arg1 with :arg2
    */
    public function theLecturerIsLoggedInAsWith($email, $password) {
        // $this->visit('/login');
        $this->getSession()->visit($this->locatePath('/login'));
        $page = $this->getSession()->getPage();
        $page->find('css', '#email')->setValue($email);
        $page->find('css', '#password')->setValue($password);
        $page->find('css', '#signInButton')->press();
    }

    /**
    * @Given The lecturer is on New Question page
    */
    public function theLecturerIsOnNewQuestionPage() {
        // $this->visit('/new_question');
        $this->getSession()->visit($this->locatePath('/new_question'));
    }

    /**
    * @When The lecturer selects the Module he would like to create a question for
    */
    public function theLecturerSelectsTheModuleHeWouldLikeToCreateAQuestionFor() {
//        $this->visit('/new_question');
        $this->getSession()->visit($this->locatePath('/new_question'));
        $page = $this->getSession()->getPage();
        dd($page->find('css', '#email'));
        // $page->find('css', '#password')->setValue($password);
        // $page->find('css', '#signInButton')->press();
    }

    /**
    * @When The lecturer selects the type of the question
    */
    public function theLecturerSelectsTheTypeOfTheQuestion()
    {
        // throw new PendingException();
    }

    /**
    * @When The lecturer fills in the question text
    */
    public function theLecturerFillsInTheQuestionText()
    {
        //throw new PendingException();
    }

    /**
    * @When The lecturer presses the Create Question button
    */
    public function theLecturerPressesTheCreateQuestionButton()
    {
        //throw new PendingException();
    }

    /**
    * @Then The lecturer has now added a new question
    */
    public function theLecturerHasNowAddedANewQuestion()
    {
        //throw new PendingException();
    }
}
