<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DomCrawler\Crawler;
use Extractor\Extractor;
use Trello\Client;
use Trello\Manager;

//Request::setTrustedProxies(array('127.0.0.1'));

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array());
})
->bind('homepage')
;

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});

$app->get('/untranslated', function () use ($app) {
    $client = new Goutte\Client();
    $crawler = $client->request('GET', 'http://doc.php.net/revcheck.php?p=missfiles&lang=pt_BR');
    
    $crawler = $crawler->filter("table > tr");

    $nodeValues = $crawler->each(
        function (Crawler $node, $i) {
            $first = $node->children()->first()->text();
            $last  = $node->children()->last()->text();
            return array($first, $last);
        }
    );

    $extractor = new Extractor($nodeValues);
    return new Response(var_dump($extractor->getFullNames()));
})
->bind('untranslated')
;

$app->get('/trello', function () use ($app) {
    $client = new Client();
    //veja aqui para gerar a key e o token de uso 
    //https://trello.com/c/jObnWvl1/25-generating-your-developer-key
    $client->authenticate(
        'afdadfasdfasfd', //api_key
        'adsfasdfsdfafas', //token trello
        Client::AUTH_URL_CLIENT_ID
    );

    $board = $client->api('board')->show('j6Nuulpn');

    $cards = $client->api('board')->cards()->all('j6Nuulpn');

    $cardsNames = new \ArrayIterator();

    foreach ($cards as $key => $value) {
        $cardsNames->append(
            $value['name']
        );
    }

    return new Response(var_dump($cardsNames));
})
    ->bind('trello')
;
