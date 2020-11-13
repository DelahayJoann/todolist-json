<?php
    header( "Content-Type: text/html; charset=utf8" );
    setlocale (LC_ALL, 'fr_FR.utf8');
    date_default_timezone_set('Europe/Paris');
    mb_internal_encoding("UTF-8");

    // The list class
    class ToDoList{
        private $toDo = [];

        public function __construct(){

        }
        public function addToDoElement(ToDoElement $toDoElement){
            $this->toDo[] = $toDoElement;
        }
        public function getToDoElements(){
            return $this->toDo;
        }
        public function save(string $fileName){
            $s = serialize($this);
            try{
                file_put_contents($fileName, $s);
            }catch(Exception $err){
                echo "Something goes wrong";
                echo $err;
            }
            
        }
        public function load(string $fileName = 'ToDoList'){
            try{
                $tmp = unserialize(file_get_contents($fileName));
                $this->toDo = $tmp->toDo;
            }catch(Exception $err){
                echo "Something goes wrong";
                echo $err;
            }
        }
    }

    // List element class
    class ToDoElement{
        public $content;
        public $archived;
        public function __construct(string $content, bool $archived = FALSE){
            $this->content = $content;
            $this->archived = $archived;
        }
        public function setArchived(bool $bool){
            $this->archived = $bool;
        }
        public function getArchived(){
            return $this->archived;
        }
    }

    // New instance of ToDoList class
    $myToDo = new ToDoList();

    $myToDoElement = new ToDoElement("test");
    $myToDo->addToDoElement($myToDoElement);

    $myToDoElement2 = new ToDoElement("test2");
    $myToDo->addToDoElement($myToDoElement2);

    $myToDoElement3 = new ToDoElement("test3");
    $myToDo->addToDoElement($myToDoElement3);

    $myToDoElement4 = new ToDoElement("test4");
    $myToDo->addToDoElement($myToDoElement4);

    $myToDoElement5 = new ToDoElement("test5");
    $myToDo->addToDoElement($myToDoElement5);

    $myToDoElement6 = new ToDoElement("test6");
    $myToDo->addToDoElement($myToDoElement6);

    /* echo '<pre>';
    print_r($myToDo);
    echo '</pre>';

    $myToDo->save('ToDoList');

    $temp = new ToDoList();
    $temp->load('ToDoList');

    $elems = $temp->getToDoElements();
    $elems[0]->setArchived(true);

    echo '<pre>';
    print_r($temp);
    echo '</pre>'; */

?>

<!doctype html>
<html lang="en">
  <head>
    <title>ToDo List</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

  <div class="container" id="aFaire">
      <div class="row">
        <form action="./contenu.php" method="post" name="form_aFaire">
        <?php echo implode("<br>\n", array_column($myToDo->getToDoElements(), "content")); ?>
        <button type="submit"></button>
        </form>
      </div>
  </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>