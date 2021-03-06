<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Home_Controller.php
 *
 *	@version        0.1.0b
 *	@package        Sparticle
 *	@subpackage     control
 *	@category       control
 *	@date           2011-05-21 03:37:00 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laikasoft <{@link http://oafbot.com}>
 *
 */
/**
 * Sparticle_Home_Controller class.
 * 
 * @extends Laika_Abstract_Page_Controller
 */
class Sparticle_Home_Controller extends Laika_Abstract_Page_Controller{

    protected static $instance;
    protected        $parameters;
    public    static $access_level = 'PUBLIC';
    public    static $caching      = TRUE;
    
    /**
     * default_action function.
     * 
     * @access public
     * @return void
     */
    public function default_action(){ $this->display(array("page"=>"sparticle")); }


    /**
     * reload_image function.
     * 
     * @access public
     * @return void
     */
    public function reload_image(){
        $result = Laika_Database::query("SELECT * FROM medias WHERE privacy = true ORDER BY RAND() LIMIT 1","SINGLE");
        $path   = $result['path'];
        $media  = Sparticle_Media::find('path',$path);
        $id     = $media->id;
                
        $name = $media->name;
        $user = Laika_User::find('id',$media->user)->username;

        $image  = Laika_Image::api_path( $path , 'auto', 500 );
        $reflection = Laika_Image::api_path( $path, 'reflection', 500 );        
        
        //$permalink = HTTP_ROOT."/content/$user?media=".$media->get_filename();        
        $permalink = HTTP_ROOT."/content?id={$media->id}";
        
        if(Laika_Access::is_logged_in())
            $check = Sparticle_Favorite::is_favorite( Laika_User::active()->id, $media->id, $media->type);
        else 
            $check = false;
        ( $check )? $fav = "N" : $fav = "O";
        
        if(empty($name))
            $name = "Untitled";
        
        $json = array("title"=>$name, 
                      "user"=>$user, 
                      "image"=>$image, 
                      "reflection"=>$reflection, 
                      "favorite"=>$fav, 
                      "id"=>$id,
                      "path"=>Laika_Image::api_path( $path, 'constrain', '800x600' ),
                      "permalink"=>$permalink
                      ); 
        
        echo json_encode($json);
    }
    
    /**
     * favorite function.
     * 
     * @access public
     * @return void
     */
    public function favorite(){
        $id = $this->parameters['id'];
        Sparticle_Favorite::mark($id);
    }
    
    /**
     * unfavorite function.
     * 
     * @access public
     * @return void
     */
    public function unfavorite(){        
        $id = $this->parameters['id'];        
        Sparticle_Favorite::undo(Sparticle_Favorite::find('item',$id));
    }
    
    public function load_next(){
        $page  = $_SESSION['pagination']+1;
        $total = Sparticle_Media::total_pages(5,array(0));
        if($total >= $page):            
            echo '<table id="set-'.$page.'" class="next_set" ><tr>';
            Sparticle_Home_Page::init()->next_set(5);
            echo '</tr></table>';
        elseif($total < $page):
            $_SESSION['pagination'] = $total;
        endif;
    }
    
    public function page_set(){
        $page  = $this->parameters['page'];
        $total = Sparticle_Media::total_pages(5,array(0));
        
        if($total < $page)            
            $_SESSION['pagination'] = $total;
        elseif($page < 1)
            $_SESSION['pagination'] = 1;
        else
            $_SESSION['pagination'] = $page;
    }    
}