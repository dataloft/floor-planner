<?php
class Login_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getUser($aParams) {
		$oDb = $this->db;
		$aParams = self::validateUserData($aParams);

		if($aParams['mailbox_id']) {
			$sAndMailboxId = ' AND `mailbox_id` = "' . intval($aParams['mailbox_id']) . '" ';
			$this->sql = '
				SELECT
					users_info.mailbox_id, '.
				//users_info.color_scheme,
				'users_info.view_avatars,
				users_info.signature,
				users_info.html_signature,
				users_info.sender_name,
				users_info.view_mode,
				users_info.cnt_msg_per_page,
				users_info.view_image_size,
				users_info.hot_key,
				users_info.html_text,
				users_info.sound,
				users_info.sms_notify,
				users_info.sms_phone,
				users_info.sms_phone_confirmed,
				users_info.group_thread,
				users_info.vcard
			FROM
				users_info
			WHERE TRUE '.
				$sAndMailboxId;

			$oDb = $oDb->query($this->sql);

			return $oDb->row();
		}
	}

	/**
	 * Валидация данных для корректной работы с БД
	 *
	 * @param $aParams
	 * @return array
	 *
	 * @autor N.Zakharenko
	 */
	private static function validateUserData($aParams){
		// $aParams = array_map('trim', $aParams);
		$aValidParams = array();
		// Проверка id ящика пользователя.
		if(isset($aParams['iMailboxId'])) {
			$iMailboxId = intval($aParams['iMailboxId']);
			if($iMailboxId) {
				$aValidParams['mailbox_id'] = $iMailboxId;
			}
		}
	}

	/**
	 * Получение части запроса
	 *
	 * @param $aParams
	 * @return array
	 *
	 * @autor N.Zakharenko
	 */
	protected function getSqlSetPart(array $aParams){
		$aSqlParts = array();

		if(isset($aParams['sPassword'])){
			$aSqlParts[] = 'email = "' . $aParams['sPassword'] . '"';
		}

		if(isset($aParams['sPassword'])){
			$aSqlParts[] = 'password = "' . $aParams['sPassword'] . '"';
		}

		return $aSqlParts;
	}
}

/* End of file page.php */
/* Location: ./system/application/models/page_model.php */