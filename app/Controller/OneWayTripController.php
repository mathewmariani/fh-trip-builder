<?php

class OneWayTripController
{
    private $gateway;

    public function __construct(OneWayTripGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function processRequest(string $method): void
    {
        switch($method){
            case "GET":
                $errors = $this->getValidationErrors($_GET);
                if (!empty($errors))
                {
                    echo json_encode(["errors" => $errors]);
                    http_response_code(422);
                    break;
                }
                $response = $this->gateway->get($_GET['source'], $_GET['destination']);
                echo json_encode($response);
                http_response_code(200);
                break;
            default:
                http_response_code(405);
                header("Allowed: GET");
        }
    }

    private function getValidationErrors(array $data): array
    {
        $errors = [];
        if (empty($data["source"]))
        {
            $errors[] = "Source is Empty";
        }
        if (empty($data["destination"]))
        {
            $errors[] = "Destination is Empty";
        }
        return $errors;
    }
}