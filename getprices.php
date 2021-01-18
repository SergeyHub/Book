<?php
require_once('./includes/admin_funcs.inc.php');
require_once('./includes/database.inc.php');
require_once('./includes/change_host.inc.php');
?>
<!DOCTYPE html >
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="UTF-8" />
<title>Get book prices</title>
<link href="styles/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<p style="line-height:1.25em; color:#666;"><h1>Book Depository</h1></p>
<?php insertMenu(); ?>
<div id="maincontent">
  <table>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">List price</th>
      <th scope="col">Store price</th>
    </tr>
<?php
if (!file_exists("./assets/bookprices.xml")) {
  echo '<tr><td colspan="3">Can\'t find XML feed</td></tr>';
  }
else {
  // load XML file as a SimpleXML object
  $xml = simplexml_load_file("./assets/bookprices.xml");
  // loop through each Book element to extract ListPrice, OurPrice and
  // ISBN, and use the details to update the books table
  foreach ($xml->Book as $book) {
    $updatePrices = "UPDATE books SET list_price ='$book->ListPrice',
                     store_price = '$book->OurPrice'
                     WHERE isbn = '$book->ISBN'";
    $conn_db->query($updatePrices);
    // get the price information from the books table
    $confirmUpdate = "SELECT title, list_price, store_price
                      FROM books WHERE isbn = '$book->ISBN'";
    $result = $conn_db->query($confirmUpdate);
    // if that ISBN exists in the database, display the result
    if ($result->num_rows) {
      $row = $result->fetch_assoc();
      echo '<tr><td>'.$row['title'].'</td><td>'.$row['list_price'].'</td>';
      echo '<td>'.$row['store_price'].'</td></tr>';
      }
    }
  }
?>
  </table>
</div>
</body>
</html>

 
