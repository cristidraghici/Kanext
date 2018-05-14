<?php
namespace Kanboard\Plugin\Kanext\Helper;

use Kanboard\Core\Base;

class ConfigHelper extends Base
{
    /**
     * Store the configuration variables
     * @var array
     */
    private $config = array();

    /**
     * Load the configuration
     * @return array List of configuration options
     */
    public function init()
    {
        if (file_exists('plugins/Kanext/config.php')) {
            return $this->config = require_once('plugins/Kanext/config.php');
        }

        $this->config = require_once('plugins/Kanext/config.default.php');
    }

    /**
     * Get a value for a configuration variable
     * @param  string $name Name of the variables
     * @return mixed        Content of the variable
     */
    public function get($name=null)
    {
        if (count($this->config) === 0) {
            $this->init();
        }

        if ($name) {
            if (isset($this->config[$name])) {
                return strlen($this->config[$name]) > 0 ? $this->config[$name] : null;
            }

            return null;
        }

        return $this->config;
    }
}
