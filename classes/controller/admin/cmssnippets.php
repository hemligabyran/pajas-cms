<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Cmssnippets extends Admincontroller
{

	public function before()
	{
		parent::before();
		xml::to_XML(array('admin_page' => 'Snippets'), $this->xml_meta);
	}

	public function action_index()
	{
	}

	public function action_snippet()
	{
	}

}