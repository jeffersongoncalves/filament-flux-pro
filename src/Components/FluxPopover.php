<?php

namespace Jeffersongoncalves\FilamentFluxPro\Components;

use Illuminate\Support\HtmlString;

class FluxPopover
{
    public static function trigger(string $triggerHtml, string $contentHtml, string $position = 'bottom'): HtmlString
    {
        $position = htmlspecialchars($position, ENT_QUOTES, 'UTF-8');

        $markup = <<<HTML
<flux:popover position="{$position}">
    {$triggerHtml}
    <flux:popover.content>
        {$contentHtml}
    </flux:popover.content>
</flux:popover>
HTML;

        return new HtmlString($markup);
    }
}
