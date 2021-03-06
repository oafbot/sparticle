<?php
/**
 *  LAIKA FRAMEWORK Release Notes:
 *
 *  @filesource     Exception_Handler.php
 *
 *  @version        0.1.0b 
 *  @date           2011-05-22 08:49:46 -0400 (Sun, 22 May 2011)
 *
 *  @author         Leonard M. Witzel <witzel@post.harvard.edu>
 *  @copyright      Copyright (c) 2011  Laikasoft <{@link http://oafbot.com}>
 *
 */
/**
 *  Laika_Exception_Handler class.
 * 
 *  Intercepts uncaught exceptions.
 *  Notifies Observers of intercepted exceptions.
 *  
 *  @package        Laika
 *  @subpackage     core
 *  @category      
 * 
 *  @extends        Laika_Singleton
 *  @implements     SplSubject
 */
class Laika_Exception_Handler extends Laika_Singleton implements SplSubject{

//-------------------------------------------------------------------
//  VARIABLES
//-------------------------------------------------------------------
    /**
    * instance of Laika_Exception_Handler
    * 
    * @var    object
    * @access protected
    * @static
    */
    protected static $instance;
    /**
    * Array of SplObserver objects
    *
    * @var array
    */
    private $observers = array();

    /**
    * Uncaught exception
    *
    * @var Exception
    */
    public $exception;


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
    * The Exception Handler calls notify() and outputs
    * a notice onscreen if DEVELOPMENT_ENVIRONMENT is set
    *
    * @return void
    */
    public function handle(Exception $e){
        $this->exception = $e;
        $this->notify();
        if(DEVELOPMENT_ENVIRONMENT == true):
            if(is_a($e,'ErrorException'))
                $trace = 
                    '<div id="php_error"><strong><span style="color:#faa51a;">PHP Interpreter ERROR ['.
                    $e->getCode().']:</span>  '.
                    $e->getMessage().' at Line( '.
                    $e->getLine().' ) in File: '.
                    str_replace(LAIKA_ROOT, "",$e->getFile()).'</strong><br /><br /><p><pre>'.
                    str_replace(LAIKA_ROOT, "",$e->getTraceAsString()).'</pre></p></div>';
            else
                $trace =
                    '<div id="php_error"><strong><span style="color:#faa51a;">LAIKA ERROR ['.
                    $e->getCode().']:</span> '.
                    $e->getMessage().' at Line( '.
                    $e->getLine().' ) in File: '.
                    str_replace(LAIKA_ROOT, "",$e->getFile()).'</strong><br /><br /><p><pre>'.
                    str_replace(LAIKA_ROOT, "",$e->getTraceAsString()).'</pre></p></div>';
            $this->display($trace,$e->getFile(),$e->getLine());
        else:
            $message = '<div id="php_error">
                        <strong><span style="color:#faa51a;">APPLICATION ERROR</span></strong>
                        </div>';
            $this->display($message,NULL,NULL); 
        endif;        
    }
    
    /**
     * display function.
     * 
     * @access public
     * @param mixed $trace
     * @param mixed $file
     * @param mixed $line
     * @return void
     */
    public function display($trace,$file,$line){
        $exception_css = HTTP_ROOT.'/stylesheets/exception.css';
        $reset_css     = HTTP_ROOT.'/stylesheets/reset.css';
        $common_css    = HTTP_ROOT.'/stylesheets/common.css';
        
        isset($file) ? $source = highlight_file($file, true) : $source = "";
        $lines = implode(range(1, count(file($file))), '<br />');
        
        $file = str_replace(LAIKA_ROOT, "", $file);
        $link = Laika_Router::init()->uri;       
        $page = "<!DOCTYPE html>
                <html lang=en>
                <head>
                <meta charset=utf-8>
                <title>FRAMEWORK EXCEPTION</title>
                <link rel=\"shortcut icon\" href=/favicon.ico type=image/x-icon />
                <link rel=stylesheet href=$reset_css type=text/css>
                <link rel=stylesheet href=$exception_css type=text/css>
                <link rel=stylesheet href=$common_css type=text/css>
                </head>
                <body>
                <div id=main>
				<a href=$link class=refresh> <span class=webfont >&#74;</span> Refresh</a>
                $trace
                <div id=source>
                <h2>Full Source:</h2>
                <h3>$file</h3>
                <br />
                <table><tr><td class=num>\n$lines\n</td><td>\n$source\n</td></tr></table>
                </div>
                </div>
                </body>
                </html>";

       $_SESSION['ERROR_MSG'] = $page;
       self::redirect_to('/error/exceptions');
         
       //echo $page;
    }
}
