<?php
class Database {
    private static $instance = null;
    private $pdo, $query, $error = false, $count, $result;

    private function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=" . Config::get('mysql.host') . "; dbname=" . Config::get('mysql.database'), Config::get('mysql.username'), Config::get('mysql.password'));
        } catch (PDOException $exception) {
            die($exception);
        }
    }

    public static function getInstance() {
        if(self::$instance == null) {
            return self::$instance = new Database();
        }

        return self::$instance;
    }

    public function query($sql, $fields = []) {
        $this->query = $this->pdo->prepare($sql);

        if($fields) {
            $i = 1;
            foreach ($fields as $item) {
                $this->query->bindValue($i, $item);
                $i++;
            }
        }

        if(!$this->query->execute()) {
            $this->error = true;
        } else {
            $this->result = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        }

        return $this;

    }

    public function action($action, $table, $where) {
        if (count($where) === 3) {

            $operators = ['=', '<', '>', '<=', '>='];

            $field    = $where[0];
            $operator = $where[1];
            $value    = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql, [$value])->error()) {
                    return $this;
                }
            }
        }
        return $this;
    }

    public function insert($table, $where = []) {
        $values = '';
        foreach ($where as $item) {
            $values .= "?, ";
        }

        $keys = array_keys($where);
        $keys = "`" . implode('`, `', $keys) . "`";
        $values = rtrim($values, ', ');

        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$values})";

        if(!$this->query($sql, $where)->error()) {
            return $this;
        }

        return $this;
    }

    public function update($table, $id, $where = []){
        $values = '';
        foreach ($where as $key => $val) {
            $values .= "`{$key}` = ?, ";
        }

        $values = rtrim($values, ', ');

        $sql = "UPDATE {$table} SET {$values} WHERE id={$id}";
        if(!$this->query($sql, $where)->error()) {
            return $this;
        }
        return $this;
    }



    public function get($table, $where = []) {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where = []) {
        return $this->action('DELETE', $table, $where);
    }

    public function error() {
        return $this->error;
    }

    public function result() {
        return $this->result;
    }

    public function count() {
        return $this->count;
    }

    public function first() {
        return $this->result()[0];
    }
}