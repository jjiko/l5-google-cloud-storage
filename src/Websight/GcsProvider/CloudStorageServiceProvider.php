<?php

namespace Websight\GcsProvider;

use CedricZiel\FlysystemGcs\GoogleCloudStorageAdapter;
use Google\Cloud\ServiceBuilder;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Storage;

/**
 * Class CloudStorageServiceProvider
 * Configures Google Cloud Storage Access for flysystem
 *
 * @package Websight\GcsProvider
 */
class CloudStorageServiceProvider extends ServiceProvider
{
  /**
   * {@inheritdoc}
   */
  public function boot()
  {
    Storage::extend('gcs', function ($app, $config) {

      $adapterConfiguration = ['bucket' => $config['bucket']];
      $optionalServiceBuilder = null;

      if (array_key_exists('project_id', $config) && false === empty($config['project_id'])) {
        $adapterConfiguration += ['projectId' => $config['project_id']];
      }

      if (array_key_exists('credentials', $config) && false === empty($config['credentials'])) {
        $adapterConfiguration += ['keyFilePath' => $config['credentials']];
      }

      $adapter = new GoogleCloudStorageAdapter(null, $adapterConfiguration);

      return new Filesystem($adapter);
    });
  }
}
