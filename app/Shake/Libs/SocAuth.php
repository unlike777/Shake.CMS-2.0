<?php
/**
 * Реализация авторизации через соц. сети через протокол OAuth 2.0
 *
 * Created by PhpStorm.
 * User: UNLIKE
 * Date: 02.04.2015
 * Time: 15:50
 */

namespace App\Shake\Libs;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Input;
use Session;
use Auth;
use Request;
use Redirect;

class SocAuth {

    /**
     * текущий провайдер vk|fb
     * @var string
     */
    private static $cur_provider = '';

    /**
     * Конфиги возможнных соц. сетей
     * @var array
     */
    private static $config = array(
        'vk' => array(
            'app_id' => '',
            'secret' => '',
            'scope' => 'status,email',
            'back_url' => '/auth/soc/vk',
            'version' => '5.29',
            'enable' => false,
            'name' => 'Вконтакте',
        ),
        'fb' => array(
            'app_id' => '',
            'secret' => '',
            'scope' => 'email,public_profile',
            'back_url' => '/auth/soc/fb',
            'enable' => false,
            'name' => 'Facebook',
        ),
        'tw' => array(
            'app_id' => '',
            'secret' => '',
            'scope' => '',
            'back_url' => '/auth/soc/tw',
            'enable' => false,
            'name' => 'Twitter',
        ),
    );

    /**
     * Вернет список всех активных соц. сетей
     * @return array
     */
    public static function getSocs() {
        $arr = array();

        $user_socs = array();
        if (!Auth::guest()) {
            $user_socs = Auth::user()->profiles()->get();
        }

        foreach (self::$config as $key => $item) {
            if (self::getVal($item['enable']) == true) {

                $item['user_has'] = false;
                foreach ($user_socs as $soc) {
                    if ($soc->provider == $key) {
                        $item['user_has'] = true;
                    }
                }

                $arr[$key] = $item;
            }
        }

        return $arr;
    }

    /**
     * Вернет данные пользователя из соц. сети или false в случае возникновения ошибок
     * @param $provider
     * @return bool|mixed|string
     * array('provider', 'soc_id', 'email', 'name')
     */
    public static function getUserData($provider) {
        //проверяем существование конфига
        if (!array_key_exists($provider, self::$config)) {
            return false;
        }

        self::$cur_provider = $provider;

        //если соц. сеть отключена сбрасываем
        if (!self::config('enable')) {
            return false;
        }

        //если не задан back_url тоже сбрасываем
        if (self::back_url() == '') {
            return false;
        }

        if ($provider == 'vk') {
            return self::connectVk();
        } else if ($provider == 'fb') {
            return self::connectFb();
        } else if ($provider == 'tw') {
            return self::connectTw();
        }

        return false;
    }

    /**
     * Вернет значение конфига с учетом текущего провайдера
     * @param $key
     * @return string
     */
    private static function config($key) {
        if (isset(self::$config[self::$cur_provider][$key])) {
            return self::$config[self::$cur_provider][$key];
        }

        return '';
    }

    /**
     * Сгенерирует переменную state и сохранит ее в сессии для дальней проверки
     * Доп. безопасность
     * @return int
     */
    private static function genState() {
        $border = 10000000;
        $rand = rand($border, $border * 10 - 1);

        Session::set('soc.' . self::$cur_provider . '.state', $rand);
        Session::save();

        return $rand;
    }

    /**
     * Проверит переданную в соц. сеть переменную state со значеним в сессии
     * @param $state
     * @return bool
     */
    private static function checkState($state) {
        if (Session::get('soc.' . self::$cur_provider . '.state') == $state) {
            return true;
        }

        return false;
    }

    /**
     * Генерирует ссылку для возрата обратно с учетом текущего домена
     * @return string
     */
    private static function back_url() {
        $back_url = self::config('back_url');

        if (!empty($back_url)) {
            return Request::root() . $back_url;
        }

        return '';
    }

    /**
     * Проверяет существование перемной и возвращает ее, в обратном случае вернет пустоту
     * @param $p
     * @return string
     */
    private static function getVal(&$p) {
        return isset($p) ? $p : '';
    }

    /**
     * Логика подключения к Вконтакте
     * @return array|bool
     */
    private static function connectVk() {

        if (!Input::has('code')) {
            $url = "https://oauth.vk.com/authorize?client_id=" . self::config('app_id') . "&scope=" . self::config('scope') . "&redirect_uri=" . self::back_url() . "&response_type=code&v=" . self::config('version') . "&state=" . self::genState();
            Redirect::to($url)->send();
        }

        if (!self::checkState(Input::get('state'))) {
            return false;
        }

        $code = Input::get('code');

        $url = "https://oauth.vk.com/access_token?client_id=" . self::config('app_id') . "&client_secret=" . self::config('secret') . "&code=$code&redirect_uri=" . self::back_url();

        $data = json_decode(file_get_contents($url), true);

        if (!self::getVal($data['user_id'])) {
            return false;
        }

        //array(first_name, last_name, photo_100)
        $info = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id=' . $data['user_id'] . '&v=5.50&fields=photo_100,first_name,last_name'), true);

        if ($info && isset($info['response'][0])) {
            $info = $info['response'][0];
        } else {
            $info = array();
        }

        $ret = array(
            'soc_id' => self::getVal($data['user_id']),
            'email' => self::getVal($data['email']),
            'name' => self::getVal($info['first_name']) . ' ' . self::getVal($info['last_name']),
            'provider' => self::$cur_provider,
            'photo' => $info['photo_100'],
        );

        return $ret;
    }

    /**
     * Логика подключения к Facebook'у
     * @return array|bool
     */
    private static function connectFb() {

        if (!Input::has('code')) {
            $url = "http://www.facebook.com/dialog/oauth?client_id=" . self::config('app_id') . "&redirect_uri=" . self::back_url() . "&state=" . self::genState() . "&scope=" . self::config('scope');
            Redirect::to($url)->send();
        }

        if (!self::checkState(Input::get('state'))) {
            return false;
        }

        $code = Input::get('code');

        $url = "https://graph.facebook.com/oauth/access_token?client_id=" . self::config('app_id') . "&redirect_uri=" . self::back_url() . "&client_secret=" . self::config('secret') . "&code=$code";
        //		$url = str_replace('&amp;', '&', $url);

        $data = @file_get_contents($url);
        @parse_str($data, $data);

        if (!isset($data['access_token'])) {
            return false;
        }

        $url = "https://graph.facebook.com/me?access_token=" . $data['access_token'] . '&fields=id,first_name,last_name,email,picture';
        $data = json_decode(file_get_contents($url), true);

        if (!self::getVal($data['id'])) {
            return false;
        }

        $ret = array(
            'soc_id' => self::getVal($data['id']),
            'email' => self::getVal($data['email']),
            'name' => self::getVal($data['first_name']) . ' ' . self::getVal($data['last_name']),
            'provider' => self::$cur_provider,
            'photo' => self::getVal($data['picture']['data']['url']),
        );

        return $ret;
    }

    /**
     * Логика подключения к Twitter'у
     * @return array|bool
     */
    private static function connectTw() {
        $auth = new TwitterOAuth(self::config('app_id'), self::config('secret'));

        if (!Input::has('oauth_verifier')) {
            $token = $auth->oauth('oauth/request_token');

            if (!isset($token['oauth_token'])) {
                return false;
            }

            $auth->setOauthToken($token['oauth_token'], $token['oauth_token_secret']);

            $url = $auth->url("oauth/authenticate", ["oauth_token" => $token['oauth_token']]);
            Redirect::to($url)->send();
        }

        $token = $auth->oauth('oauth/access_token', ["oauth_verifier" => Input::get('oauth_verifier'), 'oauth_token' => Input::get('oauth_token')]);

        if (!isset($token['oauth_token'])) {
            return false;
        }

        $auth->setOauthToken($token['oauth_token'], $token['oauth_token_secret']);

        $data = (array)$auth->get("account/verify_credentials", array('include_email' => 'true'));

        $ret = array(
            'soc_id' => self::getVal($data['id']),
            'email' => self::getVal($data['email']),
            'name' => self::getVal($data['name']),
            'provider' => self::$cur_provider,
            'photo' => self::getVal($data['profile_image_url']),
        );

        return $ret;
    }

}
