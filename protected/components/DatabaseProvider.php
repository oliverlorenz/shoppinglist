<?php

class DatabaseProvider
{
    static protected $_instance = null;
    protected $_databaseName = null;
    protected $_data = array();

    static public function getInstance($databaseName)
    {
        if(is_null(self::$_instance)) {
            self::$_instance = array();
        }

        if (!isset(self::$_instance[$databaseName])
        || null === self::$_instance[$databaseName]) {
            self::$_instance[$databaseName] = new self($databaseName);
        }
        return self::$_instance[$databaseName];
    }

    private function __construct($databaseName) {
        $this->_databaseName = $databaseName;
        $this->_getDatabase();
    }

    public function __destruct() {
        $this->_saveDatabase();
    }

    private function __clone() {}

    public function addEntry($id, $data = null) 
    {
        if(!is_null($id)
        && is_null($data)
        ) {
            $this->_data[] = $id;
        } else if (!is_null($id)
        && !is_null($data)
        ) {
            $this->_data[$id] = $data;
        }
        //$this->_data = array_unique($this->_data);
    }

    public function deleteEntry($id)
    {
        unset($this->_data[$id]);
    }

    public function updateEntry($id, $data)
    {
        $this->_data[$id] = $data;
    }

    public function keyExists($id) 
    {
        $db = $this->_getDatabase();
        foreach($this->_data as $key => $data) {
            if($key === $id) {
                return true;
            }
        }
        return false;
    }

    public function readEntry($id) 
    {
        $db = $this->_getDatabase();
        if(!isset($db[$id])) {
            throw new CException('no entry with id found');
            
        }
        return $db[$id];
    }

    public function readAll() {
        return $this->_getDatabase();
    }

    protected function _getDatabase()
    {
        if(is_null($this->_data)) {
            if(!file_exists($this->_getDatabaseFilePath())) {
                if($this->_createDatabaseFile()) {
                    throw new CException('database file could not be created');
                }
            }
        }
        $content = $this->_getDatabaseFileContent();
        $this->_data = json_decode($content, true);
        return $this->_data;
    }

    protected function _getDatabaseFileContent()
    {
        return file_get_contents($this->_getDatabaseFilePath());
    }

    protected function _getDatabaseFilePath()
    {
        $path = Yii::app()->getRuntimePath() 
              . DIRECTORY_SEPARATOR 
              . $this->_databaseName
              . '.json'
              ;
        return $path;
    }

    protected function _createDatabaseFile()
    {
        $path = $this->_getDatabaseFilePath();
        touch($path);
        return file_exists($path);
    }

    protected function _saveDatabase()
    {
        $path = $this->_getDatabaseFilePath();
        $content = json_encode($this->_data);
        file_put_contents($path, $content);
    }


}