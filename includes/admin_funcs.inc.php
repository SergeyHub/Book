<?php
//....................................
function insertMenu() {
    $pages = array("listbooks.php"    => 'List books',
        "listauthors.php"  => 'List authors',
        "listpub.php"      => 'List publishers',
        "new_book.php"     => 'New book',
        "new_auth_pub.php" => 'New author/publisher',
        "getprices.php"    => 'Get prices');
    ?>
    <div id="menu">
        <ul>
            <?php
            foreach ($pages as $file => $listing) {
                echo '<li';
                if (strpos($_SERVER['SCRIPT_FILENAME'],$file)) {
                    echo ' id="uberlink"><a href="javascript:;"';
                }
                else {
                    echo '><a href="'.$file.'"';
                }
                echo '>'.$listing.'</a></li>';
            }
            ?>
        </ul>
    </div>
    <?php
}

function checkExisting($db,$sql) {
    // create an empty array to hold the titles
    $titles = array();
    // execute the SQL query and create an array of book_id values
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $book_id[] = $row['book_id'];
        }
        // join the book_id values into a comma-delimited string
        $books = implode(',',$book_id);
        // pass to the getTitles function
        $result = getTitles($db,$books);
        // convert the result to an array of titles
        while ($row = $result->fetch_assoc()) {
            $titles[] = $row['title'];
        }
    }
    return $titles;
}

function getTitles($db,$books) {
    $getTitles = "SELECT title FROM books WHERE book_id IN ($books)";
    $result = $db->query($getTitles);
    return $result;
}

?>