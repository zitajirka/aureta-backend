<?php

namespace App\Model\Orm\User;

use Carbon\Carbon;
use DateTimeImmutable;
use Nette\Security\Passwords;
use Nextras\Orm\Entity\Entity;

/**
 * Post
 *
 * @property int                        $id          {primary}
 * @property string                     $name
 * @property string                     $email
 * @property string                     $password
 * @property string|null                $passwordResetHash
 * @property string                     $role {enum self::ROLE_*} {default self::ROLE_USER}
 * @property DateTimeImmutable          $registrationTime {default now}
 * @property DateTimeImmutable|null     $passwordResetCreationTime {default null}
 */
class User extends Entity
{

	const ROLE_ADMIN = 'admin';
	const ROLE_USER = 'user';




	public function setPassword($password)
	{
		if ($password !== "" && $password !== NULL) {
			$this->password = Passwords::hash($password);
			$this->passwordResetHash = NULL;
		}
	}

	/**
	 * @return bool
	 */
	public function isAdmin()
	{
		return $this->role === ROLE_ADMIN ? TRUE : FALSE;
	}

	public function setPasswordResetHash($hash)
	{
		$this->passwordResetHash = $hash;
		$this->passwordResetCreationTime = Carbon::now();
	}


}