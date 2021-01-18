<?php
require_once("./includes/admin_funcs.inc.php");
require_once("./includes/database.inc.php");
// this code always runs, and gets lists of authors and publishers 
require_once('./includes/change_host.inc.php');

$getAuthors = 'SELECT author_id,
               CONCAT(first_name," ", UPPER(family_name)) AS author
               FROM authors
               ORDER BY family_name, first_name';
$authors = $conn_db->query($getAuthors);
$getPublishers = 'SELECT * FROM publishers ORDER BY publisher';
$publishers = $conn_db->query($getPublishers);  
// this first block runs only if the form has been submitted
if ($_POST) {
  // check for empty fields
  foreach($_POST as $key=>$value) {
    // authors is a sub-array, so skip
    if (is_array($value)) continue;
    $value = trim($value);
    if (empty($value)) {
      if ($key == 'isbn') {
        $error[] = 'ISBN is required';
        }
      // if no publisher selected, value is 0, considered empty by PHP
      elseif ($key == 'publisher') {
        $error[] = 'You must select a publisher';
        }
      else {
        $error[] = ucfirst($key).' is required';
        }
      }
    }
  // remove any hyphens from ISBN and check for valid length
  $_POST['isbn'] = str_replace('-','',$_POST['isbn']);
  if (strlen($_POST['isbn']) != 10) {
    if (strlen($_POST['isbn']) != 13) {
      $error[] = 'ISBNs have 10 or 13 characters (excluding hyphens)';
      }
    }
  // check that an author has been chosen
  if ($_POST['author'][0] == 'choose' && count($_POST['author']) < 2) {
    $error[] = 'Select at least one author, or choose "Not listed"';
    }
  // if all fields correctly filled, prepare to insert in database
  if (!isset($error)) {
    // final preparations for insertion
	// escape quotes and apostrophes if magic_quotes_gpc off
    if (!get_magic_quotes_gpc()) {
      foreach($_POST as $key=>$value) {
        // skip author sub-array
        if (is_array($value)) continue;
        $temp = addslashes($value);
        $_POST[$key] = $temp;
        }
      }
    // create a Database instance, and set error reporting to plain text ......
	require_once('./includes/change_host.inc.php');
		
    // first check that the same ISBN doesn't already exist
    $checkISBN = 'SELECT isbn FROM books
	              WHERE isbn = "'.$_POST['isbn'].'"';
    $result = $conn_db->query($checkISBN);
    if ($result->num_rows > 0) {
      $error[] = 'A book with that ISBN already exists in the database';
      }
    else {
      // if ISBN unique, insert book in to books table
	  if ($_POST['publisher'] == 'other') $_POST['publisher'] = 0;
	  $insert = 'INSERT INTO books (title,isbn,pub_id,image,description)
                 VALUES ("'.$_POST['title'].'","'.$_POST['isbn'].'",'.
                 $_POST['publisher'].',"'.$_POST['image'].'",
                 "'.$_POST['description'].'")';
      $result = $conn_db->query($insert);
      // get the primary key of the record just inserted
	  $getBook_id = 'SELECT book_id FROM books
                     WHERE isbn = "'.$_POST['isbn'].'"';
      $result = $conn_db->query($getBook_id);
      $row = $result->fetch_assoc();
      $book_id = $row['book_id'];
	  // if "Select author(s)" still selected, remove it from the array
	  if ($_POST['author'][0] == 'choose') array_shift($_POST['author']);
      if (in_array('other',$_POST['author'])) {
	    $i = array_search('other', $_POST['author']);
		$_POST['author'][$i] = 0;
		}
      // build array of book_id and author_id pairs, one for each author
      $values = array();
      foreach ($_POST['author'] as $author_id) {
        $values[] = "($book_id, $author_id)";
        }
      // convert array to comma delimited string
      $values = implode(',',$values);
      // insert book_id/author_id pairs into lookup table
      $createLookup = 'INSERT INTO book_to_author (book_id, author_id)
                        VALUES '.$values;
      $result = $conn_db->query($createLookup);
      // if successful, redirect to confirmation page
      if ($result) {
	    $conn_db->close();
        header('Location: listbooks.php?action=inserted&title='.$_POST['title']);
        }
      }
	}
  }
?>
<!DOCTYPE html >
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="UTF-8" />
<title>Insert new book</title>
<link href="styles/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<p style="line-height:1.25em; color:#666;"><h1>Book Depository</h1></p>
<?php insertMenu(); ?>
<div id="maincontent">
    <h1>Insert new book</h1>
    <?php
        if (isset($error)) {
        echo '<div id="alert"><p>Please correct the following:</p><ul>';
        foreach ($error as $item) {
            echo "<li>$item</li>";
        }
        echo '</ul></div>';
    }
    ?>
    <form name="bookDets" id="bookDets" method="post" action="">
        <table>
            <tr>
                <th class="leftLabel">Title:</th>
                <td><input name="title" type="text" class="widebox" id="title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>" /></td>
            </tr>
            <tr>
                <th class="leftLabel">ISBN:</th>
                <td><input name="isbn" type="text" class="narrowbox" id="isbn" value="<?php if (isset($_POST['isbn'])) echo $_POST['isbn']; ?>" /></td>
            </tr>
            <tr>
                <th class="leftLabel">Author(s):</th>
                <td><select name="author[]" size="6" multiple="multiple" id="author">
                <option value="choose"
                <?php
                if (!isset($_POST['author']) || (isset($_POST['author']) && in_array('choose',$_POST['author']))) {
                  echo 'selected="selected"';
                  }
                ?>
                >Select author(s)</option>
                <option value="other"
                <?php
                if (isset($_POST['author']) && $_POST['author'] == 'other')
                  echo 'selected="selected"'; ?>
                >Not listed</option>
                <?php
                while ($row = $authors->fetch_assoc()) {
                  echo '<option value="'.$row['author_id'].'"';
                  if (isset($_POST['author']) && in_array($row['author_id'],$_POST['author'])) {
                    echo 'selected="selected"';
                    }
                  echo '>'.$row['author'].'</option>';
                  }
                ?>
                </select></td>
            </tr>
            <tr>
                <th class="leftLabel">Publisher:</th>
                <td><select name="publisher" id="publisher">
                <option value="0"
                <?php if (isset($_POST['publisher']) && $_POST['publisher'] == '0')
                echo 'selected="selected"';?>>Select publisher</option>
                <option value="other"
                <?php
                if (isset($_POST['publisher']) && $_POST['publisher'] == 'other')
                echo 'selected="selected"';
                ?>
                >Not listed</option>
                <?php
                while ($row = $publishers->fetch_assoc()) {
                echo '<option value="'.$row['pub_id'].'"';
                if (isset($_POST['publisher']) && $_POST['publisher'] == $row['pub_id'])
                echo 'selected="selected"';
                echo '>'.$row['publisher'].'</option>';
                }
                // close database connection
                $conn_db->close();
                ?>
                </select></td>
            </tr>
            <tr>
                <th class="leftLabel">Image:</th>
                <td>Yes
                <input name="image" type="radio" value="y"
                <?php
                if (!$_POST || (isset($_POST['image']) && $_POST['image'] == 'y')) {
                echo 'checked="checked"';
                }?> />
                No
                <input name="image" type="radio" value="n"
                <?php if (isset($_POST['image']) && $_POST['image'] == 'n')
                echo 'checked="checked"';?> /></td>
            </tr>
            <tr>
                <th class="leftLabel">Description:</th>
                <td><textarea name="description" id="description"><?php
                if (isset($_POST['description'])) echo $_POST['description']; ?></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="Submit" value="Insert new book" /></td>
            </tr>
        </table>
    </form>


</div>  <!-- end main content -->

</body>
<?php
require_once("./includes/footer.inc.php");
?>
</html>
