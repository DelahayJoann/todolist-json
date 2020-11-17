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
        public function setToDoElements($theArray){
            $this->toDo = $theArray;
        }
        public function save(string $fileName){
            $s = serialize($this);
            try{
                file_put_contents('./'.$fileName, $s);
            }catch(Exception $err){
                echo "Something goes wrong";
                echo $err;
            }
            
        }
        public function load(string $fileName = 'ToDoList'){
            try{
                $tmp = unserialize(file_get_contents('./'.$fileName));
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
        public $checked;
        public $archived;
        public function __construct(string $content){
            $this->content = $content;
            $this->archived = FALSE;
            $this->checked = FALSE;
        }
        public function setArchived(bool $bool){
            $this->archived = $bool;
        }
        public function setChecked(){
            ($this->checked)? $this->checked = FALSE : $this->checked = TRUE;
        }
    }

    // New instance of ToDoList class
    $myToDo = new ToDoList();

    if (file_exists('ToDoList')) {
        $myToDo->load('toDoList');
    } else {
        $myToDo->save('toDoList');      
    }

if(isset($_POST['checkedId'])){
    $tmpArray = $myToDo->getToDoElements();
    $tmpArray[$_POST['checkedId']]->setChecked();
    $myToDo->save('todolist');
    $_POST = array();
}
if(isset($_POST['task'])){
    foreach ($_POST['task'] as $key => $value){
        $myToDo->getToDoElements()[$value]->setArchived(TRUE);
    }
    $myToDo->save('todolist');
    $_POST = array();
}
if(isset($_POST['addTask'])){
    if(!empty($_POST['addTask'])){
        $string = trim($_POST['addTask']);
        $string = strip_tags($_POST['addTask']);
        $string = filter_var($string, FILTER_SANITIZE_MAGIC_QUOTES);
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        $taskElem = new ToDoElement($string);
        $myToDo->addToDoElement($taskElem);
        $myToDo->save('todolist');
        $_POST = array();
    }
}
if(isset($_POST['swapId1'],$_POST['swapId2'])){
    $myToDoArray = $myToDo->getToDoElements();

    $tmp = $myToDoArray[$_POST['swapId1']];

    $myToDoArray[intval($_POST['swapId1'])] = $myToDoArray[intval($_POST['swapId2'])];
    $myToDoArray[intval($_POST['swapId2'])] = $tmp;

    $myToDo->setToDoElements($myToDoArray);
    $myToDo->save('todolist');
    $_POST = array();
}
?>