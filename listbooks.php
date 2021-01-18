<?php
    if ($_POST && array_key_exists('editBook',$_POST) && !empty($_POST['book_id']))
        {
          header('Location: editbook.php?book_id='.$_POST['book_id'][0]);
        }
    elseif ($_POST && array_key_exists('delBook',$_POST) && !empty($_POST['delete']))
        {
          header('Location: del_book.php?delete='.implode(',',$_POST['delete']));
        }
    require_once('./includes/admin_funcs.inc.php');
    require_once('./includes/database.inc.php');
    require_once('./includes/change_host.inc.php');

    $getbooks = 'SELECT books.book_id, title, 
                 CONCAT(LEFT(first_name,1),". ",family_name) AS author
                 FROM books, book_to_author
                 LEFT JOIN authors USING (author_id)
                 WHERE books.book_id = book_to_author.book_id
                 ORDER BY title, family_name';
    // get details of books from database
    $bookDets = $conn_db->query($getbooks);
    // if the result not empty, create arrays of book_id, title, and author
    if ($bookDets->num_rows) {
        while ($row = $bookDets->fetch_assoc()) {
            $book_id[] = $row['book_id'];
            $title[] = $row['title'];
            $author[] = $row['author'];
        }
        // find total number of elements in each array (all are same length)
        $totalResults = count($book_id);
        // initialize counter for 'author' subarray
        $counter = 0;
        // loop to create a single multidimensional array for each book
        for ($i = 0, $k = 0; $k < $totalResults; $k++) {
            $book[$i]['book_id'] = $book_id[$k];
            $book[$i]['title'] = $title[$k];
            $book[$i]['author'][$counter++] = $author[$k];
            // if book_id of next element is different,
            // increment book counter and reset author counter to zero
            if (($k < $totalResults-1) && ($book_id[$k+1] != $book_id[$k])) {
              $i++;
              $counter = 0;
              }
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>List books</title>
    <link href="./styles/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <p style="line-height:1.25em; color:#666;"><h1>Book Depository</h1></p>
    <?php if (isset($_GET['action']) && isset($_GET['title'])) {
      echo '<p id="alert">'.stripslashes($_GET['title']).' has been ';
      echo $_GET['action'].' in the database!.</p>';
      }
        insertMenu();
    ?>
    <div id="maincontent">
        <form name="list" id="list" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            <table id="booklist">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Authors</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
                <?php if (!isset($book)) { ?>
                    <tr><td colspan="4">No books listed</td></tr>
                    <?php
                }
                else { // if URL contains query string, use it to initialize $start
                    if (isset($_GET['start'])) {
                    $start = $_GET['start'];
                    }
                    else { // otherwise set $start to zero
                    $start = 0;
                    }
                    // set value of maximum number of records to display
                    $max = 10;
                    if ($start+$max > count($book)) {
                    // if $start + $max greater than total number of records
                    // set the loop limit to the total number, otherwise $start + $max
                    $display = count($book);
                    }
                    else {
                    $display = $start+$max;
                    }
                    // initialize loop to begin from the value of $start
                    for ($i = $start; $i < $display; $i++) { ?>
                        <tr class="<?php echo $i%2 ? 'hilite' : 'nohilite'; ?>">
                            <td>
                                <?php
                                    echo $book[$i]['title'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    array_splice($book[$i]['author'],3);
                                    echo implode(', ',$book[$i]['author']);
                                ?>
                            </td>
                            <td class="ctr">
                                <input name="book_id[]"
                                       type="radio"
                                       value="<?php echo $book[$i]['book_id']; ?>" />
                            </td>
                            <td class="ctr">
                                <input name="delete[]"
                                       type="checkbox"
                                       value="<?php echo $book[$i]['book_id']; ?>" />
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2">
                            <?php if ($start > 0) {
                                echo '<a href="'.$_SERVER['PHP_SELF'].'?start='.($start-$max).'">';
                                echo '&lt;&lt; Prev</a>'; }
                            ?>
                        </td>
                    <td colspan="2">
                        <?php if (count($book) > ($start+$max)) {
                            echo '<a href="'.$_SERVER['PHP_SELF'].'?start='.($start+$max).'">';
                            echo 'Next &gt;&gt;</a>'; }
                        ?>
                    </td>
                    </tr>
              <?php } ?>
                  <tr>
                    <td class="button" colspan="4">
                        <input
                               name="editBook"
                               type="submit"
                               id="editBook"
                               value="Edit book"
                        />
                        <input
                               name="delBook"
                               type="submit"
                               id="delBook"
                               value="Delete book(s)"
                        />
                    </td>
                  </tr>
            </table>
        </form>

    </div>  <!-- end maincontent -->

</body>
</html>
