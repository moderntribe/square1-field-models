<?php declare(strict_types=1);

namespace Tribe\Libs\Tests;

use Codeception\TestCase\WPTestCase;
use Faker\Factory;
use Faker\Generator;

class Test_Case extends WPTestCase {

	protected Generator $faker;

	public function setUp(): void {
		parent::setUp();

		$this->faker = Factory::create();
	}

}
