<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'   => 'Эти учетные данные не соответствуют нашим записям.',
    'throttle' => 'Слишком много попыток входа в систему. Пожалуйста, повторите попытку через :seconds секунд.',

    // Activation items
    'sentEmail'        => 'Мы отправили электронное письмо по адресу: email :email.',
    'clickInEmail'     => 'Пожалуйста, нажмите на ссылку в нем, чтобы активировать свою учетную запись.',
    'anEmailWasSent'   => 'Письмо было отправлено на :email on :date.',
    'clickHereResend'  => 'Нажмите здесь, чтобы повторно отправить электронное письмо.',
    'successActivated' => 'Успех, ваша учетная запись была активирована.',
    'unsuccessful'     => 'Ваш аккаунт не может быть активирован; пожалуйста, попробуйте снова.',
    'notCreated'       => 'Ваша учетная запись не может быть создана; пожалуйста, попробуйте снова.',
    'tooManyEmails'    => 'Слишком много писем об активации отправлено на :email. <br />Пожалуйста, попробуйте еще раз спустя <span class="label label-danger">:hours часа</span>.',
    'regThanks'        => 'Спасибо за регистрацию, ',
    'invalidToken'     => 'Неверный токен активации. ',
    'activationSent'   => 'Письмо с активацией отправлено. ',
    'alreadyActivated' => 'Уже активирован. ',

    // Labels
    'whoops'          => 'Упс! ',
    'someProblems'    => 'Были некоторые проблемы с вашим вводом.',
    'email'           => 'Email адрес',
    'password'        => 'Пароль',
    'rememberMe'      => ' Запомнить меня',
    'login'           => 'Логин',
	'login_btn'       => 'Войти',
    'forgot'          => 'Забыли пароль?',
    'forgot_message'  => 'Проблемы с паролем?',
    'name'            => 'Название фирмы',
	'phone'           => 'Номер моб. телефона',
    'first_name'      => 'Имя',
    'last_name'       => 'Фамилия',
    'confirmPassword' => 'Подтвердить пароль',
    'register'        => 'Регистрация агента',
	'register_btn'    => 'Регистрация',

    // Placeholders
    'ph_name'          => 'Имя пользователя',
    'ph_email'         => 'Email адрес',
    'ph_firstname'     => 'Имя',
    'ph_lastname'      => 'Фамилия',
    'ph_password'      => 'Пароль',
    'ph_password_conf' => 'Подтвердить пароль',

    // User flash messages
    'sendResetLink' => 'Отправить ссылку для сброса пароля',
    'resetPassword' => 'Сбросить пароль',
    'loggedIn'      => 'Вы вошли в систему!',

    // email links
    'pleaseActivate'    => 'Пожалуйста, активируйте свою учетную запись.',
    'clickHereReset'    => 'Нажмите здесь, чтобы сбросить пароль: ',
    'clickHereActivate' => 'Нажмите здесь, чтобы активировать свою учетную запись: ',

    // Validators
    'userNameTaken'    => 'Имя пользователя занято',
    'userNameRequired' => 'Требуется имя пользователя',
	'phoneNumberRequired'   => 'Требуется номер телефона',
	'phoneNumberMin'   => 'Номер телефона должен содержать не менее 6 символов',
	'phoneNumberNumeric'   => 'Номер телефона должен состоять только из цифр',
    'fNameRequired'    => 'Требуется имя',
    'lNameRequired'    => 'Требуется фамилия',
    'emailRequired'    => 'Требуется адрес электронной почты',
    'emailInvalid'     => 'Email недействителен',
    'passwordRequired' => 'Требуется пароль',
    'PasswordMin'      => 'Пароль должен содержать не менее 6 символов',
    'PasswordMax'      => 'Максимальная длина пароля - 20 символов',
    'captchaRequire'   => 'Требуется капча',
    'CaptchaWrong'     => 'Неправильный код, попробуйте еще раз.',
    'roleRequired'     => 'Требуется роль пользователя.',

];
