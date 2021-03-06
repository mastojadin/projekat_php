<?php namespace App\classes;

use App\helpers\DBHelper;
use App\helpers\GeneralHelper;

class My_data {
    private string $query_string;
    private array $post;
    private array $to_return;

    public function __construct($query_string, $post)
    {
        $this->query_string = $query_string;
        $this->post = $post;
    }

    public function add() :array
    {
        $post = $_POST;
        $category_id = $post['category_id'];
        $amount = (float) $post['amount'];
        $date = date('Y-m-d H:i:s');

        // validation

        $query = "INSERT INTO my_data (category_id, amount, date) VALUES (:category_id, :amount, :date)";
        $params = array(':category_id' => $category_id, ':amount' => $amount, ':date' => $date);
        $res = DBHelper::do_my_query($query, $params);

        return $this->list();
    }

    public function update() :array
    {
        $post = $_POST;
        $my_data_id = $post['my_data_id'];
        $category_id = $post['category_id'];
        $amount = $post['amount'];
        $date = $post['date'];

        // validation

        $query = "UPDATE my_data SET category_id = :category_id, amount = :amount, date = :date WHERE id = :my_data_id";
        $params = array(':category_id' => $category_id, ':amount' => $amount, ':date' => $date, ':my_data_id' => $my_data_id);
        $res = DBHelper::do_my_query($query, $params);

        return $this->list();
    }

    public function delete() :array
    {
        $post = $_POST;
        $my_data_id = $post['my_data_id'];

        // validation
        
        $query = "DELETE FROM my_data WHERE id = :my_data_id";
        $params = array(':my_data_id' => $my_data_id);

        $res = DBHelper::do_my_query($query, $params);

        return $this->list();
    }

    public function list() :array
    {
        $date = date('Y-m-' . '01');
        
        $query = "
            SELECT
                d.id,
                d.category_id,
                d.amount,
                d.date,
                c.name
            FROM my_data d
            LEFT JOIN categories c ON c.id = d.category_id
            WHERE
                d.date > :date
            ORDER BY d.date DESC
        ";
        $params = array(':date' => $date);

        $res = DBHelper::do_my_query($query, $params);
        $to_return = GeneralHelper::make_nice_array_for_overview($res);

        return $to_return;
    }

    public function search() :array
    {
        $post = $_POST;
        $date_from = $post['date_from'];
        $date_to = $post['date_to'];

        $query = "
            SELECT
                d.id,
                d.category_id,
                d.amount,
                d.date,
                c.name
            FROM my_data d
            LEFT JOIN categories c ON c.id = d.category_id
            WHERE
                d.date > :date_from AND d.date < :date_to
            ORDER BY d.date DESC
        ";
        $params = array(':date_from' => $date_from, ':date_to' => $date_to);

        $res = DBHelper::do_my_query($query, $params);
        $to_return = GeneralHelper::make_nice_array_for_overview($res);

        return $to_return;
    }
}
