<?php declare(strict_types=1);

namespace Tribe\Libs\Tests;

use Tribe\Libs\Field_Models\Field_Model;

class Parent_Array_Model extends Field_Model {

	/**
	 * @var \Tribe\Libs\Tests\Child_Two_Model[]
	 */
	public array $children = [];

}
