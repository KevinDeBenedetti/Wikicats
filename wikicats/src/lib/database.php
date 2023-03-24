<?php

namespace Application\Lib\Database;

class DatabaseConnection
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if($this->database === null) {
            $this->database = new \PDO('mysql:host=localhost;dbname=wikicats;charset=utf8', 'root', 'Poh5(dfrmysql');
        }
        return $this->database;
    }
}