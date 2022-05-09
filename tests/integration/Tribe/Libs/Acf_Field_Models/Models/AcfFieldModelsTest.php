<?php declare(strict_types=1);

namespace Tribe\Libs\Acf_Field_Models\Models;

use Tribe\Libs\Tests\Test_Case;

final class AcfFieldModelsTest extends Test_Case {

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

		$this->assertSame( $data, $link->toArray() );
	}

	public function test_file_field(): void {
		$post_id = $this->factory()->post->create( [
			'post_status' => 'publish',
		] );

		$image     = codecept_data_dir( 'test.jpg' );
		$post_date = date( 'Y-m-d H:i:s', strtotime( 'now' ) );

		$attachment_id = $this->factory()->attachment->create( [
			'file'           => $image,
			'post_title'     => 'Test image',
			'post_parent'    => $post_id,
			'post_content'   => 'This is a test image description',
			'post_excerpt'   => 'This is a test image caption',
			'post_mime_type' => 'image/jpeg',
			'post_date'      => $post_date,
			'post_modified'  => $post_date,
		] );

		$field_key = 'field_test_file';

		acf_add_local_field( [
			'key'           => $field_key,
			'name'          => 'test_file',
			'type'          => 'file',
			'return_format' => 'array',
		] );

		$this->assertNotEmpty( update_field( $field_key, $attachment_id, $post_id ) );

		$file = new File( get_field( $field_key, $post_id ) );

		$this->assertSame( $attachment_id, $file->id );

		$this->assertSame( [
			'id'          => $attachment_id,
			'title'       => 'Test image',
			'filename'    => 'test.jpg',
			'filesize'    => filesize( $image ),
			'url'         => 'http://square1-acf-field-models.tribe/wp-content/uploads//home/justin/projects/tribe/square1-acf-field-models/tests/./_data/test.jpg',
			'link'        => "http://square1-acf-field-models.tribe/?attachment_id=$attachment_id",
			'alt'         => '',
			'author'      => 0,
			'description' => 'This is a test image description',
			'caption'     => 'This is a test image caption',
			'name'        => 'test-image',
			'status'      => 'inherit',
			'uploaded_to' => $post_id,
			'date'        => $post_date,
			'modified'    => $post_date,
			'menu_order'  => 0,
			'mime_type'   => 'image/jpeg',
			'type'        => 'image',
			'subtype'     => 'jpeg',
			'icon'        => 'http://square1-acf-field-models.tribe/wp-includes/images/media/default.png',
		], $file->toArray() );
	}

	public function test_image_field(): void {
		$post_id = $this->factory()->post->create( [
			'post_status' => 'publish',
		] );

		$image_file     = codecept_data_dir( 'test.jpg' );
		$post_date = date( 'Y-m-d H:i:s', strtotime( 'now' ) );

		$attachment_id = $this->factory()->attachment->create( [
			'file'           => $image_file,
			'post_title'     => 'Test image',
			'post_parent'    => $post_id,
			'post_content'   => 'This is a test image description',
			'post_excerpt'   => 'This is a test image caption',
			'post_mime_type' => 'image/jpeg',
			'post_date'      => $post_date,
			'post_modified'  => $post_date,
		] );

		$field_key = 'field_test_image';

		acf_add_local_field( [
			'key'           => $field_key,
			'name'          => 'test_image',
			'type'          => 'image',
			'return_format' => 'array',
		] );

		$this->assertNotEmpty( update_field( $field_key, $attachment_id, $post_id ) );

		$image = new Image( get_field( $field_key, $post_id ) );

		$this->assertSame( $attachment_id, $image->id );

		$this->assertSame( [
			'id'          => $attachment_id,
			'title'       => 'Test image',
			'filename'    => 'test.jpg',
			'filesize'    => filesize( $image_file ),
			'url'         => 'http://square1-acf-field-models.tribe/wp-content/uploads//home/justin/projects/tribe/square1-acf-field-models/tests/./_data/test.jpg',
			'link'        => "http://square1-acf-field-models.tribe/?attachment_id=$attachment_id",
			'alt'         => '',
			'author'      => 0,
			'description' => 'This is a test image description',
			'caption'     => 'This is a test image caption',
			'name'        => 'test-image',
			'status'      => 'inherit',
			'uploaded_to' => $post_id,
			'date'        => $post_date,
			'modified'    => $post_date,
			'menu_order'  => 0,
			'mime_type'   => 'image/jpeg',
			'type'        => 'image',
			'subtype'     => 'jpeg',
			'icon'        => 'http://square1-acf-field-models.tribe/wp-includes/images/media/default.png',
		], $image->toArray() );
	}

	public function test_user_field(): void {
		$user_id = $this->factory()->user->create();
		$post_id = $this->factory()->post->create( [
			'post_status' => 'publish',
		] );

		$field_key = 'field_test_user';

		acf_add_local_field( [
			'key'           => $field_key,
			'name'          => 'test_user',
			'type'          => 'user',
			'return_format' => 'array',
		] );

		$this->assertNotEmpty( update_field( $field_key, $user_id, $post_id ) );

		$user = new User( get_field( $field_key, $post_id ) );

		$wp_user = get_user_by( 'ID', $user_id );

		$this->assertSame( $user_id, $user->ID );

		$this->assertSame( [
			'ID'               => $wp_user->ID,
			'user_firstname'   => $wp_user->user_firstname,
			'user_lastname'    => $wp_user->user_lastname,
			'nickname'         => $wp_user->nickname,
			'user_nicename'    => $wp_user->user_nicename,
			'display_name'     => $wp_user->display_name,
			'user_email'       => $wp_user->user_email,
			'user_url'         => $wp_user->user_url,
			'user_registered'  => $wp_user->user_registered,
			'user_description' => $wp_user->user_description,
			'user_avatar'      => get_avatar( $wp_user->ID ),
		], $user->toArray() );

	}

}
