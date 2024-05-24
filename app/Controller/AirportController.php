<?php

class AirportController
{
    private $gateway;

    public function __construct(AirportGateway $gateway)
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
                echo json_encode(["message" => "Airport added."]);
                http_response_code(201);
                break;
            case "DELETE":
                if (!isset($_GET['code']))
                {
                    echo json_encode(["error" => "Missing airport code."]);
                    http_response_code(400);
                    break;
                }
                $rows = $this->gateway->delete($_GET['code']);
                echo json_encode([
                    "message" => "Airport was deleted successfully.",
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
            $errors[] = "Airport code is empty!";
        }
        if (empty($data["name"]))
        {
            $errors[] = "Airport name is empty!";
        }
        if (empty($data["city"]))
        {
            $errors[] = "Airport city is empty!";
        }
        if (empty($data["latitude"]))
        {
            $errors[] = "Airport latitude is empty!";
        }
        if (empty($data["longitude"]))
        {
            $errors[] = "Airport longitude is empty!";
        }
        if (empty($data["timezone"]))
        {
            $errors[] = "Airport timezone is empty!";
        }
        if (empty($data["city_code"]))
        {
            $errors[] = "Airport city code is empty!";
        }
        if (empty($data["country_code"]))
        {
            $errors[] = "Airport country code is empty!";
        }
        if (empty($data["region_code"]))
        {
            $errors[] = "Airport region code is empty!";
        }
        return $errors;
    }
}