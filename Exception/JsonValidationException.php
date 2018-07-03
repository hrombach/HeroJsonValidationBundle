<?php

declare(strict_types=1);

/**
 * @copyright  Copyright (c) 2018, Net Inventors GmbH
 * @category   steef
 * @author     hrombach
 */

namespace Hero\Bundle\JsonValidation\Exception;

class JsonValidationException extends \RuntimeException
{
    protected const MESSAGE_VALIDATION_FAILED = 'JSON Request body validation failed.';
    protected const MESSAGE_SCHEMA_NOT_FOUND = 'Could not find schema file at %s';

    public const CODE_VALIDATION_FAILED = 1;
    public const CODE_SCHEMA_NOT_FOUND = 2;
}