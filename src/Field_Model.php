<?php declare(strict_types=1);

namespace Tribe\Libs\Field_Models;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\FieldValidator;
use Spatie\DataTransferObject\FlexibleDataTransferObject;
use Spatie\DataTransferObject\ValueCaster;
use Throwable;

class Field_Model extends FlexibleDataTransferObject {

	/**
	 * Override the castValue method and automatically cast values to their type.
	 *
	 * @param  \Spatie\DataTransferObject\ValueCaster     $valueCaster
	 * @param  \Spatie\DataTransferObject\FieldValidator  $fieldValidator
	 * @param  mixed                                      $value
	 *
	 * @return mixed
	 */
	protected function castValue( ValueCaster $valueCaster, FieldValidator $fieldValidator, $value ) {
		$value = $this->castType( $value, $fieldValidator );

		return parent::castValue( $valueCaster, $fieldValidator, $value );
	}

	/**
	 * Attempt to automatically cast values before the DTO is validated upstream which
	 * would normally fail. If the type isn't valid, we'll just "null" it out and set it
	 * to the expected type to allow the default value to be used.
	 *
	 * @param  mixed                                      $value
	 * @param  \Spatie\DataTransferObject\FieldValidator  $fieldValidator
	 *
	 * @return mixed
	 */
	protected function castType( $value, FieldValidator $fieldValidator ) {
		if ( $fieldValidator->isValidType( $value ) ) {
			return $value;
		}

		foreach ( $fieldValidator->allowedTypes as $type ) {
			if ( is_subclass_of( $type, DataTransferObject::class ) ) {
				try {
					$value = new $type( (array) $value );
					break;
				} catch ( Throwable $e ) {
					continue;
				}
			} elseif ( is_scalar( $type ) || is_null( $type ) ) {
				$value = null;
				settype( $value, $type );
				break;
			}
		}

		return $value;
	}

}
