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
        public function getArchived(){
            return $this->archived;
        }
        public function setChecked(){
            ($this->checked)? $this->checked = FALSE : $this->checked = TRUE;
        }
        public function getChecked(){
            return $this->checked;
        }
    }

    // New instance of ToDoList class
    $myToDo = new ToDoList();

    if (file_exists('ToDoList')) {
        $myToDo->load('toDoList');
    } else {
        $myToDoElement = new ToDoElement('test1');
        $myToDo->addToDoElement($myToDoElement);
        $myToDoElement2 = new ToDoElement('test2');
        $myToDo->addToDoElement($myToDoElement2);
        $myToDoElement3 = new ToDoElement('test3');
        $myToDo->addToDoElement($myToDoElement3);
        $myToDoElement4 = new ToDoElement('test4');
        $myToDo->addToDoElement($myToDoElement4);
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
?>