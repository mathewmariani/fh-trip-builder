<?php

class AirportGateway
{
    private $con;

    public function __construct(PDO $connection)
    {
        $this->con = $connection;
    }

    public function getAll(): array
    {
        $sql = "
        SELECT * FROM airports
        ";

        $stmt = $this->con->query($sql);
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string
    {
        $sql = "
        INSERT INTO airports (
            code,
            name,
            city,
            latitude,
            longitude,
            timezone,
            city_code,
            country_code,
            region_code
        ) 
        VALUES (
            :code,
            :name,
            :city,
            :latitude,
            :longitude,
            :time_zone,
            :city_code,
            :country_code,
            :region_code
        )";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":code", $data["code"], PDO::PARAM_STR);
        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":city", $data["city"], PDO::PARAM_STR);
        $stmt->bindValue(":latitude", $data["latitude"], PDO::PARAM_STR);
        $stmt->bindValue(":longitude", $data["longitude"], PDO::PARAM_STR);
        $stmt->bindValue(":time_zone", $data["time_zone"], PDO::PARAM_STR);
        $stmt->bindValue(":city_code", $data["city_code"], PDO::PARAM_STR);
        $stmt->bindValue(":country_code", $data["countryCode"], PDO::PARAM_STR);
        $stmt->bindValue(":region_code", $data["region_code"], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get(string $code)
    {
        $sql = "
        SELECT * FROM airports
        WHERE
            code = :code
        ";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":code", $code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $new): string
    {
        $sql = "
        UPDATE airports
        SET  
            name = :name,
            city = :city,
            latitude = :latitude,
            longitude = :longitude,
            timezone = :timezone,
            city_code = :city_code,
            country_code = :country_code,
            region_code = :region_code
        WHERE 
            code = :code
        ";
    
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":code", $new["code"], PDO::PARAM_STR);
        $stmt->bindValue(":name", $new["name"]);
        $stmt->bindValue(":city", $new["city"]);
        $stmt->bindValue(":latitude", $new["lat"]);
        $stmt->bindValue(":longitude", $new["lng"]);
        $stmt->bindValue(":timezone", $new["timezone"]);
        $stmt->bindValue(":city_code", $new["cityCode"]);
        $stmt->bindValue(":country_code", $new["country_code"]);
        $stmt->bindValue(":region_code", $new["region_code"]);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $code): string
    {
        $sql = "
        DELETE FROM airports
        WHERE
            code = :code
        ";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":code", $code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }
}