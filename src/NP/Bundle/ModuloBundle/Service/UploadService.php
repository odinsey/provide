<?php

namespace NP\Bundle\ModuloBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\DependencyInjection\Container;
use NP\Bundle\ModuloBundle\Entity\Picture;
use Imagine\Image\Box;

class UploadService {

    protected $filesystem;
    protected $imagine;
    protected $container;

    public function __construct(Container $container) {
	$this->container = $container;
	$this->filesystem = $container->get('filesystem');
	$this->imagine = $container->get('imagine');
    }

    public function uploadFile($path, UploadedFile $file) {
	if (!$file->isValid()) {
	    return false;
	}

	$filename = pathinfo($path, PATHINFO_BASENAME);
	$path = pathinfo($path, PATHINFO_DIRNAME);


	$this->checkFolder($path);

	if ($this->isImage($path . '/' . $filename)) {
	    $orig = $this->imagine->open($file->getRealPath());
	    foreach (Picture::$FILE_TYPES as $type => $conf) {
		$thumb = $orig->copy();
		if ($conf['type'] == 'thumbnail') {
		    $thumb = $thumb->thumbnail(new Box($conf['width'], $conf['height']), $conf['thumbnail_type']);
		} elseif ($conf['type'] == 'relative_resize') {
		    $box = new Box($thumb->getSize()->getWidth(), $thumb->getSize()->getHeight());
		    $box = $box->widen($conf['width']);
		    $box = $box->heighten($conf['height']);
		    $thumb->resize($box);
		}
		$thumb->save(strtolower(str_replace('##TYPE##', $type, $path . '/' . $filename)), array('quality' => 80));
	    }
	} else {

	    $move = $file->move(
		$path, $filename
	    );

	    if (!$move instanceof File) {
		return false;
	    }
	}

	return $filename;
    }

    public function removeFile($path) {
	if ($this->isImage($path)) {
	    foreach (Picture::$FILE_TYPES as $type => $conf) {
		$this->filesystem->remove(sprintf($path, $type));
	    }
	} else {
	    $this->filesystem->remove($path);
	}
    }

    public function checkFolder($path) {
	if (!$this->filesystem->exists($path)) {
	    $this->filesystem->mkdir($path);
	}
    }

    public function isImage($path) {
	if (preg_match('/.(jpg|jpeg|png|gif)$/ims', $path)) {
	    return true;
	} else {
	    return false;
	}
    }

}

?>
