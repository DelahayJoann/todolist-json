<?php include('contenu.php'); ?>
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
                    url : 'contenu.php',
                    type : 'POST',
                    data : 'checkedId=' + key
                }); 
            };

            $("#form_aFaire").submit(function(event) {
                event.preventDefault();

                var formData = new FormData($("#form_aFaire"));

                $.ajax({
                    type: "POST",
                    url: "contenu.php",
                    data: formData
                });
            });

            $("#form_addTask").submit(function(event) {
                event.preventDefault();

                var formData = new FormData($("#form_addTask"));

                $.ajax({
                    type: "POST",
                    url: "contenu.php",
                    data: formData
                });
            });
            
        </script>
  </head>

  <!-- BODY -->
  <body>
    <div class="container" id="aFaire">
            
            <!-- FORM TASK LIST -->
            <div class="row">
                <form class="dragContainer" action="" method="post" id="form_aFaire" name="form_aFaire">
                    <?php echo implode("", array_map(
                        function($k,$v,$l,$a){
                            if(!$a){
                                if($l){ return '<div draggable="true" id="'.$k.'" class="draggable box"><input type="checkbox" name="task[]" id="task-'.$k.'" value="'.$k.'" onclick="boxChecked('.$k.');" checked>'.$v.'</div>';}
                                return '<div draggable="true" id="'.$k.'" class="draggable box"><input type="checkbox" name="task[]" id="task-'.$k.'" value="'.$k.'" onclick="boxChecked('.$k.');">'.$v.'</div>';
                            }
                        },
                        array_keys(array_column($myToDo->getToDoElements(), "content")),
                        array_values(array_column($myToDo->getToDoElements(), "content")),
                        array_values(array_column($myToDo->getToDoElements(), "checked")),
                        array_values(array_column($myToDo->getToDoElements(), "archived"))
                    )); ?>
                    <button type="submit">Archive</button>
                </form>
            </div>

            <!-- ARCHIVED TASK -->
            <div class="row">
                <div>
                    <?php echo implode("", array_map(
                        function($v,$a){
                            if($a){
                                return '<s><input type="checkbox" checked disabled="disabled">'.$v.'</s><br>';
                            }
                        },
                        array_values(array_column($myToDo->getToDoElements(), "content")),
                        array_values(array_column($myToDo->getToDoElements(), "archived"))
                    )); ?>
                </div>
            </div>
            
            <!-- ADD TASK -->
            <div class="row">
                <form action="" method="post" id="form_addTask" name="form_addTask">
                    <input type="text" name="addTask" id="task">
                    <button type="submit">Ajouter</button>
                </form>
            </div>

        </div>
        <script src="./assets/js/index.js"></script>
    </body>
</html>