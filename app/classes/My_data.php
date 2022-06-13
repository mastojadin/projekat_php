<?php namespace App\classes;

class My_data {
    private string $query_string;
    private array $post;
    private array $to_return;

    public function __construct($query_string, $post)
    {
        $this->query_string = $query_string;
        $this->post = $post;
    }

    public function add() :int
    {
        $post = $_POST;
        $category_id = $post['category_id'];
        $amount = $post['amount'];
        $date = date('Y-m-d H:i:s');

        // validation

        $query = "INSERT INTO my_data (category_id, amount, date) VALUES (:category_id, :amount, :date)";
        $params = array(':category_id' => $category_id, ':amount' => $amount, ':date' => $date);
        $res = DBHelper->do_my_query($query, $params);

        return $this->list();
    }

    public function update() :int
    {
        $post = $_POST;
        $my_data_id = $post['my_data_id'];
        $category_id = $post['category_id'];
        $amount = $post['amount'];
        $date = $post['date'];

        // validation

        $query = "UPDATE my_data SET category_id = :category_id, amount = :amount, date = :date WHERE id = :my_data_id";
        $params = array(':category_id' => $category_id, ':amount' => $amount, ':date' => $date, ':my_data_id' => $my_data_id);
        $res = DBHelper->do_my_query($query, $params);

        return $this->list();
    }

    public function delete() :int
    {
        $post = $_POST;
        $my_data_id = $post['my_data_id'];

        // validation
        
        $query = "DELETE FROM my_data WHERE id = :my_data_id";
        $params = array(':my_data_id' => $my_data_id);

        $res = DBHelper->do_my_query($query, $params);

        return $this->list();
    }

    public function list() :array
    {
        $date = date('Y-m-' . '01');
        
        $query = "SELECT id, category_id, amount, date FROM my_data WHERE date > :date";
        $params = array(':date' => $date);

        $res = DBHelper->do_my_query($query, $params);

        return $res;
    }

    public function search() :array
    {
        return [];
    }
}
