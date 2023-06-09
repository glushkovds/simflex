<?php

namespace Simflex\Core;

use Simflex\Core\ComponentBase;
use Simflex\Core\Core;

/**
 * Use ControllerBase for your component-class instead of ComponentBase to automatic routing URI paths to class methods
 * @example http://site.ru/myext/myact/ will call "myact" method from "myext" class
 * @example http://site.ru/myext/ will call "index" method from "myext" class
 *
 */
class ControllerBase extends ComponentBase
{
    protected $s; // private session for class
    protected $d; // private data for class
    protected $action = '';

    public function __construct()
    {
        parent::__construct();
        $this->s = &$_SESSION[get_class($this)]['session'];
        if (!isset($this->d)) {
            $this->d = array();
        }
    }

    public function index()
    {
    }

    protected function content()
    {
        $mname = $this->getMethodName();
        if (!method_exists($this, $mname)) {
            Core::error404();
        }
        $this->$mname(...array_slice(Core::uri(), 2));
    }

    /**
     * Find appropriate method by path
     * @return string
     */
    protected function getMethodName(): string
    {
        if ($this->action) {
            return $this->action;
        }

        // by default
        $name = $default = "index";
        $uri = Core::uri();

        if (isset($uri[1]) && (int)$uri[1]) {
            // if /article/1/
            $name = 'item';
        } elseif (isset($uri[1]) && $uri[1]) {
            // read URI
            $name = $uri[1];
        }

        return $name;
    }

    /**
     * @return string
     * @deprecated use getMethodName()
     */
    protected function mname(): string
    {
        return $this->getMethodName();
    }
}
