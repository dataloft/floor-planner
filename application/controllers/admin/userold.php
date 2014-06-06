<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class User
 *
 * @editor N.Zakharenko
 */
class UserOld extends CI_Controller {

	/**
	 * Конструктор класса
	 *
	 * @editor N.Zakharenko
	 */
	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		$this->load->helper('url');
	}

	/**
	 * Формирование отображаемой страницы
	 *
	 * @param string $view
	 *
	 * @editor N.Zakharenko
	 */
	public function index($view = 'login') {
		/** Проверяем, авторизован ли пользователь */
		if($this->ion_auth->logged_in()) {
			redirect('admin/content', 'refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/user/'.$view);
		$this->load->view('admin/footer');
	}

	/**
	 * Метод авторизации на сайте
	 *
	 * @editor N.Zakharenko
	 */
	public function login() {
		if($_POST) {
			$oInput = $this->input;
			$aParams = self::getValidationData($oInput);
			if($this->ion_auth->login($this->input->post('email'), $this->input->post('password'))) {
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect($this->config->item('base_url'), 'refresh');
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('/admin', 'refresh');
			}
		} else {
			$this->index();
		}
	}

	/**
	 * Метод регистрации на сайте
	 *
	 * @editor N.Zakharenko
	 */
	public function registration() {
		if($_POST) {
			$oInput = $this->input;
			$aParams = self::getValidationData($oInput);
			if(!empty($aParams['sEmail']) AND !empty($aParams['sPassword'])) {
				$username  = strtolower($aParams['sName']).' '.strtolower($aParams['sSurname']);

				$additional_data = array(
					'first_name' => $aParams['sName'],
					'last_name'  => $aParams['sSurname'],
					//'company'    => $this->input->post('company'),
					//'phone'      => $this->input->post('phone1') .'-'. $this->input->post('phone2') .'-'. $this->input->post('phone3'),
				);

				if($this->ion_auth->register($username, $aParams['sPassword'], $aParams['sEmail'], $additional_data)) {
					$this->session->set_flashdata('message', "Вы зарегистрированы!");
					redirect("admin/content", 'refresh');
				}
			}

			$this->data['message'] = (validation_errors()) ? ($this->ion_auth->errors() ? $this->ion_auth->errors() : validation_errors()) : $this->session->flashdata('message');
		}

		$this->index('registration');
	}

	/**
	 * Метод
	 *
	 * @editor N.Zakharenko
	 */
	public function logout() {
		$this->ion_auth->logout();
		redirect('/admin', 'location');
	}

	private static function getValidationData($oParams){
		$aValidParams = array();

		// Проверка имени пользователя.
		if($oParams->post('first_name')) {
			if(preg_match('{^ [a-яё\w\s-,.&@()+;:]+ $}ixs', $oParams->post('first_name'))) {
				$aValidParams['sName'] = htmlspecialchars($oParams->post('first_name'));
			}
		}

		// Проверка фамилии пользователя.
		if($oParams->post('last_name')) {
			if(preg_match('{^ [a-яё\w\s-,.&@()+;:]+ $}ixs', $oParams->post('last_name'))) {
				$aValidParams['sSurname'] = htmlspecialchars($oParams->post('last_name'));
			}
		}

		// Проверка пчтового адреса пользователя.
		if($oParams->post('email')) {
			if(preg_match('{^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$}ixs', $oParams->post('email'))) {
				$aValidParams['sEmail'] = $oParams->post('email');
			}
		}

		// Проверка пароля пользователя.
		if($oParams->post('password')) {
			if(preg_match('{^ [a-яё\w\s-,.&@()+;:]+ $}ixs', $oParams->post('password'))) {
				$aValidParams['sPassword'] = $oParams->post('password');
			}
		}

		// Проверка повторапароля пользователя.
		if($oParams->post('repeat_password')) {
			if(preg_match('{^ [a-яё\w\s-,.&@()+;:]+ $}ixs', $oParams->post('repeat_password'))) {
				$aValidParams['sRepeatPassword'] = $oParams->post('repeat_password');
			}
		}

		return $aValidParams;
	}
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */