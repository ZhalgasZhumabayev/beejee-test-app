<header>
        <?php if($_SESSION['admin'] == "123") { ?>
            <button type="button" class="btn-auth btn btn-outline-warning" onClick="location = '/public/task/logout'">Logout</button>
            <button type="button" class="btn-auth btn btn-outline-warning" onClick="location = '/public/'">Start Page</button>
        <?php } elseif ($_SESSION['admin'] == '') { ?>
            <button type="button" class="btn-auth btn btn-outline-warning" onClick="location = '/public/login/'">Login</button>
            <button type="button" class="btn-auth btn btn-outline-warning" onClick="location = '/public/'">Start Page</button>
        <?php } else { ?>
        <?php } ?>
</header>
<div>
    <h1 class="title">Task List</h1>
    <button type="button" class="btn btn-outline-success btn-auth" data-toggle="modal" data-target="#addTaskModal">Create task</button>

    <div class="form-group sort-box">
        <label for="sortSelect" class="margin-bottom">Sorting</label>
        <select class="form-control margin-bottom" id="sortSelect" name="sortSelect">
            <option value="1" <?php if($params['sort_type'] == 1 || $params['sort_type'] == null){ echo 'selected'; } ?>>By ID asc</option>
            <option value="2" <?php if($params['sort_type'] == 2){ echo 'selected'; } ?>>By ID desc</option>
            <option value="3" <?php if($params['sort_type'] == 3){ echo 'selected'; } ?>>By Username asc</option>
            <option value="4" <?php if($params['sort_type'] == 4){ echo 'selected'; } ?>>By Username desc</option>
            <option value="5" <?php if($params['sort_type'] == 5){ echo 'selected'; } ?>>By Email asc</option>
            <option value="6" <?php if($params['sort_type'] == 6){ echo 'selected'; } ?>>By Email desc</option>
            <option value="7" <?php if($params['sort_type'] == 7){ echo 'selected'; } ?>>By Status asc</option>
            <option value="8" <?php if($params['sort_type'] == 8){ echo 'selected'; } ?>>By Status desc</option>
        </select>

        <button type="submit" class="btn btn-primary margin-bottom sort-btn" onClick="sort()">Apply</button>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">UserName</th>
            <th scope="col">Email</th>
            <th scope="col">Task Desc</th>
            <th scope="col">Status</th>
            <?php
                if ( $_SESSION['admin'] == "123" ) {
                    echo '<th scope="col">Edit</th>';
                }
            ?>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach($data as $row)
        {

            if ($row['edited'] == 1 && $row['status'] == 1) {
                $state = 'Done and Edited by Admin';
            } else if ($row['edited'] == 1 && $row['status'] == 0) {
                $state = 'Wait and Edited by Admin';
            } else if ($row['status'] == 0){
                    $state = 'Wait';
            } else if ($row['status'] == 1) {
                $state = 'Done';
            }

            if ( $_SESSION['admin'] == "123" ) {
                $edit='<form action="editTask" method="post"><input type="hidden" name="task_id" value="' . $row['id'] . '"><button type="submit" class="btn btn-outline-success">Edit</button></form>';
            } else {
                $edit = '';
            }

            echo 
                '<tr><th scope="row">'
                . $row['id'] .
                '</th><td>'
                . $row['username'] .
                '</td><td>'
                . $row['email'] .
                '</td><td>'
                . $row['task_desc'] .
                '</td><td>'
                . $state .
                '</td><td>'
                . $edit .
                '</td></tr>';
        }

        ?>
    </tbody>
</table>

<ul class="pagination">
    <li class="page-item"><a class="page-link" onClick="insertParam('pg_num','1')">First</a></li>
    <li class="page-item <?php if($params['pg_num'] <= 1){ echo 'disabled'; } ?>">
        <a class="page-link" href="#" onClick="prev()">Prev</a>
    </li>
    <li class="page-item <?php if($params['pg_num'] >= $params['total_pages']){ echo 'disabled'; } ?>">
        <a class="page-link" href="#" onClick="next()">Next</a>
    </li>
    <li class="page-item"><a class="page-link" onClick="insertParam('pg_num',<?php echo $params['total_pages']; ?>)">Last</a></li>
</ul>

<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="public/task/addTask" method="post" name="addTask">
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="name" name="username" class="form-control" id="name" placeholder="User">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                    </div>

                    <div class="form-group">
                        <label for="task_desc">Task Description</label>
                        <input type="text" name="task_desc" class="form-control" id="task_desc" placeholder="Description">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>