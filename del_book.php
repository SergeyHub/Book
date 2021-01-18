<?php
require_once("./includes/admin_funcs.inc.php");
require_once("./includes/database.inc.php");
// create a Database instance, and set error reporting to plain text
require_once('./includes/change_host.inc.php');

// if OK button has been clicked, delete the books from the database
if ($_POST && array_key_exists('confDel',$_POST)) {
  $books = $_POST['book_id'];
  $titles = getTitles($conn_db,$books);
  // multiple-table delete ** REQUIRES MySQL 4.0 OR HIGHER **
  $deleteBooks = "DELETE FROM books, book_to_author
                  USING books, book_to_author
                  WHERE books.book_id IN ($books)
                  AND book_to_author.book_id IN ($books)";
  $booksDeleted = $conn_db->query($deleteBooks);
  }
// if Cancel button has been clicked, go to listbooks.php
elseif ($_POST && array_key_exists('cancel',$_POST)) {
  header('Location: listbooks.php');
  }
// if loaded from listbooks.php, get details of books to be deleted
elseif (isset($_GET['delete'])) {
  $books = $_GET['delete'];
  $titles = getTitles($conn_db,$books);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="UTF-8" />
<title>Delete book confirmation</title>
<link href="styles/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<p style="line-height:1.25em; color:#666;"><h1>Book Depository</h1></p>
<?php
insertMenu();                       // define in includes/admin.inc.php
if (isset($booksDeleted)) {
  $alert = 'The following ';
  $alert .= $titles->num_rows > 1 ? 'titles were deleted:' : 'title was deleted:';
  }
elseif (isset($_GET) && isset($titles)) {
  $alert = 'Please confirm you want to delete the following:';
  }
echo "<p id='alert'>$alert</p><ul>";
while ($row = $titles->fetch_assoc()) {
  echo '<li>'.$row['title'].'</li>';
  }
?>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" name="deleteBooks" id="deleteBooks">
  <input name="confDel" type="submit" id="confDel" value="OK" />
  <input name="cancel" type="submit" id="cancel" value="Cancel" />
  <input name="book_id" type="hidden" id="book_id" value="<?php echo $books;?>" />
</form>
</body>
<?php
require_once("./includes/footer.inc.php");
?>
</html>
