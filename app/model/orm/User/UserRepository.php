<?php
namespace App\Model\Orm\User;


use Nextras\Orm\Repository\Repository;


class UserRepository extends Repository
{
	static function getEntityClassNames(): array
	{
		return [User::class];
	}
}