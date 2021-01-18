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
// this block runs when the GET array has been set
// the book_id in the query string is used to get the book's details
if ($_GET && !$_POST) {
  $book_id = $_GET['book_id'];
  // get details of book from the books table
  $getDets = "SELECT title,isbn,pub_id,image,description
              FROM books WHERE book_id = $book_id";
  $bookDets = $conn_db->query($getDets);
  // assign results to ordinary variables
  while ($row = $bookDets->fetch_assoc()) {
    $title = $row['title'];
    $isbn = $row['isbn'];
    $pub_id = $row['pub_id'];
    $image = $row['image'];
    $description = $row['description'];
    }
  // get list of authors from lookup table
  $getAuthors = "SELECT author_id FROM book_to_author
                 WHERE book_id = $book_id";
  $author_ids = $conn_db->query($getAuthors);
  // filter results into an array of authors
  while ($row = $author_ids->fetch_assoc()) {
    $authorList[] = $row['author_id'];
    }
  }
// this block runs only if the form has been submitted
if ($_POST && array_key_exists('updateBook',$_POST)) {
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
    // create a Database instance, and set error reporting to plain text
	require_once('./includes/change_host.inc.php');
	    
    // first check that the same ISBN doesn't already exist
    $checkISBN = 'SELECT isbn FROM books WHERE isbn = "'.$_POST['isbn'].'"
	              AND book_id != '.$_POST['book_id'];
    $result = $conn_db->query($checkISBN);
    if ($result->num_rows > 0) {
      $error[] = 'A book with that ISBN already exists in the database';
      }
    else {
      // if ISBN unique, update book in books table
      if ($_POST['publisher'] == 'other') $_POST['publisher'] = 0;
      $update = 'UPDATE books
                 SET title = "'.$_POST['title'].'",
                 isbn = "'.$_POST['isbn'].'",
                 pub_id = '.$_POST['publisher'].',
                 image = "'.$_POST['image'].'",
                 description = "'.$_POST['description'].'"
                 WHERE book_id = '.$_POST['book_id'];
      $result = $conn_db->query($update);
      // if "Select author(s)" still selected, remove it from the array
      if ($_POST['author'][0] == 'select') array_shift($_POST['author']);
      if (in_array('other',$_POST['author'])) {
        $i = array_search('other', $_POST['author']);
        $_POST['author'][$i] = 0;
        }
      // build array of book_id and author_id pairs, one for each author
      $values = array();
      foreach ($_POST['author'] as $author_id) {
        $values[] = '('.$_POST['book_id'].", $author_id)";
        }
      // convert array to comma delimited string
      $values = implode(',',$values);
      // delete existing records for this book in lookup table
      $deleteAuthors = 'DELETE FROM book_to_author
                        WHERE book_id = '.$_POST['book_id'];
      $conn_db->query($deleteAuthors);
      // insert revised book_id/author_id pairs into lookup table
      $createLookup = 'INSERT INTO book_to_author (book_id, author_id) 
                       VALUES '.$values;
      $result = $conn_db->query($createLookup);
      // if successful, redirect to confirmation page
      if ($result) {
        $conn_db->close();
        header('Location:listbooks.php?action=updated&title='.$_POST['title']);
        }
      }
	}
  }
?>
<!DOCTYPE html >
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="UTF-8" />
<title>Edit book</title>
<link href="styles/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<p style="line-height:1.25em; color:#666;"><h1>Book Depository</h1></p>
<?php insertMenu(); ?>
<div id="maincontent">
<h1>Edit book</h1>
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
      <td><input name="title" type="text" class="widebox" id="title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; 
	  elseif (isset($title)) echo $title; ?>" /></td>
    </tr>
    <tr>
      <th class="leftLabel">ISBN:</th>
      <td><input name="isbn" type="text" class="narrowbox" id="isbn" value="<?php if (isset($_POST['isbn'])) echo $_POST['isbn']; 
	  elseif (isset($isbn)) echo $isbn; ?>" /></td>
    </tr>
    <tr>
      <th class="leftLabel">Author(s):</th>
      <td><select name="author[]" size="6" multiple="multiple" id="author">
  <option value="choose" 
  <?php 
  if (isset($_POST['author']) && in_array('choose',$_POST['author'])) {
    echo 'selected="selected"'; } ?>
  >Select author(s)</option>
  <option value="other"
  <?php if (isset($authorList) && in_array(0,$authorList) || (isset($_POST['author']) && $_POST['author'] == 'other'))
    echo 'selected="selected"'; ?>
  >Not listed</option>
  <?php while ($row = $authors->fetch_assoc()) {
    echo '<option value="'.$row['author_id'].'"';
    if ((isset($authorList) && in_array($row['author_id'],$authorList)) || (isset($_POST['author']) && in_array($row['author_id'], $_POST['author']))) {
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
        if (isset($pub_id) && $pub_id == 0 || (isset($_POST['publisher']) && $_POST['publisher'] == 'other')) echo 'selected="selected"'; ?>
        >Not listed</option>
        <?php
        while ($row = $publishers->fetch_assoc()) {
          echo '<option value="'.$row['pub_id'].'"';
          if ((isset($pub_id) && $pub_id == $row['pub_id']) || (isset($_POST['publisher']) && $_POST['publisher'] == $row['pub_id']))
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
        <?php if ((isset($image) && $image == 'y') || (isset($_POST['image']) && $_POST['image'] == 'y')) {
          echo 'checked="checked"'; }?>  /> 
        No 
        <input name="image" type="radio" value="n" 
        <?php if ((isset($image) && $image == 'n') || (isset($_POST['image']) && $_POST['image'] == 'n')) echo 'checked="checked"';?> /></td>
    </tr>
    <tr>
      <th class="leftLabel">Description:</th>
      <td><textarea name="description" id="description"><?php 
	  if (isset($_POST['description'])) echo $_POST['description']; 
	  elseif (isset($description)) echo $description; ?></textarea></td>
    </tr>
    <tr>
      <td><input name="book_id" type="hidden" id="book_id" value="
      <?php if ($_GET) echo $book_id;
         elseif (isset($_POST['book_id'])) echo $_POST['book_id'];?>" /></td>
      <td><input type="submit" name="updateBook" value="Update book details" /></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
