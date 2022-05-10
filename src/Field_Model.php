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
		if ( empty( $fieldValidator->allowedTypes[0] ) ) {
			return;
		}

		$type      = gettype( $value );
		$firstType = $fieldValidator->allowedTypes[0];

		if ( ! in_array( $type, $fieldValidator->allowedTypes ) ) {
			if ( class_exists( $firstType ) ) {
				$value = new $firstType( (array) $value );
			} else {
				$value = null;
				settype( $value, $firstType );
			}
		}
	}

}
