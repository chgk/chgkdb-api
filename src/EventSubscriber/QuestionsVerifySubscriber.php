<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Dto\VerifyQuestionsRequest;
use Chgk\ChgkDb\Parser\Formatter\FormatterFactory;
use Chgk\ChgkDb\Parser\Formatter\HtmlFormatter;
use Chgk\ChgkDb\Parser\Iterator\FileLineIterator;
use Chgk\ChgkDb\Parser\Iterator\TextLineIterator;
use Chgk\ChgkDb\Parser\ParserFactory\ParserFactory;
use Chgk\ChgkDb\Parser\TextParser\Exception\ParseException;
use Chgk\ChgkDb\Parser\TextParser\TextParser;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class QuestionsVerifySubscriber implements EventSubscriberInterface
{
    /**
     * @var ParserFactory
     */
    private $parserFactory;

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['validateQuestions', EventPriorities::POST_VALIDATE],
        ];
    }

    /**
     * QuestionsVerifySubscriber constructor.
     * @param ParserFactory $parserFactory
     */
    public function __construct(ParserFactory $parserFactory)
    {
        $this->parserFactory = $parserFactory;
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     * @throws \Chgk\ChgkDb\Parser\ParserFactory\UnregisteredParserException
     */
    public function validateQuestions(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        if ($request->attributes->get('_route') !== 'api_verify_questions_requests_post_collection')
        {
            return;
        }

        /** @var VerifyQuestionsRequest $verifyRequest */
        $verifyRequest = $event->getControllerResult();

        $parser = $this->parserFactory->getParser('text');
        $iterator = new TextLineIterator($verifyRequest->text);
        try {
            $package = $parser->parse($iterator);
            $formatterFactory = new FormatterFactory();
            $formatter = $formatterFactory->getParser($verifyRequest->outputFormat);

            $result = $formatter->format($package, $verifyRequest->textId);


            $event->setResponse(new JsonResponse(['result' => $result], 200));
        } catch (ParseException $e) {
            $event->setResponse(new JsonResponse(['error' => $e->getMessage(), 'line' => $e->getLineNumber()], 400));
        }
    }
}
