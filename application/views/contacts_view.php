<div class="container">
    <?php
        // Display alert logic
        $msg = '';
        if (isset($error)) { $msg = $error; }
        if (validation_errors()) { $msg = validation_errors(); }

        if ($msg != '')
        {
        echo '
        <div class="alert alert-warning fade in">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
            <strong>Holy guacamole!</strong>
            <p>'.$msg.'</p>
        </div>';
        }
    ?>
    <div class="well">
        <h1>Contact Lists</h1>
        <p>Build or upload new lists and edit existing ones.</p>
        <h2>Create New List or <a data-toggle="modal" href="#upload">upload file</a></h2>
        <?= form_open('contacts', array('role' => 'form')); ?>
            <div class="form-group">
                <label for="listName">List Name</label>
                <input class="form-control" name="listName" id="listName" value="<?= set_value('listName') ?>">
            </div>
            <div class="form-group">
                <label for="listMembers">List Members</label>
                <textarea class="form-control" id='listMembers' name='listMembers' rows="7"><?= set_value('listMembers') ?></textarea>
                <p class="help-block">One email address per line</p>
            </div>
            <button type="submit" class="btn btn-primary">Create List</button>
        </form>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Manage Lists</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>List Name</th>
                    <th># of Members</th>
                    <th>Delete?</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($lists as $key=>$value): ?>
                <tr>
                    <td><?='<a href="'.site_url('/contacts/edit/'.$key).'">'.$key.'</a>';?></td>
                    <td><?=$value;?></td>
                    <td>
                        <button id="<?=$key;?>" class="btn btn-default btn-sm btn-remove" type="button">
                            <span class="glyphicon glyphicon-trash"></span>
                            Remove list
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="removeList">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to do this?<br>This operation is permanent and can't be undone.</p>
                        <p>All historical statistical data will be lost</p>
                    </div>
                    <div class="modal-footer">
                        <?= form_open('contacts/delete', array('role' => 'form')); ?>
                            <input type="hidden" id="listID" name="listID">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Yes, Delete</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="panel-footer"></div>
    </div>
    <p>For help with the newsletter creator please contact <a href="<?php echo 'mailto:'.$this->config->item('support_email');?>"><?php echo $this->config->item("support_email");?></a>. &copy; Andrew Niemantsverdriet 2013</p>
</div> <!-- /container -->
