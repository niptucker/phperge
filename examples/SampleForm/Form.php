<?php

namespace PHPerge\Examples\SampleForm;

use PHPerge\Annotations as PHPerge;
use PHPerge\BasicTemplate;

/**
 * Демонстранционный шаблон (анкета)
 *
 * @PHPerge\Id("sample_form")
 * @PHPerge\Description("Демонстранционный шаблон (анкета)")
 */
class Form extends BasicTemplate {

    /**
     * Фамилия
     *
     * @var string
     *
     * @PHPerge\Description("Фамилия")
     * @PHPerge\String("lastname")
     */
    protected $lastname;

    /**
     * Имя
     *
     * @var string
     *
     * @PHPerge\Description("Имя")
     * @PHPerge\String("firstname")
     */
    protected $firstname;

    /**
     * Отчество
     *
     * @var string
     *
     * @PHPerge\Description("Отчество")
     * @PHPerge\Optional("")
     * @PHPerge\String("patronymic")
     */
    protected $patronymic = "";

    /**
     * Есть ли отчество
     *
     * @var boolean
     *
     * @PHPerge\Description("Есть ли отчество")
     * @PHPerge\Fragment("patronymic")
     */
    protected $isPatronymicPresented = false;


    const GENDER_MALE = "1";
    const GENDER_FEMALE = "2";

    /**
     * Пол
     *
     * @var string
     *
     * @PHPerge\Description("Пол")
     * @PHPerge\Enum("gender")
     *
     * @PHPerge\Values({
     *     Form::GENDER_MALE = "мужской",
     *     Form::GENDER_FEMALE = "женский"
     * })
     */
    protected $gender;

    /**
     * Фотография
     *
     * @var string
     *
     * @PHPerge\Description("Фотография")
     * @PHPerge\Image("photo")
     */
    protected $photo;

    /**
     * Места предыдущей работы
     *
     * @var array
     *
     * @PHPerge\Table(id="job_positions", rowClass="PHPerge\Examples\SampleForm\JobPosition")
     * @PHPerge\Description("Места предыдущей работы")
     */
    protected $jobPositions = array();

    /**
     * Врезка "Ранее не работал"
     *
     * @var boolean
     *
     * @PHPerge\Fragment("nojob")
     * @PHPerge\Description("Ранее не работал")
     */
    protected $hasNoJob = true;

    /**
     * Врезка с таблицей предыдущих должностей
     *
     * @var boolean
     *
     * @PHPerge\Fragment("lastjobs")
     * @PHPerge\Description("Врезка с таблицей предыдущих должностей")
     */
    protected $hasLastJobs = false;


    /**
     * Gets the Фамилия.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Sets the Фамилия.
     *
     * @param string $lastname the lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Gets the Имя.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Sets the Имя.
     *
     * @param string $firstname the firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Gets the Отчество.
     *
     * @return string
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * Sets the Отчество.
     *
     * @param string $patronymic the patronymic
     *
     * @return self
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;

        $this->isPatronymicPresented = !empty($this->patronymic);

        return $this;
    }

    /**
     * Gets the Пол
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Sets the Пол
     *
     * @param string $gender the gender
     *
     * @return self
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Gets the Фотография.
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Sets the Фотография.
     *
     * @param string $photo the photo
     *
     * @return self
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Gets the Места предыдущей работы.
     *
     * @return array
     */
    public function getJobPositions()
    {
        return $this->jobPositions;
    }

    /**
     * Sets the Места предыдущей работы.
     *
     * @param array $jobPositions the job positions
     *
     * @return self
     */
    public function setJobPositions(array $jobPositions)
    {
        $this->jobPositions = $jobPositions;

        $this->hasLastJobs = !empty($this->jobPositions);
        $this->hasNoJob = empty($this->jobPositions);

        return $this;
    }
}
