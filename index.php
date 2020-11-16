<?php include('contenu.php'); ?>
<?php
/* if($myToDo){
    echo '<pre>';
    print_r($myToDo);
    echo '</pre>';
} */
?>
<!doctype html>
<html lang="en">
  <head>
    <title>ToDo List</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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

        $("#myForm").submit(function(event) {
            //event.preventDefault();
            
            var formData = new FormData($("#myForm"));
            
            $.ajax({
                type: "POST",
                url: "contenu.php",
                data: formData
            });
        });
    </script>
  </head>
  <body>

  <div class="container" id="aFaire">
        <div class="row">
            <form action="" method="post" id="myForm" name="form_aFaire">
                    <?php echo implode("", array_map(
                        function($k,$v,$l,$a){
                            if(!$a){
                                if($l){ return '<input type="checkbox" name="task[]" id="task-'.$k.'" value="'.$k.'" onclick="boxChecked('.$k.');" checked>'.$v.'<br>';}
                                return '<input type="checkbox" name="task[]" id="task-'.$k.'" value="'.$k.'" onclick="boxChecked('.$k.')">'.$v.'<br>';
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
  </div>
  </body>
</html>