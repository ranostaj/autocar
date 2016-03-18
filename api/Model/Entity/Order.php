<?php
namespace App\Model\Entity;

use Cake\Controller\Component\AuthComponent;
use Cake\ORM\Entity;

/**
 * Order Entity.
 *
 * @property int $id
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $customer
 * @property string $street
 * @property string $email
 * @property string $phone
 * @property string $companny
 * @property string $address
 * @property string $ico
 * @property string $ic_dph
 * @property string $typ
 * @property float $base_price
 * @property float $partial_price
 * @property float $total_price
 * @property string $description
 * @property string $invoice
 * @property string $managed_through
 * @property string $internal_info
 * @property \Cake\I18n\Time $date_delivery
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $status_id
 * @property \App\Model\Entity\Status $status
 * @property int $operation_id
 * @property \App\Model\Entity\Operation $operation
 */
class Order extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'created'=>false,
        'date_order'=>false,
        'id'=>false
    ];
}
