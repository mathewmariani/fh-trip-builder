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
            default:
                http_response_code(405);
                header("Allow: GET, POST");
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
        if (empty($data["city"]))
        {
            $errors[] = "Airport City is Empty!";
        }
        if (empty($data["lat"]))
        {
            $errors[] = "Airport Latitude is Empty!";
        }
        if (empty($data["lng"]))
        {
            $errors[] = "Airport Longitude is Empty!";
        }
        if (empty($data["timezone"]))
        {
            $errors[] = "Airport Timezone is Empty!";
        }
        if (empty($data["cityCode"]))
        {
            $errors[] = "Airport City Code is Empty!";
        }
        if (empty($data["countryCode"]))
        {
            $errors[] = "Airport Country Code is Empty!";
        }
        if (empty($data["regionCode"]))
        {
            $errors[] = "Airport Region Code is Empty!";
        }
        return $errors;
    }
}