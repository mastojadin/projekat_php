<?php namespace App\classes;

use App\helpers\DBHelper;

class Category {
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
        $new_category = $post['new_category'];

        // validation

        $query = "INSERT INTO categories (name) VALUES (:name)";
        $params = array(':name' => $new_category);

        $res = DBHelper::do_my_query($query, $params);

        return $this->list();
    }

    public function update() :array
    {
        $post = $_POST;
        $id = $post['id'];
        $name = $post['name'];

        // validation

        $query = "UPDATE categories SET name=:name WHERE id=:id";
        $params = array(':name' => $name, ':id' => $id);

        $res = DBHelper::do_my_query($query, $params);

        return $this->list();
    }

    public function delete() :array
    {
        $post = $_POST;
        $id = $post['id'];

        // validation
    
        $query = "DELETE FROM categories WHERE id=:id";
        $params = array(':id' => $id);

        $res = DBHelper::do_my_query($query, $params);

        return $this->list();
    }

    public function list() :array
    {
        $query = "SELECT id, name FROM categories";
        $res = DBHelper::do_my_query($query);

        return $res;
    }

    public function search() :array
    {
        // db
        return [];
    }
}
