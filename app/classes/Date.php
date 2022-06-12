<?php namespace App\classes;

class Date {
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
        return 1;
    }

    public function update() :int
    {
        return 1;
    }

    public function delete() :int
    {
        return 1;
    }

    public function list() :int
    {
        return 1;
    }

    public function search() :int
    {
        return 1;
    }
}
