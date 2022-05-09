<?php declare(strict_types=1);

namespace Tribe\Libs\Acf_Field_Models;

use Tribe\Libs\Acf_Field_Models\Models\Link;
use Tribe\Libs\Tests\Test_Case;

class AcfFieldModelsTest extends Test_Case {

	public function test_link_field(): void {
		$post_id = $this->factory()->post->create( [
			'post_status' => 'publish',
		] );

		$field_key = 'field_test_link';

		acf_add_local_field( [
			'key'           => $field_key,
			'name'          => 'test_link',
			'type'          => 'link',
			'return_format' => 'array',
		] );

		$data = [
			'title'  => $this->faker->title(),
			'url'    => $this->faker->url(),
			'target' => '_blank',
		];

		$this->assertNotEmpty( update_field( $field_key, $data, $post_id ) );

		$link = new Link( get_field( $field_key, $post_id ) );

		$this->assertNotEmpty( $link->toArray() );
		$this->assertSame( $data, $link->toArray() );
	}

}
