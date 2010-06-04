<?php
/**
 * Description of Gallery
 *
 * @author arteau
 */

$GLOBALS["classes"]["Gallery"] = array("classname" => "Gallery", "tablename" => "fan_gallery");
	
class Gallery extends _Gallery
{
	protected $classname = 'Gallery';

	public function __construct($values = array(), $updateFields = true)
	{
		parent::__construct($values, $updateFields);
	}

	function getSubgalleries()
	{
		return Gallery::search(array(array('fan_gallery_id', $this->id)), 'name');
	}

	function getParentGalleries()
	{
		return Gallery::search(array(array('id', $this->gallery_id)), 'name');
	}

	/**
	 * Enter description here...
	 *
	 * @return Image
	 */
	function getRandomImage()
	{
		return reset(Image::search(array(array('fan_gallery_id', $this->id)), 'RAND()', 1));
	}

	public static function getHierarchy($id)
	{
		if ($id == 0)
			return array(0);

		$hierarchy = array();
		$gal = Gallery::find($id)->fan_gallery_id;
		$hierarchy []= $id;
		
		while (!empty($gal->fan_gallery_id))
		{
			$hierarchy []= $gal;
			$parent = Gallery::find($gal);
			$gal = $parent->fan_gallery_id;
		}

		$hierarchy []= 0;
		$hierarchy = array_reverse($hierarchy);
		return $hierarchy;
	}

	public function getWebDirectory()
	{
		return '/photos/' . $this->id . '/';
	}

	public function getDirectory()
	{
		return $GLOBALS['ROOTPATH'] . $this->getWebDirectory();
	}

	public function getUrl()
	{
		return APPLICATION_URL . 'gallery/' . $this->id . '/' . Tools::cleanLink($this->name) . '">' . $this->name;
	}
}
	