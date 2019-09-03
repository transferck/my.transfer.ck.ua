<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Emails Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various emails that
    | we need to display to the user. You are free to modify these
    | language lines according to your application's requirements.
    |
    */

    /*
     * Activate new user account email.
     *
     */

    'activationSubject'  => 'Требуется активация',
    'activationGreeting' => 'Добро пожаловать!!',
    'activationMessage'  => 'Вам необходимо активировать свою электронную почту, прежде чем вы сможете начать пользоваться всеми нашими услугами.',
    'activationButton'   => 'Активировать',
    'activationThanks'   => 'Спасибо за использование нашего приложения!',

    /*
     * Goobye email.
     *
     */
    'goodbyeSubject'  => 'Извините, что ушел...',
    'goodbyeGreeting' => 'Привет :username,',
    'goodbyeMessage'  => 'Нам очень жаль, что вы ушли. Мы хотели, чтобы вы знали, что ваша учетная запись была удалена. Спасибо за время, которое мы поделились. У вас есть '.config('settings.restoreUserCutoff').' дней, чтобы восстановить вашу учетную запись.',
    'goodbyeButton'   => 'Восстановить аккаунт',
    'goodbyeThanks'   => 'Мы надеемся увидеть вас снова!',

];
