<?php


namespace app\modules\v1\controllers;

use Yii;
use yii\helpers\Url;
use yii\rest\Controller;
use app\modules\v1\models\FeedUser;
use app\modules\v1\models\Token;
use app\modules\v1\components\exception\InternalException;
use app\modules\v1\components\exception\MissingParametersException;
use app\modules\v1\components\exception\WrongSecretException;
use richweber\twitter\TwitterOAuth;


class ApiController extends Controller
{

    /**
     * @var TwitterOAuth $twitter
     */
    private $twitter = null;

    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => ['application/json' => \yii\web\Response::FORMAT_JSON],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $params = Yii::$app->request->queryParams;

        if (in_array($action->id, ['add', 'remove', 'feed'])) {
            if (in_array($action->id, ['add', 'remove'])) {
                if (!isset($params['user'])) {
                    throw new MissingParametersException();
                }
            }

            if (!isset($params['id']) || !isset($params['secret'])) {
                throw new WrongSecretException('access denied');
            }

            if (strlen($params['id']) != 32) {
                throw new WrongSecretException('access denied');
            }

            if (!$this->isValidSecret($params)){
                throw new WrongSecretException('access denied');
            }
        }

        return parent::beforeAction($action);

    }


    /**
     * GET /
     */
    public function actionIndex()
    {
        return;
    }

    /**
     * GET /add?id=...&user=...&secret=...
     *
     * @param string $id
     * @param string $user
     * @param string $secret
     * @throws InternalException
     */
    public function actionAdd($id, $user, $secret)
    {
        if (!$this->isFeedUserExist($user)) {
            $feedUser = new FeedUser();
            $feedUser->user = $user;
            if (!$feedUser->save()) throw new InternalException();
            return;
        }

        throw new InternalException();
    }

    /**
     * GET /remove?id=...&user=...&secret=...
     *
     * @param $id
     * @param $user
     * @param $secret
     * @throws InternalException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemove($id, $user, $secret)
    {
        if ($this->isFeedUserExist($user)) {
            $feedUser = FeedUser::findOne(['user' => $user]);
            if (!$feedUser->delete()) throw new InternalException();
            return;
        }

        throw new InternalException();
    }

    /**
     * @return array
     * @throws InternalException
     */
    public function actionFeed()
    {
        $data = [];

        if ($twitter = $this->getTwitter()) {
            $feedUsers = FeedUser::find()->all();
            foreach ($feedUsers as $feedUser) {
                $feeds = $twitter->get('statuses/user_timeline', [
                    'screen_name' => $feedUser['user']
                ]);

                if ($feeds->errors) throw new InternalException();

                foreach ($feeds as $feed) {
                    $data['feed'][] = [
                        'user' => $feedUser['user'],
                        'tweet' => $feed->text,
                        'hashtags' => array_map(function($hashtag){
                            return $hashtag->text;
                        }, $feed->entities->hashtags)
                    ];
                }
            }

            return $data;
        }

        throw new InternalException();
    }

    /**
     * GET /login
     *
     * Twitter login
     *
     * @return \yii\web\Response
     */
    public function actionLogin()
    {
        /**
         * @var TwitterOAuth $twitter
         */
        $twitter = Yii::$app->twitter->getTwitter();
        $request_token = $twitter->getRequestToken();

        Yii::$app->session['oauth_token'] = $token = $request_token['oauth_token'];
        Yii::$app->session['oauth_token_secret'] = $request_token['oauth_token_secret'];

        if ($twitter->http_code == 200){
            $url = $twitter->getAuthorizeURL($token);
            return $this->redirect($url);
        } else {
            return $this->redirect(Url::home());
        }
    }

    /**
     * GET /callback
     *
     * Twitter callback
     *
     * @return \yii\web\Response
     */
    public function actionCallback()
    {
        /**
         * @var TwitterOAuth $twitter
         */
        $twitter = Yii::$app->twitter->getTwitterTokened(Yii::$app->session['oauth_token'], Yii::$app->session['oauth_token_secret']);

        $access_token = $twitter->getAccessToken($_REQUEST['oauth_verifier']);

        unset(Yii::$app->session['oauth_token']);
        unset(Yii::$app->session['oauth_token_secret']);

        $token = $this->getToken() ? $this->getToken() : new Token();
        $token->loadFromArray($access_token);
        if ($token->validate()) {
            $token->save();
            $this->redirect('/v1/api');
        } else {
            return $this->redirect(Url::home());
        }
    }

    /**
     * Get Twitter Access Token
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    private function getToken()
    {
        return Token::find()->one();
    }

    /**
     * Check feed user in database
     *
     * @param $user
     * @return bool
     */
    private function isFeedUserExist($user)
    {
        $findResult = FeedUser::findOne(['user' => $user]);
        return $findResult ? true : false;
    }

    /**
     * Validate secret
     *
     * @param $params
     * @return bool
     */
    private function isValidSecret($params)
    {
        $secret = $params['secret'];
        unset($params['secret']);
        return sha1(implode($params)) == $secret;
    }

    /**
     * Get Twitter Api
     *
     * @return mixed
     */
    private function getTwitter()
    {
        if ($access_token = $this->getToken()) {
            $token = $access_token['oauth_token'];
            $secret = $access_token['oauth_token_secret'];
            return Yii::$app->twitter->getTwitterTokened($token, $secret);
        }
    }
}