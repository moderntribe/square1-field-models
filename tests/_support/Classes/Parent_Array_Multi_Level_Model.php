<?php declare(strict_types=1);

namespace Tribe\Libs\Tests;

use Tribe\Libs\Field_Models\Field_Model;

class Parent_Array_Multi_Level_Model extends Field_Model {

	/**
	 * @var \Tribe\Libs\Tests\Parent_Array_Model[]
	 */
	public array $parents = [];

	/**
	 * @var \Tribe\Libs\Tests\Title_Model[]
	 */
	public array $titles = [];

}
