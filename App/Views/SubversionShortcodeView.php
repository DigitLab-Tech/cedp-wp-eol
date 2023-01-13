<?php

namespace CEDP\WPEOL\App\Views;

class SubversionShortcodeView extends AbstractShortcodeView
{
    protected function _render(array $atts = []): void{
        ?>
            <table class="table--subversions">
                <tr>
                    <td>Branch <?= $atts['cycle'] ?> </td>
                </tr>
                <?php foreach($atts['subversions'] as $subversion): ?>
                    <tr>
                        <td> <?= $subversion ?> </td>
                    </tr>
                <?php endforeach ?>
            </table>
        <?php
    }
}