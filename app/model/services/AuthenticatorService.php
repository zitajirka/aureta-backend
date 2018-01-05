<?php

namespace App\Model\Services;



use App\Model\Orm\User\User;
use App\Model\Orm\User\UserRepository;
use Nette;
use	Nette\Security\Passwords;

class AuthenticatorService implements Nette\Security\IAuthenticator
{
	/**
	 * @var UserRepository
	 */
	private $userRepository;
	/**
	 * @var EmailService
	 */
	private $emailService;

	/**
	 * AuthenticatorService constructor.
	 * @param UserRepository $userRepository
	 * @param EmailService $emailService
	 */
	public function __construct(UserRepository $userRepository, EmailService $emailService)
	{
		$this->userRepository = $userRepository;
		$this->emailService = $emailService;
	}

	/**
	 * Performs an authentication.
	 * @param array $credentials
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($email, $password) = $credentials;

		$user = $this->userRepository->getBy([
			"email" => $email
		]);

		if (!$user) {
			throw new Nette\Security\AuthenticationException('The email is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $user->password)) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($user->password)) {
			$user->password = $password;
		}

		return new Nette\Security\Identity($user->id, $user->role);
	}

	/**
	 * Sends e-mail with new password reset URL and sets corresponding hash
	 * @param $email
	 * @return bool
	 */
	public function requestPasswordReset($email)
	{
		$user = $this->userRepository->getBy([
			'email' => $email
		]);

		if ( ! $user) {
			return FALSE;
		}

		$hash = Random::generate(50);
		$user->setPasswordResetHash($hash);

		$this->userRepository->persistAndFlush($user);

		$this->emailService->send($email, [
			'hash'  => $hash,
			'email' => $email
		], 'passwordResetRequest.latte');

		return TRUE;

	}

	/**
	 * @param User $user
	 * @param $password
	 */
	public function updatePassword(User $user, $password)
	{
		$user->setPassword($password);
		$this->userRepository->persistAndFlush($user);
	}


}




