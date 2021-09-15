<?php



namespace SL;

use FastRoute\DummyRouteCollector;

class SassLoader
{



    /**
     * $scanDir
     * All the files to add to the drop point with a '@import' rule
     */
    private $scanDir = [];
    


    /**
     * populate_scandir()
     * Will walk through the $dir directory
     * Populate the scanDir array from .
     */
    private function populate_scandir($dir)
    {
        $dir = realpath($dir);
        $scanDir = scandir($dir);

        foreach($scanDir as $sd)
        {
            if($sd === '.' || $sd === '..' || $sd === $this->dropPoint)
            {
                continue;
            }

            $sd = realpath("$dir/$sd");

            if(is_dir($sd))
            {
                $this->populate_scandir($sd);
            }
            else
            {
                $sdExt = '.' . pathinfo($sd,PATHINFO_EXTENSION);
                $sd = str_replace(realpath($this->fromDir) . DIRECTORY_SEPARATOR,'',$sd);
                $sd = str_replace($sdExt,'',$sd);
                $sd = explode(DIRECTORY_SEPARATOR,$sd);
                $sd[count($sd) - 1] = substr($sd[count($sd) - 1],1);
                $sd = implode('/',$sd);
                $this->scanDir[] = "@import '$sd'";
            }
        }
    }



    private function generate_drop_point()
    {
        $scanDir = $this->scanDir;
        $content = implode("\n",$scanDir);
        file_put_contents(realpath($this->fromDir) . '/' . $this->dropPoint,$content);
    }



    public function __construct($fromDir)
    {
        $this->fromDir = "$fromDir";
    }



    public function set_drop_point($dropPointName)
    {
        $this->dropPoint = $dropPointName;
        return $this;
    }



    public function load()
    {
        $this->populate_scandir($this->fromDir);
        $this->generate_drop_point();
    }



}