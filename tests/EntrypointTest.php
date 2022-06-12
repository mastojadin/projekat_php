<?php

use PHPUnit\Framework\TestCase;

use App\Entrypoint;
use App\config\Vars;
use App\classes\Category;

final class EntrypointTest extends TestCase {
    public function test_somebody_called_us() :void
    {
        $tmp_uri = 'category/list';
        $tmp_query_string = '';
        $tmp_post = [];

        $this->assertInstanceOf(Entrypoint::class, new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post));
    }
    
    public function test_is_number_of_uri_segments_less_or_equal_then_config() :void
    {
        $config_options = Vars::get_me('api_s.options');

        $tmp_uri = '';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post);
        $this->assertTrue($entrypoint->check_number_of_uri_segments());

        $tmp_uri = 'category';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post);
        $this->assertTrue($entrypoint->check_number_of_uri_segments());
        
        $tmp_uri = 'category/list';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post);
        $this->assertTrue($entrypoint->check_number_of_uri_segments());

        $tmp_uri = 'category/list/something';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post);
        $this->assertFalse($entrypoint->check_number_of_uri_segments());
    }

    public function test_is_it_in_options() :void
    {
        $config_options = Vars::get_me('api_s.options');

        $tmp_uri = '';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post);
        $this->assertFalse($entrypoint->check_is_in_options());
        
        $tmp_uri = 'category';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post);
        $this->assertTrue($entrypoint->check_is_in_options());

        $tmp_uri = 'something';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post);
        $this->assertFalse($entrypoint->check_is_in_options());
    }

    public function test_is_it_in_actions() :void
    {
        $config_actions = Vars::get_me('api_s.actions');

        $tmp_uri = 'category/list';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post);
        $this->assertTrue($entrypoint->check_is_in_actions());

        $tmp_uri = 'category/something';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $tmp_query_string, $tmp_post);
        $this->assertFalse($entrypoint->check_is_in_actions());
    }

    public function test_are_server_uri_and_our_uri_same() :void
    {
        $server_uri = 'something';
        $our_uri = 'something';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($our_uri, $tmp_query_string, $tmp_post);
        $this->assertTrue($entrypoint->check_is_uri_string_equal($server_uri));

        $this->assertEquals($server_uri, $our_uri);

        $server_uri = 'something';
        $our_uri = 'other';
        $tmp_query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($our_uri, $tmp_query_string, $tmp_post);
        $this->assertFalse($entrypoint->check_is_uri_string_equal($server_uri));
    }

    public function test_are_server_query_string_and_our_query_same() :void
    {
        $server_query_string = 's=1';
        $our_query_string = 's=1';
        $tmp_uri = 'category';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $our_query_string, $tmp_post);
        $this->assertTrue($entrypoint->check_is_query_string_equal($server_query_string));

        $server_query_string = 's=1';
        $our_query_string = 's=2';
        $tmp_uri = 'category';
        $tmp_post = [];
        $entrypoint = new Entrypoint($tmp_uri, $our_query_string, $tmp_post);
        $this->assertFalse($entrypoint->check_is_query_string_equal($server_query_string));
    }

    public function test_call_needed() :void
    {
        $uri = 'category/list';
        $query_string = '';
        $tmp_post = [];
        $entrypoint = new Entrypoint($uri, $query_string, $tmp_post);
        $this->assertIsArray($entrypoint->call_needed());
    }
}
