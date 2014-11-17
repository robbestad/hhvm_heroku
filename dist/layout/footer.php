<footer>
    <div class="width">
        <?php
        if (defined('HHVM_VERSION')) {
            echo "HHVM ", HHVM_VERSION, " (Reporting PHP v.: ", PHP_VERSION, ")\n";
        } else {
            echo "PHP ", PHP_VERSION, "\n";
        }
        ?>
    </div>
</footer>
</body>

<!-- Fonts -->
<!--<script src="//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>-->
<!-- Contains jQuery, React and various plugins -->
<script type="text/javascript" src="./js/libs.min.js"></script>
<!-- Contains compiled js (included jsx) -->
<script type="text/javascript" src="./js/scripts.min.js"></script>
</body>
</html>


