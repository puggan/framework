<?php

use Mockery as m;
use Illuminate\Database\Query\Builder;

class DatabaseMySqlDeleteTest extends PHPUnit_Framework_TestCase
{
	public $builder = NULL;
	public $processor = NULL;
	public $query_builder = NULL;

    protected function getBuilder()
    {
    	if(!$this->query_builder)
      {
        $this->grammar = new Illuminate\Database\Query\Grammars\MySqlGrammar;
        $this->processor = m::mock('Illuminate\Database\Query\Processors\Processor');
	     $this->query_builder = new Builder(m::mock('Illuminate\Database\ConnectionInterface'), $this->grammar, $this->processor);
      }
	    return $this->query_builder;
    }

    public function testMysqlJoinDeleteWithAlias()
    {
			// Schema::create(
			// 	'join_test',
			// 	function($blueprint) {
	       //      $blueprint->int('id');
			// });

			// DB::table('join_test')->insert([['id' => 1], ['id' => 2]]);

			// DB::table('join_test AS a')->join('join_test AS b', 'a.id', '<', 'b.id')->delete();

	      // $this->assertEquals(
				// DB::table('join_test')->min('id'),
	      //    2
	      // );

         $builder = $this->getBuilder();
			$builder->from('join_test AS a')->join('join_test AS b', 'a.id', '<', 'b.id');
			$query = $this->grammar->compileDelete($builder);
			$this->assertFalse(strpos(strstr($query, " from ", TRUE), 'join_test'), "Delete query with alias should only have the alias between delete and from");
    }
}

