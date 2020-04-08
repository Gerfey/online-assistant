<?php

namespace Gerfey\OnlineAssistant\Integrations\FindMorphy\Entity;

use Gerfey\Mapper\Annotation\Field;

class WordsEntity
{
    /**
     * @Field(name="source", type="string")
     */
    public $source;

    /**
     * @Field(name="count", type="int")
     */
    public $count;

    /**
     * @Field(name="range", type="int")
     */
    public $range;

    /**
     * @Field(name="weight", type="int")
     */
    public $weight;

    /**
     * @Field(name="basic", type="array")
     */
    public $basic;
}
