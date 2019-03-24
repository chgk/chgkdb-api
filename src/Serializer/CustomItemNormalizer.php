<?php

namespace App\Serializer;

use ApiPlatform\Core\Api\IriConverterInterface;
use ApiPlatform\Core\Exception\ItemNotFoundException;
use ApiPlatform\Core\Serializer\ItemNormalizer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class CustomItemNormalizer  implements NormalizerInterface, DenormalizerInterface
{
    private $normalizer;
    /**
     * @var IriConverterInterface
     */
    private $iriConverter;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ItemNormalizer $normalizer
     * @param IriConverterInterface $iriConverter
     * @param LoggerInterface $logger
     */
    public function __construct(ItemNormalizer $normalizer, IriConverterInterface $iriConverter, LoggerInterface $logger)
    {
        $this->normalizer = $normalizer;
        $this->iriConverter = $iriConverter;
        $this->logger = $logger;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (isset($data['id']) && !isset($context[AbstractNormalizer::OBJECT_TO_POPULATE])) {
            if (isset($context['api_allow_update']) && true !== $context['api_allow_update']) {
                throw new NotNormalizableValueException('Update is not allowed for this operation.');
            }

            if (isset($context['resource_class'])) {
                try {
                    $context[AbstractNormalizer::OBJECT_TO_POPULATE] =
                        $this->iriConverter->getItemFromIri(
                            sprintf('%s/%s', $this->iriConverter->getIriFromResourceClass($context['resource_class']), $data['id']),
                            $context + ['fetch_data' => true]
                        );
                } catch (ItemNotFoundException $exception) {
                    $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $data;
                    //It is ok -- new item
                    //The decorator is especially for this catch
                }
            } else {
                // See https://github.com/api-platform/core/pull/2326 to understand this message.
                $this->logger->warning('The "resource_class" key is missing from the context.', [
                    'context' => $context,
                ]);
            }
        }

        return $this->normalizer->denormalize($data, $class, $format, $context);
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $this->normalizer->supportsDenormalization($data, $type, $format);
    }

    public function normalize($object, $format = null, array $context = [])
    {
        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->normalizer->supportsNormalization($data, $format);
    }
}
