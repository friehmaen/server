<?php
/**
 * @copyright Copyright (c) 2017 Lukas Reschke <lukas@statuscode.ch>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\OAuth2\Db;

use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;

class ClientMapper extends Mapper {

	/**
	 * @param IDBConnection $db
	 */
	public function __construct(IDBConnection $db) {
		parent::__construct($db, 'oauth2_clients');
	}

	/**
	 * @param string $clientIdentifier
	 * @return Client
	 */
	public function getByIdentifier($clientIdentifier) {
		$qb = $this->db->getQueryBuilder();
		$qb
			->select('*')
			->from($this->tableName)
			->where($qb->expr()->eq('client_identifier', $qb->createParameter('clientId')));

		return $this->findEntity($qb->getSQL(), [$clientIdentifier]);
	}

	/**
	 * @return Client[]
	 */
	public function getClients() {
		$qb = $this->db->getQueryBuilder();
		$qb
			->select('*')
			->from($this->tableName);

		return $this->findEntities($qb->getSQL());
	}
}
