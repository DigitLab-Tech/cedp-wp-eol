<?php

namespace CEDP\WPEOL\App;

class EndOfLifeApi
{
    const URL = 'https://endoflife.date/api/wordpress.json';
    
    static function Get(){
        $currentDate = current_datetime();
        $currentDatetimeString = $currentDate->format('Y-m-d H:i:s');
        $eolJson = file_get_contents(self::URL);

        if($eolJson !== false && json_decode($eolJson) !== null){
            update_option('cedp_version_endoflife_json', $eolJson);
            update_option('cedp_version_last_endoflife_sync_timestamp', $currentDate->getTimestamp());
            update_option('cedp_version_last_endoflife_sync_datetime', $currentDatetimeString);
            return $eolJson;
        }
        else{
            update_option('cedp_version_endoflife_json', null);
            update_option('cedp_version_last_endoflife_sync_datetime', 'Something went wrong with the synchronisation');
            return null;
        }
    }

    static function GetCached(int $refreshDelay = 86400){
        $lastSyncTS = get_option('cedp_version_last_endoflife_sync_timestamp');
        $lastSyncTS = $lastSyncTS !== false ? $lastSyncTS : 0;

        if(current_datetime()->getTimestamp() - $lastSyncTS > $refreshDelay){
            return self::Get();
        }
        else{
            return get_option('cedp_version_endoflife_json');
        }
    }
}