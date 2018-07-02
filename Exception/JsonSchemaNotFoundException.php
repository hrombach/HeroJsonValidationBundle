<?php

declare(strict_types=1);

/**
 * @copyright  Copyright (c) 2018, Net Inventors GmbH
 * @category   peggy
 * @author     hrombach
 */

namespace Hero\Bundle\JsonValidation\Exception;

final class JsonSchemaNotFoundException extends JsonValidationException
{
    public static function withPath(string $path) : self
    {
        return new self(\sprintf(self::MESSAGE_SCHEMA_NOT_FOUND, $path), self::CODE_SCHEMA_NOT_FOUND);
    }
}