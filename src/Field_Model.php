<?php declare(strict_types=1);

namespace Tribe\Libs\Field_Models;

use Spatie\DataTransferObject\FieldValidator;
use Spatie\DataTransferObject\FlexibleDataTransferObject;
use Spatie\DataTransferObject\ValueCaster;

class Field_Model extends FlexibleDataTransferObject {

	/**
	 * Overload the castValue method and automatically cast values to their type.
	 *
	 * @param  \Spatie\DataTransferObject\ValueCaster     $valueCaster
	 * @param  \Spatie\DataTransferObject\FieldValidator  $fieldValidator
	 * @param  mixed                                      $value
	 *
	 * @return mixed
	 */
	protected function castValue( ValueCaster $valueCaster, FieldValidator $fieldValidator, $value ) {
		$this->castType( $value, $fieldValidator );

		if ( is_array( $value ) ) {
			return $valueCaster->cast( $value, $fieldValidator );
		}

		return $value;
	}

	/**
	 * Attempt to cast scalar values to their proper type as ACF will return field data without
	 * respecting PHP types, e.g. if something should be an empty string: '', it may be a boolean
	 * false.
	 *
	 * @param  mixed                                      $value
	 * @param  \Spatie\DataTransferObject\FieldValidator  $fieldValidator
	 *
	 * @return void
	 */
	protected function castType( &$value, FieldValidator $fieldValidator ): void {
		$type      = gettype( $value );
		$firstType = $fieldValidator->allowedTypes[0];

		// If not an allowed type, empty the value and cast as the first type, so it will
		// use the default defined in the model.
		if ( ! in_array( $type, $fieldValidator->allowedTypes ) ) {
			$value = null;
			settype( $value, $firstType );
		}
	}

}
