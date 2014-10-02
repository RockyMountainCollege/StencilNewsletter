        <!-- Bootstrap core JavaScript
        ================================================== -->
        <script src="<?= base_url('/assets/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('/dist/js/bootstrap.min.js'); ?>"></script>
        <!-- Custom JavaScript Functions-->
        <?php
            if(isset($js)) {
                foreach($js as $script)
                {
                    echo '<script src="'.base_url("/assets/js/$script").'"></script>';
                }
            }
        ?>
    </body>
</html>
