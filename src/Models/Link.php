<?php declare(strict_types=1);

namespace Tribe\Libs\Acf_Field_Models\Models;

use Tribe\Libs\Acf_Field_Models\Field_Model;

class Link extends Field_Model {

	public string $title = '';
	public string $url = '';
	public string $target = '_self';

}
