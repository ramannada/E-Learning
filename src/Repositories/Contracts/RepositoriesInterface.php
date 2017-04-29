<?php 

namespace App\Repositories\Contracts;

interface RepositoriesInterface
{
	public function getAll();
	public function create($data);
	public function update($data, $column = null, $value = null);
	public function find($column, $value = null, $operator = '=');
	public function findArray($column, $value = null, $operator = '=');
	public function delete($name = 'soft', $column, $value);
}