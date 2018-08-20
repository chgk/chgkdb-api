<?php

namespace App\PathResolver;

use ApiPlatform\Core\Api\OperationType;
use ApiPlatform\Core\PathResolver\OperationPathResolverInterface;
use Doctrine\Common\Inflector\Inflector;

class ChgkOperationPathResolver implements OperationPathResolverInterface
{
    public function resolveOperationPath(
        string $resourceShortName,
        array $operation,
        $operationType/*, string $operationName = null*/
    ): string
    {
        if (isset($operation['path'])) {
            return $operation['path'];
        }

        $path = Inflector::pluralize(strtolower($resourceShortName));
        if ($operationType != OperationType::COLLECTION) {
            $path .= '/{id}';
        }
#        $path .= '.{_format}';

        return $path;
    }
}
