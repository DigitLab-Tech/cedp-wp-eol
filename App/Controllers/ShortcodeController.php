<?php

namespace CEDP\WPEOL\App\Controllers;

use CEDP\WPEOL\App\Views\LatestShortcodeView;
use CEDP\WPEOL\App\Views\SubversionShortcodeView;
use CEDP\WPEOL\App\Views\ValidateShortcodeView;
use CEDP\WPEOL\App\Views\MineShortcodeView;
use CEDP\WPEOL\App\Services\EoLVersionsService;

class ShortcodeController
{   
    public LatestShortcodeView $latestShortcodeView;
    public SubversionShortcodeView $subversionShortcodeView;
    public ValidateShortcodeView $validateShortcodeView;
    public MineShortcodeView $mineShortcodeView;
    public EoLVersionsService $versionsService;

    public function __construct()
    {
        $this->latestShortcodeView = new LatestShortcodeView();
        $this->subversionShortcodeView = new SubversionShortcodeView();
        $this->validateShortcodeView = new ValidateShortcodeView();
        $this->mineShortcodeView = new MineShortcodeView();
        $this->versionsService = new EoLVersionsService();
    }

    public function execute($atts){
        if(!$this->versionsService->isDataValid()){
            return 'Something went wrong with the synchronisation';
        }

        if(is_array($atts) && isset($atts['type'])){
            $hasColor = ($atts['color'] ?? 'yes') === 'no' ? false : true; 

            switch($atts['type']){
                case 'latest':
                    return $this->latestShortcodeView->render(['latest' => $this->versionsService->getLatest()]);

                case 'subversion':
                    if(!isset($atts['version'])){
                        return 'Error shortcode attribute missing: version';
                    }

                    if(!$this->versionsService->validateVersion($atts['version'])){
                        return 'Invalid version number';
                    }

                    return $this->subversionShortcodeView->Render([
                        'cycle' => $atts['version'],
                        'subversions' => $this->versionsService->getSubversions($atts['version'])
                    ]);

                case 'validate':
                    if(!isset($atts['version'])){
                        return 'Error shortcode attribute missing: version';
                    }

                    if(!$this->versionsService->validateVersion($atts['version'])){
                        return 'Invalid version number';
                    }

                    $status = $this->versionsService->getVersionStatus($atts['version']);

                    return $this->validateShortcodeView->Render([
                        'status' => $status,
                        'versionColor' => $hasColor ? $status : '',
                        'hasColor' => $hasColor
                    ]);

                case 'mine':
                    $currentVersion = get_bloginfo('version');

                    return $this->mineShortcodeView->Render([
                        'currentVersion' => $currentVersion,
                        'versionColor' => $hasColor ? $this->versionsService->getVersionStatus($currentVersion) : '',
                        'hasColor' => $hasColor
                    ]);
            }

            return 'Invalid type';
        }
    }
}