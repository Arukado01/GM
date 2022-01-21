<?php

namespace App\Helpers;

class StringHelpers
{
    public static function getToolTip($text, $limit = 5, $delimiter = '...')
    {
        $shortText = str_limit($text, $limit, $delimiter);
        $html = <<<EOT
            <div class="tooltip-core">
                <span class="tooltip-core-text-base">{$shortText}</span>
                <span class="tooltiptext-core" data-placement="top">
                    {$text}
                </span>
            </div>
EOT;

        return $html;
    }

    public static function getProgressBar($value)
    {
        $html = <<<EOT
            <div class="text-center">
                {$value}%
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        style="width: {$value}%;" 
                        aria-valuenow="{$value}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
EOT;
        return $html;
    }

    public static function getBtn($route, $text, $isData = true, $icon = 'save', $btnType = null, $classActionName = '', $target = null)
    {
        $btnType = empty($btnType) || $btnType == null ? 'success' : $btnType;
        $target = empty($target) || $target == null ? '' : $target;

        $dataUrl = '';
        $hrefUrl = '';

        if($isData) {
            $dataUrl = 'data-url="' . $route . '"';
        }else{
            $hrefUrl = $route;
        }
        $html = <<<EOT
                        <div class="tooltip-core">
                            <a href="{$hrefUrl}" class="btn btn-sm btn-{$btnType} {$classActionName}" title="" 
                                target="{$target}" $dataUrl><i class="fa fa-{$icon}"></i>
                            </a>
                            <span class="tooltiptext-core">$text</span>
                        </div>
EOT;

        return $html;
    }
}