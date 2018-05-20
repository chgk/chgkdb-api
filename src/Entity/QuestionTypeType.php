<?php

namespace App\Entity;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class QuestionTypeType extends Type
{
    const TYPE_CHGK = 'Ч';
    const TYPE_BRAIN = 'Б';
    const TYPE_INTERNET = 'И';
    const TYPE_BESKRYLKA = 'Л';
    const TYPE_JEOPARDY = 'Я';
    const TYPE_ERUDIT = 'Э';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('Ч', 'Б', 'И', 'Л', 'Я', 'Э')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array(
            $value,
            array(
                self::TYPE_CHGK,
                self::TYPE_BRAIN,
                self::TYPE_INTERNET,
                self::TYPE_BESKRYLKA,
                self::TYPE_JEOPARDY,
                self::TYPE_ERUDIT,
            )
        )) {
            throw new \InvalidArgumentException("Invalid status");
        }

        return $value;
    }

    public function getName()
    {
        return 'chgkdb_question_type';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
