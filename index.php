<?php include('./contenu.php'); ?>
<?php
ob_start();
/* echo '<pre>';
print_r($myToDo->getArchivedElements());
echo '</pre>'; */
?>
<html lang="fr">
    <head>
        <title>ToDo List</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/css/style.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            function boxChecked(key){      
                $.ajax({
                    url : './contenu.php',
                    type : 'POST',
                    data : 'checkedId=' + key
                });
                if(!document.querySelector('#form_aFaire #task-'+key).hasAttribute('checked')){
                    document.querySelector('#form_aFaire #task-'+key).setAttribute('checked','true');
                }else{
                    document.querySelector('#form_aFaire #task-'+key).removeAttribute('checked');
                }      
            };

            $("#form_aFaire").submit(function(event) {
                event.preventDefault();

                var formData = new FormData($("#form_aFaire"));

                $.ajax({
                    type: "POST",
                    url: "./contenu.php",
                    data: formData
                });
            });

            $("#form_addTask").submit(function(event) {
                event.preventDefault();

                var formData = new FormData($("#form_addTask"));

                $.ajax({
                    type: "POST",
                    url: "./contenu.php",
                    data: formData
                });
            });
            
        </script>
  </head>

  <!-- BODY -->
  <body>
      <p style='font-size: 12px;'>Only 7 first tasks added are display. You can still add more but they'll only appear when you archive already displayed tasks.</p>
      <p style='font-size: 12px;'>Only 7 last archived tasks are display.</p>
    <div class="container" id="aFaire">
            
            <!-- FORM TASK LIST -->
            <div class="row d-flex flex-column pt-4 pl-4 pr-4" id="currentTask">
                <h4>Tasks To Do:</h4>
                <form class="dragContainer m-0" action="" method="post" id="form_aFaire" name="form_aFaire">
                    <?php array_map(
                        function($k,$v,$l){
                            if($l){echo '<div draggable="true" id='.$k.' class="text-wrap draggable box"><input type="checkbox" name="task[]" id="task-'.$k.'" value="'.$k.'" onclick="boxChecked('.$k.');" checked="true">'.$v.'</div>';}
                            else{echo '<div draggable="true" id='.$k.' class="text-wrap draggable box"><input type="checkbox" name="task[]" id="task-'.$k.'" value="'.$k.'" onclick="boxChecked('.$k.');">'.$v.'</div>';}
                        },
                        array_keys(array_slice($myToDo->getToDoElements(), 0, 7,true)),
                        array_values(array_column(array_slice($myToDo->getToDoElements(), 0, 7), "content")),
                        array_values(array_column(array_slice($myToDo->getToDoElements(), 0, 7), "checked")),
                    ); ?>
                    <button type="submit" id="button_archive" class='m-4'>Archive</button>
                </form>
            </div>

            <!-- ADD TASK -->
            <div class="row d-flex flex-column pt-4 pl-4 pr-4" id="addTask">
                <h4>Add Task To Do:</h4>
                <form action="" method="post" id="form_addTask" name="form_addTask">
                    <textarea name="addTask" id="task" cols="30" rows="2" class="col-12"></textarea>
                    <button type="submit">Ajouter</button>
                </form>
            </div>

            <!-- ARCHIVED TASK -->
            <div class="row d-flex flex-column p-4" id="archivedTask">
                <h4>Archived Tasks:</h4>
                <div id="archivedDiv">
                    <?php array_map(
                        function($v){
                                echo '<s><div class="archived"><input type="checkbox" checked disabled="disabled">'.$v.'</div></s>';
                        },
                        array_values(array_column(array_slice($myToDo->getArchivedElements(), 0, 7,true), "content")),
                    ); ?>
                </div>
            </div>

        </div>
        <script src="./assets/js/index.js"></script>
        <script>
            window.addEventListener("DOMContentLoaded", (event) => {
                document.getElementById("task").focus();
            });
        </script>
    </body>
</html>