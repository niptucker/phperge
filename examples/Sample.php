<?php

namespace PHPerge\Examples;

use PHPerge\Annotations as PHPerge;

/**
 * Шаблонный шаблон
 *
 * @PHPerge\Id("sample")
 * @PHPerge\Description("Шаблонный шаблон")
 */
class Sample implements \PHPerge\ITemplate {

    /**
     * Обязательное строковое поле
     * Синоним к слову «быстро»
     *
     * @var string
     *
     * @PHPerge\Description("Синоним к слову «быстро»")
     * @PHPerge\String("quickly")
     */
    protected $quickly;

    /**
     * Строковое поле, значение которого может быть неопределено
     *
     * @var string
     *
     * @PHPerge\Description("Проверка опциональной строки")
     * @PHPerge\Optional("")
     * @PHPerge\String("optional_string")
     */
    protected $optionalString;

    /**
     * Необязательное строковое поле со значением по умолчанию
     *
     * @var string
     *
     * @PHPerge\Description("Проверка опциональной строки")
     * @PHPerge\Optional("значение по умолчанию")
     * @PHPerge\String("default_string")
     */
    protected $defaultString;



    const CAN_MAY  = "0";
    const CAN_NEED = "1";
    const CAN_WANT = "2";

    /**
     * Перечисление (поле с выбором из карты значений; обязательное)
     * Синоним к слову «нужно»
     *
     * @var Enum
     *
     * @PHPerge\Description("Синоним к слову «нужно»")
     * @PHPerge\Enum("can")
     *
     * @PHPerge\Values({
     *     Sample::CAN_MAY  = "можно",
     *     Sample::CAN_NEED = "нужно",
     *     Sample::CAN_WANT = "хочется"
     * })
     */
    protected $can;


    const OPTIONAL_ENUM_ZERO = "0";
    const OPTIONAL_ENUM_FIRST   = "1";
    const OPTIONAL_ENUM_SECOND  = "2";

    /**
     * Необязательное перечисление
     * Проверка опционального поля
     *
     * @var Enum
     *
     * @PHPerge\Description("Проверка опционального поля")
     * @PHPerge\Enum("optional_enum")
     * @PHPerge\Optional(Sample::OPTIONAL_ENUM_SECOND)
     * @PHPerge\Values({
     *     Sample::OPTIONAL_ENUM_ZERO    = "значение",
     *     Sample::OPTIONAL_ENUM_FIRST   = "заданное значение",
     *     Sample::OPTIONAL_ENUM_SECOND  = "еще одно заданное значение"
     * })
     */
    protected $optionalEnum;


    const DEFAULT_ENUM_DEFAULT = "0";
    const DEFAULT_ENUM_FIRST   = "1";
    const DEFAULT_ENUM_SECOND  = "2";

    /**
     * Проверка опционального поля (со значением по умолчанию)
     *
     * @var Enum
     * @PHPerge\Optional(Sample::DEFAULT_ENUM_DEFAULT)
     * @PHPerge\Description("Проверка опционального поля")
     * @PHPerge\Enum("default_enum")
     *
     * @PHPerge\Values({
     *     Sample::DEFAULT_ENUM_DEFAULT = "значение по умолчанию",
     *     Sample::DEFAULT_ENUM_FIRST   = "заданное значение",
     *     Sample::DEFAULT_ENUM_SECOND  = "еще одно заданное значение"
     * })
     */
    protected $defaultEnum;

    /**
     * @var Image
     *
     * @PHPerge\Description("Картинка для проверки")
     * @PHPerge\Image("pic")
     */
    protected $pic;

    /**
     * Таблица для примера
     *
     * @var array
     *
     * @PHPerge\Table(id="table", rowClass="PHPerge\Examples\SampleTableRow")
     */
    protected $table;


    /**
     * Gets the Синоним к слову «быстро».
     *
     * @return string
     */
    public function getQuickly()
    {
        return $this->quickly;
    }

    /**
     * Sets the Синоним к слову «быстро».
     *
     * @param string $quickly the quickly
     *
     * @return self
     */
    public function setQuickly($quickly)
    {
        $this->quickly = $quickly;

        return $this;
    }

    /**
     * Gets the Синоним к слову «быстро».
     *
     * @return string
     */
    public function getCan()
    {
        return $this->can;
    }

    /**
     * Sets the Синоним к слову «быстро».
     *
     * @param string $can the can
     *
     * @return self
     */
    public function setCan($can)
    {
        $this->can = $can;

        return $this;
    }

    /**
     * Gets the Синоним к слову «быстро».
     *
     * @return string
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Sets the Синоним к слову «быстро».
     *
     * @param string $pic the pic
     *
     * @return self
     */
    public function setPic($pic)
    {
        $this->pic = $pic;

        return $this;
    }

    /**
     * Gets the Таблица для примера.
     *
     * @return array
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Sets the Таблица для примера.
     *
     * @param array $table the table
     *
     * @return self
     */
    public function setTable(array $table)
    {
        $this->table = $table;

        return $this;
    }

    public function render() {
        return (new \PHPerge\PdfRenderer($this, require __DIR__ . '/connection.php'))->render();
    }
}