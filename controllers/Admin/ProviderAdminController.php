<?php

namespace Controllers\Admin;

use Interfaces\ProviderServiceInterface;
use Models\Provider;

class ProviderAdminController
{
  private $providerService;
  public function __construct(ProviderServiceInterface $providerService)
  {
    $this->providerService = $providerService;
  }

  public function showProviders()
  {
    $providers = $this->providerService->findAll();
    require __DIR__ . '/../../views/admin/providers.php';
  }

  public function createProvider()
  {
    $name = $_POST['name'];
    $state = 1;
    $provider = new Provider($name, $state);


    if ($this->providerService->create($provider)) {
      echo "<script>
      window.location.href = '/apps/theowl/public/admin/dashboard';</script>";
      exit;
    }
    require __DIR__ . '/../../views/admin/create_provider.php';
  }

  public function editProvider()
  {
    $name = $_POST['name'];
    $providerId = $_POST['providerId'];
    $provider = $this->providerService->find($providerId);
    if ($provider) {
      $providerToEdit = new Provider($name, $provider['Estado']);
      if ($this->providerService->update($providerId, $providerToEdit)) {
        echo "<script>
      window.location.href = '/apps/theowl/public/admin/dashboard';</script>";
        exit;
      }
    }
  }
}
