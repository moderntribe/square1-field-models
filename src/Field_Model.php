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
		$value = $this->castType( $valueCaster, $fieldValidator, $value );

		return parent::castValue( $valueCaster, $fieldValidator, $value );
	}

	/**
	 * Attempt to automatically cast values before the DTO is validated upstream which
	 * would normally fail. If the type isn't valid, we'll just "null" it out and set it
	 * to the expected type to allow the default value to be used.
	 *
	 * @param  \Spatie\DataTransferObject\ValueCaster     $valueCaster
	 * @param  \Spatie\DataTransferObject\FieldValidator  $fieldValidator
	 * @param  mixed                                      $value
	 *
	 * @return mixed
	 */
	protected function castType( ValueCaster $valueCaster, FieldValidator $fieldValidator, $value ) {
		if ( $fieldValidator->isValidType( $value ) ) {
			return $value;
		}

		foreach ( $fieldValidator->allowedTypes as $key => $type ) {
			if ( is_subclass_of( $type, DataTransferObject::class ) ) {
				try {
					$value = new $type( (array) $value );
					break;
				} catch ( Throwable $e ) {
					continue;
				}
			} elseif ( is_scalar( $type ) || is_null( $type ) ) {
				// This is supposed to be an array of models, e.g. \Some_Model[]
				if ( ! empty( $fieldValidator->allowedArrayTypes[ $key ] ) ) {
					// ACF passed some random type, ensure it's cast to an array
					if ( empty( $value ) ) {
						$value = [];
					}

					// Pass arrays back up to the parent class for casting to models
					$value = parent::castValue( $valueCaster, $fieldValidator, $value );
					break;
				}

				// If we made it here, this is a true scalar type, allow PHP to cast it.
				settype( $value, $type );
				break;
			}
		}

		return $value;
	}

}
