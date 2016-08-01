<?php

/**
 * This is the model class for table "sales_flat_order_payment".
 *
 * The followings are the available columns in table 'sales_flat_order_payment':
 * @property string $entity_id
 * @property string $parent_id
 * @property string $base_shipping_captured
 * @property string $shipping_captured
 * @property string $amount_refunded
 * @property string $base_amount_paid
 * @property string $amount_canceled
 * @property string $base_amount_authorized
 * @property string $base_amount_paid_online
 * @property string $base_amount_refunded_online
 * @property string $base_shipping_amount
 * @property string $shipping_amount
 * @property string $amount_paid
 * @property string $amount_authorized
 * @property string $base_amount_ordered
 * @property string $base_shipping_refunded
 * @property string $shipping_refunded
 * @property string $base_amount_refunded
 * @property string $amount_ordered
 * @property string $base_amount_canceled
 * @property integer $quote_payment_id
 * @property string $additional_data
 * @property string $cc_exp_month
 * @property string $cc_ss_start_year
 * @property string $echeck_bank_name
 * @property string $method
 * @property string $cc_debug_request_body
 * @property string $cc_secure_verify
 * @property string $protection_eligibility
 * @property string $cc_approval
 * @property string $cc_last4
 * @property string $cc_status_description
 * @property string $echeck_type
 * @property string $cc_debug_response_serialized
 * @property string $cc_ss_start_month
 * @property string $echeck_account_type
 * @property string $last_trans_id
 * @property string $cc_cid_status
 * @property string $cc_owner
 * @property string $cc_type
 * @property string $po_number
 * @property string $cc_exp_year
 * @property string $cc_status
 * @property string $echeck_routing_number
 * @property string $account_status
 * @property string $anet_trans_method
 * @property string $cc_debug_response_body
 * @property string $cc_ss_issue
 * @property string $echeck_account_name
 * @property string $cc_avs_status
 * @property string $cc_number_enc
 * @property string $cc_trans_id
 * @property string $paybox_request_number
 * @property string $address_status
 * @property string $additional_information
 * @property string $cybersource_token
 * @property string $flo2cash_account_id
 * @property string $ideal_issuer_id
 * @property string $ideal_issuer_title
 * @property integer $ideal_transaction_checked
 * @property string $paybox_question_number
 */
class Mage1SalesOrderPaymentPeer extends Mage1ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sales_flat_order_payment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id', 'required'),
			array('quote_payment_id, ideal_transaction_checked', 'numerical', 'integerOnly'=>true),
			array('parent_id', 'length', 'max'=>10),
			array('base_shipping_captured, shipping_captured, amount_refunded, base_amount_paid, amount_canceled, base_amount_authorized, base_amount_paid_online, base_amount_refunded_online, base_shipping_amount, shipping_amount, amount_paid, amount_authorized, base_amount_ordered, base_shipping_refunded, shipping_refunded, base_amount_refunded, amount_ordered, base_amount_canceled', 'length', 'max'=>12),
			array('cc_exp_month, cc_ss_start_year, echeck_bank_name, method, cc_debug_request_body, cc_secure_verify, protection_eligibility, cc_approval, cc_last4, cc_status_description, echeck_type, cc_debug_response_serialized, cc_ss_start_month, echeck_account_type, last_trans_id, cc_cid_status, cc_owner, cc_type, po_number, cc_exp_year, cc_status, echeck_routing_number, account_status, anet_trans_method, cc_debug_response_body, cc_ss_issue, echeck_account_name, cc_avs_status, cc_number_enc, cc_trans_id, paybox_request_number, address_status, cybersource_token, flo2cash_account_id, ideal_issuer_id, ideal_issuer_title, paybox_question_number', 'length', 'max'=>255),
			array('additional_data, additional_information', 'safe'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mage1SalesOrderPaymentPeer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
