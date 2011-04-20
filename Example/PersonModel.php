<?php

class PersonModel
{
    protected $name;
    protected $gender;

    const G_MALE = 0;
    const G_FEMALE = 2;
    const G_OTHER = 2;

    public function setRealName($name)
    {
        $this->name = $name;
    }

    public function getRealName() {
        return $this->name;
    }

    public function setGender($gender)
    {
        if (in_array($gender, array(self::G_MALE, self::G_FEMALE, self::G_OTHER))) {
            $this->gender = $gender;
        } else {
            $this->gender = self::G_OTHER;
        }
    }

    public function getGender() {
        return $this->gender;
    }

    public function getGenderString()
    {
        switch ($this->getGender()) {
            case self::G_MALE:
                return 'Male';
                break;
            case self::G_FEMALE:
                return 'Female';
                break;
            case self::G_OTHER:
                return 'Other';
                break;
        }
    }
}