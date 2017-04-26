<?php

class Photo extends Db_object {

	protected static $db_table = "photos";
	protected static $db_table_fields = array('id', 'title', 'caption', 'description', 'filename', 'type', 'size', 'alternate_text');
	public $id;
	public $title;
	public $caption;
	public $description;
	public $filename;
	public $alternate_text;
	public $type;
	public $size;

	public $tmp_path;
	public $upload_directory = "images";
	public $errors = array();
	public $upload_errors_array = array(

		UPLOAD_ERR_OK 		  => "There is no error.",
		UPLOAD_ERR_INI_SIZE   => "The uploaded file excssds the upload_max_filesize directive in php-ini.",
		UPLOAD_ERR_FORM_SIZE  => "The uploaded file exceeds the MAML form.",
		UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded.",
		UPLOAD_ERR_NO_FILE    => "No file was uploaded.",
		UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
		UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
		UPLOAD_ERR_EXTENSION  => "A PHP extension stopped the file upload."

		);

	// This is passing $_FILES['uploaded_files'] as an argument

	

	public function picture_path(){

		return $this->upload_directory.DS.$this->filename;

	}

	public function save() {

		if($this->id){

			$this->update();

		} else {

			if(!empty($this->errors)){

				return false;

			}

			if(empty($this->filename) || empty($this->tmp_path)){

				$this->errors[] = "the file was not available";
				return false;

			}
			$target_path = SITE_ROOT . DS . 'admin' .DS . $this->upload_directory . DS . $this->filename;

			if(file_exists($target_path)){
				$this->errors[] = "The file {$this->filename} already exists";
				return false;
			}

			if(move_uploaded_file($this->tmp_path, $target_path)){

				if($this->create()){

					unset($this->tmp_path);
					return true;

				}

			} else {

				$this->errors[] = "The file directory probably does not have permissions";
				return false;

			}

		}

	}

	public function delete_photo() {

		if($this->delete()){

			$target_path =  SITE_ROOT . DS . 'admin' . DS . $this->picture_path();

			return unlink($target_path) ? true : false;

		} else {

			return false;

		}

	}


	public static function display_sidebar_data($photo_id){

		$photo = Photo::find_by_id($photo_id);

		$output = "<a class='thumbnail' href='#'><img width='100' src='{$photo->picture_path()}'></a>";
		$output .= "<p>{$photo->filename}</p>";
		$output .= "<p>{$photo->type}</p>";
		$output .= "<p>{$photo->size}</p>";

		echo $output;
	}

}




?>