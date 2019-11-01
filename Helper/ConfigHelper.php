<?php
namespace Kanboard\Plugin\Kanext\Helper;

use Kanboard\Core\Base;

// TODO: add default values here
class ConfigHelper extends Base
{
    /**
     * Get a value for a configuration variable
     * @param  string $name Name of the variables
     * @return mixed        Content of the variable
     */
    public function get($name=null)
    {
        return $this->configModel->get($name);
    }
}
