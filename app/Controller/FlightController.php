<?php

class FlightController
{
    private $gateway;

    public function __construct(FlightGateway $gateway)
    {
        $this->gateway = $gateway;
    }
 
    public function processRequest(string $method): void
    {
        switch($method){
            case "GET":
                if (isset($_GET['number']))
                {
                    echo json_encode($this->gateway->get($_GET['number']));
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
                echo json_encode(["message" => "Flight added."]);
                http_response_code(201);
                break;
            case "DELETE":
                if (isset($_GET['number']))
                {
                    $rows = $this->gateway->delete($_GET['number']);
                    echo json_encode([
                        "message" => "Flight was deleted successfully.",
                        "rows"=> $rows
                    ]);
                    http_response_code(200);
                }
                break;
            default:
                http_response_code(405);
                header("Allow: GET, DELETE");
        }
    }

    private function getValidationErrors(array $data): array
    {
        $errors = [];
        if (empty($data["airline"]))
        {
            $errors[] = "Flight airline is empty!";
        }
        if (empty($data["number"]))
        {
            $errors[] = "Flight number is empty!";
        }
        if (empty($data["departure_airport"]))
        {
            $errors[] = "Flight departure airport is empty!";
        }
        if (empty($data["departure_time"]))
        {
            $errors[] = "Flight departure time is empty!";
        }
        if (empty($data["arrival_airport"]))
        {
            $errors[] = "Flight arrival airport is empty!";
        }
        if (empty($data["arrival_time"]))
        {
            $errors[] = "Flight arrival time is empty!";
        }
        if (empty($data["price"]))
        {
            $errors[] = "Flight price is empty!";
        }
        return $errors;
    }
}