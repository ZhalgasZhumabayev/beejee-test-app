<?php 
    echo '<h1>Task id: ' . $data['id'] . '</h1>';
?>

<form action="public/task/saveTask" method="post">
    <div class="form-group">
        <label for="name">Task Description</label>
        <input type="hidden" name="task_id" value="<?php echo $data['id'] ?>">
        <input type="text" name="task_desc_edit" class="form-control" id="name" value="<?php echo $data['task_desc']?>">
    </div>

    <div class="form-group">
        <label for="stateSelect">Select State</label>
        <select class="form-control" name="stateSelect" id="stateSelect">
            <option value="0">Wait</option>
            <option value="1">Done</option>
        </select>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onClick="location = '/public/task/index'">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>  
</form>