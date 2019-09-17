CREATE TABLE purchases (
    name VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    amount VARCHAR(10) NOT NULL,
    category VARCHAR(50) NOT NULL,
    notes VARCHAR(100)
);

CREATE TABLE categories (
    name VARCHAR(50) PRIMARY KEY
);

INSERT INTO purchases VALUES ("Groceries", "2019-01-01", 100, "Food/Drink", "Weekly Shop");
INSERT INTO purchases VALUES ("Petrol", "2019-02-01", 300, "Petrol", "Gas Is expensive");
INSERT INTO purchases VALUES ("Movies", "2019-03-01", 34, "Food/Drink", "Movie Night");
INSERT INTO purchases VALUES ("Sunblock", "2019-04-01", 5, "Personal Items", "");
INSERT INTO purchases VALUES ("Chocolate", "2019-01-01", 10, "Food/Drink", "");
INSERT INTO purchases VALUES ("Coffee", "2020-01-01", 5, "Food/Drink", "");
INSERT INTO purchases VALUES ("Lunch", "2020-01-01", 34, "Food/Drink", "");
INSERT INTO purchases VALUES ("Dinner", "2007-01-01", 60, "Food/Drink", "");
INSERT INTO purchases VALUES ("Groceries", "2006-01-01", 150, "Food/Drink", "");
INSERT INTO purchases VALUES ("Groceries", "2005-01-01", 60, "Food/Drink", "");

INSERT INTO categories VALUES ("Food/Drink");
INSERT INTO categories VALUES ("Bills to Pay");
INSERT INTO categories VALUES ("Petrol");
INSERT INTO categories VALUES ("Personal Items");