<?php
/**
 *  LAIKA FRAMEWORK Release Notes:
 *
 *  @filesource     Event_Handler.php
 *
 *  @version        0.1.0b
 *  @date           2012-05-18 21:51:53 -0400 (Fri, 18 May 2012)
 *
 *  @author         Leonard M. Witzel <witzel@post.harvard.edu>
 *  @copyright      Copyright (c) 2012  Laikasoft <{@link http://oafbot.com}>
 *
 */
/**
 *  Laika_Event_Handler class.
 *  
 *  The framework event handler class.
 *
 *  @package        Laika
 *  @subpackage     core
 *  @category       
 * 
 *  @extends        Laika_Singleton
 *  @implements     SplSubject
 */
class Laika_Event_Handler extends Laika_Singleton implements SplSubject{

//-------------------------------------------------------------------
//  PROPERTIES
//-------------------------------------------------------------------
    protected static $instance; 
    /**
    * Array of SplObserver objects
    *
    * @var array
    */
    private $observers = array();
    protected $event;
    protected $param;

//-------------------------------------------------------------------
//  METHODS
//-------------------------------------------------------------------
    
    /**
    * Attaches an SplObserver object to the handler
    *
    * @param SplObserver
    * @return void
    */
    public function attach(SplObserver $observer){
        $id = spl_object_hash($observer);
        $this->observers[$id] = $observer;
    }
    /**
    * Detaches the SplObserver object from the handler
    *
    * @param SplObserver
    * @return void
    */
    public function detach(SplObserver $observer){
        $id = spl_object_hash($observer);
        unset($this->observers[$id]);
    }

    /**
    * Notify all observers
    *
    * @return void
    */
    public function notify(){
        foreach($this->observers as $observer){
            $observer->update($this);
        }
    }

    /**
    * The Event Handler calls notify() and broadcasts
    * state to all the listners.
    *
    * @return void
    */
    public function handle($event,$param){
        $this->event = $event;
        $this->param = $param;
        $this->notify();
    }
}