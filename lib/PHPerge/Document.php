<?php

namespace PHPerge;

class Document implements IDocument {

    const PRIORITY_LOW = "low";
    const PRIORITY_NORMAL = "normal";
    const PRIORITY_HIGH = "high";


    protected $templateId;
    protected $priority = self::PRIORITY_NORMAL;
    protected $fields = array();

    protected $connectionOptions;

    public function __construct($templateId, $connectionOptions = array()) {

        $this->setTemplateId($templateId);
        $this->setConnectionOptions($connectionOptions);
    }

    public function setTemplateId($templateId) {
        $this->templateId = $templateId;
        return $this;
    }
    public function getTemplateId() {
        return $this->templateId;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
        return $this;
    }
    public function getPriority() {
        return $this->priority;
    }

    public function setConnectionOptions($connectionOptions) {
        $this->connectionOptions = $connectionOptions;
        return $this;
    }
    public function getConnectionOptions() {
        return $this->connectionOptions;
    }

    public function setField($fieldName, $fieldValue) {
        $this->fields[$fieldName] = $fieldValue;
        return $this;
    }

    public function getField($fieldName) {
        if (isset($this->fields[$fieldName])) {
            return $this->fields[$fieldName];
        }
        return null;
    }

    public function getFields() {
        return $this->fields;
    }

    public function setTable($tableName, $tableContent) {
        $this->setField("table-" . $tableName, $tableContent);
        return $this;
    }

    public function getTable($tableName) {
        return $this->getField("table-" . $tableName);
    }



    protected function getPostData() {
        $post = array();
        $post["templateID"] = $this->templateId;
        $post["priority"] = $this->priority;
        $post["data"] = json_encode($this->fields);

        return http_build_query($post);
    }

    /**
     * @todo Use HttpRequest or helper class
     * */
    protected static function performRequest($connectionURL, $postData) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $connectionURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function getPDFContent() {
        $postData = $this->getPostData();

        $result = self::performRequest($this->connectionOptions["url"], $postData);

        return $result;
    }

}