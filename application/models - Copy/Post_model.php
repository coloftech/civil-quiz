<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Post_model extends CI_Model
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}

    function esc_array($array){
        $posts = array();
        if(!empty($array)){
         foreach($array as $key => $value)
         {  
            $posts[$key] = $this->db->escape_str($value);
         }
        }
        return $posts;
    }
    public function listall($total=false,$start=false,$limit=false)
    {
        # code...
        if ($start || $limit) {
            # code...
            if (is_numeric($start) || is_numeric($limit)) {
                # code...
                $sql = sprintf("SELECT p.page_id,p.title,p.slug,p.date_created,p.status,c.value as content,p.year_presented as year,i.url as imgs FROM pages p LEFT JOIN page_contents c ON c.group_id = p.page_id LEFT JOIN col_images i ON i.page_id = p.page_id WHERE c.name = 'content' GROUP BY p.page_id ORDER BY p.page_id DESC LIMIT  %d,%d",$start,$limit);
            $query = $this->db->query($sql);
            $result = $query->result();
            return $result;
            }
            

        }
        if ($total) {
            # code...
            $sql = sprintf("SELECT p.page_id,p.title,p.slug,p.date_created,p.status,c.value as content,p.year_presented as year,i.url as imgs FROM pages p LEFT JOIN page_contents c ON c.group_id = p.page_id LEFT JOIN col_images i ON i.page_id = p.page_id WHERE c.name = 'content' GROUP BY p.page_id ORDER BY p.page_id DESC");
            $query = $this->db->query($sql);
            $result = $query->result();
            return $result;

        }
        return false;


    }
    public function listpostcategory($post_id=false)
    {

        if($post_id){

            $this->db->select('category_id')->where('page_id',$post_id);
            return $this->db->get('page_category')->result();
        }
        return false;


    }
        public function list_to_home($total=false,$start=false,$limit=false)
    {

        if ($start || $limit) {
            # code...
            if (is_numeric($start) || is_numeric($limit)) {
                # code...
                $sql = sprintf("SELECT p.page_id,p.title,p.slug,p.date_created,p.status,c.value as content,p.year_presented as year,i.url as imgs FROM pages p LEFT JOIN page_contents c ON c.group_id = p.page_id  LEFT JOIN col_images i ON i.page_id = p.page_id WHERE c.name = 'content' AND p.status = 1 ORDER BY p.page_id DESC LIMIT  %d,%d",$start,$limit);
            $query = $this->db->query($sql);
            $result = $query->result();
            return $result;
            }
            

        }else{

                # code...
            $sql = sprintf("SELECT p.page_id,p.title,p.slug,p.date_created,p.status,c.value as content,p.year_presented as year,i.url as imgs FROM pages p LEFT JOIN page_contents c ON c.group_id = p.page_id  LEFT JOIN col_images i ON i.page_id = p.page_id WHERE c.name = 'content' AND p.status = 1 ORDER BY p.page_id DESC");
            $query = $this->db->query($sql);
            $result = $query->result();
            return $result;
        }
        return false;


    }
        public function showinfo($slug=false)
    {
        # code...
        if (is_numeric($slug)) {
            # code...
                # code...
            $sql = sprintf("SELECT p.page_id,p.title,p.slug,p.date_created,c.value as content,cc.id as cat_id,cc.name as category,p.year_presented as year,i.url as imgs FROM pages p LEFT JOIN page_contents c ON c.group_id = p.page_id LEFT JOIN page_category cat ON cat.page_id = p.page_id LEFT JOIN col_category cc ON cc.id = cat.category_id  LEFT JOIN col_images i ON i.page_id = p.page_id WHERE c.name = 'content' AND p.page_id = %d",$slug);
            $query = $this->db->query($sql);
            $result = $query->result();
            return $result;
            

        }
        return false;


    }
    public function limitext($string='')
    {
        # code...
        $string = strip_tags($string);

        if (strlen($string) > 50) {

            // truncate string
            $stringCut = substr($string, 0, 50);

            // make sure it ends in a word so assassinate doesn't become ass...
            $string = substr($stringCut, 0, strrpos($stringCut, ' ')); 
        }
        return $string;
    }

    public function isExist($value='')
    {
        # code...

        $sql = sprintf("SELECT * FROM pages WHERE title = '%s'",$value);
        $query = $this->db->query($sql);
        
        return $query->result();
        
    }
    public function iscatExist($cat='')
    {
        # code...

        $sql = sprintf("SELECT * FROM col_category WHERE name = '%s'",$cat);
        $query = $this->db->query($sql);
        
        return $query->result();
        
    }
	public function save_abstract($value='')
	{


		if($this->db->insert('pages',array('title'=>$value['title'],'slug'=>$value['slug'],'year_presented'=>$value['year'],'date_created'=>$value['month'],'status'=>$value['status']))){
			//var_dump($pages);

		$id = $this->db->insert_id();

		$content  = array('name' => 'content','value'=>$value['content'],'group_id'=>$id,'date_updated'=>date("Y-d-m") );
		$result = $this->db->insert('page_contents',$content);
		
		return $id;
		}
		//var_dump($id);
		return false;
	}

	    public function get_current_page_records($limit, $start) 
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get("pages");
 
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data[] = $row;
            }
             
            return $data;
        }
 
        return false;
    }
     
    public function get_total() 
    {
        return $this->db->count_all("pages");
    }

    public function get_pageTitle($slug = false) 
    {
        if (is_numeric($slug)) {
            # code...
            $query = $this->db->select('title')->from('pages')->where('page_id',$slug)->get();
            if($query->num_rows() > 0){
                foreach ($query->result() as $key) {
                    # code...
                    return $key->title;
                }
            }else{
                    return false;
            }

        } elseif($slug){
            $query = $this->db->select('title')->from('pages')->where('slug',$slug)->get();
            if($query->num_rows() > 0){
                foreach ($query->result() as $key) {
                    # code...
                    return $key->title;
                }
            }else{
                    return false;
            }
        }
        return false;
    }

    public function get_pageId($slug = '') 
    {
        if($slug <> ''){
            $query = $this->db->select('page_id')->from('pages')->where('slug',$slug)->get();
            if($query->num_rows() > 0){
                foreach ($query->result() as $key) {
                    # code...
                    return $key->page_id;
                }
            }else{
                    return 0;
            }
        }
        return 0;
    }
    public function get_pageSlug($id = false) 
    {
        if(is_numeric($id)){
            $query = $this->db->select('slug')->from('pages')->where('page_id',$id)->get();
            if($query->num_rows() > 0){
                foreach ($query->result() as $key) {
                    # code...
                    return $key->slug;
                }
            }else{
                    return 0;
            }
        }
        return 0;
    }
    public function get_post_content($id = 0) 
    {
        if($id > 0){
            $query = $this->db->select('value')->from('page_contents')->where(array('name'=>'content','group_id'=>$id))->get();
            if($query->num_rows() > 0){
                $result = $query->result();
                    # code...
                    return $result[0]->value;
                
            }
            return null;
        }
        return null;
    }

    public function get_keyword($id = 0) 
    {
        if($id > 0){
            $query = $this->db->select('keyword')->from('page_tag')->where('group_id',$id)->get();
            if($query->num_rows() > 0){
                $result = $query->result(); 
                    # code...
                    return $result[0]->keyword;
                
            }
            return null;

        }
        return null;
    }
    public function get_content($id = 0) 
    {
    	if($id > 0){
    		$query = $this->db->select('value')->from('page_contents')->where(array('name'=>'content','group_id'=>$id))->get();
    		if($query->num_rows() > 0){
    			foreach ($query->result() as $key) {
    				# code...
    				return $key->value;
    			}
    		}else{
    				return null;
    		}
    	}
        return null;
    }

    public function get_proponents($id = 0) 
    {
    	if($id > 0){
    		$query = $this->db->select('value')->from('page_contents')->where(array('name'=>'proponents','group_id'=>$id))->get();
    		if($query->num_rows() > 0){
    			foreach ($query->result() as $key) {
    				# code...
    				return $key->value;
    			}
    		}else{
    				return null;
    		}
    	}
        return null;
    }

    public function get_clients($id = 0) 
    {
    	if($id > 0){
    		$query = $this->db->select('value')->from('page_contents')->where(array('name'=>'clients','group_id'=>$id))->get();
    		if($query->num_rows() > 0){
    			foreach ($query->result() as $key) {
    				# code...
    				return $key->value;
    			}
    		}else{
    				return null;
    		}
    	}
        return null;
    }
    public function getallcategory($str=false)
    {
        # code...
            return $this->db->select('*')->get('col_category')->result();
        
    }

    public function insert($data=null)
    {
    	# code...
    	if($data !== null){

		//$content  = array('name' => 'content','value'=>$value['content'],'group_id'=>$id,'date_updated'=>date("Y-d-m") );
		$result = $this->db->insert('page_contents',$data);
    		return $result;
    	}else{
    		return false;
    	}
    }

    public function add_to_user($data=null)
    {
        # code...
        if($data !== null){
        

        $result = $this->db->insert('col_post_by_user',$data);
            return $result;
        }else{
            return false;
        }
    }
    public function insertTags($data=null)
    {
    	# code...
    	if($data !== null){
            $data = $this->esc_array($data);

		$result = $this->db->insert('page_tag',$data);
    		return $result;
    	}else{
    		return false;
    	}
    }
     public function insertimages($data=null)
    {
        # code...
        if($data !== null){
            $data = $this->esc_array($data);

        $result = $this->db->insert('col_images',$data);
            return $result;
        }else{
            return false;
        }
    }
    public function page_permission($page=false,$group=false,$perm=0)
    {
        # code...
        if ($group && $page) {
            # code...
            $sql = "INSERT INTO `page_perm_group` (`page_id`, `group_id`, `perm_id`) VALUES (?, ?, ?)";
            $result = $this->db->query($sql,array($page,$group,$perm));
            return $result;

        }
        return false;


    }

    public function search($tags='',$limit,$start)
    {
    	# code...

    $tags = explode(' ',$tags) ;
	foreach ($tags as $keyword) {
	# code...

    $this->db->select('p.*,t.keyword');
    $this->db->from('pages p'); 
    $this->db->join('page_tag t', 't.group_id=p.page_id', 'left');
    $this->db->join('page_contents c', 'c.group_id=t.group_id','right');
    //$this->db->where('c.album_id',$id);
    $this->db->like('t.keyword',$keyword);
    $this->db->or_like('p.title',$keyword);
    $this->db->or_like('c.value',$keyword);
    $this->db->limit($limit,$start);
    $this->db->group_by('p.page_id'); 
    $this->db->order_by('p.page_id','asc');  

    $query = $this->db->get(); 
    if($query->num_rows() != 0)
    {
        return $query->result();
    }
	}
    
        return false;
    

    }

    public function searchBy($tags='',$limit,$start,$filter,$by)
    {
        # code...

    $tags = explode(' ',$tags) ;
    foreach ($tags as $keyword) {
    # code...
        $sql = sprintf("SELECT p.*,t.keyword FROM pages p left join page_tag t on t.group_id = p.page_id left join page_contents c on c.group_id = t.group_id where t.keyword like '%s' or  p.title like '%s' or c.value = '%s' and %s = '%s' ",$v,$v,$v,$filter,$by); 


    $query = $this->db->get(); 
    if($query->num_rows() != 0)
    {
        return $query->result();
    }
    }
    
        return false;
    

    }

    public function like_total($tags='')
    {
    	# code...
    $tags = explode(' ',$tags) ;
	foreach ($tags as $keyword) {


    $this->db->select('p.*,t.keyword');
    $this->db->from('pages p'); 
    $this->db->join('page_tag t', 't.group_id=p.page_id', 'left');
    $this->db->join('page_contents c', 'c.group_id=p.page_id', 'left');
    //$this->db->where('c.album_id',$id);
    $this->db->like('t.keyword',$keyword);
    $this->db->or_like('p.title',$keyword);
    $this->db->or_like('c.value',$keyword);
   // $this->db->limit($limit,$start);
    $this->db->order_by('p.page_id','asc');  

    $query = $this->db->get(); 
    if($query->num_rows() != 0)
    {
        return count($query->result());
    }
	}
	return 0;
    
    }

    public function category($str=false)
    {
        # code...
        if($str){
            $str = $this->db->escape_str($str);
            $this->db->select('*')->where('name',$str);
            return $this->db->get('col_category')->result();
        }
        return false;
    }

    public function categoryid_by_name($str=false)
    {
        # code...
        if($str){
            $sql = sprintf("SELECT id FROM col_category WHERE name = '%s'",$str);
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result) > 0){
                return $result[0]->id;
            }
                return false;
        }
        return false;
    }
    public function categoryname_by_id($cat_id=false)
    {
        # code...
        if($cat_id){

            $this->db->select('name')->where('id',$cat_id);
            $result = $this->db->get('col_category')->result();
            if(count($result) > 0){
                return $result[0]->name;
            }
            else{
                return false;
            }
        }
        return false;
    }
    public function change_content($post_id=false,$content = false)
    {
        # code...
        if ($post_id) {
            # code...
            $sql = sprintf("UPDATE page_contents SET value = '%s' where name = 'content' AND group_id = %d",$content,$post_id);
            $query = $this->db->query($sql);
            return $query;
        }
        return false;
    }

    public function change_title($post_id=false,$title = false)
    {
        # code...
        if ($post_id) {
            # code...
            $sql = sprintf("UPDATE pages SET title = '%s' where page_id = %d",$title,$post_id);
            $query = $this->db->query($sql);
            return $query;
        }
        return false;
    }
         public function changeimages($post_id=false,$link = false)
    {
        //return $link;
        if ($post_id) {
            # code...
            $sql_s = sprintf("SELECT * FROM col_images WHERE page_id = %d",$post_id);
            $query_s = $this->db->query($sql_s);
            if($query_s->result()){

            $sql_u = sprintf("UPDATE col_images SET url = '%s' where page_id = %d",$link,$post_id);
            $query_u = $this->db->query($sql_u);
            return $query_u;
            }else{
               $this->insertimages(array('page_id'=>$post_id,'url'=>$link,'date_added'=>date('Y-m-d h:m:s')));

            }


        }
        return;

    }

    public function updatecategory($data=false)
    {
        # code...
         if($data){
           // $data = $this->esc_array($data);

        $result = $this->db->insert('page_category',$data);
            return $result;
        }else{
            return false;
        }
    }
    public function updatepoststatus($data=false)
    {
        # code...
         if($data){
                # code...
                $status = $data['status'];
                $id = $data['post_id'];

            $sql = sprintf("UPDATE pages SET status = %d WHERE page_id= %d ",$status,$id);
            $result = $this->db->query($sql);

            return $result;
        }else{
            return false;
        }
    }

    public function updatepostcategory($id=false,$category=false)
    {
        # code...
         if($id && $category){
                # code...
            if (is_array($category)) {
                $del = sprintf("DELETE FROM page_category WHERE page_id = %d",$id);
                $del_result = $this->db->query($del);

                foreach ($category as $key) {
                    # code...
                $cat_id = $this->categoryid_by_name($key);

                if($cat_id > 0){
                $result = $this->db->insert('page_category', array('page_id' =>$id ,'category_id'=>$cat_id ));

               }

                }


            }
            return true;
            
        }else{
            return false;
        }
    }
    
    public function get_post_by_user($id=0,$start=false,$limit=false)
    {
        # code...

        if ($id > 0 && $limit != false) {
            # code...

        $sql = sprintf("SELECT p.page_id,p.slug,p.title,p.status,p.date_created,pb.posted_by,u.username,i.url as imgs FROM pages p LEFT JOIN col_post_by_user pb on pb.post_id = p.page_id  LEFT JOIN col_images i on i.page_id = p.page_id LEFT JOIN aauth_users u on u.id = pb.posted_by WHERE posted_by = %d AND p.status < 3 ORDER BY p.page_id desc LIMIT %d,%d ",$id,$start,$limit);
        $query = $this->db->query($sql);
        return $query->result();
        }elseif ($id > 0) {
            # code...

        $sql = "SELECT p.page_id,p.slug,p.title,p.status,p.date_created,pb.posted_by,u.username,i.url as imgs FROM pages p LEFT JOIN col_post_by_user pb on pb.post_id = p.page_id  LEFT JOIN col_images i on i.page_id = p.page_id LEFT JOIN aauth_users u on u.id = pb.posted_by WHERE posted_by = ? AND p.status < 3 ORDER BY p.page_id desc ";
        $query = $this->db->query($sql,$id);
        return $query->result();
        }else{
            return false;
        }

    }



}
