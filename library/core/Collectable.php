<?php
/**
 *  LAIKA FRAMEWORK Release Notes:
 *
 *  @filesource     Collectable.php
 *
 *  @version        0.1.0b
 *  @date           2012-05-18 21:53:52 -0400 (Fri, 18 May 2012)
 *
 *  @author         Leonard M. Witzel <witzel@post.harvard.edu>
 *  @copyright      Copyright (c) 2012  Laikasoft <{@link http://oafbot.com}>
 *
 */
/**
 *  Laika_Collectable class.
 * 
 *  Normalized Object abstraction class for object collections.
 *
 *  @package        Laika
 *  @subpackage     core
 *  @category       
 *
 *  @extends        Laika
 */
class Laika_Collectable extends Laika{

    /**
     * __construct function.
     * 
     * @access public
     * @param mixed $name
     * @param mixed $array
     * @return void
     */
    public function __construct($object){
        if(is_subclass_of($object,'Laika_Singleton')):
            $array = $object->to_array();
        elseif(is_subclass_of($object,'Laika')):
            //$array = $object::reflect()->getProperties();
            $array = $object->to_array();
        else:
            $ref = new ReflectionClass($object);
            $array = $ref->getProperties();
        endif;        
        $name = get_class($object);

        return $this->freeze($name,$array);
    }

    /**
     * get_var function.
     * 
     * @access public
     * @param mixed $key
     * @return void
     */
    public function get_property($key){
        $object = $this->revive();
        if(is_subclass_of($object,'Laika'))
            return $object->$key;
        else throw new Laika_Exception('INVALID_DATA_TYPE',800);
    }
    
    /**
     * freeze function.
     * 
     * @access public
     * @param mixed $name
     * @param mixed $array
     * @return void
     */
    public function freeze($name,$array){
        $this->object_type = $name;
        
        foreach($array as $k => $value){

/* @todo the following conditional was commented out when php was upgraded. needs to be fixed. 
/*
            if(is_a($value,'ReflectionProperty')):
                $value->setAccessible(true);
                $key = $value->getName();
                $this->$key = $value->getValue($value);
            else:
*/
                $this->$k = $value;
            //endif;
        }
        return $this;    
    }
    
    /**
     * revive function.
     * 
     * @access public
     * @return void
     */
    public function revive(){
        $class = $this->object_type;
        is_subclass_of($class,'Laika_Singleton') ? $object = $class::init() : $object = new $class();
        $vars = get_object_vars($this);
        foreach($vars as $key => $value) 
            if($key!='object_type')
                $object->$key($value);
        return $object;
    }
}