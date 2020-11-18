<?php
    // The list class
    class ToDoList{
        private $toDo = [];
        private $toDo2 = []; // JSON test purpose

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
        public function save(string $fileName = 'todolist.serial'){
            $s = serialize($this);
            try{
                file_put_contents($fileName, $s);
            }catch(Exception $err){
                echo "Something goes wrong";
                echo $err;
            }
            $this->toDo2 = $this->toDo; // JSON test purpose
            $this->jsonSave();   // JSON test purpose
        }
        public function jsonSave(string $fileName = 'todolist.json'){ // JSON test purpose
            $tmpJson = json_encode($this->toDo2, JSON_PRETTY_PRINT);
            try{
                file_put_contents($fileName, $tmpJson);
            }catch(Exception $err){
                echo "Something goes wrong";
                echo $err;
            }
        }

        public function load(string $fileName = 'todolist.serial'){
            try{
                $tmp = unserialize(file_get_contents($fileName));
                $this->toDo = $tmp->toDo;
            }catch(Exception $err){
                echo "Something goes wrong";
                echo $err;
            }
            $this->jsonLoad();   // JSON test purpose
        }

        public function jsonLoad(string $fileName = 'todolist.json'){ // JSON test purpose
            try{
                $tmp = json_decode(file_get_contents($fileName), true);
                $this->toDo2 = $tmp;
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

    if (file_exists('todolist.serial')) {
        $myToDo->load('todolist.serial');
    } else {
        $myToDo->save('todolist.serial');  
    }

if(isset($_POST['checkedId'])){
    $tmpArray = $myToDo->getToDoElements();
    $tmpArray[$_POST['checkedId']]->setChecked();
    $myToDo->save('todolist.serial');
    $_POST = array();
}
if(isset($_POST['task'])){
    foreach ($_POST['task'] as $key => $value){
        $myToDo->getToDoElements()[$value]->setArchived(TRUE);
    }
    $myToDo->save('todolist.serial');
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
        $myToDo->save('todolist.serial');
        $_POST = array();
    }
}
if(isset($_POST['swapId1'],$_POST['swapId2'])){
    $myToDoArray = $myToDo->getToDoElements();

    $tmp = $myToDoArray[$_POST['swapId1']];

    $myToDoArray[intval($_POST['swapId1'])] = $myToDoArray[intval($_POST['swapId2'])];
    $myToDoArray[intval($_POST['swapId2'])] = $tmp;

    $myToDo->setToDoElements($myToDoArray);
    $myToDo->save('todolist.serial');
    $_POST = array();
}
?>