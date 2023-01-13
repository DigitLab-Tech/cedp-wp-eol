<?php

namespace CEDP\WPEOL\App\Views;

class SettingsView
{
    function Render(){ ?>
        <h1 class="title title--settings">CEDP WP-EOL</h1>
        <div class="wrapper--settings">
        <button 
            id="btn_sync" 
            class="btn btn--sync" 
            data-ajax-url="admin-ajax.php?action=endoflife_sync&nonce=<?= wp_create_nonce("endoflife_nonce") ?>"
        >
            Synchronise
        </button>
        <p>
            Last Updated: 
            <span id="last_sync_date">
                <?= get_option('cedp_version_last_endoflife_sync_datetime', '') ?>
            <span>
        </p>
    </div>
    <?php }
}