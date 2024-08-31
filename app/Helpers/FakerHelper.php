<?php

namespace App\Helpers;

use App\Models\EndpointObject;

class FakerHelper
{
    public static function fieldTypes(): array
    {
        $objects = \Auth::user()->endpointObjects()->get()->pluck('name')->toArray();
        return ['Number', 'String', ...array_values($objects)];
    }

    public static function transform($json)
    {
        // Декодируем входной JSON
        $data = json_decode($json, true);

        $result = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Определяем тип данных
                if ($key === 'Number') {
                    // Если это числа, добавляем их как есть
                    $result[$value[0]] = (int)$value[1];
                } elseif ($key === 'String') {
                    // Если это строки, добавляем их как пары ключ-значение
                    $result[$value[0]] = $value[1];
                }
            } else {
                // Обработка объектов
                $endpointObject = EndpointObject::where('name', $key)->first();
                if ($endpointObject) {
                    $result[$key] = $endpointObject->getTransformedData();
                } else {
                    $result[$key] = 'Object not found or recursion guard';
                }
            }
        }

        return json_encode($result);
    }

    public static function patterns(): array
    {
        return ['name',
            'firstName',
            'lastName',
            'title',
            'userName',
            'email',
            'safeEmail',
            'freeEmail',
            'companyEmail',
            'freeEmailDomain',
            'safeEmailDomain',
            'companyEmailDomain',
            'domainName',
            'domainWord',
            'tld',
            'ipv4',
            'ipv6',
            'macAddress',
            'slug',
            'url',
            'uri',
            'userAgent',
            'password',
            'md5',
            'sha1',
            'sha256',
            'locale',
            'country',
            'countryCode',
            'city',
            'streetName',
            'streetAddress',
            'postcode',
            'address',
            'secondaryAddress',
            'state',
            'stateAbbr',
            'latitude',
            'longitude',
            'phoneNumber',
            'e164PhoneNumber',
            'company',
            'companySuffix',
            'jobTitle',
            'catchPhrase',
            'bs',
            'paragraph',
            'text',
            'sentence',
            'word',
            'words',
            'date',
            'time',
            'dateTime',
            'dateTimeAD',
            'iso8601',
            'unixTime',
            'dateTimeThisCentury',
            'dateTimeThisDecade',
            'dateTimeThisYear',
            'dateTimeThisMonth',
            'amPm',
            'dayOfMonth',
            'dayOfWeek',
            'month',
            'monthName',
            'year',
            'century',
            'timezone',
            'unixTime',
            'uuid',
            'boolean',
            'randomDigit',
            'randomDigitNotNull',
            'randomNumber',
            'randomFloat',
            'numberBetween',
            'randomElement',
            'randomElements',
            'shuffle',
            'randomLetter',
            'randomAscii',
            'randomKey',
            'randomHtmlColor',
            'rgbColor',
            'rgbCssColor',
            'safeColorName',
            'colorName',
            'hexColor',
            'boolean',
            'biasedNumberBetween',
            'isbn10',
            'isbn13',
            'ean13',
            'ean8',
            'swiftBicNumber',
            'iban',
            'ibanLetter',
            'bankAccountNumber',
            'countryISOAlpha3',
            'currencyCode',
            'languageCode',
            'languageName',
            'mimeType',
            'fileExtension',
            'file',
            'mimeType',
            'uuid',
            'hexColor',
            'citySuffix',
            'cityPrefix',
            'streetSuffix',
            'buildingNumber',
            'secondaryAddress',
            'county',
            'state',
            'stateAbbr',
            'countryCode',
            'countryISOAlpha3',
            'latitude',
            'longitude',
            'password',
            'md5',
            'sha1',
            'sha256',
            'locale',
            'iso8601',
            'unixTime',
            'dateTime',
            'dateTimeThisCentury',
            'dateTimeThisDecade',
            'dateTimeThisYear',
            'dateTimeThisMonth',
            'amPm',
            'dayOfMonth',
            'dayOfWeek',
            'month',
            'monthName',
            'year',
            'century',
            'timezone',
            'biasedNumberBetween',
            'dateTimeBetween',];
    }

    public static function processPattern(string $pattern)
    {
        return fake()->$pattern;
    }
}
