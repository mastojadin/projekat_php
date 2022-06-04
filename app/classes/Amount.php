<?php namespace App\classes;

class Amount {
    private string $query_string;
    private array $post;
    private array $to_return;

    public function __construct($query_string, $post)
    {
        $this->query_string = $query_string;
        $this->post = $post;

        $this->to_return = [];
        $this->to_return['data'] = '';
        $this->to_return['error'] = '';
    }

    public function add() :string
    {
        return json_encode(1);
    }

    public function update() :string
    {
        return json_encode(1);
    }

    public function delete() :string
    {
        return json_encode(1);
    }

    public function list()
    {
        return json_encode($this->to_return);
    }

    public function search()
    {
        return json_encode($this->to_return);
    }
}
