<?php

namespace PHPerge;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\ClassLoader\UniversalClassLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\IndexedReader;
use ReflectionClass;
use Exception;

class PdfRenderer implements IRenderer {

    protected $templateClass;

    protected $connectionOptions;

    protected $document;

    protected $reflectionTemplateClass;
    protected $reflectionTemplateProperties;
    protected $annotationReader;

    public function __construct($templateClass, $connectionOptions = array()) {

        $this->setTemplateClass($templateClass);
        $this->setConnectionOptions($connectionOptions);

        $this->mapTemplateToDocument();



        // $this->setTemplateId($templateId);
    }

    protected static function getAnnotationReader() {
        AnnotationRegistry::registerAutoloadNamespace("PHPerge\\Annotations\\", __DIR__);
        return new IndexedReader(new AnnotationReader());
    }

    protected function mapTemplateToDocument() {
        $this->annotationReader = self::getAnnotationReader();

        $this->reflectionTemplateClass = new ReflectionClass(get_class($this->templateClass));
        $this->reflectionTemplateProperties = $this->reflectionTemplateClass->getProperties();

        $this->readClassAnnotations();
        $this->readPropertiesAnnotations();
    }

    protected function readClassAnnotations() {
        $templateClassAnnotation = $this->annotationReader->getClassAnnotations($this->reflectionTemplateClass);

        if (isset($templateClassAnnotation["PHPerge\Annotations\Id"])) {
            $idAnnotation = $templateClassAnnotation["PHPerge\Annotations\Id"];
            if ($idAnnotation instanceof \PHPerge\Annotations\Id) {
                $this->document = (new Document($idAnnotation->id, $this->connectionOptions));
            }
        }

        if ($this->document instanceof \PHPerge\IDocument) {
            if (isset($templateClassAnnotation["PHPerge\Annotations\Description"])) {
                $descriptionAnnotation = $templateClassAnnotation["PHPerge\Annotations\Description"];
                if ($descriptionAnnotation instanceof \PHPerge\Annotations\Description) {

                    $this->document->setTemplateDescription($descriptionAnnotation->description);

                }
            }
        }
    }

    protected function readPropertiesAnnotations() {
        if ($this->document instanceof \PHPerge\IDocument) {
            foreach ($this->reflectionTemplateProperties as $reflectionTemplateProperty) {
                $templatePropertyAnnotation = $this->annotationReader->getPropertyAnnotations($reflectionTemplateProperty);
                // var_dump("Checking field " . $reflectionTemplateProperty->getName() . ":");
                // var_dump($templatePropertyAnnotation);
                $this->readPropertyAnnotations($reflectionTemplateProperty, $templatePropertyAnnotation);
            }
        }
    }

    protected function readPropertyAnnotations($reflectionTemplateProperty, $propertyAnnotation) {
        if (isset($propertyAnnotation["PHPerge\Annotations\String"])) {
            $this->readStringPropertyAnnotation($reflectionTemplateProperty, $propertyAnnotation);
        }
        if (isset($propertyAnnotation["PHPerge\Annotations\Enum"])) {
            $this->readEnumPropertyAnnotation($reflectionTemplateProperty, $propertyAnnotation);
        }
        if (isset($propertyAnnotation["PHPerge\Annotations\Image"])) {
            $this->readImagePropertyAnnotation($reflectionTemplateProperty, $propertyAnnotation);
        }
        if (isset($propertyAnnotation["PHPerge\Annotations\Table"])) {
            $this->readTablePropertyAnnotation($reflectionTemplateProperty, $propertyAnnotation);
        }
    }

    protected function readStringPropertyAnnotation($reflectionTemplateProperty, $propertyAnnotation) {
        $fieldNameAnnotation = $propertyAnnotation["PHPerge\Annotations\String"];
        if ($fieldNameAnnotation instanceof \PHPerge\Annotations\String) {

            $fieldValue = $this->getTemplateClassProperty($reflectionTemplateProperty->getName());

            $isOptional = false;
            $defaultValue = null;

            if (isset($propertyAnnotation["PHPerge\Annotations\Optional"])) {
                $fieldOptionalAnnotation = $propertyAnnotation["PHPerge\Annotations\Optional"];
                if ($fieldOptionalAnnotation instanceof \PHPerge\Annotations\Optional) {

                    $isOptional = true;
                    $defaultValue = $fieldOptionalAnnotation->default;

                }
            }

            if (is_null($fieldValue) && $isOptional) {
                $fieldValue = $defaultValue;
            }

            if (!is_string($fieldValue)) {
                throw new Exception('Value "' . $fieldValue . '" is not string');
            }


            $this->document->setField($fieldNameAnnotation->fieldName, $fieldValue);

            $fieldDescriptionAnnotation = $propertyAnnotation["PHPerge\Annotations\Description"];
            if ($fieldDescriptionAnnotation instanceof \PHPerge\Annotations\Description) {

                $this->document->setFieldDescription($fieldNameAnnotation->fieldName, $fieldDescriptionAnnotation->description);

            }
        }
    }

    protected function readEnumPropertyAnnotation($reflectionTemplateProperty, $propertyAnnotation) {
        $fieldNameAnnotation = $propertyAnnotation["PHPerge\Annotations\Enum"];
        $valuesAnnotation = $propertyAnnotation["PHPerge\Annotations\Values"];

        if ($fieldNameAnnotation instanceof \PHPerge\Annotations\Enum
            && $valuesAnnotation instanceof \PHPerge\Annotations\Values) {

            $fieldValue = $this->getTemplateClassProperty($reflectionTemplateProperty->getName());

            $isOptional = false;
            $defaultValue = null;

            if (isset($propertyAnnotation["PHPerge\Annotations\Optional"])) {
                $fieldOptionalAnnotation = $propertyAnnotation["PHPerge\Annotations\Optional"];
                if ($fieldOptionalAnnotation instanceof \PHPerge\Annotations\Optional) {

                    $isOptional = true;
                    $defaultValue = $fieldOptionalAnnotation->default;

                }
            }


            if (is_null($fieldValue) && $isOptional) {
                $fieldValue = $defaultValue;
            }

            if (!is_array($valuesAnnotation->values)) {
                throw new Exception("No enum values annotation");
            }
            if (!in_array($fieldValue, array_keys($valuesAnnotation->values))) {
                throw new Exception('Enum value "' . $fieldValue . '" does not in array of values');
            }

            $this->document->setEnum($fieldNameAnnotation->fieldName, $fieldValue);

            $fieldDescriptionAnnotation = $propertyAnnotation["PHPerge\Annotations\Description"];
            if ($fieldDescriptionAnnotation instanceof \PHPerge\Annotations\Description) {

                $this->document->setEnumDescription($fieldNameAnnotation->fieldName, $fieldDescriptionAnnotation->description);

            }
        }
    }

    protected function readImagePropertyAnnotation($reflectionTemplateProperty, $propertyAnnotation) {
        $fieldNameAnnotation = $propertyAnnotation["PHPerge\Annotations\Image"];
        if ($fieldNameAnnotation instanceof \PHPerge\Annotations\Image) {

            $fieldValue = $this->getTemplateClassProperty($reflectionTemplateProperty->getName());
            if (empty($fieldValue)) {
                throw new Exception('Image value ("' . $fieldValue . '") cannot be empty: set image path or base64 encode image');
            }
            if (!file_exists($fieldValue)) {
                throw new Exception('File "' . realpath($fieldValue) . '" does not exist, check paths');
            }

            if (file_exists($fieldValue)) {
                $imageContent = base64_encode(file_get_contents($fieldValue));
            } else {
                $imageContent = $fieldValue;
            }

            $this->document->setImage($fieldNameAnnotation->imageId, $imageContent);

            $fieldDescriptionAnnotation = $propertyAnnotation["PHPerge\Annotations\Description"];
            if ($fieldDescriptionAnnotation instanceof \PHPerge\Annotations\Description) {

                $this->document->setImageDescription($fieldNameAnnotation->imageId, $fieldDescriptionAnnotation->description);

            }
        }
    }

    protected function readTablePropertyAnnotation($reflectionTemplateProperty, $propertyAnnotation) {
        $tableAnnotation = $propertyAnnotation["PHPerge\Annotations\Table"];
        if ($tableAnnotation instanceof \PHPerge\Annotations\Table) {

            $reflectionRowClass = new ReflectionClass($tableAnnotation->rowClass);
            $reflectionRowClassProperties = $reflectionRowClass->getProperties();

            $rowClassAnnotation = $this->annotationReader->getClassAnnotations($reflectionRowClass);

            if (isset($rowClassAnnotation["PHPerge\Annotations\TableRow"])) {
                $tableRowAnnotation = $rowClassAnnotation["PHPerge\Annotations\TableRow"];
                if ($tableRowAnnotation instanceof \PHPerge\Annotations\TableRow) {

                    $tableContent = array();

                    $tableRows = $this->getTemplateClassProperty($reflectionTemplateProperty->getName());

                    if (!is_array($tableRows)) {
                        throw new Exception("Table row var is not an array");
                    }

                    foreach ($tableRows as $tableRow) {
                        $tableContentRow = array();
                        foreach ($reflectionRowClassProperties as $reflectionRowClassProperty) {
                            $rowClassPropertyAnnotation = $this->annotationReader->getPropertyAnnotations($reflectionRowClassProperty);

                            if (isset($rowClassPropertyAnnotation["PHPerge\Annotations\TableColumn"])) {
                                $columnNameAnnotation = $rowClassPropertyAnnotation["PHPerge\Annotations\TableColumn"];
                                if ($columnNameAnnotation instanceof \PHPerge\Annotations\TableColumn) {

                                    $tableContentRow[$columnNameAnnotation->columnName] = self::getObjectProperty($tableRow, $reflectionRowClassProperty->getName());

                                }
                            }
                        }
                        $tableContent[] = $tableContentRow;
                    }



                    $this->document->setTable($tableAnnotation->id, $tableContent);

                    if (isset($rowClassAnnotation["PHPerge\Annotations\Description"])) {
                        $descriptionAnnotation = $rowClassAnnotation["PHPerge\Annotations\Description"];
                        if ($descriptionAnnotation instanceof \PHPerge\Annotations\Description) {

                            $tableRowDescription = $descriptionAnnotation->description;

                            $this->document->setTableDescription($tableAnnotation->id, $tableContent);

                        }
                    }

                }
            }

        }
    }

    protected static function getObjectProperty($object, $property) {
        if (function_exists("mb_convert_case")) {
            $propertyTitleCase = mb_convert_case($property, MB_CASE_TITLE);
        } else {
            $propertyTitleCase = ucwords($property);
        }
        $getterName = "get" . $propertyTitleCase;
        if (method_exists($object, $getterName)) {
            return $object->$getterName();
        }
    }

    protected function getTemplateClassProperty($property) {
        return self::getObjectProperty($this->templateClass, $property);
    }

    public function setConnectionOptions($connectionOptions) {
        $this->connectionOptions = $connectionOptions;
        return $this;
    }
    public function getConnectionOptions() {
        return $this->connectionOptions;
    }

    public function render() {
        return $this->document->getPDFContent();
    }

    /**
     * Gets the value of templateClass.
     *
     * @return mixed
     */
    public function getTemplateClass()
    {
        return $this->templateClass;
    }

    /**
     * Sets the value of templateClass.
     *
     * @param mixed $templateClass the template class
     *
     * @return self
     */
    protected function setTemplateClass($templateClass)
    {
        $this->templateClass = $templateClass;

        return $this;
    }

}