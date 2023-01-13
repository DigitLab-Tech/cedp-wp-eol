<?php

namespace CEDP\WPEOL\App\Views;

class LatestShortcodeView extends AbstractShortcodeView
{
    protected function _render(array $atts = []): void{
        ?>
            <p> <?= $atts['latest'] ?>
        <?php
    }
}