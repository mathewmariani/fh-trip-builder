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
            default:
                http_response_code(405);
                header("Allow: GET");
        }
    }

    private function getValidationErrors(array $data): array
    {
        $errors = [];
        if (empty($data["code"]))
        {
            $errors[] = "Airport Code is Empty";
        }
        if (empty($data["name"]))
        {
            $errors[] = "Airport Name is Empty!";
        }
        return $errors;
    }
}