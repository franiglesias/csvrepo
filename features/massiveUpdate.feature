Feature: Massively update product prices when needed
  As Sales Manager
  I want to be able to massively update product prices
  In order to invoice our customers with the latest prices

  Scenario: Update uploading a csv file with new prices
    Given There are current prices in the system
      | id  | name      | price |
      | 101 | Product 1 | 10.25 |
      | 102 | Product 2 | 14.95 |
      | 103 | Product 3 | 21.75 |
    And I have a file named "prices_update.csv" with the new prices
      | product_id | new_price |
      | 101        | 17        |
      | 103        | 23        |
    When I upload the file
    Then Changes are applied to the current prices
      | id  | name      | price |
      | 101 | Product 1 | 17.00 |
      | 102 | Product 2 | 14.95 |
      | 103 | Product 3 | 23.00 |

  Scenario: Update fails because an invalid file
    Given There are current prices in the system
    And I have a file named "invalid_data.csv" with invalid data
    When I upload the file
    Then A message is shown explaining the problem
    And Changes are not applied to the current prices

  Scenario: Update fails because a system error
    Given There are current prices in the system
    And I have a file named "prices_update.csv" with the new prices
    When I upload the file
    And There is an error in the system
    Then A message is shown explaining the problem
    And Changes are not applied to the current prices
