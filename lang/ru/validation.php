<?php

return [
    'accepted' => 'Поле :attribute должно быть принято.',
    'after' => 'Поле :attribute должно содержать дату после :date.',
    'after_or_equal' => 'Поле :attribute должно содержать дату не раньше :date.',
    'alpha' => 'Поле :attribute может содержать только буквы.',
    'array' => 'Поле :attribute должно быть массивом.',
    'before' => 'Поле :attribute должно содержать дату до :date.',
    'between' => [
        'numeric' => 'Поле :attribute должно быть между :min и :max.',
        'string' => 'Поле :attribute должно содержать от :min до :max символов.',
    ],
    'boolean' => 'Поле :attribute должно быть истинным или ложным значением.',
    'confirmed' => 'Поле :attribute не совпадает с подтверждением.',
    'date' => 'Поле :attribute должно быть корректной датой.',
    'email' => 'Поле :attribute должно быть корректным email-адресом.',
    'exists' => 'Выбранное значение поля :attribute некорректно.',
    'in' => 'Выбранное значение поля :attribute некорректно.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'max' => [
        'numeric' => 'Поле :attribute не должно быть больше :max.',
        'string' => 'Поле :attribute не должно превышать :max символов.',
    ],
    'min' => [
        'numeric' => 'Поле :attribute должно быть не меньше :min.',
        'string' => 'Поле :attribute должно содержать не менее :min символов.',
    ],
    'numeric' => 'Поле :attribute должно быть числом.',
    'regex' => 'Поле :attribute имеет неверный формат.',
    'required' => 'Поле :attribute обязательно для заполнения.',
    'string' => 'Поле :attribute должно быть строкой.',
    'unique' => 'Такое значение поля :attribute уже используется.',

    'attributes' => [
        'name' => 'ФИО',
        'email' => 'email',
        'password' => 'пароль',
        'password_confirmation' => 'подтверждение пароля',
        'phone' => 'номер телефона',
        'creative_type_id' => 'вид творчества',
        'title' => 'название мастер-класса',
        'description' => 'описание мастер-класса',
        'session_date' => 'дата',
        'slot_time' => 'время',
        'max_participants' => 'количество мест',
        'price' => 'стоимость',
    ],
];
