<?php
require_once('./includes/admin_funcs.inc.php');
// include Database classes
require_once('./includes/database.inc.php');
if ($_GET && !$_POST) {
  // get details of record to be edited  ............................................
  require_once('./includes/change_host.inc.php');
  
  $getDets = 'SELECT * FROM '.$_GET['table'];
  $getDets .= ' WHERE '.$_GET['type'].' = '.$_GET['num'];
  $result = $db->query($getDets);
  $row = $result->fetch_assoc();
  }
elseif ($_POST) {
  // escape quotes and apostrophes if magic_quotes_gpc off
  if (!get_magic_quotes_gpc()) {
  foreach($_POST as $key=>$value) {
      $temp = addslashes($value);
      $_POST[$key] = $temp;
      }
    }
  // create Database instance  .....................................................
  require_once('./includes/change_host.inc.php');
  
  // if the "Update author name" button has been clicked 
  if (array_key_exists('updateAuthor', $_POST)) {
    // code for updating author
    $first_name = $_POST['first_name'];
    $family_name = $_POST['family_name'];
    $author_id = $_POST['author_id'];
    $checkName = "SELECT * FROM authors
                  WHERE first_name = '$first_name'
                  AND family_name = '$family_name'
                  AND author_id != $author_id";
    $result = $db->query($checkName);
    if ($result->num_rows > 0) {
      $authorAlert = "$first_name $family name is already registered";
      }
    if (!isset($authorAlert)) {
      $updateAuthor = "UPDATE authors SET first_name = '$first_name',
                       family_name = '$family_name'
                       WHERE author_id = $author_id";
      $result = $db->query($updateAuthor);
      if ($result) {
	    $db->close();
        $author = urlencode("$first_name $family_name");
        header('Location: listauthors.php?author='.$author);
        }
      }
    }
  // if the "Insert new publisher" button has been clicked
  elseif (array_key_exists('updatePublisher', $_POST)) {
    // code for updating publisher
	$publisher = $_POST['publisher'];
	$pub_id = $_POST['pub_id'];
	$checkName = "SELECT * FROM publishers
	              WHERE publisher = '$publisher'
				  AND pub_id != $pub_id";
	$result = $db->query($checkName);
	if ($result->num_rows > 0) {
	  $publisherAlert = "$publisher is already registered";
	  }
	if (!isset($publisherAlert)) {
	  $updatePublisher = "UPDATE publishers SET publisher = '$publisher'
	                      WHERE pub_id = $pub_id";
	  $result = $db->query($updatePublisher);
	  if ($result) {
	    $db->close();
		header('Location: listpub.php?pub='.$publisher);
		}
	  }
    }
  // close database connection
  $db->close();
  }
?>
<!DOCTYPE html >
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="UTF-8" />
<title>Insert authors and publishers</title>
<link href="styles/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<p style="line-height:1.25em; color:#666;"><h1>Book Depository</h1></p>
<?php insertMenu(); ?>
<div id="maincontent">
  <h1>Edit author name</h1>
  <?php
  if (isset($authorAlert))
    echo '<p id="alert">'.$authorAlert.'</p>';
  ?>
  <form name="authorDets" id="authorDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <table>
      <tr>
        <th scope="row" class="leftLabel">First name: </th>
        <td><input name="first_name" type="text" id="first_name" class="mediumbox"
		value="<?php if (isset($row['first_name'])) echo $row['first_name']; ?>"
		/></td>
      </tr>
      <tr>
        <th scope="row" class="leftLabel">Family name: </th>
        <td><input name="family_name" type="text" id="family_name" class="mediumbox"
		value="<?php if (isset($row['family_name'])) echo $row['family_name']; ?>"
		/></td>
      </tr>
      <tr>
      <th><input name="author_id" type="hidden" id="author_id"
	  value="<?php if (isset($row['author_id'])) echo $row['author_id']; ?>" />
</th>
      <td><input name="updateAuthor" type="submit" id="updateAuthor" value="Update author name" /></td>
      </tr>
    </table>
  </form>
  <h1>Edit publisher</h1>
  <?php
  if (isset($publisherAlert))
    echo '<p id="alert">'.$publisherAlert.'</p>';
  ?>
  <form name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <table>
      <tr>
        <th scope="row" class="leftLabel">Publisher:</th>
        <td><input name="publisher" type="text" id="publisher" class="mediumbox"
		value="<?php if (isset($row['publisher'])) echo $row['publisher']; ?>"
		/></td>
      </tr>
      <tr>
        <th><input name="pub_id" type="hidden" id="pub_id"
	  value="<?php if (isset($row['pub_id'])) echo $row['pub_id']; ?>" /></th>
      <td><input name="updatePublisher" type="submit" id="updatePublisher" value="Update publisher" /></td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>
