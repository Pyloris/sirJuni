<?php
require_once __DIR__ . "/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;

use sirJuni\Framework\Components\Request;


final class RequestTest extends TestCase
{
    private $backupFiles = NULL;

    public function setUp(): void {
        $this->backupFiles = $_FILES;

        $_FILES['input_file'] = [
            'name' => 'filename.ext',
            'type' => 'image/jpg',
            'error' => 4040,
            'tmp_name' => 'wwzz.tmp'
        ];
    }

    public function tearDown(): void {
        $_FILES = $this->backupFiles;
    }

    public function testFileSize() {
        $request = new Request();

        $size = $request->fileSize('input_file');

        $this->assertSame(NULL, $size);
    }

    public function testFileMIME() {
        $request = new Request();

        $type = $request->fileMIME('input_file');

        $this->assertSame('image/jpg', $type);
    }

    public function testFileError() {
        $request = new Request();

        $error = $request->fileError('input_file');

        $this->assertSame(4040, $error);
    }

    public function testFile() {
        $request = new Request();

        $tmp_name = $request->File('input_file');

        $this->assertSame('wwzz.tmp', $tmp_name);
    }

    public function testFileName() {
        $request = new Request();

        $name = $request->fileName('input_file');
        $this->assertSame('filename.ext', $name);
    }

    public function testGetExtension() {
        $request = new Request();
        
        $ext = $request->getExtension('input_file');
        $this->assertSame('ext', $ext);
    }
}
?>