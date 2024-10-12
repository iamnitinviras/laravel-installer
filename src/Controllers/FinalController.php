<?php

namespace IamNitinViras\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use IamNitinViras\LaravelInstaller\Events\LaravelInstallerFinished;
use IamNitinViras\LaravelInstaller\Helpers\EnvironmentManager;
use IamNitinViras\LaravelInstaller\Helpers\FinalInstallManager;
use IamNitinViras\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \IamNitinViras\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \IamNitinViras\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \IamNitinViras\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
