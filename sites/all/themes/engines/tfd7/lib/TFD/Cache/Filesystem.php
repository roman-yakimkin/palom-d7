<?php

/**
 * Class TFD_Cache_Filesystem.
 */
class TFD_Cache_Filesystem extends Twig_Cache_Filesystem implements Twig_CacheInterface {

  /**
   * The scheme wrapper.
   *
   * @var DrupalLocalStreamWrapper
   */
  private $scheme_wrapper;

  /**
   * Class constructor.
   *
   * @param string $cache_scheme
   *   The cache scheme.
   */
  public function __construct($cache_scheme) {
    if ($cache_scheme instanceof DrupalStreamWrapperInterface) {
      $this->scheme_wrapper = $cache_scheme;
    }
    else {
      $this->scheme_wrapper = file_stream_wrapper_get_instance_by_scheme(file_uri_scheme($cache_scheme));
    }
    parent::__construct($this->scheme_wrapper->getDirectoryPath());
  }

  /**
   * Removes all files in this bin.
   */
  public function deleteAll() {
    return $this->unlink($this->scheme_wrapper->getDirectoryPath());
  }

  /**
   * Deletes files and/or directories in the specified path.
   *
   * @param string $dir
   *   A string containing a directory path.
   *
   * @return bool
   *   Return TRUE for success.
   */
  protected function unlink($dir) {
    $di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
    $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);

    foreach ( $ri as $file ) {
      $file->isDir() ?  rmdir($file) : unlink($file);
    }

    return TRUE;
  }

}
