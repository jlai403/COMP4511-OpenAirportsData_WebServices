<?php

abstract class BaseController {
    public function invokeAction($action) {
        call_user_func(array($this, $action));
    }
} 