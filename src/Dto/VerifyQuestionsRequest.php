<?php
declare(strict_types=1);

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "post"={
 *              "method"="POST",
 *              "path"="/questions/validate",
 *
 *              "swagger_context" = {
 *                  "responses" = {
 *                      "200" = {
 *                          "description" = "The package is ok",
 *                          "schema" = {
 *                              "type" = "object",
 *                              "properties" = {
 *                                  "html" = {
 *                                      "type" = "string"
 *                                  }
 *                              }
 *                          }
 *                      },
 *                      "400" = {
 *                          "description" = "There an error during parsing",
 *                          "schema" = {
 *                              "type" = "object",
 *                              "properties" = {
 *                                  "error" = {
 *                                      "type" = "string",
 *                                  },
 *                                  "line" = {
 *                                      "type" = "integer"
 *                                  }
 *                              }
 *                          }
 *                      },
 *                  },
 *                  "summary" = "Validates the chgk package",
 *                  "consumes" = {
 *                      "application/json"
 *                  },
 *                  "produces" = {
 *                      "application/json"
 *                  }
 *              }
 *          }
 *      },
 *      itemOperations={},
 * )
 */
class VerifyQuestionsRequest
{
    /**
     * @var string Text to verify
     * @Assert\NotBlank
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type"="string",
     *              "example"="Чемпионат:
Мой турнир

Тур:
1

Вопрос 1:
Сколько будет 2x2?

Ответ:
4

Зачёт:
4.0

Комментарий:
А не 5.

Автор:
Василий Пукин"
     *
     *           }
     *     }
     * )
     */
    public $text;

    /**
     * @var string
     */
    public $outputFormat;

    /**
     * @var string
     */
    public $textId;
}
