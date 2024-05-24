<?php

class AirlineController
{
    private $gateway;

    public function __construct(AirlineGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function processRequest(string $method): void
    {
        switch($method){
            case "GET":
                if (isset($_GET['code']))
                {
                    echo json_encode($this->gateway->get($_GET['code']));
                }
                else
                {
                    echo json_encode($this->gateway->getAll());
                }
                http_response_code(200);
                break;
            case "POST":
                $errors = $this->getValidationErrors($_POST);
                if(!empty($errors))
                {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                $this->gateway->create($_POST);
                echo json_encode(["message" => "Airline added."]);
                http_response_code(201);
                break;
            case "DELETE":
                if (!isset($_GET['code']))
                {
                    echo json_encode(["error" => "Missing airline code."]);
                    http_response_code(400);
                    break;
                }
                $rows = $this->gateway->delete($_GET['code']);
                echo json_encode([
                    "message" => "Airline was deleted successfully.",
                    "rows"=> $rows
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET, POST, DELETE");
        }
    }

    private function getValidationErrors(array $data): array
    {
        $errors = [];
        if (empty($data["code"]))
        {
            $errors[] = "Airline code is empty!";
        }
        if (empty($data["name"]))
        {
            $errors[] = "Airline name is empty!";
        }
        return $errors;
    }
}