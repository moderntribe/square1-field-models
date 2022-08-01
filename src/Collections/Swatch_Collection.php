<?php declare(strict_types=1);

namespace Tribe\Libs\Field_Models\Collections;

use Spatie\DataTransferObject\DataTransferObjectCollection;
use Tribe\Libs\Field_Models\Models\Swatch;

class Swatch_Collection extends DataTransferObjectCollection {

	public static function create( array $swatches ): Swatch_Collection {
		return new static( Swatch::arrayOf( $swatches ) );
	}

	public function current(): Swatch {
		return parent::current();
	}

	/**
	 * Retrieve a Swatch by slug
	 *
	 * @param mixed $offset The slug, e.g. black.
	 *
	 * @return \Tribe\Libs\Field_Models\Models\Swatch|null
	 */
	public function offsetGet( $offset ): ?Swatch {
		return parent::offsetGet( $offset );
	}

	/**
	 * Return a subset of the theme color swatches from all available swatches.
	 *
	 * @param  string[]  $color_slugs
	 *
	 * @return \Tribe\Libs\Field_Models\Collections\Swatch_Collection
	 */
	public function get_subset( array $color_slugs = [] ): Swatch_Collection {
		return self::create( array_intersect_key( $this->toArray(), array_flip( $color_slugs ) ) );
	}

	/**
	 * Format a swatch collection for the ACF swatch field.
	 *
	 * @return array
	 */
	public function format_for_acf(): array {
		return array_column( $this->items(), 'label', 'color' );
	}

	/**
	 * Return a swatch by an ACF Swatch Field value.
	 *
	 * @param  string  $color_format  The swatch value, e.g. #FFFFFF, rgba(255,0,0, 1) etc...
	 *
	 * @return \Tribe\Libs\Field_Models\Models\Swatch|null
	 */
	public function get_by_value( string $color_format = '' ): ?Swatch {
		foreach ( $this->iterator as $swatch ) {
			if ( $swatch->color === $color_format ) {
				return $swatch;
			}
		}

		$this->rewind();

		return null;
	}

}
