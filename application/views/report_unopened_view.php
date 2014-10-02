<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>ID #</th>
            <th>E-Mail</th>
            <th>Event</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($log as $row): ?>
        <tr>
            <td><?=$row->id;?></td>
            <td><?=$row->email;?></td>
            <td><?=$row->event;?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
