<?php
require_once('./includes/admin_funcs.inc.php');
if ($_POST) {
    // include Database classes
    require_once('./includes/database.inc.php');
    // escape quotes and apostrophes if magic_quotes_gpc off
    if (!get_magic_quotes_gpc()) {
        foreach ($_POST as $key => $value) {
            $temp = addslashes($value);
            $_POST[$key] = $temp;
        }
    }
    // create Database instance
    require_once('./includes/change_host.inc.php');

    // if the "Insert new author" button has been clicked
    if (array_key_exists('insAuthor', $_POST)) {
        // code for inserting author
        $first_name = $_POST['first_name'];
        $family_name = $_POST['family_name'];
        $checkName = "SELECT * FROM authors
                  WHERE first_name = '$first_name'
                  AND family_name = '$family_name'";
        $result = $conn_db->query($checkName);
        if ($result->num_rows > 0) {
            $authorAlert = stripslashes($first_name) . ' ';
            $authorAlert .= stripslashes($family_name) . ' is already registered';
        }
        if (!isset($authorAlert)) {
            $insertAuthor = "INSERT INTO authors (first_name, family_name)
                       VALUES ('$first_name', '$family_name')";
            $result = $conn_db->query($insertAuthor);
            if ($result) {
                $authorAlert = stripslashes($first_name) . ' ';
                $authorAlert .= stripslashes($family_name) . ' entered successfully';
            }
        }
    } // if the "Insert new publisher" button has been clicked
    elseif (array_key_exists('insPublisher', $_POST)) {
        // code for inserting publisher
        $publisher = $_POST['publisher'];
        $checkName = "SELECT * FROM publishers
                  WHERE publisher = '$publisher'";
        $result = $conn_db->query($checkName);
        if ($result->num_rows > 0) {
            $publisherAlert = stripslashes($publisher);
            $publisherAlert .= ' is already registered in the publishers table';
        }
        if (!isset($publisherAlert)) {
            $insertPublisher = "INSERT INTO publishers
                          SET publisher = '$publisher'";
            $result = $conn_db->query($insertPublisher);
            if ($result) {
                $publisherAlert = stripslashes($publisher);
                $publisherAlert .= ' successfully entered in the publishers table';
            }
        }
    }
}
?>

<!DOCTYPE html >
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="UTF-8"/>
    <title>Insert authors and publishers</title>
    <link href="./styles/admin.css" rel="stylesheet" type="text/css"/>
    <link href="./styles/content.css" rel="stylesheet" type="text/css">
</head>
<body>
<p style="line-height:1.25em; color:#666;">
<h1>Book Depository</h1></p>
<?php insertMenu(); ?>
<div id="maincontent">
    &nbsp;
    <h1>Insert new author</h1>
    <?php
    if (isset($authorAlert))
        echo '<p id="alert">' . $authorAlert . '</p>';
    ?>
    <form name="authorDets" id="authorDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <div class="input_form">
            <label for="first_name">First name:</label>
            <input class="medium_box" name="first_name" type="text" id="first_name" value=""/>
        </div>
        <div class="input_form">
            <label for="family_name">Family name:</label>
            <input class="medium_box" name="family_name" type="text" id="family_name" value=""/>
        </div>
        <div class="input_form">
            <input name="insAuthor" type="submit" id="insAuthor" value="Insert new author"/>
        </div>
    </form>
    <h1>Insert new publisher</h1>
    <?php
    if (isset($publisherAlert))
        echo '<p id="alert">' . $publisherAlert . '</p>';
    ?>
    <form name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <div class="input_form">
            <label for="publisher">Publisher:</label>
            <input class="medium_box" name="publisher" type="text" id="publisher" value=""/>
        </div>
        <div class="input_form">
            <input name="insPublisher" type="submit" id="insPublisher" value="Insert new publisher"/>
        </div>
    </form>


</div>
</body>
<?php
require_once("./includes/footer.inc.php");
?>
</html>
