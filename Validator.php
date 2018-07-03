<?php

declare(strict_types=1);

/**
 * @copyright  Copyright (c) 2018, Net Inventors GmbH
 * @category   steef
 * @author     hrombach
 */

namespace Hero\Bundle\JsonValidation;

use Hero\Bundle\JsonValidation\Exception\{
    JsonSchemaNotFoundException, JsonValidationFailedException
};
use JsonSchema\{
    Constraints\Constraint, Validator as JsonValidator
};
use Symfony\Component\HttpFoundation\Request;

class Validator
{
    /**
     * @var string
     */
    private $schemaDir;

    public function __construct(string $projectDir)
    {
        $this->schemaDir = $projectDir.'/public/schema';
    }

    /**
     * @param Request $request
     * @param string $schemaFilePath
     *
     * @return \stdClass
     *
     * @throws JsonValidationFailedException
     * @throws JsonSchemaNotFoundException
     */
    public function validateRequest(Request $request, string $schemaFilePath = ''): \stdClass
    {
        if ('' === $schemaFilePath) {
            $schemaFilePath = $this->schemaDir.\DIRECTORY_SEPARATOR.$request->get('_route').'.schema.json';
        } elseif (\DIRECTORY_SEPARATOR !== $schemaFilePath[0]) {
            $schemaFilePath = $this->schemaDir.\DIRECTORY_SEPARATOR.$schemaFilePath;
        }

        if (!\is_file($schemaFilePath) || !\is_readable($schemaFilePath)) {
            throw JsonSchemaNotFoundException::withPath($schemaFilePath);
        }

        $payload = \json_decode($request->getContent()) ?? new \stdClass();

        if (!$payload instanceof \stdClass) {
            throw new JsonValidationFailedException('Json Request validation failed: Must be object');
        }

        $this->validate($payload, $schemaFilePath);

        return $payload;
    }

    /**
     * @param \stdClass $payload
     * @param string $schemaFilePath - if no fully qualified path is provided, the schema dir will be prepended
     *
     * @throws JsonValidationFailedException
     */
    public function validate(\stdClass $payload, string $schemaFilePath): void
    {
        $validator = new JsonValidator();
        $validator->validate(
            $payload,
            (object)['$ref' => 'file://'.$schemaFilePath],
            Constraint::CHECK_MODE_APPLY_DEFAULTS |
            Constraint::CHECK_MODE_COERCE_TYPES |
            Constraint::CHECK_MODE_ONLY_REQUIRED_DEFAULTS
        );

        if (!$validator->isValid()) {
            throw JsonValidationFailedException::withErrors($validator->getErrors());
        }
    }
}