<?php declare(strict_types=1);

namespace Tribe\Libs\Acf_Field_Models\Models;

use Tribe\Libs\Acf_Field_Models\Field_Model;

class File extends Field_Model {

	public int $id = 0;
	public string $title = '';
	public string $filename = '';
	public int $filesize = 0;
	public string $url = '';
	public string $link = '';
	public string $alt = '';
	public int $author = 0;
	public string $description = '';
	public string $caption = '';
	public string $name = '';
	public string $status = '';
	public int $uploaded_to = 0;
	public string $date = '';
	public string $modified = '';
	public int $menu_order = 0;
	public string $mime_type = '';
	public string $type = '';
	public string $subtype = '';
	public string $icon = '';

}
