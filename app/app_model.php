<?php
App::import('vendor', 'spyc/spyc');

class AppModel extends Model
{
    public $serialize = null; // serialize fields

    public function __construct($id = false, $table = null, $ds = null)
    {
        if (is_null($ds) && Configure::read('Database.useDbConfig') === 'test') {
            $this->useDbConfig = 'test_suite';
        }
        parent::__construct($id, $table, $ds);
    }

    public function beforeSave()
    {
        $this->serializeFields();

        // for rails-style column name
        $now = date_create()->format('Y-m-d H:i:s');
        if (!$this->exists()) {
            $this->set('created_on', $now);
        }
        $this->set('updated_on', $now);

        return true;
    }

    public function afterFind($results)
    {
        $results = $this->unserializeFields($results);

        return $results;
    }

    public function serializeFields()
    {
        if (!isset($this->serialize) || !is_array($this->serialize)) return;
        foreach ($this->serialize as $field) {
            if (empty($this->data[$this->alias][$field])) continue;
            $this->set($field, Spyc::YAMLDump($this->data[$this->alias][$field]));
        }
    }

    public function unserializeFields($results)
    {
        if (!isset($this->serialize) || !is_array($this->serialize)) return $results;
        foreach ($this->serialize as $field) {
            foreach ($results as $k => $data) {
                if (empty($data[$this->alias][$field])) continue;
                $results[$k][$this->alias][$field] = Spyc::YAMLLoad($data[$this->alias][$field]);
            }
        }
        return $results;
    }
}
