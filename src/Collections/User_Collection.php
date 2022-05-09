<?php declare( strict_types=1 );

namespace Tribe\Libs\Acf_Field_Models\Collections;

use Spatie\DataTransferObject\DataTransferObjectCollection;
use Tribe\Libs\Acf_Field_Models\Models\User;

class User_Collection extends DataTransferObjectCollection {

	public static function create( array $users ): User_Collection {
		return new static( User::arrayOf( $users ) );
	}

}
