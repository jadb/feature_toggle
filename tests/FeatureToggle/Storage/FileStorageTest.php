<?php declare(strict_types=1);

namespace FeatureToggle\Test\Storage;

use FeatureToggle\Feature\BooleanFeature;
use FeatureToggle\Feature\EnabledFeature;
use FeatureToggle\FeatureFactory;
use FeatureToggle\Storage\FileStorage;
use FeatureToggle\Strategy\DateTimeStrategy;

class FileStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var \FeatureToggle\Storage\FileStorage
     */
    protected $storage;

    public function setUp()
    {
        $this->path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ft' . DIRECTORY_SEPARATOR;
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777);
        }

        $this->storage = new FileStorage($this->path);
    }

    public function tearDown()
    {
        try {
            foreach (new \DirectoryIterator($this->path) as $file) {
                $filename = $file->getFilename();
                if (trim($filename, '.')) {
                    unlink($this->path . $filename);
                }
            }
            rmdir($this->path);
        } catch (\Exception $e) {
        }
        unset($this->path);
    }

    /**
     * @test
     */
    public function itShouldWriteSerializedObjectToFile()
    {
        $feature = new BooleanFeature('foo');
        $expected = $this->path . 'foo';
        $this->storage->add('foo', $feature);
        $this->assertFileExists($expected);
        $this->assertStringEqualsFile($expected, serialize($feature));
    }

    /**
     * @test
     */
    public function itShouldUnserializeObjectFromFile()
    {
        $expected = FeatureFactory::buildFeature('foo', [
            'type' => 'threshold',
            'description' => 'bar',
            'strategies' => [
                DateTimeStrategy::class => [new \DateTime('now')]
            ]
        ])->threshold(3);
        $this->storage->add('foo', $expected);
        $result = $this->storage->get('foo');
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function itShouldListAllSerializedObjectsFromFile()
    {
        $boolean = new BooleanFeature('foo');
        $enabled = new EnabledFeature('bar');

        $this->storage->add('boolean', $boolean);
        $this->storage->add('enabled', $enabled);

        $result = $this->storage->index();
        $expected = compact('boolean', 'enabled');
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function itShouldRemoveSpecifiedObjectsFromFile()
    {
        $boolean = new BooleanFeature('foo');
        $enabled = new EnabledFeature('bar');

        $this->storage->add('boolean', $boolean);
        $this->storage->add('enabled', $enabled);

        $this->assertInstanceOf(FileStorage::class, $this->storage->remove('enabled'));

        $result = $this->storage->index();
        $expected = compact('boolean');
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function itShouldDeleteAllSerializedObjectsFromFile()
    {
        $boolean = new BooleanFeature('foo');
        $enabled = new EnabledFeature('bar');

        $this->storage->add('boolean', $boolean);
        $this->storage->add('enabled', $enabled);

        $this->assertInstanceOf(FileStorage::class, $this->storage->flush());
        $this->assertFileNotExists($this->path);
    }
}
