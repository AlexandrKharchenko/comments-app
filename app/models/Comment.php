<?php

namespace App\Models;

use Core\Mvc\Model;
use PDO;


class Comment  extends Model {

    public $table = 'comments';


    public function getAllComments()
    {
        $sql = "Select * FROM  {$this->table};";

        $query = $this->pdo->prepare($sql);
        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        return $data;


    }



}