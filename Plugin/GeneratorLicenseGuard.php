<?php
declare(strict_types=1);

namespace Etechflow\Sitemap\Plugin;

use Etechflow\Sitemap\Model\Generator;
use Etechflow\Sitemap\Model\LicenseValidator;

/**
 * Gates sitemap generation behind a valid eTechFlow licence.
 *
 * A valid licence (SP-key validated by the portal, or the shared eTechFlow
 * bundle key) is ALWAYS required. Without one nothing is generated, covering
 * every entry point: the cron job, the CLI command and the admin grid.
 */
class GeneratorLicenseGuard
{
    public function __construct(
        private readonly LicenseValidator $licenseValidator
    ) {
    }

    public function aroundGenerate(Generator $subject, callable $proceed): array
    {
        if (!$this->licenseValidator->isValid()) {
            return [];
        }

        return $proceed();
    }
}
