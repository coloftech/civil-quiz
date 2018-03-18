<?php 


/**
* 
*/
class Mglobal extends CI_Model
{
	
	function __construct()
	{
		# code...
		parent::__construct();
		$this->init();
	}
	function init()
	{
		# code...

        date_default_timezone_set('Asia/Manila');

		$this->load->library('pagination');



                    // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
			
        $this->pagination->initialize($config);
	}
    public function metakeyword()
    {
        # code...



    }
    function p_status($stats = false)
    {
       // $stats = (int)$stats;
        switch ($stats) {
            case '1':
                # code...
            return 'Published';
                break;
            case '2':
                # code...
            return  'Unpublished';
                break;
            case '3':
                # code...
            return 'Trash';
                break;
            
            default:
                # code...
            return 'Draft';
                break;
        }
    }
        public function limitext($string='')
    {
        # code...
        $string = strip_tags($string);

        if (strlen($string) > 100) {

            // truncate string
            $stringCut = substr($string, 0, 100);

            // make sure it ends in a word so assassinate doesn't become ass...
            $string = substr($stringCut, 0, strrpos($stringCut, ' ')); 
        }
        return $string;
    }
}