<?php 

// app/Gateways/SmsGatewayManager.php
namespace App\Gateways;

class SmsGatewayManager
{
    protected $gateways = [];

    public function __construct()
    {
        $this->loadDefaultGateways();
        $this->loadUserDefinedGateways();
    }

    protected function loadDefaultGateways()
    {
        // Load default gateways, as before
        $this->registerGateway('africastalking', AfricastalkingSmsGateway::class);
        // Register other default gateways...
    }

    protected function loadUserDefinedGateways()
    {
        $userDefinedGatewayPath = app_path('Gateways/UserDefined');

        foreach (scandir($userDefinedGatewayPath) as $file) {
            $filePath = $userDefinedGatewayPath . DIRECTORY_SEPARATOR . $file;

            if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $gatewayName = pathinfo($file, PATHINFO_FILENAME);
                $gatewayClass = 'App\\Gateways\\UserDefined\\' . $gatewayName . 'SmsGateway';

                $this->registerGateway($gatewayName, $gatewayClass);
            }
        }
    }

    public function registerGateway($name, $class)
    {
        $this->gateways[$name] = $class;
    }

    public function loadGateway($name)
    {
        $gatewayClassName = 'App\\Gateways\\UserDefined\\' . ucfirst($name) . 'SmsGateway';

        if (class_exists($gatewayClassName)) {
            return new $gatewayClassName();
        }

        return null;
    }

    public function getAvailableGateways()
    {
        return array_keys($this->gateways);
    }
}

