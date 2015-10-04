<?php
namespace FeatureToggle\Test\Storage;

use FeatureToggle\Feature\BooleanFeature;
use FeatureToggle\Feature\EnabledFeature;
use FeatureToggle\Storage\FileStorage;

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

    public function testAdd()
    {
        $feature = new BooleanFeature();
        $expected = $this->path . 'foo';
        $this->storage->add('foo', $feature);
        $this->assertFileExists($expected);
        $this->assertStringEqualsFile($expected, serialize($feature));
    }

    public function testGet()
    {
        $expected = new BooleanFeature();
        $this->storage->add('foo', $expected);
        $result = $this->storage->get('foo');
        $this->assertEquals($expected, $result);
    }

    public function testIndex()
    {
        $boolean = new BooleanFeature();
        $enabled = new EnabledFeature();

        $this->storage->add('boolean', $boolean);
        $this->storage->add('enabled', $enabled);

        $result = $this->storage->index();
        $expected = compact('boolean', 'enabled');
        $this->assertEquals($expected, $result);
    }

    public function testRemove()
    {
        $boolean = new BooleanFeature();
        $enabled = new EnabledFeature();

        $this->storage->add('boolean', $boolean);
        $this->storage->add('enabled', $enabled);

        $this->assertInstanceOf('FeatureToggle\Storage\FileStorage', $this->storage->remove('enabled'));

        $result = $this->storage->index();
        $expected = compact('boolean');
        $this->assertEquals($expected, $result);
    }

    public function testFlush()
    {
        $boolean = new BooleanFeature();
        $enabled = new EnabledFeature();

        $this->storage->add('boolean', $boolean);
        $this->storage->add('enabled', $enabled);

        $this->assertInstanceOf('FeatureToggle\Storage\FileStorage', $this->storage->flush());
        $this->assertFileNotExists($this->path);
    }
}
