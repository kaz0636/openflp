<?php
class AppHelper extends Helper
{

    public function __construct()
    {
        parent::__construct();
        $this->tags['error'] = '<li>%2$s</li>';
    }

    public function output($str)
    {
        echo $str;
    }

    public function hasError()
    {
        return !empty($this->validationErrors);
    }

    public function errorMsg($field, $rulename, $msg)
    {
        $this->setEntity($field);
        if ($rulename === $this->tagIsInvalid()) {
            $model = ClassRegistry::getObject($this->model());
            if (!empty($model->validate[$this->field()][$rulename]['rule'])) {
                // get rule parameters
                $params = $model->validate[$this->field()][$rulename]['rule'];
                array_shift($params);
                // format error msg
                $msg = vsprintf($msg, $params);
            }
            $this->output(sprintf($this->tags['error'], '', $msg));
        }
    }
}
