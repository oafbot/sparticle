<?php
/**
 *  LAIKA FRAMEWORK Release Notes:
 *
 *  @filesource     Interface_Exception.php
 *
 *  @version        0.1.0b
 *  @date           2011-05-22 08:52:15 -0400 (Sun, 22 May 2011)
 *
 *  @author         Leonard M. Witzel <witzel@post.harvard.edu>
 *  @copyright      Copyright (c) 2011  Laikasoft <{@link http://oafbot.com}>
 *
 */
/** 
 *  Laika_Interface_Exception interface.
 * 
 *  Interface for Exception classes
 *
 *  @package        Laika
 *  @subpackage     core
 *  @category       interface
 *
 *  @interface
 */
interface Laika_Interface_Exception{

//-------------------------------------------------------------------
//  CONSTRUCTOR
//-------------------------------------------------------------------
    /**
     * __construct function.
     * 
     * Overrideable constructor method inherited from Exception class
     *
     * @access public
     * @param mixed $message (default: null)
     * @param int $code (default: 0)
     * @return void
     */
    public function __construct($message = null, $code = 0);

//-------------------------------------------------------------------
//  METHODS
//-------------------------------------------------------------------
    /**
     * __toString function.
     *
     * Overrideable toString method inherited from Exception class
     * 
     * @access public
     * @return void
     */
    public function __toString();
    
    /* Protected methods inherited from Exception class */
    public function getMessage();                 // Exception message
    public function getCode();                    // User-defined Exception code
    public function getFile();                    // Source filename
    public function getLine();                    // Source line
    public function getTrace();                   // An array of the backtrace()
    public function getTraceAsString();           // Formated string of trace
    
}