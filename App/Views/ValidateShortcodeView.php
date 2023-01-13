<?php

namespace CEDP\WPEOL\App\Views;

class ValidateShortcodeView extends AbstractShortcodeView
{
    protected function _render(array $atts = []): void{
        ?>
            <p class="<?= $atts['hasColor'] ? 'text-'.$atts['status'] : '' ?>"> <?= $atts['status'] ?></p>
        <?php
    }
}