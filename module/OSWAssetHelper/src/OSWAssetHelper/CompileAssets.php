<?php
/**
 * Created by IntelliJ IDEA.
 * User: openworkers
 * Date: 12.10.13
 * Time: 10:31
 * To change this template use File | Settings | File Templates.
 */

namespace OSWAssetHelper;


use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;

class CompileAssets extends AbstractHelper
{

    /**
     * Service Locator
     * @var ServiceManager
     */
    protected $serviceLocator;

    /**
     * __invoke
     *
     * @access public
     * @param string $path
     * @param string $compiled
     * @param string $prefix
     *
     * @return String
     */
    public function __invoke($path = "/js/", $compiled = "/application.js", $prefix = "/public/")
    {
        if (!file_exists(getcwd() . $compiled)) {

            $Directory = new RecursiveDirectoryIterator(getcwd() . $prefix . $path);
            $Iterator = new RecursiveIteratorIterator($Directory);
            $Regex = new RegexIterator($Iterator, '/^.+\.js$/i', RecursiveRegexIterator::GET_MATCH);
            $files = array();
            foreach ($Regex as $file) {
                $start = strpos($file[0], $path);
                $files[] = $this->view->basePath() . substr($file[0], $start);
            }

            sort($files);

            foreach ($files as $file) {
                $this->view->headScript()->appendFile($file);
            }
        } else {
            $this->view->headScript()->appendFile($this->view->basePath() . $compiled);
        }
        return "";
    }
}
