<?php declare( strict_types=1 );

namespace Tribe\Libs\Acf_Field_Models\Collections;

use Tribe\Libs\Tests\Test_Case;

final class CollectionTest extends Test_Case {

	public function test_user_collection(): void {
		$user_ids = [
			$this->factory()->user->create(),
			$this->factory()->user->create(),
			$this->factory()->user->create(),
			$this->factory()->user->create(),
			$this->factory()->user->create(),
		];

		$post_id = $this->factory()->post->create( [
			'post_status' => 'publish',
		] );

		$field_key = 'field_test_users';

		acf_add_local_field( [
			'key'           => $field_key,
			'name'          => 'test_users',
			'multiple'      => true,
			'type'          => 'user',
			'return_format' => 'array',
		] );

		$this->assertNotEmpty( update_field( $field_key, $user_ids, $post_id ) );

		$collection = User_Collection::create( get_field( $field_key, $post_id ) );

		$this->assertSame( count( $user_ids ), $collection->count() );

		foreach ( $collection as $key => $user ) {
			$wp_user = get_user_by( 'ID', $user_ids[ $key ] );

			$this->assertSame( $wp_user->ID, $user->ID );
			$this->assertSame( $wp_user->user_firstname, $user->user_firstname );
			$this->assertSame( $wp_user->user_lastname, $user->user_lastname );
			$this->assertSame( $wp_user->nickname, $user->nickname );
			$this->assertSame( $wp_user->display_name, $user->display_name );
			$this->assertSame( $wp_user->user_email, $user->user_email );
		}

	}
}
