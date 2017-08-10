<?php

namespace Core\Mvc;

use Core\Db;

class Model extends Db
{
    private $dbh;
    public $pdo;
    public $table;

    public function __construct()
    {
        $this->dbh = Db::getInstance();
        $this->pdo = $this->dbh->connect();

    }


    public function find($id)
    {

        $query = $this->pdo->prepare("Select * FROM  {$this->table} WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $data = $query->fetchAll($this->dbh->fetch_mode);

        if (!empty($data))
            return $data[0];
        else
            return null;
    }

    public function select_where(array $where)
    {


        $whereStr = '';
        
        $index = 0;
        $allWhereAmount = count($where);
        foreach ($where as $field => $value) {
            $index++;
            $andStr = ($index === $allWhereAmount) ? '' : 'AND';
            $whereStr .= "{$field} = :{$field} $andStr";

        }

        $sql = "Select * FROM  {$this->table} WHERE $whereStr ;";

        $query = $this->pdo->prepare($sql);
        foreach ($where as $field => &$value) {
            $query->bindParam(":{$field}", $value);

        }

        $query->execute();

        $data = $query->fetchAll($this->dbh->fetch_mode);
        $query->closeCursor();


        if (!empty($data))
            return $data;
        else
            return null;
    }

    public function insert(array $data)
    {

        $sql = "INSERT INTO {$this->table} SET " . $this->setFieldValue($data) .';';
        $query = $this->pdo->prepare($sql);
        foreach ($data as $field => &$value) {
           $query->bindParam(":{$field}", $value);
        }

        $query->execute();
        $query->closeCursor();



        //return $this->pdo->lastInsertId();
    }

    public function select()
    {
        $query = $this->pdo->prepare('SELECT * FROM test');
        $query->execute();
        $data = $query->fetchAll($this->dbh->fetch_mode);


    }

    private function setFieldValue(array $data)
    {
        $set = '';

        foreach ($data as $field => $value) {
            $set.="`".str_replace("`","``",$field)."`". "=:$field, ";

        }

        return substr($set, 0, -2);
    }
}