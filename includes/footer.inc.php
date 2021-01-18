<div id="footer">

    <p>&copy;
        <?php
        $startYear = 2009;
        $thisYear = date('Y');
        if ($startYear == $thisYear) {
            echo $startYear;
        } else {
            echo "{$startYear}&#8211;{$thisYear}".".";
        }
        ?>
        Page last modified
        <?php $filename=basename($_SERVER['PHP_SELF']); echo strftime("%d %B %Y",filemtime($filename)); ?>.
        <br />To make an inquiry, follow
        <a href="http://www.Dummy Consortium.ru/contacts.php" style="color:#003366;font-weight:bold;"> this link</a>.

    </p>
</div>



