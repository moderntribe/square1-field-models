<?php declare(strict_types=1);

namespace Tribe\Libs\Field_Models\Models;

use Tribe\Libs\Field_Models\Field_Model;

/**
 * Represents a color swatch.
 */
class Swatch extends Field_Model {

	/**
	 * The hex color code.
	 *
	 * @example #ffffff, rgb(255,0,0), rgba(255,0,0, 1), hsl(0,100%,50%)
	 */
	public string $color;

	/**
	 * The i18n translated color label.
	 *
	 * @example esc_html__( 'White', 'tribe' )
	 */
	public string $label;

	/**
	 * The uniquely named slug for this swatch.
	 *
	 * @example white
	 */
	public string $slug;

}
