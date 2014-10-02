<div class="container">
    <div class="well">
        <h1>Report Builder</h1>
        <p>Select which campaign you would like to view from the list.</p>
        <?= form_open('reports', array('role' => 'form', 'id' => 'reports')); ?>
            <div class="form-group">
                <label for="campaign">Campaign ID</label>
                <select class="form-control" name="campaign" id="campaign">
                    <?php foreach ($records as $row): ?>
                    <option><?=$row->campaign;?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" id="action" name="action" value="view">
            </div>
            <button type="submit" class="btn btn-primary">View Campaign</button>
            <button class="btn btn-default" data-toggle='modal' data-target="#confirm">Delete Campaign</button>
        </form>
        <div class="modal fade" id="confirm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to do this?<br>This operation is permanent and can't be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button id="deleteBtn" type="button" class="btn btn-primary">Yes, Delete</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <p>For help with the newsletter creator please contact <a href="<?php echo 'mailto:'.$this->config->item('support_email');?>"><?php echo $this->config->item("support_email");?></a>. &copy; Andrew Niemantsverdriet 2013</p>
</div> <!-- /container -->
