<!-- Modal -->
<div class="modal fade" id="recipients" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Select Recipients</h4>
            </div>
            <div class="modal-body">
                <p>Select the list that you want the email to go to.</p>
                <select name="recipientList" class="form-control" value="<?=set_value('recipientList');?>">
                    <?php foreach ($records as $row): ?>
                    <option><?=$row->list_name;?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-footer">
            <button id="recipient" type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
