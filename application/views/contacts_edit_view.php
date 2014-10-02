<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Editing List: <?=$listID;?></h3>
        </div>
        <div class="panel-body">
            <table id="table" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <?php 
                        foreach ($headers as $header)
                            if ($header != 'id')
                                echo "<th>$header</th>";
                        ?>
                        <th>Remove?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($table as $entry)
                    {
                        echo '<tr>';
                        foreach ($headers as $header)
                            if ($header == 'id')
                                $id = $entry->$header;
                            else
                                echo '<td><a href="#" data-name="'.$header.'" data-pk="'.$id.'">'.$entry->$header.'</a></td>';
                                echo '
                                <td>
                                    <button id="'.$id.'" class="btn btn-default btn-xs delete" type="button">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </td>';
                        echo '</tr>';
                    }
                    ?>
                    <!-- TODO Paginate results
                    <tr>
                        <td align="right" colspan="3">Previous Next</td>
                    </tr>
                    -->
                </tbody>
            </table>
        </div>
    </div>
    <p>For help with the newsletter creator please contact <a href="<?php echo 'mailto:'.$this->config->item('support_email');?>"><?php echo $this->config->item("support_email");?></a>. &copy; Andrew Niemantsverdriet 2013</p>
</div> <!-- /container -->
