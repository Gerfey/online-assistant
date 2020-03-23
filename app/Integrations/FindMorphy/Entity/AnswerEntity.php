<?php

namespace App\Integrations\FindMorphy\Entity;

use Gerfey\Mapper\Annotation\Field;

class AnswerEntity
{
    /**
     * @Field(name="range", type="int")
     */
    public $range;

    /**
     * @Field(type="array")
     */
    public $words;
}
