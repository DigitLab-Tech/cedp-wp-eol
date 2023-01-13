<?php

namespace CEDP\WPEOL\App\Controllers;
use CEDP\WPEOL\App\EndOfLifeApi;
use CEDP\WPEOL\App\AjaxResponse;

class AjaxAdminController
{   
    public function endoflife_sync(){
        $response = new AjaxResponse();

        if(EndOfLifeApi::Get()){
            $response->setData(['updated_at' => get_option('cedp_version_last_endoflife_sync_datetime', '')]);
        }
        else{
            $response->setHasError(true);
            $response->setMsg('Something went wrong with the synchronisation');
        }

        echo $response->toJson();
        wp_die();
    }
}