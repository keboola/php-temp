<?php
/**
 * User: kachnitel
 * Date: 7/12/13
 * Time: 3:32 PM
 */

namespace Keboola\Temp\Tests;

use Keboola\Temp\Temp;

class TempTest extends \PHPUnit_Framework_TestCase
{

	public function testCreateTmpFile()
	{
		$temp = new Temp('test');
		/** @var \SplFileInfo $file */
		$file = $temp->createTmpFile('filename_suffix');
		$this->assertFileExists($file->getPathName());
	}

}
