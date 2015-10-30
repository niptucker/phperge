<?php

namespace PHPerge;

/**
 * Wrapper class for request sending to the Verge Server
 */
class Document implements IDocument {

    /**
     * Priority constants
     */
    const PRIORITY_LOW = "low";
    const PRIORITY_NORMAL = "normal";
    const PRIORITY_HIGH = "high";

    /**
     * Id of template in the Verge Server
     * @var string
     */
    protected $templateId;

    /**
     * Template description
     * @var string
     */
    protected $templateDescription;

    /**
     * Priority of render operation
     * Default: self::PRIORITY_NORMAL (normal priority)
     * @var string
     */
    protected $priority = self::PRIORITY_NORMAL;

    protected $isAsync = false;

    protected $callbackUrl;

    protected $renderSessionId;

    protected $isRendered;

    protected $renderStatus;
    protected $renderStatusCode;
    protected $renderStatusMessage;
    protected $renderPercent;

    /**
     * Array of fields sent to the Verge Server as JSON
     * @var array
     */
    protected $fields = array();

    /**
     * Array of field descriptions
     * @var array
     */
    protected $fieldDescriptions = array();

    /**
     * Connection options
     * array(
     *   "url" => "http://verge.server/verge/app/url",
     *   "redis" => "tcp://redis.server",
     * )
     * @var array
     */
    protected $connectionOptions = array();

    public static function createFromRenderSessionId($renderSessionId, $connectionOptions) {
        $doc = new static(null, $connectionOptions);
        $doc->setRenderSessionId($renderSessionId);

        return $doc;
    }


    public function saveRender($filename) {
        file_put_contents($filename, $this->getRenderContent());
    }

    public function isRendered() {
        return $this->isRendered;
    }

    protected function setRendered($isRendered) {
        $this->isRendered = $isRendered;

        return $this;
    }

    public function getRenderStatus() {
        return $this->renderStatus;
    }

    protected function setRenderStatus($renderStatus) {
        $this->renderStatus = $renderStatus;

        return $this;
    }

    public function getRenderStatusCode() {
        return $this->renderStatusCode;
    }

    protected function setRenderStatusCode($renderStatusCode) {
        $this->renderStatusCode = $renderStatusCode;

        return $this;
    }

    public function getRenderStatusMessage() {
        return $this->renderStatusMessage;
    }

    protected function setRenderStatusMessage($renderStatusMessage) {
        $this->renderStatusMessage = $renderStatusMessage;

        return $this;
    }

    public function getRenderPercent() {
        return $this->renderPercent;
    }

    protected function setRenderPercent($renderPercent) {
        $this->renderPercent = $renderPercent;

        return $this;
    }

    protected function parseRenderStatus() {
        $status = $this->getRenderStatus();

        $matches = array();
        preg_match('/\d+(\.\d+)?(?=%)/', $status, $matches);

        $this->setRenderStatusCode(substr($status, 0, 3));
        $this->setRenderStatusMessage(substr($status, 4) ?: "Ожидание ответа от сервера печати");
        $this->setRenderPercent(isset($matches[0]) ? $matches[0] : null);
    }

    protected function getRedisClient() {

        $parameters = [$this->connectionOptions["redis"]];
        $options = ['cluster' => 'redis'];
        $redis = new \Predis\Client($parameters, $options);

        return $redis;
    }
    public function checkRender() {

        $redis = $this->getRedisClient();

        $this->setRendered($redis->exists($this->getRenderSessionId()));
        $this->setRenderStatus($redis->get("ST:" . $this->getRenderSessionId()));
        $this->parseRenderStatus();

        return $this->isRendered();
    }

    public function getRenderContent() {

        $redis = $this->getRedisClient();

        return base64_decode($redis->get($this->getRenderSessionId()));
    }

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

    public function setAsync($isAsync) {
        $this->isAsync = $isAsync;
        return $this;
    }
    public function isAsync() {
        return $this->isAsync;
    }

    public function setCallbackUrl($callbackUrl) {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }
    public function getCallbackUrl() {
        return $this->callbackUrl;
    }

    public function setConnectionOptions($connectionOptions) {
        $this->connectionOptions = $connectionOptions;
        return $this;
    }
    public function getConnectionOptions() {
        return $this->connectionOptions;
    }

    public function getFields() {
        return $this->fields;
    }

    public function unsetFields() {
        $this->fields = array();
        return $this;
    }

    public function setField($fieldName, $fieldValue) {
        $fieldName = strtoupper($fieldName);
        $this->fields[$fieldName] = $fieldValue;
        return $this;
    }

    public function getField($fieldName) {
        $fieldName = strtoupper($fieldName);
        if (isset($this->fields[$fieldName])) {
            return $this->fields[$fieldName];
        }
        return null;
    }

    public function setFragmentPresence($fragmentName, $isPresented) {
        $fragmentName = strtoupper($fragmentName);
        $this->fields["#" . $fragmentName] = (int)$isPresented;
        return $this;
    }

    public function getFragmentPresence($fragmentName) {
        $fragmentName = strtoupper($fragmentName);
        if (isset($this->fields["#" . $fragmentName])) {
            return $this->fields["#" . $fragmentName];
        }
        return null;
    }

    public function setEnum($fieldName, $fieldValue) {
        $fieldName = strtoupper($fieldName);
        $this->fields[$fieldName] = $fieldValue;
        return $this;
    }

    public function getEnum($fieldName) {
        $fieldName = strtoupper($fieldName);
        if (isset($this->fields[$fieldName])) {
            return $this->fields[$fieldName];
        }
        return null;
    }

    public function setImage($imageName, $imageContent) {
        $imageName = strtoupper($imageName);
        $this->fields["@" . $imageName] = $imageContent;
        return $this;
    }

    public function getImage($imageName) {
        $imageName = strtoupper($imageName);
        if (isset($this->fields["@" . $imageName])) {
            return $this->fields["@" . $imageName];
        }
        return null;
    }

    public function setTable($tableName, $tableContent) {
        $tableName = strtoupper($tableName);
        $this->fields["table-" . $tableName] = $tableContent;
        return $this;
    }

    public function getTable($tableName) {
        $tableName = strtoupper($tableName);
        if (isset($this->fields["table-" . $tableName])) {
            return $this->fields["table-" . $tableName];
        }
        return null;
    }



    public function setFieldDescription($fieldName, $fieldDescription) {
        $fieldName = strtoupper($fieldName);
        $this->fieldDescriptions[$fieldName] = $fieldDescription;
        return $this;
    }

    public function getFieldDescription($fieldName) {
        $fieldName = strtoupper($fieldName);
        if (isset($this->fieldDescriptions[$fieldName])) {
            return $this->fieldDescriptions[$fieldName];
        }
        return null;
    }

    public function setEnumDescription($fieldName, $fieldDescription) {
        $fieldName = strtoupper($fieldName);
        $this->fieldDescriptions[$fieldName] = $fieldDescription;
        return $this;
    }

    public function getEnumDescription($fieldName) {
        $fieldName = strtoupper($fieldName);
        if (isset($this->fieldDescriptions[$fieldName])) {
            return $this->fieldDescriptions[$fieldName];
        }
        return null;
    }

    public function setImageDescription($imageName, $imageDescription) {
        $imageName = strtoupper($imageName);
        $this->fieldDescriptions["@" . $imageName] = $imageDescription;
        return $this;
    }

    public function getImageDescription($imageName) {
        $imageName = strtoupper($imageName);
        if (isset($this->fieldDescriptions["@" . $imageName])) {
            return $this->fieldDescriptions["@" . $imageName];
        }
        return null;
    }

    public function setTableDescription($tableName, $tableDescription) {
        $tableName = strtoupper($tableName);
        $this->fieldDescriptions["table-" . $tableName] = $tableDescription;
        return $this;
    }

    public function getTableDescription($tableName) {
        $tableName = strtoupper($tableName);
        if (isset($this->fieldDescriptions["table-" . $tableName])) {
            return $this->fieldDescriptions["table-" . $tableName];
        }
        return null;
    }

    public function setFragmentDescription($fragmentName, $fragmentDescription) {
        $fragmentName = strtoupper($fragmentName);
        $this->fieldDescriptions["#" . $fragmentName] = $fragmentDescription;
        return $this;
    }

    public function getFragmentDescription($fragmentName) {
        $fragmentName = strtoupper($fragmentName);
        if (isset($this->fieldDescriptions["#" . $fragmentName])) {
            return $this->fieldDescriptions["#" . $fragmentName];
        }
        return null;
    }


    protected function getPostData() {
        $post = array();
        $post["templateID"] = $this->templateId;
        $post["priority"] = $this->priority;
        $post["data"] = json_encode($this->fields);

        if ($this->isAsync()) {
            $post["url"] = $this->getCallbackUrl();
        }
        return http_build_query($post);
    }

    /**
     * @todo Use HttpRequest or helper class
     */
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


    public function asyncRender() {
        $postData = $this->getPostData();

        $result = self::performRequest($this->connectionOptions["url"], $postData);

        $this->setRenderSessionId(trim($result));

        return $this->getRenderSessionId();
    }

    public function getRenderSessionId() {
        return $this->renderSessionId;
    }

    public function setRenderSessionId($renderSessionId) {
        $this->renderSessionId = $renderSessionId;

        return $this;
    }

    /**
     * Gets the template description.
     *
     * @return string
     */
    public function getTemplateDescription() {
        return $this->templateDescription;
    }

    /**
     * Sets the template description.
     *
     * @param string $templateDescription description of template
     *
     * @return self
     */
    public function setTemplateDescription($templateDescription) {
        $this->templateDescription = $templateDescription;

        return $this;
    }
}
