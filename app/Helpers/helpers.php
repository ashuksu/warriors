<?php

namespace Helpers;

function renderTemplate($templatePath, $params = [])
{
    extract($params);
    require $templatePath;
}