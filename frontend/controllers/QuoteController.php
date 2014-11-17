<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Quote controller
 */
class QuoteController extends Controller
{


    private $_quotes = [
        ['quote'=>'Walking on water and developing software from a specification are easy if both are frozen.', 'author'=>'Edward V Berard'],
        ['quote'=>'It always takes longer than you expect, even when you take into account Hofstadter&rsquo;s Law.', 'author'=>'Hofstadter&rsquo;s Law'],
        ['quote'=>'Always code as if the guy who ends up maintaining your code will be a violent psychopath who knows where you live.', 'author'=>'Rick Osborne'],
        ['quote'=>'I have always wished for my computer to be as easy to use as my telephone; my wish has come true because I can no longer figure out how to use my telephone.', 'author'=>'Bjarne Stroustrup'],
        ['quote'=>'Java is to JavaScript what Car is to Carpet.', 'author'=>'Chris Heilmann'],
    ];
    public function actionIndex() {
        $quote = $this->_getRandomQuote();
        if(!Yii::$app->request->get('random')){
            return $this->render('index', ['quote' => $quote]);
        }else{
            Yii::$app->response->format=Response::FORMAT_JSON;
            return $quote;
        }
    }

    private function _getRandomQuote(){
        return $this->_quotes[array_rand($this->_quotes)];
    }
}
