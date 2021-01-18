<?php
require_once('./includes/admin_funcs.inc.php');
require_once('./includes/database.inc.php');
require_once('./includes/change_host.inc.php');

$getPublishers = 'SELECT * FROM publishers ORDER BY publisher';
$result = $conn_db->query($getPublishers);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Dummy White Box Company</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Publishers registered</title>
<link href="styles/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function checkDel(who,id) {
  var msg = 'Are you sure you want to delete '+who+'?';
  if (confirm(msg))
    location.replace('del_auth_pub.php?name='+who+'&pub_id='+id);
  }
</script>
</head>
<body>
<p style="line-height:1.25em; color:#666;"><h1>Book Depository</h1></p>
<?php insertMenu(); ?>
<div id="maincontent">
<h1>Publishers registered in the database</h1>
<?php
if (isset($_GET['pub']))
  echo '<p id="alert">'.stripslashes($_GET['pub']).' has been updated</p>';
?>
<table>

<?php  //.............................................
$i = 1;
while ($row = $result->fetch_assoc()) {   //..........
?>  

  <tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
    <td><?php echo $row['publisher']; ?></td>
    <td><a href="edit_auth_pub.php?table=publishers&type=pub_id&num=<?php echo $row['pub_id']; ?>">edit</a></td>
    <td><a href="javascript:checkDel('<?php echo addslashes($row['publisher']); ?>',<?php echo $row['pub_id']; ?>)">delete</a></td>
  </tr>

<?php 
  $i++;
  }
$conn_db->close();
?>

</table>
</div>
</body>
<?php
require_once("./includes/footer.inc.php");
?>

</html>