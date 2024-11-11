<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>7Learn</title>
    <link rel="stylesheet" href="<?php __DIR__ ?>assets/css/style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="page">
    <div class="pageHeader">
        <div class="title">Dashboard</div>
        <div class="userPanel"><a  onclick="return confirm('Are You Sure??')" href="<?= site_url('?logout')  ?>"><i class="fa fa-sign-out"></i></a><span class="username"><?=  $_SESSION['login']->name ?></span><img
                    src="https://s3.amazonaws.com/uifaces/faces/twitter/kolage/73.jpg" width="40" height="40"/></div>
    </div>
    <div class="main">
        <div class="nav">
            <div class="searchbox">
                <div><i class="fa fa-search"></i>
                    <input type="search" placeholder="Search"/>
                </div>
            </div>
            <div class="menu">
                <div class="title">Folders</div>
                <ul class="folder-list">
                    <li class="<?= $_GET['folder_id'] == null ? 'active' : '' ?>">
                        <a href="?folder_id=<?= '' ?>">
                            <i class="fa fa-folder"></i> <a href="<?= BASE_URL ?>">All</a>
                        </a>
                    </li>
                    <?php foreach ($folders as $folder) { ?>


                        <li class="<?= $_GET['folder_id'] === $folder->id ? 'active' : '' ?>">
                            <a href="?folder_id=<?= $folder->id ?>">
                                <i class="fa fa-folder"></i><?php echo $folder->name ?>
                            </a>
                            <a href="?delete_folder=<?= $folder->id ?>" class="remove">
                                x
                            </a>
                        </li>
                    <?php } ?>


                </ul>
            </div>
            <div class="searchbox">
                <input type="text" id="addFolderInput" style='width: 65%;margin-left:3%' placeholder="Add New Folder"/>
                <button id="addFolderBtn" class="btn clickable">+</button>
            </div>
        </div>

        <div class="view">
            <div class="viewHeader">
                <div class="title" style="width: 50%">
                    <input type="text" id="taskNameInput" style='width: 65%;margin-left:3%' placeholder="Add New Task"/>

                </div>
                <div class="functions">
                    <div class="button active">Add New Task</div>
                    <div class="button">Completed</div>
                </div>
            </div>
            <div class="content">
                <div class="list">
                    <div class="title">Today</div>
                    <ul>
                        <?php if (count($tasks) > 0)  : ?>
                            <?php foreach ($tasks as $task) { ?>
                                <li class="<?= $task->is_done === '1' ? 'checked' : '' ?>">
                                    <i id="task" data-taskId="<?= $task->id ?>"  class="isDone clickable <?= $task->is_done === '1' ? 'fa fa-check-square-o' : 'fa fa-square-o' ?>"></i><span><?= $task->title ?></span>
                                    <div class="info">

                                        <span style="margin-right: 10px; font-size: 12px"><?= $task->created_at ?></span>
                                        <a href="?delete_task=<?= $task->id ?>" class="remove"
                                           onclick="return confirm('Are You Sure??')">
                                            x
                                        </a>
                                    </div>
                                </li>
                            <?php } ?>
                        <?php else: ?>
                            <li>NO Tasks Here</li>
                        <?php endif ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- partial -->
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="<?php __DIR__ ?>assets/js/script.js"></script>
<script>
    $(".isDone").click(function (e){
       var tid = $(this).attr('data-taskId');
        $.ajax({
            url: "process/ajaxHandler.php",
            method: "post",
            data: {action: "doneSwitch", taskId:tid},
            success: function (response) {
                if (response == '1') {
                location.reload();
                } else {
                    alert(response)
                }
            }
        });
    });



    $('#addFolderBtn').click(function (e) {
        var input = $('input#addFolderInput');
        $.ajax({
            url: "process/ajaxHandler.php",
            method: "post",
            data: {action: "addFolder", folderName: input.val()},
            success: function (response) {
                if (response == '1') {
                    $('<li> <a href="#"><i class="fa fa-folder"></i>' + input.val() + '</a></li>').appendTo('ul.folder-list');
                } else {
                    alert(response)
                }
            }
        });
    });
    $('#taskNameInput').on('keypress', function (e) {
        e.stopPropagation();

        if (e.which == 13) {
            var input = $('#taskNameInput').val();
            var folder_id =  <?=  $_GET['folder_id'] ?? 0 ?>;
            $.ajax({
                url: "process/ajaxHandler.php",
                method: "POST",
                data: {action: "addTask", taskTitle: input, folderId: folder_id},
                success: function (response) {
                    if (response == '1') {
                        location.reload();
                    } else {
                        alert(response);
                    }
                }
            })

        }
    });
    $('#taskNameInput').focus();

</script>
</body>
</html>
