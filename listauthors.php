<?php
require_once('./includes/admin_funcs.inc.php');
require_once('./includes/database.inc.php');
require_once('./includes/change_host.inc.php');

$getAuthors = 'SELECT author_id,
               CONCAT(first_name," ",UPPER(family_name)) AS author
			   FROM authors ORDER BY family_name, first_name';
$result = $conn_db->query($getAuthors);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="UTF-8">
    <title>Authors registered</title>
    <link href="styles/admin.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
    function checkDel(who,id) {
      var msg = 'Are you sure you want to delete '+who+'?';
      if (confirm(msg))
        location.replace('del_auth_pub.php?name='+who+'&author_id='+id);
      }
    </script>
</head>
<body>
<p style="line-height:1.25em; color:#666;"><h1>Book Depository</h1></p>
<?php insertMenu(); ?>
<div id="maincontent">
<h1>Authors registered in the database</h1>
<?php
if (isset($_GET['author']))
  echo '<p id="alert">'.stripslashes($_GET['author']).' has been updated in the database</p>';
?>
<table>
<?php
$i = 1;
while ($row = $result->fetch_assoc()) {
?>
  <tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
    <td><?php echo $row['author']; ?></td>
    <td><a href="edit_auth_pub.php?table=authors&type=author_id&num=<?php echo $row['author_id']; ?>">edit</a></td>
    <td><a href="javascript:checkDel('<?php echo addslashes($row['author']); ?>',<?php echo $row['author_id']; ?>)">delete</a></td>
  </tr>
<?php
  $i++;
  }
// close the database connection
$conn_db->close();
?>
</table>
</div>
</body>
<?php
require_once("./includes/footer.inc.php");
?>
</html>
