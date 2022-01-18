<?php

namespace App\Factory;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Brand>
 *
 * @method static Brand|Proxy createOne(array $attributes = [])
 * @method static Brand[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Brand|Proxy find(object|array|mixed $criteria)
 * @method static Brand|Proxy findOrCreate(array $attributes)
 * @method static Brand|Proxy first(string $sortedField = 'id')
 * @method static Brand|Proxy last(string $sortedField = 'id')
 * @method static Brand|Proxy random(array $attributes = [])
 * @method static Brand|Proxy randomOrCreate(array $attributes = [])
 * @method static Brand[]|Proxy[] all()
 * @method static Brand[]|Proxy[] findBy(array $attributes)
 * @method static Brand[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Brand[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BrandRepository|RepositoryProxy repository()
 * @method Brand|Proxy create(array|callable $attributes = [])
 */
final class BrandFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->text(5,10),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Brand $brand): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Brand::class;
    }
}
