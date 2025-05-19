<?php

namespace Views\Helpers;

class RenderHelper
{
    public static function renderTemplate($templatePath, $params = [])
    {
        extract($params);
        require $templatePath;
    }
}