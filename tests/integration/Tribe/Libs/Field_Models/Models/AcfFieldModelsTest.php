<?php declare(strict_types=1);

namespace Tribe\Libs\Field_Models\Models;

use Tribe\Libs\Field_Models\Field_Model;
use Tribe\Libs\Tests\Child_One_Model;
use Tribe\Libs\Tests\Child_Two_Model;
use Tribe\Libs\Tests\Parent_Model;
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
			'url'         => 'http://square1-field-models.tribe/wp-content/uploads/' . $image,
			'link'        => "http://square1-field-models.tribe/?attachment_id=$attachment_id",
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
			'icon'        => 'http://square1-field-models.tribe/wp-includes/images/media/default.png',
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
			'url'         => 'http://square1-field-models.tribe/wp-content/uploads/' . $image_file,
			'link'        => "http://square1-field-models.tribe/?attachment_id=$attachment_id",
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
			'icon'        => 'http://square1-field-models.tribe/wp-includes/images/media/default.png',
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

	public function test_cta_field(): void {
		$post_id = $this->factory()->post->create( [
			'post_status' => 'publish',
		] );

		$field_key = 'field_test_cta';

		acf_add_local_field( [
			'key'           => $field_key,
			'name'          => 'test_cta',
			'type'          => 'link',
			'return_format' => 'array',
		] );

		$data = [
			'title'  => $this->faker->title(),
			'url'    => $this->faker->url(),
			'target' => '_blank',
		];

		$this->assertNotEmpty( update_field( $field_key, $data, $post_id ) );

		$link = new Cta( [
			'link'           => get_field( $field_key, $post_id ),
			'add_aria_label' => true,
			'aria_label'     => 'Screen reader text',
		] );

		$this->assertSame( [
			'link'           => $data,
			'add_aria_label' => true,
			'aria_label'     => 'Screen reader text',
		], $link->toArray() );
	}

	public function test_cta_field_with_different_submission_structures(): void {
		$post_id = $this->factory()->post->create( [
			'post_status' => 'publish',
		] );

		$field_key = 'field_test_cta';

		acf_add_local_field( [
			'key'           => $field_key,
			'name'          => 'test_cta',
			'type'          => 'link',
			'return_format' => 'array',
		] );

		$empty_field_value = get_field( $field_key, $post_id );

		// Random ACF return type
		$this->assertNull( $empty_field_value );
		$cta = new Cta( [ 'link' => $empty_field_value ] );

		$this->assertInstanceOf( Field_Model::class, $cta );
		$this->assertEquals( new Link(), $cta->link );

		// boolean
		$cta2 = new Cta( [ 'link' => false ] );
		$this->assertInstanceOf( Field_Model::class, $cta2 );
		$this->assertEquals( new Link(), $cta2->link );

		// empty array
		$cta3 = new Cta( [ 'link' => [] ] );
		$this->assertInstanceOf( Field_Model::class, $cta3 );
		$this->assertEquals( new Link(), $cta3->link );

		// completely missing child definition
		$cta4 = new Cta();
		$this->assertInstanceOf( Field_Model::class, $cta4 );
		$this->assertEquals( new Link(), $cta4->link );

		// invalid and partial data
		$cta5 = new Cta( [
			'add_aria_label' => 'this should be a boolean',
			'link'           => [
				0               => 'mixed array',
				'invalid_index' => 'I do not exist',
				'url'           => 'https://tri.be',
			],
		] );
		$this->assertInstanceOf( Field_Model::class, $cta5 );
		$this->assertSame( [
			'title'  => '',
			'url'    => 'https://tri.be',
			'target' => '_self',
		], $cta5->link->toArray() );
		$this->assertFalse( $cta5->add_aria_label );

		// already created child instance
		$cta6 = new Cta( [
			'link'           => new Link( [
				'title'  => 'Click me',
				'url'    => 'https://tri.be',
				'target' => '_blank',
			] ),
			'add_aria_label' => true,
			'aria_label'     => 'Screen reader text',
		] );
		$this->assertInstanceOf( Field_Model::class, $cta6 );
		$this->assertEquals( [
			'title'  => 'Click me',
			'url'    => 'https://tri.be',
			'target' => '_blank',
		], $cta6->link->toArray() );

		// raw child object
		$cta7 = new Cta( [
			'link'           => (object) [
				'title'  => 'Click me',
				'url'    => 'https://tri.be',
				'target' => '_blank',
			],
			'add_aria_label' => true,
			'aria_label'     => 'Screen reader text',
		] );
		$this->assertInstanceOf( Field_Model::class, $cta7 );
		$this->assertEquals( [
			'title'  => 'Click me',
			'url'    => 'https://tri.be',
			'target' => '_blank',
		], $cta7->link->toArray() );
	}

	public function test_nested_models(): void {
		$data = [
			'name'      => 'parent',
			'child_one' => [
				'name'      => 'Child One',
				'child_two' => [
					'name' => 'Child Two',
				],
			],
		];

		$model = new Parent_Model( $data );

		$this->assertEquals( $data, $model->toArray() );
		$this->assertInstanceOf( Child_One_Model::class, $model->child_one );
		$this->assertInstanceOf( Child_Two_Model::class, $model->child_one->child_two );
	}

	public function test_empty_nested_models(): void {
		$data = [
			'name' => 'parent',
		];

		$model = new Parent_Model( $data );

		$this->assertNotEquals( $data, $model->toArray() );
		$this->assertSame( 'parent', $model->name );
		$this->assertInstanceOf( Child_One_Model::class, $model->child_one );
		$this->assertInstanceOf( Child_Two_Model::class, $model->child_one->child_two );
		$this->assertSame( '', $model->child_one->name );
		$this->assertSame( 'This is my default', $model->child_one->child_two->name );
	}

}
