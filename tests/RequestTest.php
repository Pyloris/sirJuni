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

    public function testFileMethods() {
        $request = new Request();

        $this->assertSame('filename.ext', $request->fileName('input_file'));
        $this->assertSame('image/jpg', $request->fileMIME('input_file'));
        $this->assertSame('wwzz.tmp', $request->File('input_file'));
        $this->assertSame(4040, $request->fileError('input_file'));
        $this->assertSame('ext', $request->fileExtension('input_file'));
    } 
}
?>