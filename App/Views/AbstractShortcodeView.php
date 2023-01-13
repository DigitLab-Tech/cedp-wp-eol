<?php

namespace CEDP\WPEOL\App\Views;

abstract class AbstractShortcodeView
{
    public function render(array $atts = []): string{
        ob_start();
        $this->_render($atts);
        return ob_get_clean();
    }

    protected abstract function _render(array $atts = []): void;
}