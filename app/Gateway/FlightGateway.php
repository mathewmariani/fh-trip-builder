<?php

class FlightGateway
{
    private $con;

    public function __construct(PDO $connection)
    {
        $this->con = $connection;
    }

    public function getAll(): array
    {
        $sql = "
        SELECT * FROM flights
        ";

        $stmt = $this->con->query($sql);
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data[] = $row;
        }

        return $data;
    }

    public function get(string $number)
    {
        $sql = "
        SELECT * FROM flights
        WHERE
            number = :number
        ";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":number", $number, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string
    {
        $sql = "
        INSERT INTO flights (
            number,
            code,
            departure_airport,
            departure_time,
            arrival_airport,
            arrival_time,
            price
        )
        VALUES (
            :number,
            :code,
            :departure_airport,
            :departure_time,
            :arrival_airport,
            :arrival_time,
            :price
        )";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":number", $data["number"], PDO::PARAM_INT);
        $stmt->bindValue(":code", $data["code"], PDO::PARAM_STR);
        $stmt->bindValue(":departure_airport", $data["departure_airport"], PDO::PARAM_STR);
        $stmt->bindValue(":departure_time", $data["departure_time"],PDO::PARAM_STR);
        $stmt->bindValue(":arrival_airport", $data["arrival_airport"], PDO::PARAM_STR);
        $stmt->bindValue(":arrival_time", $data["arrival_time"], PDO::PARAM_STR);
        $stmt->bindValue(":price", $data["price"], PDO::PARAM_STR);
        $stmt->execute();

        return $this->con->lastInsertId();
    }

    public function update(array $new): string
    {
        $sql = "
        UPDATE airports
        SET  
            name = :name,
        WHERE 
            code = :code
        ";
    
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":name", $new["name"]);
        $stmt->execute();

        return $stmt->rowCount();        
    }

    public function delete(string $code): string
    {
        $sql = "
        DELETE FROM flights
        WHERE
            code = :code
        ";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":code", $code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }
}