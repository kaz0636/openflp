<?php
/**
 * Test Suite Console.
 * 
 * $Id: testsuite.php 11 2007-06-24 06:05:54Z geoff $
 *
 * @filesource
 * @package	vendors
 * @subpackage	shells
 * 
 * @version			$Revision: 11 $
 * @modifiedby		$LastChangedBy: geoff $
 * @lastmodified	$Date: 2007-06-24 16:05:54 +1000 (Sun, 24 Jun 2007) $
 */
set_time_limit(600);
ini_set('memory_limit','128M');
require_once CAKE . 'dispatcher.php';
require_once CAKE . 'basics.php';
require_once CAKE . 'tests' . DS . 'lib' . DS . 'test_manager.php';

/**
 * Test Suite Shell 
 * 
 * This Shell allows the running of test suites via the cake command line 
 * 
 * @author	Geoff Ford <geoff.ford@gmail.com>
 * @package	vendors
 * @subpackage	shells
 */
class TestSuiteShell extends Shell {
	/**
	 * CliTestManger
	 * @access private;
	 */
	var $manager;
	/**
	 * Test Parametrs
	 * @access private
	 */
	var $testToRun;
	/**
	 * List of plugins with test cases
	 * @access private
	 */
	var $plugins;
	
	/**
	 * Set up a few variables etc
	 */
    function initialize() {

        // added
        define('TEST_CAKE_CORE_INCLUDE_PATH', CAKE_CORE_INCLUDE_PATH);

        $this->manager = new CliTestManager();
        vendor('simpletest'.DS.'reporter');
        $this->testToRun = array();
        $this->plugins = $this->_findPlugins();        
    }
    /**
     * Prints the header infomation to the console
     */
    function header(){
        $this->out('Test Suite Cli Manager');
        $this->out('V 0.1');
        $this->out('Author: Geoff Ford <geoff.ford@gmail.com>');
        $this->hr();
    }
	/**
	 * Main Shell function
	 */
    function main() {
		$this->header();
        if (count($this->args) === 0) {
        	$this->_interactive();
        } else {
        	$this->_parseArgs();
        }
        if($this->_validTest()){
        	$this->out('Running ' . implode(' ', $this->testToRun));
        	$this->_runTest();
        } else {
        	$this->err('Coud not find the tests you were looking for.');
        }
    }
	/**
	 * Help output
	 */
    function help() {
    	$this->header();
        $this->out('Usage: ');
        
        $this->out("\tcake testsuite help");
        $this->out("\t\tthis message");
        
        $this->out("\tcake testsuite run section test_type [case_type] test");
        $this->out("\t\t - section - app, core or plugin_name");
        $this->out("\t\t - test_type - case, group or all");
        $this->out("\t\t - case_type - only with case, one of behaviors, components, controllers, helpers or models");
        $this->out("\t\t - test - file without (test|group).php");
        
    }
    /**
     * Checks the command line arguments and adds them to $testToRun array
     */
    function _parseArgs(){
    	// app, core or plugin
    	$this->testToRun['section'] = $this->args[0];
    	
    	// case, group or all
    	if (isset($this->args[1])){
    		$this->testToRun['area'] = $this->args[1];
    	}
    	
    	// case, group or all
    	if ($this->testToRun['area'] == 'case'){
    		if (isset($this->args[2])){
    			// mvc
	    		$this->testToRun['type'] = $this->args[2];
	    		if (isset($this->args[3])){
		    		$this->testToRun['file'] = $this->args[3];
		    	}
    		} else {
    			$this->testToRun['file'] = $this->args[2];
    		}
    	}
    	
    }
    /**
     * Checks to see if the test can be run.
     * 
     * Basically checks to see if the $testToRun array points to a valid file
     * 
     * @return bool
     */
    function _validTest(){
    	
    	if ($this->testToRun['section'] != 'app' &&
    		$this->testToRun['section'] != 'core' &&
    		!in_array($this->testToRun['section'], $this->plugins) &&
    		!in_array(Inflector::Humanize($this->testToRun['section']), $this->plugins)) {
    		
    		$this->err($this->testToRun['section'] . ' is an invalid test section');
    		return false;
    	}
    	
    	if ($this->testToRun['area'] != 'group' &&
    		$this->testToRun['area'] != 'case' &&
    		$this->testToRun['area'] != 'all'){
   			
    		$this->err($this->testToRun['type'] . ' is invalid. Should be case, group or all');
    		return false;
   		}
   		
   		$folder = '';
   		if ($this->testToRun['section'] == 'core'){
   			$folder = 'cake' . DS . 'tests';
   		} elseif ($this->testToRun['section'] == 'app'){
   			$folder = 'app' . DS . 'tests';
   		} else {
   			$folder = 'app'. DS . 'plugins' . DS . Inflector::underscore($this->testToRun['section']) . DS . 'tests';
   		}
   		
   		if (!file_exists($folder)){
   			$this->err($folder . ' not found');
   			return false;
   		}
    
    	if($this->testToRun['area'] == 'all'){
    		return true;
    	}
    	
    	$file = Inflector::underscore($this->testToRun['file']);
    	
    	if ($this->testToRun['area'] == 'group' && file_exists($folder . DS . 'groups' . DS .$file . '.group.php')){
   			return true;
    	}
    	if ($this->testToRun['area'] == 'case'){
    		if(file_exists($folder . DS . 'cases' . DS . low($this->testToRun['type']) . DS . $file . '.test.php')){
    			return true;
    		}
    	}
    	
    	$this->err(implode(' ', $this->testToRun) . ' is an invalid test identifier');
    	return false;
    	
    }
    /**
     * Executes the tests depending on $testToRun
     */
    function _runTest(){
    	// Need to set some get variables as TestManager depends on them
    	if (in_array($this->testToRun['section'], $this->plugins)){
    		$_GET['plugin'] = $this->testToRun['section'];
    	} elseif (in_array(Inflector::Humanize($this->testToRun['section']), $this->plugins)){
    		$_GET['plugin'] = Inflector::Humanize($this->testToRun['section']);
    	} elseif ($this->testToRun['section'] == 'app'){
    		$_GET['app'] = true;
    	} 
    	
    	if($this->testToRun['area'] == 'all'){
    		TestManager::runAllTests(new TextReporter());
    		return;
    	} elseif ($this->testToRun['area'] == 'group'){
    		$_GET['group'] == $this->testToRun['file'];
    		if (isset($_GET['app'])) {
				TestManager::runGroupTest(ucfirst($_GET['group']), APP_TEST_GROUPS, new TextReporter());
			} elseif (isset($_GET['plugin'])) {
				TestManager::runGroupTest(ucfirst($_GET['group']), APP.'plugins'.DS.$_GET['plugin'].DS.'tests'.DS.'groups', new TextReporter());
			} else {
				TestManager::runGroupTest(ucfirst($_GET['group']), CORE_TEST_GROUPS, new TextReporter());
			}
			return;
    	} else {
    		$_GET['case'] = 'cases' . DS . $this->testToRun['type'] . DS . $this->testToRun['file'] . '.test.php'; 
    		TestManager::runTestCase($_GET['case'], new TextReporter());
    		return;
    	}
    }
    /**
     * Executes the shell in interactive mode
     * 
     * @todo implement
     */
    function _interactive(){
    	$this->err('There is no interactive support at the moment.  See help for usage');
    	exit;
    }
    /**
     * Finds all plugins with test suites
     * 
     * @return array plugin_name => PluginName
     */
    function _findPlugins(){
    	if (!class_exists('Folder')){
    		uses('folder');
    	}
    	
    	$pluginDir = ROOT.DS.APP_DIR.DS.'plugins';
		$pluginFolder = new Folder($pluginDir);
		$contents = $pluginFolder->read();
		$plugins = array();
		foreach($contents[0] as $plugin){
			if (file_exists($pluginDir.DS.$plugin.DS.'tests')){
				$plugins[$plugin] = Inflector::humanize($plugin);
			}
		}
		return $plugins;
    }
}
?>
