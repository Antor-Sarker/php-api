<?php

// namespace api\TaskApi;

class Router{
    private $task;

    public function __construct($task) {
        $this->task=$task;
    }

    //handel request
    public function handelRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = isset($_GET['id'])? intval($_GET['id']): NULL;
        
        switch ($method) {
            case "GET":
                $this->getRequest($path);
                break;
                case "POST":
                $this->handelPostRequest();
                break;
            case "PUT":
                $this->handelPutRequest($path);
                break;
            case "DELETE":
                $this->handelDeleteRequest($path);
                break;
            
            default:
                http_response_code(405);
                echo json_encode(["error"=>"method not allow"]);
                break;
        }
    }

    //handel get request
    private function getRequest($id) {

        $id = intval($id);
        if($id) {
            $tasks = $this->task->getTask($id);
            if (empty($tasks)) {
                http_response_code(404);
                echo json_encode(["error"=>"task not found"]);
            }
            else {
                echo json_encode($tasks);
            }
        }
        else {
            //get all task
            $tasks = $this->task->getAllTask();
            if (empty($tasks)) {
                http_response_code(404);
                echo json_encode(["error"=>"task not found"]);
            }
            else {
                echo json_encode($tasks);
            }

        }
    }

    //handel post request
    private function handelPostRequest() {
        
        $data = json_decode(file_get_contents("php://input"),true);

        if(!isset($data['title']) || trim($data['title']==="")) {
            http_response_code(400);
            echo json_encode(["error"=>"title is required"]);
            return;
        }

        $validPririties = ["high","medium","low"];
        if(isset($data['priority']) && !in_array($data['priority'],$validPririties)){
            http_response_code(400);
            echo json_encode(["error"=>"Invalid Priority. valid priorites are low,medium,high"]);
            return;
        }

        $response = $this->task->createTask($data);
        echo $response;
    }

    //handel put request
    private function handelPutRequest($id){
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error"=>"task id is required"]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"),true);
        echo json_encode($this->task->updateTask($id,$data));

    }

    //handel Delete
    private function handelDeleteRequest($id){
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error"=>"task id is required"]);

            return;
        }
        echo json_encode($this->task->deleteTask($id));

    }


}




?>