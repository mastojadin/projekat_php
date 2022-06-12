<?php namespace App\config;

class Vars {
    private array $vars = [];

    public static function get_me(string $var) :array | string | int | bool
    {
        $tmp_array = explode('.', $var);
        if (count($tmp_array) !== 2) {
            return false;
        }

        $to_return = new Vars();
        return $to_return->get_value($tmp_array[0], $tmp_array[1]);
    }

    private function __construct()
    {
        $this->vars['api_s']['options'] = ['category', 'amount', 'date', 'my_data'];
        $this->vars['api_s']['actions'] = ['add', 'update', 'delete', 'list', 'search'];
        $this->vars['api_s']['size'] = count($this->vars['api_s']);

        $this->vars['db']['host'] = 'localhost';
        $this->vars['db']['port'] = '3306';
        $this->vars['db']['username'] = 'root';
        $this->vars['db']['password'] = '';
        $this->vars['db']['db_name'] = 'projekat';
        $this->vars['db']['size'] = count($this->vars['db']);
    }

    private function get_value(string $key_1, string $key_2) :array | string | int
    {
        return $this->vars[$key_1][$key_2];
    }
}
