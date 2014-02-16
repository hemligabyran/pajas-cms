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
		$cmssnippets = Cmssnippets::factory();
		xml::to_XML($cmssnippets->get(), array('cmssnippets' => $this->xml_content), 'cmssnippet', 'id');
	}

	public function action_cmssnippet()
	{
		$formdata = array(
			'group'  => 'global',
			'locale' => Kohana::$config->load('cms.locale'),
		);

		if (isset($_GET['id']))
		{
			$cmssnippet = new Cmssnippet($_GET['id']);
			$formdata   = $cmssnippet->get();

			if (isset($_GET['rm']) || (isset($_POST['action']) && $_POST['action'] == 'rm'))
			{
				$cmssnippet->rm();
				$this->redirect('/admin/cmssnippets');
			}
		}
		else
		{
			$cmssnippet = new Cmssnippet();
		}

		if (isset($_POST['action']) && $_POST['action'] == 'save')
		{
			unset($_POST['action']);
			foreach ($_POST as $field => $value)
				$cmssnippet->$field = $value;
			$cmssnippet->save();
			$formdata = $cmssnippet->get();
			$this->add_message('Snippet saved');
		}


		$this->set_formdata($formdata);
	}

}