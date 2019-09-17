<!DOCTYPE html>
<html>
<head>
<title>Frontend</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>

<?php

$db_host = '192.168.33.14';
$db_name = 'fvision';
$db_user = 'webuser';
$db_pass = 'Alexander';

$categoryErrorString = "";
$spendErrorString = "";

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";
$pdo = new PDO($pdo_dsn, $db_user, $db_pass);

if(isset($_POST['submitSpend'])){
    $isValid = true;
    if($_POST['purchaseName'] === ""){
        $isValid = false;
        $spendErrorString = "Please enter values for Name, Date and Amount";
    }
    if($_POST['purchaseDate'] === ""){
        $isValid = false;
        $spendErrorString = "Please enter values for Name, Date and Amount";
    }
    if($_POST['purchaseAmount'] === ""){
        $isValid = false;
        $spendErrorString = "Please enter values for Name, Date and Amount";
    }

    if ($isValid){
        $name = $_POST['purchaseName'];
        $date = $_POST['purchaseDate'];
        $amount = $_POST['purchaseAmount'];
        $category = $_POST['category'];
        $notes = $_POST['purchaseNotes'];
        $sql = "INSERT INTO purchases VALUES ('$name','$date','$amount','$category','$notes')";
        $pdo->exec($sql);
    }
}

// Category form
if(isset($_POST['submitCategories'])){

    // Check the submission was not empty
    if($_POST['categoryName'] === ""){
        $categoryErrorString = "Please enter a value";
    }
    // Submission contains text we can check
    else {
        $isValid = true;

        $query = $pdo->query("SELECT * FROM categories");

        // Loop and check the category doesn't exist in DB
        while ($row = $query->fetch()) {
            $dbresult = strtolower($row["name"]);
            $match = strtolower($_POST['categoryName']);
            if ($dbresult === $match) {
                $categoryErrorString = "Category already exists";
                $isValid = false;
            }
        }
        if ($isValid) {
            $sql = "INSERT INTO categories VALUES ('$_POST[categoryName]')";
            $pdo->exec($sql);
        }
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">SpendTrack</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="graph.php">Spending Graph</a>
        </div>
    </div>
</nav>

<div class="text-center">
    <img src="banner.png" class="rounded" style="margin-top: 20px">
</div>

<div class="container-fluid">
    <div class="justify-content-center">
        <hr>
        <h1>Spending tracking made easy</h1>
        <h2>Welcome</h2>
        <div class="row">
            <div class="col">
                <p>SpendTrack is a helpful tool that will track your spending and will graph your spending habits
                    to your desired timescale, be that weekly, monthly, or yearly.</p>
                <p>Click below on Add Spending to add a purchase and start your tracking. Or select Add Category to
                    add another spending category to select from when you add a purchase</p>
                <p>Remember, you can only track what you put in!</p>
            </div>
            <div class="col">
                <div class="text-center">
                    <img src="money.png" class="rounded" style="padding-bottom: 10px">
                </div>
                <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='graph.php'" name="goToTracking">Graph your spending</button>
            </div>
        </div>
        <hr>
    </div>
</div>

<div class="container-fluid">
    <h3>Select one of the options to get started</h3>
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Add Spending
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <form name="add-spend-form" method="post" id="add-spend-form">
                            <p class="h4 mb-4 text-center">Add Purchase</p>
                            <div class="form-row">
                                <div class="col">
                                    <label for="purchaseName">Purchase Name:</label>
                                    <input id="purchaseName" name="purchaseName" type="text" class="form-control" placeholder="e.g. Dinner">
                                </div>
                                <div class="col">
                                    <label for="purchaseDate">Purchase date:</label>
                                    <input id="purchaseDate" name="purchaseDate" type="date" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="purchaseAmount">Purchase Amount:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input id="purchaseAmount" name="purchaseAmount" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="category">Category:</label>
                                    <select name="category" class="form-control">
                                        <?php
                                        $query = $pdo->query("SELECT * FROM categories");
                                        while ($row = $query->fetch()) {
                                            echo  "<option value=$row[name]>$row[name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="purchaseNotes">Notes: </label>
                                <textarea type="textarea" id="purchaseNotes" name="purchaseNotes" class="form-control" rows="3" cols="10"></textarea>
                            </div>
                            <?php
                            if($spendErrorString !== ""){
                                echo "<p style='text-align: center'>$spendErrorString</p>";
                            }
                            ?>
                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="submitSpend">Add Spend</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Add Category
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <form name="add-category-form" method="post" id="add-category-form">
                            <p class="h4 mb-4 text-center">Add Category</p>
                            <div class="form-group">
                                <label for="categoryName">Category Name:</label>
                                <input id="categoryName" name="categoryName" type="text" class="form-control" placeholder="e.g. Groceries">
                            </div>
                            <?php
                            if($categoryErrorString !== ""){
                                echo "<p style='text-align: center'>$categoryErrorString</p>";
                            }
                            ?>
                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="submitCategories">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>