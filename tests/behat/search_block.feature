@block @block_ragflowsearch @javascript
Feature: RAGflow file search block
  In order to search a RAGflow knowledge base from a course
  As a site administrator
  I need to add the RAGflow file search block and be told to configure a knowledge base first

  Scenario: The block shows a not-configured hint until a knowledge base is chosen
    Given I log in as "admin"
    And I am on site homepage
    And I turn editing mode on
    When I add the "RAGflow file search" block
    Then I should see "RAGflow file search is not configured yet"
