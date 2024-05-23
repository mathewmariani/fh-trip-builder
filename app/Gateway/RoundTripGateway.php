<?php

class RoundTripGateway
{
    private $con;

    public function __construct(PDO $connection)
    {
        $this->con = $connection;
    }

    public function get(string $source, string $destination): array
    {
        $sql = "
        SELECT 
            airline.code AS airline_code, 
            airline.name AS airline_name, 
            airport.code AS airport_code,
            airport.name AS airport_name,
            airport.city AS airport_city,
            airport.latitude AS airport_latitude,
            airport.longitude AS airport_longitude,
            airport.timezone AS airport_timezone,
            airport.city_code AS airport_city_code,
            airport.country_code AS airport_country_code,
            airport.region_code AS airport_region_code,
            flight.number AS flight_number,
            flight.airline AS flight_airline,
            flight.departure_airport AS flight_departure_airport,
            flight.departure_time AS flight_departure_time,
            flight.arrival_airport AS flight_arrival_airport,
            flight.arrival_time AS flight_arrival_time,
            flight.price AS flight_price
        FROM 
            flights AS flight
        JOIN 
            airports AS airport ON flight.departure_airport = airport.code
        JOIN 
            airlines AS airline ON flight.airline = airline.code
        WHERE 
            flight.departure_airport = '$source' 
            AND flight.arrival_airport = '$destination'
        ";

        $stmt = $this->con->query($sql);
        $stmt->execute();
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data['airlines'][] = array(
                'code' => $row['airline_code'],
                'name' => $row['airline_name'],
            );
            $data['airports'][] = array(
                'code' => $row['airport_code'],
                'name' => $row['airport_name'],
                'city' => $row['airport_city'],
                'latitude' => $row['airport_latitude'],
                'longitude' => $row['airport_longitude'],
                'timezone' => $row['airport_timezone'],
                'city_code' => $row['airport_city_code'],
                'country_code' => $row['airport_country_code'],
                'region_code' => $row['airport_region_code'],
            );
            $data['flights'][] = array(
                'number' => $row['flight_number'],
                'airline'=> $row['flight_airline'],
                'departure_airport' => $row['flight_departure_airport'],
                'departure_time' => $row['flight_departure_time'],
                'arrival_airport' => $row['flight_arrival_airport'],
                'arrival_time' => $row['flight_arrival_time'],
                'price' => $row['flight_price']
            );
        }

        return $data;
    }
}