<?php

namespace CEDP\WPEOL\App\Views;

class MineShortcodeView extends AbstractShortcodeView
{
    protected function _render(array $atts = []): void{
        ?>
            <p class="<?= $atts['hasColor'] ? 'text-'.$atts['versionColor'] : '' ?>"> <?= $atts['currentVersion'] ?></p>
        <?php
    }
}