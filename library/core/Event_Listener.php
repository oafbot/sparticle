<?php
/**
 *	LAIKA FRAMEWORK Release Notes:
 *
 *	@filesource     Event_Listener.php
 *
 *	@version        0.1.0b
 *	@package        Laika
 *	@subpackage     core
 *	@category       
 *	@date           2011-05-21 03:15:10 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 *
 * Laika_Event_Listener class.
 */
class Laika_Event_Listener extends Laika_Singleton implements SPLObserver{
    
    protected static $instance;
    protected        $registry = array();
    
    public static function init($event,$class,$method){
        if( empty(self::$instance) )
            if( Laika_Registry::peek(__CLASS__) )
                self::$instance = Laika_Registry::get_record(__CLASS__);
            else
                parent::init();
        self::$instance->registry[$event] = array("CLASS"=>$class,"METHOD"=>$method);
        
        Laika_Registry::register(__CLASS__,self::$instance); 
        
        return self::$instance; 
    }
    
    public function update(SplSubject $subject){
        //var_dump($subject);
     
        $handler = $this->registry[$subject->event];
        $method  = $handler['METHOD'];
        $class   = $handler['CLASS'];
        
        if(is_subclass_of($class,'Laika_Singleton'))         
            call_user_func(array($class::init(),$method), $subject->event, $subject->param);
        else
            call_user_func(array($class, $method), $subject->event, $subject->param);     
    }

}