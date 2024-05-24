<?php

class AirlineGateway
{
    private $con;

    public function __construct(PDO $connection)
    {
        $this->con = $connection;
    }

    public function getAll(): array
    {
        $sql = "
        SELECT * FROM airlines
        ";

        $stmt = $this->con->query($sql);
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data[] = $row;
        }

        return $data;
    }

    public function get(string $code)
    {
        $sql = "
        SELECT * FROM airlines
        WHERE
            code = :code
        ";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":code", $code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string
    {
        $sql = "
        INSERT INTO airlines (
            code,
            name
        ) 
        VALUES (
            :code,
            :name
        )";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":code", $data["code"], PDO::PARAM_STR);
        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $new): string
    {
        $sql = "
        UPDATE airlines
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
        DELETE FROM airlines
        WHERE
            code = :code
        ";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":code", $code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }
}