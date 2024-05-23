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
            $errors[] = "Flight Airline is Empty";
        }
        if (empty($data["number"]))
        {
            $errors[] = "Flight Number is Empty!";
        }
        if (empty($data["departure_airport"]))
        {
            $errors[] = "Flight Departure Airport is Empty!";
        }
        if (empty($data["departure_time"]))
        {
            $errors[] = "Flight Departure Time is Empty!";
        }
        if (empty($data["arrival_airport"]))
        {
            $errors[] = "Flight Arrival Airport is Empty!";
        }
        if (empty($data["arrival_time"]))
        {
            $errors[] = "Flight Arrival Time is Empty!";
        }
        if (empty($data["price"]))
        {
            $errors[] = "Flight Price is Empty!";
        }
        return $errors;
    }
}