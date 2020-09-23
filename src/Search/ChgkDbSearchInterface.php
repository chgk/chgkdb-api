<?php

namespace App\Search;

use App\Dto\SearchQuestionFilterDto;

interface ChgkDbSearchInterface {
    const FIELD_QUESTION = 'question';
    const FIELD_ANSWER = 'answer';
    const FIELD_COMMENTS = 'comments';
    const FIELD_AUTHORS = 'authors';
    const FIELD_PASS_CRITERIA = 'passCriteria';
    const FIELD_SOURCES = 'sources';
    const TYPE_CHGK = 'Ч';
    const TYPE_BRAIN = 'Б';
    const TYPE_INTERNET = 'И';
    const TYPE_BESKRYLKA = 'Л';
    const TYPE_SVOYAK = 'Я';
    const TYPE_EHRUDIT = 'Э';
    const PARAM_TYPE_CHGK = 'chgk';
    const PARAM_TYPE_BRAIN = 'brain';
    const PARAM_TYPE_INTERNET = 'internet';
    const PARAM_TYPE_BESKRYLKA = 'beskrylka';
    const PARAM_TYPE_SVOYAK = 'svoyak';
    const PARAM_TYPE_EHRUDIT = 'ehrudit';
    const ORDER_DATE = 'date';
    const ORDER_RANDOM = 'random';

    const PARAM_TYPE_MAP = [
        self::PARAM_TYPE_CHGK => self::TYPE_CHGK,
        self::PARAM_TYPE_BRAIN => self::TYPE_BRAIN,
        self::PARAM_TYPE_INTERNET => self::TYPE_INTERNET,
        self::PARAM_TYPE_BESKRYLKA => self::TYPE_BESKRYLKA,
        self::PARAM_TYPE_SVOYAK => self::TYPE_SVOYAK,
        self::PARAM_TYPE_EHRUDIT => self::TYPE_EHRUDIT
    ];
    const ALL_FIELDS = [
        self::FIELD_QUESTION,
        self::FIELD_ANSWER,
        self::FIELD_PASS_CRITERIA,
        self::FIELD_COMMENTS,
        self::FIELD_SOURCES,
        self::FIELD_AUTHORS
    ];

    const ALL_TYPES = [
        self::TYPE_CHGK,
        self::TYPE_BRAIN,
        self::TYPE_INTERNET,
        self::TYPE_BESKRYLKA,
        self::TYPE_SVOYAK,
        self::TYPE_EHRUDIT
    ];

    const ALL_TYPE_PARAMS = [
        self::PARAM_TYPE_CHGK,
        self::PARAM_TYPE_BRAIN,
        self::PARAM_TYPE_INTERNET,
        self::PARAM_TYPE_BESKRYLKA,
        self::PARAM_TYPE_SVOYAK,
        self::PARAM_TYPE_EHRUDIT
    ];

    const ALL_ORDERS = [
        self::ORDER_DATE,
        self::ORDER_RANDOM
    ];

    /**
     * @param SearchQuestionFilterDto $searchFilterDto
     * @return array
     */
    public function searchQuestions(SearchQuestionFilterDto $searchFilterDto);
}
