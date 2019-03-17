<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/constants/session.php';

session_name('session_id');
session_start();
setcookie(session_name(), session_id(), time() + LIFETIME_SESSION);