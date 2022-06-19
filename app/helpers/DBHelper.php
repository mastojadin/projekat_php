<?php namespace App\helpers;

use App\config\Vars;

class DBHelper {
    private $conn;

    public static function do_my_query(string $query, array $params = [])
    {
        $db = new DBHelper();
        return $db->run_query($query, $params);
    }

    private function __construct()
    {
        if (!$this->conn) {
            $username = Vars::get_me('db.username');
            $password = Vars::get_me('db.password');
            $db_name = Vars::get_me('db.db_name');
            $db_host = Vars::get_me('db.host');
            $port = Vars::get_me('db.port');
            
            $dns = "mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8mb4";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            ];
            
            try {
                $this->conn = new \PDO($dns, $username, $password, $options);
            } catch(\PDOException $e) {
                throw new \Exception($e->getMessage());
            }
        }

        return $this->conn;
    }

    private function run_query(string $query, array $params = []) :array
    {
        $stmt = $this->conn->prepare($query);

        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();

        if (strpos( $query, 'SELECT') !== false) {
            return $stmt->fetchAll();
        } else if (strpos($query, 'INSERT') !== false) {
            // return $this->conn->lastInsertId();
            return ['data inserted'];
        } else if (strpos($query, 'UPDATE') !== false) {
            return ['data updated'];
        } else if (strpos($query, 'DELETE') !== false) {
            return ['data deleted'];
        } else {
            throw new \Exception('No such query verb');
        }
    }
}
