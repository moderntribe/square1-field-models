<?php declare( strict_types=1 );

final class Acf_Downloader extends Downloader {

	private object $data;

	public function __construct() {
		$this->data = $this->getData();
	}

	/**
	 * @inheritDoc
	 */
	public function download(): string {
		$file = sprintf( '/tmp/%s-%s.zip', $this->data->slug, $this->data->version );

		file_put_contents( $file, file_get_contents( $this->data->download_link ) );

		return $file;
	}

	/**
	 * @inheritDoc
	 */
	public function destination(): string {
		return __DIR__ . '/../../tests/wordpress/wp-content/plugins/';
	}

	private function getData(): object {
		return json_decode( file_get_contents( 'https://api.wordpress.org/plugins/info/1.0/advanced-custom-fields.json' ) );
	}

}
