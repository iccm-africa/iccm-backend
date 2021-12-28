<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintedItemsController extends Controller
{
	public function __construct() {
		$this->middleware('admin');
	}

	public function directory() {
		// load directory
		/*
			* preferred name (nickname)
			* Other name
			* Organization
			* Email 
			* Talents (postreg)
			* Soon implemented (postreg)
			* etc (postreg)
			* Notes
		*/
	}

	public function roomsigns() {
		/*
			* what is running in this room
			* Workshop / BOF
		*/
	}
	
	public function prayerpals() {
		/* 
			* random shared users per group
			* min of 2
		*/
	}

	public function nametags() {
		// nametages per user
	}

	public function certificates() {
		// certificates per user
	}

	public function taxipickup() {
		// list who needs taxi
	}
}
