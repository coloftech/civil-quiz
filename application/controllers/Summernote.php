<?php 
/**
* 
*/
class Summernote extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}

	
	public function insert_image()
	{
			if($file = $_FILES){

   				if(!$check = getimagesize($_FILES["note_upload"]["tmp_name"])){


					echo json_encode(array('stats'=>false,'msg'=>'File is not an image.'));
					exit();
  				 }
    
				if($upload = $this->upload('Summernote','note_upload')){

					echo json_encode(array('stats'=>true,'link'=>base_url().$upload['link']));
					exit();
				}else{

					echo json_encode(array('stats'=>false,'msg'=>'File upload error'));
					exit();
				}
			}
	}
	
	public function upload($title=false,$file)
	{
		
		# code...
            	$tmp_file = $_FILES[$file]['tmp_name'];


            	$mimetype = mime_content_type($tmp_file);
              	$date =  date('y-m-d-h-m-s');
              		switch ($mimetype) {
	 				case 'image/png':
	 					# code...
	 					$type='image';
	 					break;
	 				case 'image/jpeg':
	 					# code...
	 					$type='image';
	 					break;
	 				case 'image/jpg':
	 					# code...
	 					$type='image';
	 					break;
	 				case 'image/gif':
	 					# code...
	 					$type='image';
	 					break;
	 				default:
	 					$type = 'others';
	 					break;
	 				}
	 				if($type != 'image'){
	 					return false;
	 				}
	 				

	 				$upload_path ='public/uploads/image/';//UPLOADPATH;//base_url('public/');
	 				
                
                $filename = basename($_FILES[$file]["name"]);
                $targetfile = $upload_path . basename($_FILES[$file]["name"]);

                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $oldname = pathinfo($filename, PATHINFO_FILENAME);

                $oldname = $this->slug->create($oldname);
                if($title){

                $title = $this->slug->create($title);
                $newfile = $upload_path.$title.'-'.$oldname.'-'.$date.'.'.$ext;
                $newfilename = $title.'-'.$oldname.'-'.strtotime("now").'.'.$ext;
	            }else{

	                $newfile = $upload_path.$oldname.'-'.$date.'.'.$ext;
	                $newfilename = $oldname.'-'.strtotime("now").'.'.$ext;
	            }


        		if(move_uploaded_file($tmp_file, $newfile)){

                    $data = array('link'=>$newfile,'mtype'=>$mimetype,'newfilename'=>$newfilename,'type'=>$type,'u_key'=>time());
                    
                    return $data;
                }else{

                    return false;
                }
            
	}
	    function check_mimetype($filename)
    {
		if (!$this->aauth->is_loggedin()){
        	redirect();
        }	
        $mimetype = false;
        if(function_exists('mime_content_type')) {
            $mimetype = mime_content_type($filename); 

            $allowed = array('image/jpeg','image/pjpeg','image/png','image/x-png','audio/mp3','video/*','application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint','application/pdf');
            if (in_array($mimetype, $allowed)) {

                return true;
            }else{
                return false;
            }
        }
       return true;
    }
}