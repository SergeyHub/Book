<?php
require_once("./includes/admin_funcs.inc.php");
if (isset($_GET)) {
	require_once("./includes/database.inc.php");
    // create a Database instance, and set error reporting to plain text 
	require_once('./includes/change_host.inc.php');
	
   if (!get_magic_quotes_gpc()) stripslashes($_GET['name']);
  // if query string includes author_id
  if (isset($_GET['author_id'])) {
    $author_id = $_GET['author_id'];
    // check whether author still listed in the lookup table
	$checkBooks = "SELECT book_id FROM book_to_author
	               WHERE author_id = $author_id";
	$titles = checkExisting($conn_db,$checkBooks);
	// if no titles listed in lookup table, proceed with deletion
	if (empty($titles)) {  
	  $deleteAuthor = "DELETE FROM authors
	                   WHERE author_id = $author_id";
	  $result = $conn_db->query($deleteAuthor);
	  if ($result) $deleted = $_GET['name'].' has been removed from the authors table';
	  }
    }
  // if query string includes pub_id
  elseif (isset($_GET['pub_id'])) {
    $pub_id = $_GET['pub_id'];
    // check whether published still listed in the books table
	$checkBooks = "SELECT book_id FROM books
	               WHERE pub_id = $pub_id";
	$titles = checkExisting($conn_db,$checkBooks);
	// if no titles listed for that publisher, proceed with deletion
	if (empty($titles)) {
	  $deletePublisher = "DELETE FROM publishers WHERE pub_id = $pub_id";
	  $result = $conn_db->query($deletePublisher);
	  if ($result) $deleted = $_GET['name'].' has been removed from the publishers table';
	  }    
    }
  // if author_id, $type is 'author'; otherwise, 'publisher'
  $type = isset($author_id) ? 'author' : 'publisher';
  }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="UTF-8">
<title>Delete <?php echo $type; ?></title>
<link href="styles/admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<p style="line-height:1.25em; color:#666;"><h1>Book Depository</h1></p>
<?php insertMenu(); ?>
<div id="maincontent">
<h1>Delete <?php echo $type; ?></h1>
<?php
// if $titles is not empty, the delete process has been abandoned
if (!empty($titles)) {
  // adjust message if only one book is in the list
  $book = count($titles) > 1 ? 'books are' : 'book is';
  echo '<p id="alert">'.$_GET['name']." cannot be removed, as the following $book registered in that {$type}'s name:</p><ul>";
  // display list of books still registered
  foreach ($titles as $title) {
    echo "<li>$title</li>";
	}
  echo '</ul>';
  }
// if delete operation completed, display confirmation message
elseif (isset($deleted)) {
  echo "<p>$deleted</p>";
  }
?>
</div>
</body>
<?php
require_once("./includes/footer.inc.php");
?>
</html>
