<?php

namespace App\Controller;

use Chgk\ChgkDb\Parser\Formatter\HtmlFormatter;
use Chgk\ChgkDb\Parser\Iterator\TextLineIterator;
use Chgk\ChgkDb\Parser\ParserFactory\ParserFactory;
use Chgk\ChgkDb\Parser\TextParser\Exception\ParseException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ValidatorFormController extends Controller
{
    /**
     * @var ParserFactory
     */
    private $parserFactory;

    /**
     * ValidatorFormController constructor.
     * @param ParserFactory $parserFactory
     */
    public function __construct(ParserFactory $parserFactory)
    {
        $this->parserFactory = $parserFactory;
    }

    /**
     * @Route("/validator", name="validator_form")
     */
    public function validatorForm(Request $request)
    {
        $text = $request->request->get('package_text', '');


        $parser = $this->parserFactory->getParser('text');
        $result = '';
        $error = '';
        if ($text) {
            $iterator = new TextLineIterator($text);
            try {
                $package = $parser->parse($iterator);
                $formatter = HtmlFormatter::create();
                $html = $formatter->format($package);
                $result = $html;
            } catch (ParseException $e) {
                $result = htmlentities($text);
                $lines = preg_split('/\r\n|\r|\n/', $result);
                $lines[$e->getLineNumber()] =
                    sprintf('<a name="error"></a><div class="alert alert-danger">%s</div>', $lines[$e->getLineNumber()]);
                $result = implode("\n", $lines);
                $error = $e->getMessage();
            }
        }

        $vars = [
            'plain_text' => $text,
            'result' => $result,
            'error' => $error
        ];
        return $this->render('validator_form.html.twig', $vars);
#        return new Response('Hello');
    }
}
