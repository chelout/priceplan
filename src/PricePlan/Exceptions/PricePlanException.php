<?php

namespace PricePlan\Exceptions;

use Exception;

class PricePlanException extends Exception
{
    const ERRORS = [
        '1'  => 'дубликат значения',
        '2'  => 'пустое значенине',
        '3'  => 'invalid_argument',
        '4'  => 'missing_argument',
        '5'  => 'invalid_data = 5',
        '6'  => 'объект не найден',
        '7'  => 'bad_request',
        '8'  => 'trigger',
        '9'  => 'few_resources',
        '10' => 'no_funds',
        '11' => 'data',
        '12' => 'missing_variable',
        '13' => 'объект заблокировн для редактирования',
        '14' => 'invoice_line_alresdy_used',
        '15' => 'счет уже выставлен',
        '16' => 'объект заблокирован',
        '17' => 'obsolete',
        '18' => 'такой тип блокировки уже существует',
        '19' => 'Неверная дата блокирвоки',
        '20' => 'дата блокировки уже устарела',
        '21' => 'превышен максимальный размер файла',
        '22' => 'очередь переполнена',
        '23' => 'dublicate_field',
        '24' => 'excluding_field',
        '25' => 'unknown_field',
        '26' => 'unknown_argument',
        '27' => 'биллинг уже запущен',
        '28' => 'у клиента не нулевой баланс (нельзя удалить)',
        '29' => 'has_subsctibe',
        '30' => 'запрещенное значенине',
        '31' => 'negative_amount',
        '32' => 'stack_overflow, скорее всего последовательность созданных правил вызвала бесконечный цикл',
        '33' => 'invalid_status',
        '34' => 'no_funds_revenues',
        '35' => 'block_licence',
        '36' => 'максимальное число килентов',
        '37' => 'var_is_used',
        '-1' => 'неизвестная ошибка',
    ];

    /**
     * Create a new exception instance.
     *
     * @param string $json
     * @return void
     */
    public function __construct($json)
    {
        $errors = [];
        $data = json_decode($json);
        if (isset($data->errors)) {
            foreach ($data->errors as $error) {
                $errors[] = self::ERRORS[$error->code];
            }
        }

        parent::__construct(implode('; ', $errors));
    }
}
