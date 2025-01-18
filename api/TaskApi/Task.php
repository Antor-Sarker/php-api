<?php

// namespace api\TaskaApi;

class Task{
    private $conn;

    public function __construct($dbConnection){
        $this->conn = $dbConnection;
    }

    //get all task
    public function getAllTask(){
        
        $sql = "SELECT * FROM tasks";
        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //GET Singel Task
    public function getTask($id) {
    
        $id = intval($id);
        $singelTaskSql = "SELECT * FROM tasks WHERE id='$id'";

        $result = $this->conn->query($singelTaskSql);
        return $result->fetch_assoc();
    }


    //create a task
    public function createTask($data){

        $title = $data['title'];
        $description = $data['description'] ?? "";
        $priority = $data['priority'] ?? "low";

        $query = "INSERT INTO tasks(title,description,priority)VALUES('$title','$description','$priority')";
        
        // $result=$this->conn->query($query);
        if ($this->conn->query($query)) {
            return json_encode(["message"=>"task created is successfull"]);
        }
        
        return json_encode(["error"=>"failed to task create"]);
    }


    //update a task
    public function updateTask($id, $data){
        $id = intval($id);

        $findTheTask = $this->conn->query("SELECT * FROM tasks WHERE id='$id'");

        if($findTheTask->num_rows===0) {
            http_response_code(404);
            return json_encode(["error"=>"task not found"]);
        }

        //update the task
        $existedTask = $findTheTask->fetch_assoc();

        $title = isset($data['title'])? $data['title']: $existedTask['title'];
        $description = isset($data['description'])? $data['description']: $existedTask['description'];
        $priority = isset($data['priority'])? $data['priority']: $existedTask['priority'];
        $is_completed = isset($data['is_completed'])? $data['is_completed']: $existedTask['is_completed'];


        $query="UPDATE tasks SET title='$title',description='$description',priority='$priority',is_completed='$is_completed' WHERE id='$id'";

        $result = $this->conn->query($query);
        if($result){
            return json_encode(["message"=>"task update successfull"]);
        }
        
        return json_encode(["error"=>"task update failed"]);

    }


    //Delete Task by id
    public function deleteTask($id) {
        $id = intval($id);
        $query = "DELETE FROM tasks WHERE id='$id'";

        if($this->conn->query($query)){
            return ["message"=>"the task is deleted"];
        }

        return ["error"=>"failed to delete task"];
    }

}








?>