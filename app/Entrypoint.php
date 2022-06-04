<?php namespace App;

use App\config\Vars;

class Entrypoint {
    private string $o_uri;
    private string $o_query_string;
    private array $o_post;
    private array $uri_array;

    public function __construct(string $uri, string $query_string, array $post)
    {
        $this->o_uri = $uri;
        $this->o_query_string = $query_string;
        $this->o_post = $post;
        $this->uri_array = explode('/', $this->o_uri);
    }

    public function check_number_of_uri_segments() :bool
    {
        $config_api_s_size = Vars::get_me('api_s.size');

        return $config_api_s_size >= count($this->uri_array);
    }

    public function check_is_in_options() :bool
    {
        $config_options = Vars::get_me('api_s.options');

        return in_array($this->uri_array[0], $config_options);
    }

    public function check_is_in_actions() :bool
    {
        $config_actions = Vars::get_me('api_s.actions');

        return in_array($this->uri_array[1], $config_actions);
    }

    public function check_is_uri_string_equal($string) :bool
    {
        return $this->o_uri === $string;
    }
    
    public function check_is_query_string_equal($string) :bool
    {
        return $this->o_query_string === $string;
    }

    public function call_needed()
    {
        $class_name = 'App\\classes\\' . ucfirst($this->uri_array[0]);
        $method_name = $this->uri_array[1];

        $c = new $class_name($this->o_query_string, $this->o_post);
        
        return $c->$method_name();
    }
}
