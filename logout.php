<?php
require_once 'business.class.php';

if(User::getLoggedUser()){
	User::logout();
}

header('Location: index.php');